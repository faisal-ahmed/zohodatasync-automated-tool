<?php

include_once 'ZohoIntegrator.php';

class ZohoDataSync extends ZohoIntegrator
{
    public function __construct()
    {
        $this->resetWithDefaults();
        /*$authtokenSet = $this->setZohoAuthToken(AUTH_TOKEN);*/
        $authtokenSet = $this->setZohoAuthToken(get_option( 'zoho_authtoken' ));
        if ($authtokenSet !== true) {
            echo 'Please provide authtoken or set auth token first';
            die();
        }
    }

    public function doRequest()
    {
        $response = $this->buildRequestUri();
        if ($response !== true) return $response;
        $response = $this->buildUriParameter();
        if ($response !== true) return $response;
        return $this->sendCurl();
    }

    public function searchRecordsWithCustomField($moduleName, $fieldName, $fieldValue, $fromIndex = null, $toIndex = null, $matchingExpression = 'contains')
    {
        $this->resetWithDefaults();
        $this->setZohoModuleName("$moduleName");
        $this->setZohoApiOperationType('getSearchRecords');
        if ($matchingExpression == 'contains') $fieldValue = '*' . $fieldValue . '*';
        $extraParameter = array(
            "searchColumn" => "$moduleName($fieldName)",
            "searchCondition" => "($fieldName|$matchingExpression|$fieldValue)",
            "selectColumns" => "All",
        );

        if ($fromIndex != null) {
            $extraParameter['fromIndex'] = $fromIndex;
        } else {
            $extraParameter['fromIndex'] = 1;
        }
        if ($toIndex != null) {
            $extraParameter['toIndex'] = $toIndex;
        } else {
            $extraParameter['toIndex'] = 200;
        }
        $this->setZohoExtendedUriParameter($extraParameter);

        return $this->doRequest();
    }

    public function getRecordById($moduleName, $id, $newFormat = 1)
    {
        $this->resetWithDefaults();
        $this->setZohoModuleName("$moduleName");
        $this->setZohoApiOperationType('getRecordById');
        $extraParameter = array(
            "id" => "$id",
            "newFormat" => $newFormat
        );
        $this->setZohoExtendedUriParameter($extraParameter);

        return $this->doRequest();
    }

    /*
     * Param: @type
     * Empty - To retrieve all fields from the module
     * 1 - To retrieve all fields from the summary view
     * 2 - To retrieve all mandatory fields from the module
     *
    */
    public function getFields($moduleName, $type = null) // 1 for all fields and 2 for mandatory fields
    {
        $this->resetWithDefaults();
        $this->setZohoModuleName("$moduleName");
        $this->setZohoApiOperationType('getFields');
        if ($type != null) {
            $extraParameter = array(
                "type" => "$type"
            );
            $this->setZohoExtendedUriParameter($extraParameter);
        }

        return $this->doRequest();
    }

    public function insertRecords($moduleName, $xmlArray, $duplicateCheck = 'false', $wfTrigger = 'false', $version = 'false')
    {
        $this->resetWithDefaults();
        $this->setZohoModuleName("$moduleName");
        $this->setZohoApiOperationType('insertRecords');
        $this->setRequestMethod('POST');
        if ($duplicateCheck != 'false' && count($xmlArray) > 1 ) {
            $version = 4;
            $this->setZohoExtendedUriParameter(array('duplicateCheck' => $duplicateCheck));
        }
        if ($wfTrigger != 'false') $this->setWfTrigger($wfTrigger);
        if ($version != 'false') $this->setMultipleOperation($version);
        if (($xmlSet = $this->setZohoXmlColumnNameAndValue($xmlArray)) !== true) return $xmlSet;
        /*if (count($xmlArray) == 1 && ($response = $this->checkMandatoryFields($moduleName)) !== true){
            return $response;
        } else if (count($xmlArray) > 1 && ($response = $this->checkMandatoryFieldsForMultiple($moduleName)) !== true) {
            return $response;
        }*/

        return $this->doRequest();
    }

    public function uploadFile($moduleName, $id, $fileUrl)
    {
        $this->resetWithDefaults();
        $this->setZohoModuleName("$moduleName");
        $this->setZohoApiOperationType('uploadFile');
        $extraParameter = array(
            "id" => "$id",
            "content" => "@$fileUrl"
        );

        $this->setZohoExtendedUriParameter($extraParameter);

        return $this->doRequest();
        // Response trim($xml->result->message) == "File has been attached successfully"
    }

    public function uploadPhoto($moduleName, $id, $fileUrl)
    {
        $this->resetWithDefaults();
        $this->setZohoModuleName("$moduleName");
        $this->setZohoApiOperationType('uploadPhoto');
        $extraParameter = array(
            "id" => "$id",
            "content" => "@$fileUrl"
        );

        $this->setZohoExtendedUriParameter($extraParameter);

        return $this->doRequest();
        // Response trim($xml->result->message) == "Photo uploaded succuessfully"
    }

    public function getRecordsOfZoho($moduleName, $lastModifiedTime = null, $sortColumnString = null, $sortOrderString = 'desc', $fromIndex = null, $toIndex = null)
    {
        $this->resetWithDefaults();
        $this->setZohoModuleName("$moduleName");
        $this->setZohoApiOperationType('getRecords');
        $extraParameter = array(
            "sortOrderString" => "$sortOrderString"
        );
        if (isset($lastModifiedTime)) $extraParameter['lastModifiedTime'] = $lastModifiedTime;
        if (isset($fromIndex)) $extraParameter['fromIndex'] = $fromIndex;
        if (isset($toIndex)) $extraParameter['toIndex'] = $toIndex;
        if (isset($sortColumnString)) $extraParameter['sortColumnString'] = $sortColumnString;

        $this->setZohoExtendedUriParameter($extraParameter);

        return $this->doRequest();
    }

    public function getCVRecordsOfZoho($moduleName, $cvName, $lastModifiedTime = null, $fromIndex = null, $toIndex = null)
    {
        $this->resetWithDefaults();
        $this->setZohoModuleName("$moduleName");
        $this->setZohoApiOperationType('getCVRecords');
        $extraParameter = array(
            "cvName" => "$cvName",
            "selectColumns" => "All",
        );
        if (isset($lastModifiedTime)) $extraParameter['lastModifiedTime'] = $lastModifiedTime;
        if (isset($fromIndex)) $extraParameter['fromIndex'] = $fromIndex;
        if (isset($toIndex)) $extraParameter['toIndex'] = $toIndex;

        $this->setZohoExtendedUriParameter($extraParameter);

        return $this->doRequest();
    }

    public function errorFound($xml) {
        if ((isset($xml->nodata->code) && trim($xml->nodata->code) !== "")
            || (isset($xml->error->code) && trim($xml->error->code) !== "")) {
            return true;
        }
        return false;
    }

    public function parseError($errorXml){

    }
}

?>