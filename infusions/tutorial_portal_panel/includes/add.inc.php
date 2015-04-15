<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: matze
| Lizenz: CCL v1.0
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

add_to_head("<link rel='stylesheet' href='".INFUSIONS."tutorial_portal_panel/includes/css/add.css' type='text/css' media='screen' />");
add_to_head("<link rel='stylesheet' href='".INFUSIONS."tutorial_portal_panel/includes/css/add1.css' type='text/css' media='screen' />");
add_to_head("<link rel='stylesheet' href='".INFUSIONS."tutorial_portal_panel/includes/css/thickbox.css' type='text/css' media='screen' />");
add_to_head("<script src='".INFUSIONS."tutorial_portal_panel/includes/js/thickbox.js' type='text/javascript'></script>
             <script src='".INFUSIONS."tutorial_portal_panel/includes/js/jquery.autosize.js' type='text/javascript'></script>");

add_to_footer("<script type='text/javascript'>
	$(function(){ $('.animated').autosize(); });
		var maxLength = 500;
        $('#proptext').keyup(function() {
        var length = $(this).val().length;
        var length = maxLength-length;
    $('#charsleft').text(length);
});

/* <![CDATA[ */
jQuery(document).ready(function() {
	$('.tbl1 select').change(function () {
		var color = $('option:selected', this).attr('style');
		$(this).attr('style', color);
	});

	$('.tbl1 select').each(function () {
		var color = $('option[selected=selected]', this).attr('style');
		$(this).attr('style', color);
	});
	
});
/* ]]>*/
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = '//connect.facebook.net/sv_SE/sdk.js#xfbml=1&appId=104489596253993&version=v2.0';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

	function __SML_Projects() {
         var mlp = document.getElementById('show_mlp');
         var mlp_txt = document.getElementById('show_mlp_text');
if (mlp.style.display == 'none') {
         mlp.style.display = 'block';
         mlp_txt.innerHTML = '<strong>Anzeige der letzten Tutorials</strong>';
} else {
         mlp.style.display = 'none';
         mlp_txt.innerHTML = '<strong>Anzeige mehr Tutorials</strong>';
       }
}

$(document).ready(function(){
$('#hideField1').hide();
$('#hideField2').hide();
$('#hideField3').hide();
$('#hideField4').hide();
	$('#propos-ul-l').change(function() {
		if ($('#propos-ul-l').val() == 0){
			$('#hidefie1').show();
			$('#hidefie2').show();
			$('#hidefie3').show();
			$('#hidefie4').show();
			$('#hidefie-text1').hide();
			$('#hidefie-text2').hide();
			$('#hidefie-text3').hide();
			$('#hidefie-text4').hide();
		} else {     
            $('#hidefie1').hide();		
			$('#hidefie2').hide();
			$('#hidefie3').hide();
			$('#hidefie4').hide();
			$('#hidefie-text1').show();
			$('#hidefie-text2').show();
			$('#hidefie-text3').show();
			$('#hidefie-text4').show();
		}
		$('#hideField1').show('fast');
		$('#hideField2').show('fast');
		$('#hideField3').show('fast');
		$('#hideField4').show('fast');
	}); $('#propos-ul-l').change();
});
</script>");

?>
