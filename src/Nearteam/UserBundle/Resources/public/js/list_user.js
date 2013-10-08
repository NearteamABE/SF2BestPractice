jQuery(document).ready(function(){

  setTimeout(function() { 
 $('a').each(function(){
    $(this).removeAttr("title");

 }); 

},3000);
	
	
	$("#cancel_button").click(function(){
		if($("#enrg_succed").val()=='1'){
			window.location.reload(true);
		}
	
	});
	
});
function changePassword(idUser, link)
{
    ajaxManager.ajax({
        url: link,
        data: "id_user="+idUser,
        dataType: 'json',
        success: function(data) {
						
        }
    });

}
function dateFormat(date)
{
    var format = date.split('/');
    return format[2]+'-'+format[1]+'-'+format[0];

}

function fieldChange()
{
	$("#check_button").show();
	$(".t_end_loading").hide();
	$(".alert").hide();
	$("#subbmit_button").hide();
}
