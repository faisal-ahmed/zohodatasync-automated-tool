<?php

include_once 'ZohoIntegrator.php';
include_once 'Utilities.php';

class ZohoDataSync extends ZohoIntegrator
{
    public function __construct()
    {
        $this->resetWithDefaults();
        $authtokenSet = $this->setZohoAuthToken(AUTH_TOKEN);
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

    public function searchRecordsWithCustomField($moduleName, $fieldName, $fieldValue, $matchingExpression = 'contains')
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
        $this->setZohoExtendedUriParameter($extraParameter);

        return $this->doRequest();
    }

    public function insertRecords($moduleName, $xmlArray, $wfTrigger = 'false', $version = 'false')
    {
        if (($response = $this->checkMandatoryFields($moduleName, $xmlArray)) !== true) return $response;
        $this->resetWithDefaults();
        $this->setZohoModuleName("$moduleName");
        $this->setZohoApiOperationType('insertRecords');
        $this->setRequestMethod('POST');
        if ($wfTrigger != 'false') $this->setWfTrigger($wfTrigger);
        if ($version != 'false') $this->setMultipleOperation($version);
        $xmlSet = $this->setZohoXmlColumnNameAndValue($xmlArray);

        if ($xmlSet !== true) return $xmlSet;

        return $this->doRequest();
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
}

?>