<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mohammad Faisal Ahmed <faisal.ahmed0001@gmail.com>
 * Date: 1/29/14
 * Time: 8:11 PM
 * To change this template use File | Settings | File Templates.
 */

function authtokenView($updated) {
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
<?php } ?>