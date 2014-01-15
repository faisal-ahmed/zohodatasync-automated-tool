<?php
/*
 * Created on January 6, 2014
 * Author: Mohammad Faisal Ahmed <faisal.ahmed0001@gmail.com>
 */

//Auth Token
define("AUTH_TOKEN","5e702408ec8f9da1dd38acc66707bb1d");

//Zoho Modules Name
define("LEAD_MODULE","Leads");
define("ACCOUNT_MODULE","Accounts");
define("CONTACT_MODULE","Contacts");
define("SALES_ORDER_MODULE","SalesOrders");
define("INVOICE_MODULE","Invoices");
define("PRODUCT_MODULE","Products");

//Zoho Module
global $MODULE;
$MODULE = array(
    LEAD_MODULE => "Leads",
    ACCOUNT_MODULE => "Accounts",
    CONTACT_MODULE => "Contacts",
    SALES_ORDER_MODULE => "Sales Orders",
    INVOICE_MODULE => "Invoices",
    PRODUCT_MODULE => "Products",
);

//Zoho Fields To Exclude For Data Migration
global $EXCLUDE_FIELDS;
$EXCLUDE_FIELDS = array(
    "CONTACTID",
    "SMOWNERID",
    "ACCOUNTID",
    "CAMPAIGNID",
    "Contact Owner",
    "Created Time",
    "Modified Time",
    "Last Activity Time",
);

//Zoho Default ID For Each Module To Get A Sample Record
global $DEFAULT_ID_FOR_MODULE;
$DEFAULT_ID_FOR_MODULE[CONTACT_MODULE] = "673941000000271001"; // Contact last name: oDesk Faisal

global $MANDATORY_FIELD_FOR_MODULE;
$MANDATORY_FIELD_FOR_MODULE[CONTACT_MODULE] = array('Last Name');
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