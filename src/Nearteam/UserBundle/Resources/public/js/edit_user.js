jQuery(document).ready(function(){
document.getElementById( "password_user_form_password" ).setAttribute( "autocomplete","off" );
document.getElementById( "password_user_form_passwordVerif" ).setAttribute( "autocomplete","off" );
document.getElementById("user_edit_form_gender_F").checked = true;
var idGender = '';
if(jQuery("#Gender").val()!='')
    {
	    idGender = jQuery("#Gender").val();
	    document.getElementById("user_edit_form_gender_"+idGender).checked = true;
	}

if(jQuery("#gender_edit").val()!='')
{
	document.getElementById("user_edit_form_gender_"+jQuery("#gender_edit").val()).checked = true;
}

jQuery("#user_edit_form_country").change(function(){

jQuery("#id_country_ville").val(jQuery("#user_edit_form_country").val());
listVille(0);
});

//brthdate
var birthDate = jQuery("#birthDate").val().split('-');

var phone = jQuery("#phone").val().split('-');
var day = '';
var month = '';
var birthYear = '';


jQuery("#user_edit_form_phoneCode option[value=" + phone[0] +"]").attr("selected","selected") ;
 if(jQuery("#birthDate").val() != "") {
 day = parseInt(birthDate[2]);
 month = parseInt(birthDate[1]);
 birthYear = parseInt(birthDate[0]);

}

jQuery('#user_edit_form_dateNaissance_year option[value="'+ birthYear +'"]').attr("selected","selected") ;
jQuery('#user_edit_form_dateNaissance_month option[value="'+ month +'"]').attr("selected","selected") ;
jQuery('#user_edit_form_dateNaissance_day option[value="'+ day +'"]').attr("selected","selected") ;
jQuery("#optinsuser").val("");

if(jQuery("#codePostal").val()!=''){
       jQuery("#user_edit_form_postalCode").val(jQuery("#codePostal").val()) ;
	}
	
    jQuery("#user_edit_form_dateNaissance_year option[value=" + birthYear +"]").attr("selected","selected") ;
    jQuery("#user_edit_form_dateNaissance_month option[value=" + month +"]").attr("selected","selected") ;
    jQuery("#user_edit_form_dateNaissance_day option[value=" + day +"]").attr("selected","selected") ;

	
	
    // end birth day	
	
    var idCountry=jQuery("#idCountry").val();
    if(jQuery("#idCountry").val()!='')
    {
        idCountry = jQuery("#idCountry").val();
    }
    var idSite=jQuery("#idSite").val();

    if(jQuery("#site").val()!='')
    {
        idSite = jQuery("#site").val();
    }

    var idCity=jQuery("#idCity").val();

    if(jQuery("#city").val()!='')
    {
        idCity = jQuery("#city").val();
    }

    jQuery("#user_edit_form_country option[value='"+idCountry+"']").attr("selected","selected") ;
	jQuery("#user_edit_form_city").append("<option value="+jQuery("#idCity").val()+">"+jQuery("#cityTrans").val()+"</option>");
	 setTimeout(function() { 
    jQuery("#user_edit_form_city option[value='"+idCity+"']").attr("selected","selected") ;
	},2);
    jQuery("#user_edit_form_site option[value='"+idSite+"']").attr("selected","selected") ;
    subscriptionTable = $( "#optinsc" ).val().split(',');
	
    $(".optins input[type=checkbox]").click(function(){
        if($(this).is(':checked')){
            addOptin($(this).val());
			
        }else{
            moveOptin($(this).val());
        }
        var optinsChecked = subscriptionTable.join(", ");
		
        $('#optinsc').val(optinsChecked);
		
    });
	
	
		
    $(".optins input[type=checkbox]").each(function(){
	
        if(jQuery.inArray($(this).attr('value'), subscriptionTable) > -1)
        {
		  
            $(this).attr('checked','checked');
        }

    });
	
	
});


// verification of password
function verifPassword()
{
    if(jQuery("#password_user_form_password").val() != jQuery("#password_user_form_passwordVerif").val())
    { 
        alert(ExposeTranslation.get('messages:verifPassword'));
	    
		return false;
    }
    else
    {  
        jQuery("#editForm").submit();
    }
}


function addOptin(id)
{
    subscriptionTable.push(id);
}

function moveOptin(id)
{
    subscriptionTable = jQuery.grep(subscriptionTable, function(value) {
        return value != id;
    });
	
}

