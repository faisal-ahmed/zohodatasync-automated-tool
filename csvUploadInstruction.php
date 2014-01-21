<?php

require_once dirname(__FILE__) . '/utils_conversion.php';

function uploadInstruction() {
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        $url = '/wordpress/wp-content/plugins/zohodatasync_automated_tool/utils_conversion.php?get_my_csv=download_now';
    } else {
        $url = '/wp-content/plugins/zohodatasync_automated_tool/utils_conversion.php?get_my_csv=download_now';
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
		<h2 style="margin: 0;">Zoho Data Sync Automated Tools Settings</h2>
		<h2 style="margin: 0; float: right;"><a href="#" onclick="location.reload(true);">Back to Step one</a></h2>
	</div>
	<div class="block_content">
		<h2>If your download isn't started yet then please click <a href="#" onclick="javascript: download_csv();">here</a> to download your CSV file.<br/>
		Afterwards, follow the following instructions to upload your csv file into your Zoho CRM</h2>
	</div>
	<div class="bendl"></div>
	<div class="bendr"></div>
	<div class="clear"></div>
</div>
<?php
}