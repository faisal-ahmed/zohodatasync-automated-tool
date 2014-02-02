<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mohammad Faisal Ahmed <faisal.ahmed0001@gmail.com>
 * Date: 1/29/14
 * Time: 6:37 PM
 * To change this template use File | Settings | File Templates.
 */

function migationFailedData()
{
    $csvConversion = new CsvConversion();
    $dataColumn = $csvConversion->parse_csv_column('report.csv');
    $reportData = $csvConversion->get_report();
    ?>
    <div class="block" style="margin: 10px 20px 25px 0px; padding-bottom: 0px;">
        <div class="block_head">
            <div class="bheadl"></div>
            <div class="bheadr"></div>
            <h2 style="margin: 0;">Zoho Data Sync Automated Tools Settings</h2>
        </div>
        <div class="block_content">
            <form action="" method="post">
                <?php if ($success != '') { ?>
                    <div class="message success"><?php echo $success ?></div><?php } ?>
                <?php if ($error != '') { ?>
                    <div class="message errormsg"><?php echo $error ?></div><?php } ?>
                <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
                    <thead>
                    <tr>
                        <?php foreach ($dataColumn as $key => $value) { ?>
                        <th class="header headerSortUp" style="cursor: pointer; <?php if ($key == 0 || $key == 1) echo "font-weight: bold;"; ?>">
                            <?php echo $value; ?>
                        </th>
                        <?php } ?>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($reportData as $key => $row) { ?>
                    <tr>
                        <?php foreach ($row as $key1 => $value) { ?>
                        <td style="<?php if ($key1 == 0 || $key1 == 1) echo "font-weight: bold;"; ?>">
                            <?php if ($key1 != 1) { echo $value; } else { echo date("Y-m-d H:i:s", $value); }?>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </form>
        </div>
        <div class="bendl"></div>
        <div class="bendr"></div>
        <div class="clear"></div>
    </div>
<?php
}