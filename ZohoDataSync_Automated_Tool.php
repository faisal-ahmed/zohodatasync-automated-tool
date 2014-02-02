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

/********** Admin Panel **************************/

include_once ( plugin_dir_path( __FILE__ ) . 'includeLibraryFiles.php');
function pr_scripts_styles() {
	if (strpos($_SERVER['REQUEST_URI'], 'zds-automated-id') !== false ||
        strpos($_SERVER['REQUEST_URI'], 'set-zoho-authtoken') !== false ||
        strpos($_SERVER['REQUEST_URI'], 'show-zoho-missing-data') !== false) {
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
    add_menu_page('Zoho Data Migrator', 'Zoho Data Migrator', 'manage_options', 'zds-automated-id', 'zdsAutomated_options', '', 40);
    add_submenu_page('zds-automated-id', 'Zoho Authtoken', 'Zoho Authtoken', 'manage_options', 'set-zoho-authtoken', 'setZohoAuthtoken');
    add_submenu_page('zds-automated-id', 'Zoho Report', 'Zoho Report', 'manage_options', 'show-zoho-missing-data', 'showReport');
}

function showReport() {
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    migationFailedData();
    echo '<button id="donatchart" value="' . basename(__DIR__) . '" style="display:none;"></button>';
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
    authtokenView($updated);
    echo '<button id="donatchart" value="' . basename(__DIR__) . '" style="display:none;"></button>';
}

function zdsAutomated_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	extract($_POST);
	
    if( isset($zds_automated_hidden) && $zds_automated_hidden == 'step1' ) {
		$parser = new CsvConversion();
		$parser->convert_excel_to_csv(substr($uploaded_file_name, (strpos($uploaded_file_name, '.') + 1) ), $uploaded_file_name);
		if ( isset($action) && $action == 'csv' ) {
			uploadInstructionView();
		} else if ( isset($action) && $action == 'zoho' ) {
			zohoMigratorStepTwoView($zoho_module_name);
		}
	} else if( isset($zds_automated_hidden) && $zds_automated_hidden == 'step2' ) {
        zohoMigratorStepThreeDataSync($zoho_module_name, $zoho_column_matching, $duplicateCheck);
	} else if ( !isset($zds_automated_hidden) ){
        zohoMigratorStepOneView();
	}
    echo '<button id="donatchart" value="' . basename(__DIR__) . '" style="display:none;"></button>';
}
?>