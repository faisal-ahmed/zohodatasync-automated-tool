<?php
/*
Plugin Name: ZohoDataSync Automated Tool
Description: This Plugin manages some automated data sync with Zoho
Author: Mohammad Faisal Ahmed
Version: 1
Author Email: faisal.ahmed0001@gmail.com
*/

$dir_name = str_replace('\\', '/', dirname(__FILE__));
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $resource_dir_name = "http://".$_SERVER['HTTP_HOST']. substr($dir_name, strpos($dir_name, '/wordpress/wp-content/plugins/'));
} else {
    $resource_dir_name = "http://".$_SERVER['HTTP_HOST']. substr($dir_name, strpos($dir_name, '/wp-content/plugins/'));
}
include ( plugin_dir_path( __FILE__ ) . 'utils_conversion.php');
include ( plugin_dir_path( __FILE__ ) . 'zoho_handler.php');
include ( plugin_dir_path( __FILE__ ) . 'csvUploadInstruction.php');

/********** Admin Panel **************************/
function pr_scripts_styles() {
	if (strpos($_SERVER['REQUEST_URI'], 'zds-automated-id') !== false || strpos($_SERVER['REQUEST_URI'], 'set-zoho-authtoken') !== false) {
		/*   REGISTER ALL JS FOR SITE */
		wp_register_style('style', plugins_url( 'css/style.css' , __FILE__ ));
		wp_register_style('mystyle', plugins_url( 'style.css' , __FILE__ ));
		wp_register_style('date_input', plugins_url( 'css/date_input.css' , __FILE__ ));
		wp_register_style('facebox', plugins_url( 'css/facebox.css' , __FILE__ ));
		wp_register_style('jquery-wysiwyg', plugins_url( 'css/jquery.wysiwyg.css' , __FILE__ ));
		wp_register_style('ie', plugins_url( 'css/ie.css' , __FILE__ ));
		wp_register_style('visualize', plugins_url( 'css/visualize.css' , __FILE__ ));
		wp_register_style('wysiwyg', plugins_url( 'css/wysiwyg.css' , __FILE__ ));

		/*   REGISTER ALL CSS FOR SITE */
		wp_register_script('my-jquery', plugins_url( 'js/jquery.js' , __FILE__ ));
		wp_register_script('my-script', plugins_url( 'script.js' , __FILE__ ));
		wp_register_script('excanvas', plugins_url( 'js/excanvas.js' , __FILE__ ));
		wp_register_script('jquery-img-preload', plugins_url( 'js/jquery.img.preload.js' , __FILE__ ));
		wp_register_script('jquery-filestyle-mini', plugins_url( 'js/jquery.filestyle.mini.js' , __FILE__ ));
		wp_register_script('jquery-wysiwyg', plugins_url( 'js/jquery.wysiwyg.js' , __FILE__ ));
		wp_register_script('date_input', plugins_url( 'js/jquery.date_input.pack.js' , __FILE__ ));
		wp_register_script('facebox', plugins_url( 'js/facebox.js' , __FILE__ ));
		wp_register_script('visualize', plugins_url( 'js/jquery.visualize.js' , __FILE__ ));
		wp_register_script('tooltip', plugins_url( 'js/jquery.visualize.tooltip.js' , __FILE__ ));
		wp_register_script('select_skin', plugins_url( 'js/jquery.select_skin.js' , __FILE__ ));
		wp_register_script('tablesorter', plugins_url( 'js/jquery.tablesorter.min.js' , __FILE__ ));
		wp_register_script('ajaxupload', plugins_url( 'js/ajaxupload.js' , __FILE__ ));
		wp_register_script('pngfix', plugins_url( 'js/jquery.pngfix.js' , __FILE__ ));
		wp_register_script('custom', plugins_url( 'js/custom.js' , __FILE__ ));

		/*   CALL ALL CSS AND SCRIPTS FOR SITE */
		wp_enqueue_script('my-jquery');
		wp_enqueue_script('my-script');
		wp_enqueue_script('excanvas');
		wp_enqueue_script('jquery-img-preload');
		wp_enqueue_script('jquery-filestyle-mini');
		wp_enqueue_script('jquery-wysiwyg');
		wp_enqueue_script('date_input');
		wp_enqueue_script('facebox');
		wp_enqueue_script('visualize');
		wp_enqueue_script('tooltip');
		wp_enqueue_script('select_skin');
		wp_enqueue_script('tablesorter');
		wp_enqueue_script('ajaxupload');
		wp_enqueue_script('pngfix');
		wp_enqueue_script('custom');

		wp_enqueue_style('style');
		wp_enqueue_style('mystyle');
		wp_enqueue_style('date_input');
		wp_enqueue_style('facebox');
		wp_enqueue_style('jquery-wysiwyg');
		wp_enqueue_style('ie');
		wp_enqueue_style('visualize');
		wp_enqueue_style('wysiwyg');
	}
}

add_action( 'admin_enqueue_scripts', 'pr_scripts_styles' );

add_action('admin_menu', 'zds_plugin_menu');

