<?php
/*
 * Created on January 6, 2014
 * Author: Mohammad Faisal Ahmed <faisal.ahmed0001@gmail.com>
 */

//TODO: This authtoken is replaced by the database field.
define("AUTH_TOKEN", "5e702408ec8f9da1dd38acc66707bb1d");
//Max record count to insert via bulk insert
define("MAX_RECORD_TO_INSERT_VIA_insertRecords", 100);

//Zoho Modules Name
define("LEAD_MODULE", "Leads");
define("ACCOUNT_MODULE", "Accounts");
define("CONTACT_MODULE", "Contacts");
define("POTENTIAL_MODULE", "Potentials");
define("CAMPAIGN_MODULE", "Campaigns");
define("CASE_MODULE", "Cases");
define("SOLUTION_MODULE", "Solutions");
define("PRODUCT_MODULE", "Products");
define("PRICE_BOOK_MODULE", "PriceBooks");
define("QUOTE_MODULE", "Quotes");
define("INVOICE_MODULE", "Invoices");
define("SALES_ORDER_MODULE", "SalesOrders");
define("VENDOR_MODULE", "Vendors");
define("PURCHASE_ORDER_MODULE", "PurchaseOrders");
define("EVENT_MODULE", "Events");
define("TASK_MODULE", "Tasks");
define("CALL_MODULE", "Calls");

//Zoho Module
//array format == (Module name => Module title to show)
global $MODULE;
$MODULE = array(
    LEAD_MODULE => "Leads",
    ACCOUNT_MODULE => "Accounts",
    CONTACT_MODULE => "Contacts",
    POTENTIAL_MODULE => "Potentials",
    CAMPAIGN_MODULE => "Campaigns",
    CASE_MODULE => "Cases",
    SOLUTION_MODULE => "Solutions",
    PRODUCT_MODULE => "Products",
    PRICE_BOOK_MODULE => "Price Books",
    QUOTE_MODULE => "Quotes",
    INVOICE_MODULE => "Invoices",
    SALES_ORDER_MODULE => "Sales Orders",
    VENDOR_MODULE => "Vendors",
    PURCHASE_ORDER_MODULE => "Purchase Orders",
    EVENT_MODULE => "Events",
    TASK_MODULE => "Tasks",
    CALL_MODULE => "Calls"
);

//Holds the module name where multiple insertion is not possible
global $MULTIPLE_INSERT_NOT_ALLOWED_FOR_MODULE;
$MULTIPLE_INSERT_NOT_ALLOWED_FOR_MODULE = array(
    QUOTE_MODULE,
    SALES_ORDER_MODULE,
    INVOICE_MODULE,
    PURCHASE_ORDER_MODULE
);

//Zoho Fields To Exclude For Data Migration
global $EXCLUDE_FIELDS;
$EXCLUDE_FIELDS = array(
    "SMOWNERID",
    "ACCOUNTID",
    "CONTACTID",
    "CAMPAIGNID",
    "Contact Owner",
    "Created Time",
    "Created By",
    "Modified Time",
    "Modified By",
    "Last Activity Time",
);

//Zoho Default ID For Each Module To Get A Sample Record
global $DEFAULT_ID_FOR_MODULE;
$DEFAULT_ID_FOR_MODULE[CONTACT_MODULE] = "673941000000271001"; // Contact last name: oDesk Faisal

global $MANDATORY_FIELD_FOR_MODULE;
$MANDATORY_FIELD_FOR_MODULE[LEAD_MODULE] = array('Company', 'Last Name');
$MANDATORY_FIELD_FOR_MODULE[ACCOUNT_MODULE] = array('Account Name');
$MANDATORY_FIELD_FOR_MODULE[CONTACT_MODULE] = array('Last Name');
$MANDATORY_FIELD_FOR_MODULE[POTENTIAL_MODULE] = array('Potential Name', 'Account Name', 'Closing Date', 'Stage');
$MANDATORY_FIELD_FOR_MODULE[CAMPAIGN_MODULE] = array('Campaign Name');
$MANDATORY_FIELD_FOR_MODULE[CASE_MODULE] = array('Case Origin', 'Status', 'Subject');

global $ZOHO_ERROR_CODES;
$ZOHO_ERROR_CODES = array(
    "4000" => "Please use Authtoken, instead of API ticket and APIkey.",
    "4500" => "Internal server error while processing this request",
    "4501" => "API Key is inactive",
    "4502" => "This module is not supported in your edition",
    "4401" => "Mandatory field missing",
    "4600" => "Incorrect API parameter or API parameter value. Also check the method name and/or spelling errors in the API url.",
    "4831" => "Missing parameters error",
    "4832" => "Text value given for an Integer field",
    "4834" => "Invalid ticket. Also check if ticket has expired.",
    "4835" => "XML parsing error",
    "4890" => "Wrong API Key",
    "4487" => "No permission to convert lead.",
    "4001" => "No API permission",
    "401" => "No module permission",
    "401.1" => "No permission to create a record",
    "401.2" => "No permission to edit a record",
    "401.3" => "No permission to delete a record",
    "4101" => "Zoho CRM disabled",
    "4102" => "No CRM account",
    "4103" => "No record available with the specified record ID.",
    "4422" => "No records available in the module",
    "4420" => "Wrong value for search parameter and/or search parameter value.",
    "4421" => "Number of API calls exceeded",
    "4423" => "Exceeded record search limit",
    "4807" => "Exceeded file size limit",
    "4424" => "Invalid File Type",
    "4809" => "Exceeded storage space limit"
);

/*    $testXmlArray = array(
        1 => array(
            'Subject' => 'TEST',
            'Due Date' => '2009-03-10',
            'Sub Total' => '48000.0',
            'Product Details' => array(
                'product' => array(
                    1 => array(
                        'Product Id' => '269840000000136287',
                        'Product Name' => 'prd1',
                        'Unit Price' => '10.0',
                    ),
                    2 => array(
                        'Product Id' => '269840000000136287',
                        'Product Name' => 'prd1',
                        'Unit Price' => '10.0',
                    ),
                    3 => array(
                        'Product Id' => '269840000000136287',
                        'Product Name' => 'prd1',
                        'Unit Price' => '10.0',
                    ),
                    4 => array(
                        'Product Id' => '269840000000136287',
                        'Product Name' => 'prd1',
                        'Unit Price' => '10.0',
                    ),
                ),
            ),
        ),
        2 => array(
            'Subject' => 'TEST',
            'Due Date' => '2009-03-10',
            'Sub Total' => '48000.0',
            'Product Details' => array(
                'product' => array(
                    1 => array(
                        'Product Id' => '269840000000136287',
                        'Product Name' => 'prd1',
                        'Unit Price' => '10.0',
                    ),
                    2 => array(
                        'Product Id' => '269840000000136287',
                        'Product Name' => 'prd1',
                        'Unit Price' => '10.0',
                    ),
                ),
            ),
        ),
    );*/

?>