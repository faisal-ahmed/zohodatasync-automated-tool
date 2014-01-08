<?php
/*
 * Author - Mohammad Faisal Ahmed
 * Email - <faisal.ahmed0001@gmail.com>
 */
 
include_once 'Utilities.php';

abstract class ZohoIntegrator
{
    private $zohoApiUrl;
    private $zohoModuleName;
    private $zohoApiOperationType;
    private $zohoXmlColumn;
    private $zohoAuthToken;
    private $zohoScope;
    private $zohoEncoding;
    private $xmlData;
    private $requestMethod;
    private $requestUriToZoho;
    private $zohoResponse;
    private $uriParameter;
    private $wfTrigger;
    private $uriParameterExtended;
    private $multipleOperation;

    public function resetWithDefaults()
    {
        $this->setZohoApiUrl('https://crm.zoho.com/crm/private/xml');
        $this->setZohoScope('crmapi');
        $this->setZohoEncoding('ISO-8859-1');
        $this->setRequestMethod('GET');
        $this->wfTrigger = 'false';
        $this->multipleOperation = 'false';
        $this->xmlData = '';
        $this->zohoApiOperationType = '';
        $this->zohoModuleName = '';
        $this->uriParameter = '';
        $this->requestUriToZoho = '';
        $this->zohoResponse = '';
        $this->uriParameterExtended = '';
        return true;
    }

    public function setZohoApiUrl($apiUrl)
    {
        if ($apiUrl == '') return 'Value cannot be empty';
        $this->zohoApiUrl = $apiUrl;
        return true;
    }

    public function setZohoModuleName($moduleName)
    {
        if ($moduleName == '') return 'Value cannot be empty';
        $this->zohoModuleName = $moduleName;
        return true;
    }

    public function setZohoApiOperationType($operationType)
    {
        if ($operationType == '') return 'Value cannot be empty';
        $this->zohoApiOperationType = $operationType;
        return true;
    }

    public function setZohoXmlColumnNameAndValue($xmlColumn)
    {
        if (!is_array($xmlColumn)) return 'Data must be an array';

        $this->zohoXmlColumn = $xmlColumn;

        return true;
    }

    public function addZohoXmlColumnNameAndValue($xmlColumn)
    {
        if (!is_array($this->zohoXmlColumn)) $this->zohoXmlColumn = array();

        if (!is_array($xmlColumn)) $this->zohoXmlColumn = array_merge($this->zohoXmlColumn, (array)$xmlColumn);
        else $this->zohoXmlColumn = array_merge($this->zohoXmlColumn, $xmlColumn);

        return true;
    }

    public function setZohoExtendedUriParameter($parameter)
    {
        if (!is_array($parameter)) return 'Data must be an array';

        $this->uriParameterExtended = $parameter;

        return true;
    }

    public function addZohoExtendedUriParameter($parameter)
    {
        if (!is_array($this->uriParameterExtended)) $this->uriParameterExtended = array();

        if (!is_array($parameter)) $this->uriParameterExtended = array_merge($this->uriParameterExtended, (array)$parameter);
        else $this->uriParameterExtended = array_merge($this->uriParameterExtended, $parameter);
        ;

        return true;
    }

    public function setZohoAuthToken($authToken)
    {
        if ($authToken == '') return 'Value cannot be empty';
        $this->zohoAuthToken = $authToken;
        return true;
    }

    public function setZohoScope($scope)
    {
        if ($scope == '') return 'Value cannot be empty';
        $this->zohoScope = $scope;
        return true;
    }

    public function setZohoEncoding($encoding)
    {
        if ($encoding == '') return 'Value cannot be empty';
        $this->zohoEncoding = $encoding;
        return true;
    }

    public function setRequestMethod($requestMethod)
    {
        if ($requestMethod == '') return 'Value cannot be empty';
        $this->requestMethod = $requestMethod;
        return true;
    }

    public function setWfTrigger($trigger)
    {
        if (!(strtolower($trigger) === 'true' || strtolower($trigger) === 'false')) return 'Value must be either true or false';
        $this->wfTrigger = strtolower($trigger);
        return true;
    }

    public function setMultipleOperation($operation)
    {
        $this->multipleOperation = $operation;
        return true;
    }

    public function getWfTrigger()
    {
        return $this->wfTrigger;
    }

    public function getMultipleOperation()
    {
        return $this->multipleOperation;
    }

    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    public function getZohoEncoding()
    {
        return $this->zohoEncoding;
    }

    public function getZohoApiUrl()
    {
        return $this->zohoApiUrl;
    }

    public function getZohoModuleName()
    {
        return $this->zohoModuleName;
    }

    public function getZohoApiOperationType()
    {
        return $this->zohoApiOperationType;
    }

    public function getZohoXmlColumn()
    {
        return $this->zohoXmlColumn;
    }

    public function getZohoAuthToken()
    {
        return $this->zohoAuthToken;
    }

    public function getZohoScope()
    {
        return $this->zohoScope;
    }

    public function getExtendedParameter()
    {
        return $this->uriParameterExtended;
    }

    public function getFullRequestUriToZoho()
    {
        return $this->requestUriToZoho . '?' . $this->uriParameter;
    }

    public function getXMLData()
    {
        return $this->xmlData;
    }

