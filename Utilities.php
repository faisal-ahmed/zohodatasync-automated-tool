<?php
/*
 * Created on January 6, 2014
 * Author: Mohammad Faisal Ahmed <faisal.ahmed0001@gmail.com>
 */

//TODO: This authtoken is replaced by the database field.
define("AUTH_TOKEN","5e702408ec8f9da1dd38acc66707bb1d");

//Zoho Modules Name
define("LEAD_MODULE","Leads");
define("ACCOUNT_MODULE","Accounts");
define("CONTACT_MODULE","Contacts");
define("POTENTIAL_MODULE","Potentials");
define("CAMPAIGN_MODULE","Campaigns");
define("CASE_MODULE","Cases");
define("SOLUTION_MODULE","Solutions");
define("PRODUCT_MODULE","Products");
define("PRICE_BOOK_MODULE","PriceBooks");
define("QUOTE_MODULE","Quotes");
define("INVOICE_MODULE","Invoices");
define("SALES_ORDER_MODULE","SalesOrders");
define("VENDOR_MODULE","Vendors");
define("PURCHASE_ORDER_MODULE","PurchaseOrders");
define("EVENT_MODULE","Events");
define("TASK_MODULE","Tasks");
define("CALL_MODULE","Calls");

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
    CALL_MODULE => "Calls",
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
$MANDATORY_FIELD_FOR_MODULE[LEAD_MODULE] = array('Company','Last Name');
$MANDATORY_FIELD_FOR_MODULE[ACCOUNT_MODULE] = array('Account Name');
$MANDATORY_FIELD_FOR_MODULE[CONTACT_MODULE] = array('Last Name');
$MANDATORY_FIELD_FOR_MODULE[POTENTIAL_MODULE] = array('Potential Name','Account Name','Closing Date','Stage');
$MANDATORY_FIELD_FOR_MODULE[CAMPAIGN_MODULE] = array('Campaign Name');
$MANDATORY_FIELD_FOR_MODULE[CASE_MODULE] = array('Case Origin','Status','Subject',);
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