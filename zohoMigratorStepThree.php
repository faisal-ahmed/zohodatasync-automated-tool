<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mohammad Faisal Ahmed <faisal.ahmed0001@gmail.com>
 * Date: 1/29/14
 * Time: 8:25 PM
 * To change this template use File | Settings | File Templates.
 */

// $zoho_column_matching is a key => value matching where key = zoho column and value = file's column
function zohoMigratorStepThreeDataSync($zoho_module_name, $zoho_column_matching, $duplicateCheck){
    $xmlArray = buildXmlArray($zoho_column_matching);
    $dataMigrationControllerObj = new ZohoDataSync();
    $error = '';
    $totalInserted = 0;
    $totalUpdated = 0;
    $totalIgnored = 0;
    foreach ($xmlArray as $bulkKey => $bulkRecords) {
        $response = $dataMigrationControllerObj->insertRecords($zoho_module_name, $bulkRecords, "$duplicateCheck");
        $xml = simplexml_load_string($response);
        if ($dataMigrationControllerObj->errorFound($xml)) {
            $error = "Zoho error. Parse the error code";
            break;
        } else if ($xml !== false) {
            foreach ($xml->result->row as $key => $insertedObject) {
                if (trim($insertedObject->success->code) == 2000 ) $totalInserted++;
                else if (trim($insertedObject->success->code) == 2001 ) $totalUpdated++;
                else if (trim($insertedObject->success->code) == 2002 ) $totalIgnored++;
            }
        } else {
            $error = 'Error on reading data file. Please try again from beginning.';
            break;
        }
    }
    if ($totalInserted != 0 || $totalUpdated != 0) {
        $successMessage = "$totalInserted records have been inserted, ";
        $successMessage .= "$totalUpdated records have been updated and ";
        $successMessage .= "$totalIgnored records have been ignored.";
    } else {
        $successMessage = '';
    }
    zohoMigratorStepTwoView($zoho_module_name, $error, $successMessage);
}

function buildXmlArray($zoho_column_matching){
    $xmlMultipleArray = array();
    $newConverter = new CsvConversion();
    $start = 1;
    $end = $start + 99;
    while (count($tempArray = $newConverter->parse_csv_to_array($zoho_column_matching, $start, $end))) {
        $xmlMultipleArray[] = $tempArray;
        $start = $end;
        $end = $start + 99;
    }

    return $xmlMultipleArray;
}