function zds_plugin_menu() {
    add_menu_page('ZohoDataSync Automated Tool', 'ZohoDataSync Automated Tool', 'manage_options', 'zds-automated-id', 'zdsAutomated_options', '', 40);
    add_submenu_page('zds-automated-id', 'Zoho Authtoken', 'Zoho Authtoken', 'manage_options', 'set-zoho-authtoken', 'setZohoAuthtoken');
}

function setZohoAuthtoken() {
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    $updated = false;
    if (isset($_REQUEST['authtoken']) && $_REQUEST['authtoken'] != '') {
        update_option('zoho_authtoken', $_REQUEST['authtoken']);
        $updated = true;
    }
?>
<div class="block" style="margin: 10px 20px 25px 0px; padding-bottom: 0px;">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2 style="margin: 0;">Zoho Data Sync Automated Tools Settings</h2>
    </div>
    <div class="block_content">
        <?php if ($updated) { ?><div class="message success">Your Zoho authtoken has been updated.</div><?php } ?>
        <form id="authtoken_set" name="authtoken_set" onsubmit="return validate_authtoken();" method="post" action="">
            <h4>Please set your Zoho Authtoken here</h4>
            <p>
                <label for="authtoken">Your Zoho Authtoken: </label>
                <input type="text" class="text small" name="authtoken" id="authtoken" value="<?php echo get_option( 'zoho_authtoken' ); ?>"/>
            </p>
            <hr />
            <p>
                <input type="submit" class="submit long" value="Update Authtoken" />
            </p>
        </form>
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
    <div class="clear"></div>
</div>
<?php
}

function zdsAutomated_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

    global $MODULE;
	
	extract($_POST);
	
    if( isset($zds_automated_hidden) && $zds_automated_hidden == 'step1' ) {
		$parser = new CsvConversion();
		$parser->convert_excel_to_csv(substr($uploaded_file_name, (strpos($uploaded_file_name, '.') + 1) ), $uploaded_file_name);
		if ( isset($action) && $action == 'csv' ) {
			uploadInstruction();
		} else if ( isset($action) && $action == 'zoho' ) {
			module_load_before_sync($zoho_module_name);
		}
	} else if( isset($zds_automated_hidden) && $zds_automated_hidden == 'step2' ) {
        data_sync_into_zoho($zoho_module_name);
	} else if ( !isset($zds_automated_hidden) ){
    ?>
<div class="block" style="margin: 10px 20px 25px 0px; padding-bottom: 0px;">
	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>
		<h2 style="margin: 0;">Zoho Data Sync Automated Tools Settings</h2>
	</div>
	<div class="block_content">
		<form id="zds_file_convert_into_CSV" name="zds_file_convert_into_CSV" onsubmit="return validate_form_step_1();" enctype="multipart/form-data" method="post" action="">
			<input type="hidden" name="zds_automated_hidden" value="step1"/>
			<input type="hidden" id="uploaded_file_name" name="uploaded_file_name" value=""/>
			<h3 style="text-decoration: underline;">Step One</h3>
			<h4>Please upload your file either to upload directly into Zoho or download the CSV format file.</h4>
			<p>
				<label for="file_type">Your file type: </label>
				<select id="file_type" class="styled" name="file_type">
					<option selected="selected" value="">None</option>
					<option value="xlsx">Microsoft Excel 2007</option>
					<option value="xls">Microsoft Excel 2003</option>
				</select>
			</p>
			<p>
				<label for="action">You want to: </label>
				<select id="action" class="styled" name="action">
					<option value="csv" selected="selected">Download CSV</option>
					<option value="zoho">Upload into Zoho</option>
				</select>
			</p>		
			<p id="zoho_module_p">
				<label for="zoho_module_name">Zoho module (Only for uploading directly into Zoho): </label>
				<select id="zoho_module_name" class="styled" name="zoho_module_name">
					<option selected="selected" value="none">None</option>
                    <?php foreach ($MODULE as $key => $value) { ?>
                        <option value="<?php echo $key ?>"><?php echo $value ?></option>
                    <?php } ?>
				</select>
			</p>
			<p class="fileupload">
				<label>Your file: </label><br/>
				<input id="fileupload" type="file"/>
				<span id="uploadmsg">Max size depends on your server uploading configuration.</span>
			</p>
			<hr />			
			<p>
				<input type="submit" class="submit small" value="Submit" />
			</p>
		</form>
	</div>
	<div class="bendl"></div>
	<div class="bendr"></div>
	<div class="clear"></div>
</div>
<script type="text/javascript">
	function validate_form_step_1(){
		$('#zoho_module_p .cmf-skinned-select').removeClass('redBorder');
		var selectedAction = document.getElementById("action").value;
		var selectedZohoModule = document.getElementById("zoho_module_name").value;
		var uploadedFile = document.getElementById("uploaded_file_name").value;
		
		if (selectedAction == 'zoho' && selectedZohoModule == 'none') {
			alert("Please select correct zoho module to upload your data.");
			$('#zoho_module_p .cmf-skinned-select').addClass('redBorder');
			return false;
		}
		
		if (uploadedFile == '') {
			alert("Please upload your data file first.");
			$('.fileupload .file').addClass('redBorder');
			return false;
		}
		
		return true;
	}

    function validate_authtoken(){
        if ($('#authtoken').val == '') {
            alert("Authtoken can not be empty.");
            return false;
        }

        return true;
    }
</script>

<?php
	}
}
?>