    private function XMLGeneration($xmlArray, $rowsCount = 1, $rowsName = 'row', $keyAdd = true)
    {
        $xmlData = '';
        $count = $rowsCount;
        foreach ($xmlArray as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) $finalOutput = $this->XMLGeneration($value, $key, $rowsName);
                else $finalOutput = $this->XMLGeneration($value, 1, $key, false);
            } else {
                $finalOutput = $value;
            }
            if (is_string($key) && (is_string($value) || !array_key_exists(1, $value))) $xmlData .= "<FL val='$key'>$finalOutput</FL>";
            else $xmlData .= $finalOutput;
        }

        if ($keyAdd === true) return "<$rowsName no='$rowsCount'>$xmlData</$rowsName>";
        return $xmlData;
    }

    protected function buildXML()
    {
        if (empty($this->zohoXmlColumn))
            return 'Please set the XML values correctly';

        $xmlData = '';
        $count = 1;
        foreach ($this->zohoXmlColumn as $key => $value) {
            $xmlData .= "<row no='$count'>" . $this->XMLGeneration($value, 1, 'row', false) . "</row>";
            $count++;
        }

        $this->xmlData = "<?xml version='1.0' encoding='{$this->zohoEncoding}'?>" . "<{$this->zohoModuleName}>" . $xmlData . "</{$this->zohoModuleName}>";

        return true;
    }

    protected function buildRequestUri()
    {
        if (empty($this->zohoApiUrl))
            return 'Please set the Zoho URL correctly';
        else if (empty($this->zohoModuleName))
            return 'Please set the Zoho Module correctly';
        else if (empty($this->zohoApiOperationType))
            return 'Please set the Zoho Operation type correctly';

        $this->requestUriToZoho = $this->zohoApiUrl . '/' . $this->zohoModuleName . '/' . $this->zohoApiOperationType;

        return true;
    }

    private function setParameter($key, $value)
    {
        $this->uriParameter = isset($this->uriParameter) && strlen($this->uriParameter) != 0 ? ("{$this->uriParameter}&$key=$value") : ("$key=$value");
        return true;
    }

    protected function buildUriParameter()
    {
        $this->buildXML();

        if (isset($this->zohoAuthToken))
            $this->setParameter('authtoken', $this->zohoAuthToken);
        else return 'Zoho Auth Token missing';

        if (isset($this->zohoScope))
            $this->setParameter('scope', $this->zohoScope);
        else return 'Zoho Scope missing';

        if (isset($this->xmlData))
            $this->setParameter('xmlData', $this->xmlData);

        if (isset($this->wfTrigger))
            $this->setParameter('wfTrigger', $this->wfTrigger);

        if ($this->multipleOperation != 'false')
            $this->setParameter('version', $this->multipleOperation);

        foreach ($this->uriParameterExtended as $key => $value)
            $this->setParameter($key, $value);

        return true;
    }

    protected function sendCurl()
    {
        if (!isset($this->requestUriToZoho) || strlen($this->requestUriToZoho) == 0) return "Request URI not set";
        if (!isset($this->uriParameter) || strlen($this->uriParameter) == 0) return "Request URI parameter not set";
        try {
            /* initialize curl handle */
            $ch = curl_init();
            /* set url to send request */
            curl_setopt($ch, CURLOPT_URL, $this->requestUriToZoho);
            /* allow redirects */
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            /* return a response into a variable */
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            /* times out after 30s */
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            /* set POST method */
            curl_setopt($ch, CURLOPT_POST, 1);
            /* add POST fields parameters */
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->uriParameter);
            /* execute the cURL */
            $this->zohoResponse = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $exception) {
            $this->zohoResponse = $exception;
            echo 'Exception Message: ' . $exception->getMessage() . '<br/>';
            echo 'Exception Trace: ' . $exception->getTraceAsString();
        }

        return $this->zohoResponse;
    }

    private function array_key_exist_recursive($keyElement, $arrayElement)
    {
        foreach ($arrayElement as $key => $value) {
            if (($key == $keyElement) || (is_array($value) && $this->array_key_exist_recursive($keyElement, $value)))
                return true;
        }
        return false;
    }

    protected function checkMandatoryFields($moduleName, $xmlArray)
    {
        if ($moduleName === ACCOUNT_MODULE && !$this->array_key_exist_recursive('Account Name', $xmlArray))
            return 'Account Name is mandatory field for Accounts and is missing';
        if ($moduleName === CONTACT_MODULE && !$this->array_key_exist_recursive('Last Name', $xmlArray))
            return 'Last Name is mandatory field for Contacts and is missing';
        if ($moduleName === SALES_ORDER_MODULE) {
            if (!$this->array_key_exist_recursive('Subject', $xmlArray)) return 'Subject is mandatory field and is missing';
            if (!$this->array_key_exist_recursive('Account Name', $xmlArray)) return 'Account Name is mandatory field and is missing';
            if (!$this->array_key_exist_recursive('Product Id', $xmlArray)) return 'Product Id is mandatory field and is missing';
        }
        return true;
    }

    abstract public function doRequest();
}

class B2CControllerForDrupal extends ZohoIntegrator
{
    public function __construct($authtoken = null)
    {
        $this->resetWithDefaults();
        $authtoken = ($authtoken === null) ? variable_get('zoho_authtoken', '') : $authtoken;
        $authtokenSet = $this->setZohoAuthToken($authtoken);
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