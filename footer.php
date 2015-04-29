<!--Bvalidator-->
<link rel="stylesheet" href="<?=SITE_URL?>/plugin/bValidator-0.73/bvalidator.css"> 
<script src="<?=SITE_URL?>/plugin/bValidator-0.73/jquery.bvalidator.js"></script>
<script type="text/javascript">
    $('#form1,#form2,#form3,#form4,#form5,formsubmit,#login').bValidator();
</script>
	
<!--Copy text to clipboard START-->
<script type="text/javascript" src="<?=SITE_URL?>/plugin/jquery.clipboard-master/jquery.zclip.js"></script>
<script>
$(document).ready(function(){
	if(navigator.userAgent.search("Chrome") >= 0) {
		$('#copytxt').zclip({
			path:'<?=SITE_URL?>/plugin/jquery.clipboard-master/ZeroClipboard.swf',
			copy:function(){return $('#video_code_output,.video_code_output').val();}
		});
	}else{
		$('#copytxt').click(function(){
			alert('Please use [ Ctrl+C ]  to copy the code.');
			$( "#video_code_output,.video_code_output" ).trigger( "focus" );
		});
	}});

$('#myModal').on('show.bs.modal', function () {
    $("#copytxt").delay(250).queue(function(next){
	if(navigator.userAgent.search("Chrome") >= 0) {		
		$('#copytxt').zclip({
			path:'<?=SITE_URL?>/plugin/jquery.clipboard-master/ZeroClipboard.swf',
			copy:function(){return $('#video_code_output,.video_code_output').val();}
		});
	}else{
		/*$('#copytxt').click(function(){
			alert('Please use [ Ctrl+C ]  to copy the code.');
			$( "#video_code_output,.video_code_output" ).trigger( "focus" );
		});*/
	}
    });});

// Default focus
	$("#focus").focus();

// add site_client_form
	var options9 = {
	onAfterAllValidations: function(elements, formIsValid){            
		if(formIsValid && $('.bvalidator_errmsg > :visible').length<=0){
			$('.site_client_form').find('.btn').html('<i class="fa fa-spinner fa-spin"></i> Saving...');	
			$('.site_client_form').find('.btn').addClass('disabled');	
		}
	}};
	$('#site_client_form').bValidator(options9);

// tooltip	
	$(function () {$('[data-toggle="tooltip"]').tooltip();$('.pophover').popover('hide');})
	
	
	
// submit false
	var ButtonValue;
	$('button[type="submit"]').click(function(e){ ButtonValue = $(this).val();});
	$(".form_basic_code").submit(function(){if(ButtonValue == 1){return true;}else{return false;}});

// select the code 
	$(".video_code_output").focus(function() {
    var $this = $(this);
    $this.select();
    $this.mouseup(function() {
        $this.unbind("mouseup");
        return false;
    });});

// option all code --------------------------------
	var options10 = {
	onAfterAllValidations: function(elements, formIsValid){            
		if(formIsValid && $('.bvalidator_errmsg > :visible').length<=0){
			$("#copytxt,.copytxt").removeClass('disabled');
			var choose_code_option=$('.choose_code_option input[name=code_option]:checked').val(); // check code type
			if(choose_code_option=='video'){
				create_code(video_form);
			}else if(choose_code_option=='html'){
				encoded(video_form);
			}else if(choose_code_option=='iframe'){
				//encoded(video_form);
			}
			
		}else{
			$(".video_code_output").val('');
			$("#copytxt,.copytxt").addClass('disabled');
		}
	}};
	$('.form_basic_code').bValidator(options10);

// VIDEO code --------------------------------	
	function create_code ( form_name ){
  var video_embed; 
  var output_embed; 
  var script_embed;
  var ilen;
  var key = 2;
  var origlen;
  video_embed="<iframe src=\""+form_name.video_url.value+"\" width=\""+ form_name.video_width.value+ "\" height=\""+form_name.video_height.value+"\" marginwidth=\"1\" marginheight=\"1\" frameborder=\"0\" id=\"external\"></iframe>";
  origlen = video_embed.length;
  script_embed = "";
  if ( form_name.url_permission.value != "" )
    {
      script_embed += "<SCR" + "IPT language='JavaScript' type='text/javascript'>";
      script_embed += "var URL=window.location.href;";
      script_embed += "var split = URL.indexOf ( \"" + form_name.url_permission.value + "\");";
      script_embed += "if (split<0) {location.href=\"" + form_name.url_block.value + "\";}else{document.write(unescape(\"" + escape ( video_embed ) + "\"));}";
      script_embed += "</SCR" + "IPT>";
      video_embed = script_embed;
    }
  video_embed = escape ( video_embed );
  ilen = video_embed.length;
  output_embed = "";
  for ( i = 0; i < ilen; i++ )
	output_embed += String.fromCharCode ( video_embed.charCodeAt ( i ) ^ key );
	output_embed =  "var code=\"" + output_embed + "\"; var res=\"\";"
	output_embed += "var len=code.length; var i;";
	output_embed += "for (i=0;i<len;i++) {res+=String.fromCharCode(code.charCodeAt(i)^" + key + ")} ";
	output_embed += "res=unescape(res);";
	output_embed += "document.write(res);";
	output_embed = "<SCR" + "IPT language='JavaScript' type='text/javascript'>" + output_embed + "</SCR" + "IPT>";
	$('.video_code_output').val(output_embed);}
	
// HTML code ----------------------------------
	function escapeAll(input) {
	  var output = "";
	  var escapeCode;
	  for (i = 0; i < input.length; i++) {
		escapeCode = escape(input[i]);
		if (escapeCode.length == 1) {
		  escapeCode = input.charCodeAt(i).toString(16).toUpperCase();
		  if (escapeCode.length < 2) escapeCode = "0" + escapeCode;
		  escapeCode = "%" + escapeCode;
		}
		output += escapeCode;
	  }
	  return output;
	}
	function encoded( form_name ){
		var scriptBase = form_name.scriptbase.value;
		var inputCode = form_name.video_code_input.value;
		$('.video_code_output').val(scriptBase.replace("{0}",
		"<!-- HTML Encryption provided by www.cre8ivelabs.com -->"+
		"document.write(unescape(\"" + escapeAll(inputCode) + "\"));"));
	}
	
// iFrame code ----------------------------------	
		
</script>

</body>
</html>
<?
unset($_SESSION['msg']);
unset($_SESSION['error']);
?>
<div id="ajax_result"></div>