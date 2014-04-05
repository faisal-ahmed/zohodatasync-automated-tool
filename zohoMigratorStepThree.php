<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mohammad Faisal Ahmed <faisal.ahmed0001@gmail.com>
 * Date: 1/29/14
 * Time: 8:25 PM
 * To change this template use File | Settings | File Templates.
 */

// $zoho_column_matching is a key => value matching where key = zoho column and value = file's column
function zohoMigratorStepThreeDataSync($zoho_module_name, $zoho_column_matching, $duplicateCheck, $mendatoryArray){
    $mendatoryArray = explode(',', $mendatoryArray);
    global $MULTIPLE_INSERT_NOT_ALLOWED_FOR_MODULE;
    $xmlArray = buildXmlArray($zoho_column_matching, $zoho_module_name);
    $dataMigrationControllerObj = new ZohoDataSync();
    $error = '';
    $insertedCount = 0;
    $updatedCount = 0;
    $ignoredCount = 0;
    $ignoredDataToBuildCSV = array(buildIgnoredDataColumn($mendatoryArray, $zoho_column_matching));
    $ignoredDataToBuildCSV1 = array(buildIgnoredDataColumn($mendatoryArray, $zoho_column_matching, true));
    $offset = getOffsetCountToSendDataPerRequest($zoho_module_name);
    $currentTime = time();
    $dataProcessed = 0;
    foreach ($xmlArray as $bulkKey => $bulkRecords) {
        echo $duplicateCheck;
        $response = $dataMigrationControllerObj->insertRecords($zoho_module_name, $bulkRecords, "$duplicateCheck");
        $xml = simplexml_load_string($response);
        if ($xml !== false) {
            $updated = array();
            $inserted = array();
            $ignored = array();
            if (!in_array($zoho_module_name, $MULTIPLE_INSERT_NOT_ALLOWED_FOR_MODULE) && !$dataMigrationControllerObj->errorFound($xml)) {
                foreach ($xml->result->row as $key => $insertedObject) {
                    if (trim($insertedObject->success->code) == 2000 ) {
                        $inserted[] = $insertedObject['no'];
                    }
                    else if (trim($insertedObject->success->code) == 2001 ) {
                        $updated[] = $insertedObject['no'];
                    }
                    else if (trim($insertedObject->success->code) == 2002 ) {
                        $ignored[] = $dataProcessed + $insertedObject['no'];
                    }
                }
                $ignored = array_merge($ignored, array_diff(range(1, count($bulkRecords)), array_merge($inserted, $updated)));
            } else {
                if (isset($xml->result->message) && trim($xml->result->message) == 'Record(s) added successfully') {
                    $inserted[] = $bulkKey+1;
                } else {
                    $ignored[] = $bulkKey+1;
                }
            }
            $insertedCount += count($inserted);
            $updatedCount += count($updated);
            $ignoredCount += count($ignored);
            if (count($ignored) > 0) {
                sort($ignored);
                $rowsValue = getDataOfRowsForReport($ignored, $zoho_module_name, $currentTime);
                foreach ($rowsValue as $row => $rowValue) {
                    $ignoredDataToBuildCSV[] = $rowValue[0];
                    $ignoredDataToBuildCSV1[] = $rowValue[1];
                }
            }
        } else {
            $error = 'Something went wrong! Please try again later. Please check the Zoho authtoken/Zoho daily API limits/Your Internet connection.';
            zohoMigratorStepOneView('', $error);
        }
        $dataProcessed += $offset;
    }
    if ($insertedCount != 0 || $updatedCount != 0 || $ignoredCount != 0) {
        $successMessage = $insertedCount . " record(s) added successfully, ";
        $successMessage .= $updatedCount . " record(s) updated successfully";
        if ($ignoredCount) {
            $successMessage .= " and " . $ignoredCount . " record(s) ignored. Please see report for details.";
        }
    } else {
        $successMessage = 'No Result! Your request has been processed.';
    }

    $csvConversion = new CsvConversion();
    $csvConversion->array_to_csv_report_file($ignoredDataToBuildCSV);
    $csvConversion->array_to_csv_report_file($ignoredDataToBuildCSV1, true);

    zohoMigratorStepOneView($successMessage, $error);
}

function buildIgnoredDataColumn($mendatoryArray, $zoho_column_matching, $forReportDownload = false){
    if ($forReportDownload === false) {
        $csvColumnForIgnoredData = array('Module_Name', 'Migration_Time');
    } else {
        $csvColumnForIgnoredData = array();
    }
    $csvConversion = new CsvConversion();
    $csv_column_name = $csvConversion->parse_csv_column();

    foreach ($csv_column_name as $key => $value){
        $mendatory = '';
        if ( ($keyMatching = array_search($key, $zoho_column_matching)) !== FALSE && in_array($keyMatching, $mendatoryArray)){
            $mendatory = "<span style='color: red;font-size: 1.3em;font-weight: bolder;'>*</span>";
        }
        if ($forReportDownload === false) {
            $csvColumnForIgnoredData[] = $key . $mendatory;
        } else {
            $csvColumnForIgnoredData[] = $key;
        }
    }

    return $csvColumnForIgnoredData;
}

function getOffsetCountToSendDataPerRequest($zoho_module_name) {
    global $MULTIPLE_INSERT_NOT_ALLOWED_FOR_MODULE;
    $trashholdValueForMultipleInsertion = 1;
    if (!in_array($zoho_module_name, $MULTIPLE_INSERT_NOT_ALLOWED_FOR_MODULE)) {
        $trashholdValueForMultipleInsertion = MAX_RECORD_TO_INSERT_VIA_insertRecords;
    }

    return $trashholdValueForMultipleInsertion;
}

function buildXmlArray($zoho_column_matching, $zoho_module_name){
    $trashholdValueForMultipleInsertion = getOffsetCountToSendDataPerRequest($zoho_module_name);
    $xmlMultipleArray = array();
    $newConverter = new CsvConversion();
    $start = 1;
    while (count($tempArray = $newConverter->parse_csv_to_array($zoho_column_matching, $start, $trashholdValueForMultipleInsertion))) {
        $xmlMultipleArray[] = $tempArray;
        $start += $trashholdValueForMultipleInsertion;
    }

    return $xmlMultipleArray;
}

function getDataOfRowsForReport($rows, $zoho_module_name, $currentTime) {
    $csvConversion = new CsvConversion();
    $initialItem = array($zoho_module_name, $currentTime);
    $return = array();
    $rowsData = $csvConversion->getDataOfRows($rows);
    foreach ($rowsData as $key => $value) {
        $ret = array();
        $ret[0] = array_merge($initialItem, $value);
        $ret[1] = $value;
        $return[] = $ret;
    }
    return $return;
}