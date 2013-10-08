backend default {
	.host = "localhost";
	.port = "81";
}

# point d'entrée d'une requête
sub vcl_recv {
	# interdit l'actualisation par le client
	unset req.http.Cache-Control;

	# traitement du accept-encoding
	if (req.http.Accept-Encoding) {
		if (req.url ~ "(?i)\.(flv|swf|mp3|mp4|m4a|ogg|mov|avi|wmv|jpe?g|png|gif|gz|tgz|bz2|tbz|mp3|ogg|eot|woff|ttf|htc|pdf)(\?.*)?$" ) {
			# No point in compressing these
			remove req.http.Accept-Encoding;
		}
		elsif (req.http.Accept-Encoding ~ "gzip") {
			set req.http.Accept-Encoding = "gzip";
		}
		else {
			# unkown algorithm
			remove req.http.Accept-Encoding;
		}
	}

    # on indique au BackEnd qu'on accepte les ESI
	set req.http.Surrogate-Capability = "abc=ESI/1.0";
	
	# on transmet l'ip du client
	set req.http.X-Varnish-Client-IP = client.ip;
	set req.http.X-Real-IP = client.ip;
	set req.http.X-Forwarded-For = client.ip;

	# traitement des PURGE
	if (req.request == "PURGE") {
		return(lookup);
	}

	# requete pas conforme HTTP
	if (!req.request ~ "GET|HEAD|PUT|POST|TRACE|OPTIONS|DELETE") {
		error 400 "Bad request";
	}

	# si le backend ne repond pas on a le droit de servir du cache expiré depuis 2 minutes
	set req.grace = 120s;
	set req.backend = default;

	# on ne traite en terme de cache que les GET et les HEAD
	if (req.request != "GET" && req.request != "HEAD") {
		return (pass);
	}

	# par defaut on ne cache pas et on forwarde sur le backend web (ie le cluster de frontaux webs)
	return (lookup);
}

# Sélection des champs qui interviendront pour l'entrée en cache 
sub vcl_hash {
	hash_data(req.url);

	if (req.http.host) {
		hash_data(req.http.host);
	}
	else {
		hash_data(server.ip);
	}
	return (hash);
}

# Si l'élément a été trouvé en cache
sub vcl_hit {
	if (req.request == "PURGE") {
		purge;
		error 200 "Purged";
	}
}

# Si l'élément n'a pas été trouvé en cache
sub vcl_miss {
	if (req.request == "PURGE") {
		error 404 "Not in cache.";
	}

	# compression done in vcl_fetch
	unset bereq.http.accept-encoding;

	return (fetch);
}

# Après récupération de l'info depuis le backend
sub vcl_fetch {
	# compression, si demander par l'internaute
	if (req.http.Accept-Encoding) {
		set beresp.do_gzip = true;
	}

	# traitement ESI
	if (beresp.http.Surrogate-Control ~ "ESI/1.0") {
		unset beresp.http.Surrogate-Control;
		set beresp.do_esi = true;
	}

	# élément non cachable
	if (beresp.ttl <= 0s || 
		beresp.http.Vary == "*" ||
		beresp.http.Cache-Control ~ "no-cache"
	) {
		set beresp.ttl = 120 s;
		return (hit_for_pass);
	}

    # nettoyer par sécurité
    remove beresp.http.Set-Cookie;

	# cache
	return (deliver);
}


sub vcl_pass {
	# compression done in vcl_fetch
	unset bereq.http.accept-encoding;

	return (pass);
}

sub vcl_deliver {
	if (obj.hits > 0) {
		set resp.http.X-Cache = "HIT";
	}
	else {
		set resp.http.X-Cache = "MISS";
	}
	remove resp.http.X-Varnish-IP;
	set    resp.http.X-Varnish-IP = server.ip;

	return (deliver);
}

sub vcl_error {
	if (obj.status == 401) {
		set obj.http.Content-Type = "text/html; charset=utf-8";
		set obj.http.WWW-Authenticate = "Basic realm=Secured";
		synthetic {"

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
  <HEAD>
    <TITLE>Error</TITLE>
    <META HTTP-EQUIV='Content-Type' CONTENT='text/html;'>
  </HEAD>
  <BODY><H1>401 Unauthorized (varnish).</H1></BODY>
</HTML>
		"};
		return (deliver);
	}
}


