#!/usr/bin/php -q

<?php
//  Use -q so that php doesn't print out the HTTP headers

/*
 * mailPipe.php
 *
 * This script is a sample of how to use mailReader.php as a mailp pipe to save 
 * emailed attachments and emails into a directory and/or database
 *
 * Test it by running
 *
 * cat mail.raw | ./mailPipe.php
 *
 * Support: 
 * http://stuporglue.org/mailreader-php-parse-e-mail-and-save-attachments-php-version-2/
 *
 * Code:
 * https://github.com/stuporglue/mailreader
 *
 * See the README.md for the license, and other information
 */


// Set a long timeout in case we're dealing with big files
ini_set("include_path", '/home/uhlngcom/php:' . ini_get("include_path") );
set_time_limit(600);
ini_set('max_execution_time',600);

// Anything printed to STDOUT will be sent back to the sender as an error!
// error_reporting(-1);
// ini_set("display_errors", 1);

error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/home/uhlngcom/error_log');
// Require the file with the mailReader class in it
require_once('mailReader.php');

// Where should discovered files go
$save_directory = __DIR__; // stick them in the current directory

// Configure your MySQL database connection here
// Other PDO connections will probably work too
$db_host = 'localhost';
$db_un = 'uhlngcom_erp';
$db_pass = 'AxIe]4;3)AIF';
$db_name = 'uhlngcom_eco';
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8",$db_un,$db_pass);


// Who can send files to through this script?
$allowed_senders = Array('OSOGA@ecobank.com', 'BERAYANMEN@ecobank.com', 'WSALAMI@ecobank.com','KAMAECHI@ecobank.com', 'Alleng-AtmandPos@ecobank.com', 'osoga@ecobank.com', 'berayanmen@ecobank.com', 'wsalami@ecobank.com', 'EISAAC@ecobank.com', 'EADUM@ecobank.com', 'chnny4allmygirl@yahoo.com', 'eisaac@ecobank.com', 'eadum@ecobank.com', 'HDAIRO@ecobank.com', 'hdairo@ecobank.com', 'alleng-atmandpos@ecobank.com','AAJIBADE@ecobank.com','jafolayan@ecobank.com', 'JAFOLAYAN@ecobank.com', 'fabdulazeez@ecobank.com', 'FABDULAZEEZ@ecobank.com', 'aamoo@ecobank.com', 'AAMOO@ecobank.com', 'dchukwuji@ecobank.com', 'DCHUKWUJI@ecobank.com', 'oladejisteven@gmail.com', 'Oladejisteve@gmail.com', 'Oladejisteven@gmail.com','kamaechi@ecobank.com');



$mr = new mailReader($save_directory,$allowed_senders,$pdo);
$mr->save_msg_to_db = TRUE;
$mr->send_email = TRUE;
$mr->send_ce_email = TRUE;
$mr->send_requester_mail = TRUE;
//$mr->extract_terminal_id = TRUE;


// Example of how to add additional allowed mime types to the list
// $mr->allowed_mime_types[] = 'text/csv';
$mr->readEmail();