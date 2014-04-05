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
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        $url = '/wordpress/wp-content/plugins/' . basename(__DIR__) . '/utils_conversion.php?get_my_csv=download_now&file=report';
    } else {
        $url = '/wp-content/plugins/' . basename(__DIR__) . '/utils_conversion.php?get_my_csv=download_now&file=report';
    }

    $csvConversion = new CsvConversion();
    $dataColumn = $csvConversion->parse_csv_column('report.csv');
    $reportData = $csvConversion->get_report();
    ?>
    <script type="text/javascript">
        function download_csv(){
            var file_download = $.post( "", {'get_my_csv': 'download_now', 'file': 'report'}, function( data ) {
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
        </div>
        <div class="block_content">
            <h2>These rows of data were failed to migrate into Zoho CRM in your last data migration.</h2>
            <h3 style="display: inline-block;"><span style="color: red;font-size: 1.3em;font-weight: bolder;">*</span> denotes the mandatory field as per your mapping.</h3>
            <h3 style="display: inline-block; float: right;"><a href="#" onclick="download_csv();">Download this report file</a></h3>
            <form action="" method="post">
                <?php if ($success != '') { ?>
                    <div class="message success"><?php echo $success ?></div><?php } ?>
                <?php if ($error != '') { ?>
                    <div class="message errormsg"><?php echo $error ?></div><?php } ?>
                <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
                    <thead>
                    <tr>
                        <?php foreach ($dataColumn as $key => $value) { ?>
                        <th class="header headerSortUp" style="cursor: pointer; <?php if ($key == 0 || $key == 1) echo "font-weight: bold;"; if ($key == 0) echo "border-left: 1px solid #dddddd;"; ?>">
                            <?php echo $value; ?>
                        </th>
                        <?php } ?>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if (count($reportData) > 0) { foreach ($reportData as $key => $row) { ?>
                    <tr>
                        <?php foreach ($row as $key1 => $value) { ?>
                        <td style="<?php if ($key1 == 0 || $key1 == 1) echo "font-weight: bold;"; if ($key1 == 0) echo "border-left: 1px solid #dddddd;"; ?>">
                            <?php if ($key1 != 1) { echo $value; } else { echo date("Y-m-d H:i:s", $value); }?>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php } } else { ?>
                    <tr>
                        <td colspan="<?php echo count($dataColumn) ?>" style="font-weight: bold;text-align: center;border-left: 1px solid #dddddd;">
                            <?php echo 'All data have been migrated successfully last time.'?>
                        </td>
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