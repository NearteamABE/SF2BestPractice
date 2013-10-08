jQuery(document).ready(function() {
    jQuery("#nearteam_user_search_user_cp").val("");
    //$( "input[date=datePicker]" ).datepicker($.datepicker.regional[$("#locale_date_picker").val()]);
    // ticket 5923
    $.datepicker.setDefaults($.datepicker.regional[$("#locale_date_picker").val()]);
    $("input[date=datePicker]" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });

    jQuery("#LangFlag").click(function(){
        jQuery("#list_flags").toggle();
    });

    jQuery("#loc").change(function(){
        document.location.replace(jQuery("#loc").val());
    });

    $(document).keypress(function(e) {
        if(e.which == 13) {
            jQuery(".btn_validate_form").click();
        }
    });


    /* ******** Arbi Jaafar - 18/10/2012 - bug #5808 ******* */
    setInterval(function(){

        $(".ui-jqgrid tr.jqgrow td:nth-child(3) div").each(function(){
            var classOfDiv = $(this).attr("class");

            if (classOfDiv == 'alert-info') {
                $(this).parent("td").css("background-color","#D9EDF7");
            }
            if (classOfDiv == 'alert-success') {
                $(this).parent("td").css("background-color","#DFF0D8");
            }
            if (classOfDiv == 'alert-danger') {
                $(this).parent("td").css("background-color","#F2DEDE");
            }
        });

    },1000);


    /* ******** Arbi Jaafar - 30/10/2012 - for iFrame ******* */

    /* General variable for iFrames */
    var iframeIsOpen = false;

    // open iframe
    $("a.menu_myf").click(function () {
        iframeIsOpen = actionForIframe("open");
		$(".breadcrumb LI").css("cursor", "pointer");
    });
    // close iframe
    $(".menu_services").click(function () {
        iframeIsOpen = actionForIframe("close");
		$(".breadcrumb LI").css("cursor", "auto");
    });
    // close iframe
    $("ul.breadcrumb").click(function () {
        iframeIsOpen = actionForIframe("close");
		$(".breadcrumb LI").css("cursor", "auto");
    });

    function actionForIframe(action)
    {
        if(action == "open")
        {
            if ( iframeIsOpen == false)
            {
                $("div.container_body").hide("blind", "slow");
                $("#iframes").show("blind", "slow");

                iframeIsOpen = true;
            }

        }
        if(action == "close")
        {
            if ( iframeIsOpen == true)
            {
                $("div.container_body").show("blind", "slow");
                $("#iframes").hide("blind", "slow");

                iframeIsOpen = false;
            }
        }

        return iframeIsOpen;

    }



});

function flagsHide(localeCode)
{
    jQuery("#LangFlag").removeClass().addClass("langue_"+localeCode);
    jQuery("#list_flags").toggle();

}

function listVille(option)
{ 

	 $.ajax({
      type: "POST",
      url:  $("#modif_ville").val(),
      data: "cp="+$(".autoCodePostal").val()
			+"&id_country_ville="+$("#id_country_ville").val(),
      success: function (data) {
       // $(".autoCity").html(data.html);
	
	   jQuery("#countCities").val(data.count);
	   jQuery("#msgCities").val(data.html);
	   var all = ExposeTranslation.get('messages:all');
	   var emptyMsg  = ExposeTranslation.get('messages:emptyMsg');
	   if(option == 1) {
	   
	       $(".autoCity").prepend('<option value="">'+all+'</option>');
	   }
	   
		   $("#listCitiesHidden").html(data.html);
		   
		   if ($('#listCitiesHidden option').length  < parseInt(jQuery("#countCities").val())) {
			  $(".autoCity").html('');
		   }
		   else {

			   if( parseInt($('.autoCodePostal').val().length) >= 3)
			   {
					$(".autoCity").html(data.html);
			   }
				else
				{
					$(".autoCity").html('');
				}
		   }
	   
	   
	
	  
	   
	 
	  
      }
    });  // end Ajax        
    return false; 

}





function listVilleBank()
{ 
 
	 $.ajax({
      type: "POST",
      url:  $("#modif_ville").val(),
      data: "cp="+$(".autoCodePostalBank").val()
			+"&id_country_ville="+$("#id_country_ville_bank").val(),
     
      success: function (data) {
	    var emptyMsg  = ExposeTranslation.get('messages:emptyMsg');

	   jQuery("#countCitiesBank").val(data.count);
	  
	    $("#listCitiesBankHidden").html(data.html);
		   
		   if ($('#listCitiesBankHidden option').length  < parseInt(jQuery("#countCitiesBank").val())) {
			  $(".autoCity").html('');
		   }
		   else {

			   if( parseInt($('.autoCodePostalBank').val().length) >= 3)
			   {
					$(".autoCityBank").html(data.html);
			   }
				else
				{
					$(".autoCityBank").html('');
				}
		   }
	   
      }
    });  // end Ajax        
    return false; 

}

function addHref(login,idResto, hashKey)
{

jQuery("#myfourchette_"+idResto).attr('href',jQuery('#urlMyf').val()+'/?super_authentication='+login+'%7C'+idResto+'%7C'+hashKey);

}
function addHref(login,idResto, hashKey)
{

jQuery("#myfourchette_"+idResto).attr('href',jQuery('#urlMyf').val()+'/?super_authentication='+login+'%7C'+idResto+'%7C'+hashKey);

}function addHref(login,idResto, hashKey)
{

jQuery("#myfourchette_"+idResto).attr('href',jQuery('#urlMyf').val()+'/?super_authentication='+login+'%7C'+idResto+'%7C'+hashKey);

}
function pad(number, length) {
   
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
   
    return str;

}