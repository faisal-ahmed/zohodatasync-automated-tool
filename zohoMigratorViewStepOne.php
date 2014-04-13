<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mohammad Faisal Ahmed <faisal.ahmed0001@gmail.com>
 * Date: 1/29/14
 * Time: 8:15 PM
 * To change this template use File | Settings | File Templates.
 */

function zohoMigratorStepOneView($success = '', $error = ''){
    global $MODULE;
?>
<div class="block" style="margin: 10px 20px 25px 0px; padding-bottom: 0px;">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2 style="margin: 0;">Zoho Data Sync Automated Tools Settings</h2>
    </div>
    <div class="block_content">
        <?php if ($success != '') { ?><div class="message success"><?php echo $success ?></div><?php } ?>
        <?php if ($error != '') { ?><div class="message errormsg"><?php echo $error ?></div><?php } ?>
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
            <input type="hidden" name="action" id="action" value="zoho"/>
<!--            <p>
                <label for="action">You want to: </label>
                <select id="action" class="styled" name="action">
                    <option value="csv" selected="selected">Download CSV</option>
                    <option value="zoho">Upload into Zoho</option>
                </select>
            </p>
-->            <p id="zoho_module_p">
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
<?php } ?>