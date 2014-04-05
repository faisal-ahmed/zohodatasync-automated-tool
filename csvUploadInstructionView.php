<?php

function uploadInstructionView() {
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        $url = '/wordpress/wp-content/plugins/' . basename(__DIR__) . '/utils_conversion.php?get_my_csv=download_now';
    } else {
        $url = '/wp-content/plugins/' . basename(__DIR__) . '/utils_conversion.php?get_my_csv=download_now';
    }
?>
<script type="text/javascript">
	$(function () {
		var iframe = document.getElementById("download-container");
		if (iframe === null)
		{
			iframe = document.createElement('iframe');  
			iframe.id = "download-container";
			iframe.style.visibility = 'hidden';
			document.body.appendChild(iframe);
		}
		iframe.src = "<?php echo $url ?>";
	});
	function download_csv(){
		var file_download = $.post( "", {'get_my_csv': 'download_now'}, function( data ) {
			var iframe = document.getElementById("download-container");
			if (iframe === null)
			{
				iframe = document.createElement('iframe');  
				iframe.id = "download-container";
				iframe.style.visibility = 'hidden';
				document.body.appendChild(iframe);
			}
			iframe.src = "<?php echo $url ?>";
		});
	}
</script>
<div class="block" style="margin: 10px 20px 25px 0px; padding-bottom: 0px;">
	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>
		<h2 style="margin: 0;">Zoho Data Sync Automated Tools Direct File Upload Instruction</h2>
		<h2 style="margin: 0; float: right;"><a href="#" onclick="location.reload(true);">Back to Step one</a></h2>
	</div>
	<div class="block_content">
		<h2>If your download hasn't been started yet then please click <a href="#" onclick="download_csv();">here</a> to download your CSV file.<br/><br/></h2>
		<h3>Things you need to remember:<br/>You can only upload your CSV file direct into Zoho CRM in some selected modules only. It's always good to use automated migration system to upload your file into zoho.
        But if you use automated system then you cannot cross your allowed daily API limit of Zoho. However, If you have large file(s) and you don't have enough API call remaining today then
        split your file(s) into some small files and migrate them at Zoho daily basis via API. Or You can increase your daily API limit by increasing your organization users of Zoho.</h3>

        <h3>To know your today's remaining API call go to the "Developer Space" available in "Setup" tab at your Zoho CRM account</h3>

        <h3 style="color: #3aa3e6;">Thanks and Good Luck</h3>
	</div>
	<div class="bendl"></div>
	<div class="bendr"></div>
	<div class="clear"></div>
</div>
<?php
}