<?php

require_once('mimeDecode.php');
date_default_timezone_set('Africa/Lagos');
/*
 * @class mailReader.php
 *
 * @brief Recieve mail and attachments with PHP
 *
 * Support: 
 * http://stuporglue.org/mailreader-php-parse-e-mail-nd-save-attachments-php-version-2/
 *
 * Code:
 * https://github.com/stuporglue/mailreader
 *
 * See the README.md for the license, and other information
 */

class mailReader {

    var $saved_files = Array();
    var $send_email = FALSE; // Send confirmation e-mail back to sender?
    var $save_msg_to_db = FALSE; // Save e-mail message and file list to DB?
    var $send_softwork_email = FALSE; // Send Mail to SoftWork Assigned?
    var $send_requester_mail = FALSE; // Send Mail to the CC of the mail?
    //var extract_terminal_id = FALSE;
    var $save_directory; // A safe place for files. Malicious users could upload a php or executable file, so keep this out of your web root
    var $allowed_senders = Array(); // Allowed senders is just the email part of the sender (no name part)
    
// $due_date ->getTimestamp(); 
 //$maildate ->getTimestamp(); 
 
 

    var $allowed_mime_types = Array(
        'audio/wave',
        'application/pdf',
        'application/zip',
        'application/octet-stream',
        'image/jpeg',
        'image/png',
        'image/gif',
    );
    var $debug = FALSE;
    var $raw = '';
    var $decoded;
    var $from;
    var $subject;
    var $body2;
    var $body;
    var $due_date;
      var $maildate;
   var 	$mat;
      var $day;
   var $tech_name;
    var $request_status;
       // var $headers= " From: info@universalhorizonng.com";

    /**
     * @param $save_directory (required) A path to a directory where files will be saved
     * @param $allowed_senders (required) An array of email addresses allowed to send through this script
     * @param $pdo (optional) A PDO connection to a database for saving emails_dump 
     */
    public function __construct($save_directory, $allowed_senders, $pdo = NULL) {
        if (!preg_match('|/$|', $save_directory)) {
            $save_directory .= '/';
        } // add trailing slash if needed
        $this->save_directory = $save_directory;
        $this->allowed_senders = $allowed_senders;
        $this->pdo = $pdo;
    }

    /**
     * @brief Read an email message
     *
     * @param $src (optional) Which file to read the email from. Default is php://stdin for use as a pipe email handler
     *
     * @return An associative array of files saved. The key is the file name, the value is an associative array with size and mime type as keys.
     */
    public function readEmail($src = 'php://stdin') {
        // Process the e-mail from stdin
        $fd = fopen($src, 'r');
        while (!feof($fd)) {
            $this->raw .= fread($fd, 1024);
        }

        // Now decode it!
        // http://pear.php.net/manual/en/package.mail.mail-mimedecode.decode.php
        $decoder = new Mail_mimeDecode($this->raw);
        $this->decoded = $decoder->decode(
                Array(
                    'decode_headers' => TRUE,
                    'include_bodies' => TRUE,
                    'decode_bodies' => TRUE,
                )
        );

        // Set $this->from_email and check if it's allowed
        $this->from = $this->decoded->headers['from'];
        $this->from_email = preg_replace('/.*<(.*)>.*/', "$1", $this->from);
        if (!in_array($this->from_email, $this->allowed_senders)) {
            die("$this->from_email not an allowed sender");
        }

        // Set the $this->subject
        $this->subject = $this->decoded->headers['subject'];

        // Find the email body, and any attachments
        // $body_part->ctype_primary and $body_part->ctype_secondary make up the mime type eg. text/plain or text/html
        if (isset($this->decoded->parts) && is_array($this->decoded->parts)) {
            foreach ($this->decoded->parts as $idx => $body_part) {
                $this->decodePart($body_part);
            }
        }

        if (isset($this->decoded->disposition) && $this->decoded->disposition == 'inline') {
            $mimeType = "{$this->decoded->ctype_primary}/{$this->decoded->ctype_secondary}";

            if (isset($this->decoded->d_parameters) && array_key_exists('filename', $this->decoded->d_parameters)) {
                $filename = $this->decoded->d_parameters['filename'];
            } else {
                $filename = 'file';
            }

            $this->saveFile($filename, $this->decoded->body, $mimeType);
            $this->body = "Body was a binary";
        }

        // We might also have uuencoded files. Check for those.
        if (!isset($this->body)) {
            if (isset($this->decoded->body)) {
                $this->body = $this->decoded->body;
            } else {
                $this->body = "No plain text body found";
            }
        }

        if (preg_match("/begin ([0-7]{3}) (.+)\r?\n(.+)\r?\nend/Us", $this->body) > 0) {
            foreach ($decoder->uudecode($this->body) as $file) {
                // file = Array('filename' => $filename, 'fileperm' => $fileperm, 'filedata' => $filedata)
                $this->saveFile($file['filename'], $file['filedata']);
            }
            // Strip out all the uuencoded attachments from the body
            while (preg_match("/begin ([0-7]{3}) (.+)\r?\n(.+)\r?\nend/Us", $this->body) > 0) {
                $this->body = preg_replace("/begin ([0-7]{3}) (.+)\r?\n(.+)\r?\nend/Us", "\n", $this->body);
            }
        }


        // Put the results in the database if needed
        if ($this->save_msg_to_db && !is_null($this->pdo)) {
            $this->saveToDb();
        }

        // Send response e-mail if needed
        if ($this->send_email && $this->from_email != "") {
            $this->sendEmail();
        }

        
      
        // Send e-mail to Technician
      //  if ($this->extract_terminal_id) {
        //    $this->ExtractTerminal();
          //          }
 
        
        // Send e-mail to Technician
        
         if ($this->send_requester_mail) {
            $this->sendRequesterMail();
          
        }
        if ($this->send_softwork_email) {
            $this->sendSoftworkEmail();
                    }
        // Print messages
        if ($this->debug) {
            $this->debugMsg();
        }

        return $this->saved_files;
    }

    /**
     * @brief Decode a single body part of an email message
     *
     * @note Recursive if nested body parts are found
     *
     * @note This is the meat of the script.
     *
     * @param $body_part (required) The body part of the email message, as parsed by Mail_mimeDecode
     */
    private function decodePart($body_part) {
        if (array_key_exists('name', $body_part->ctype_parameters)) { // everyone else I've tried
            $filename = $body_part->ctype_parameters['name'];
        } else if ($body_part->ctype_parameters && array_key_exists('filename', $body_part->ctype_parameters)) { // hotmail
            $filename = $body_part->ctype_parameters['filename'];
        } else {
            $filename = "file";
        }

        $mimeType = "{$body_part->ctype_primary}/{$body_part->ctype_secondary}";

        if ($this->debug) {
            print "Found body part type $mimeType\n";
        }

        if ($body_part->ctype_primary == 'multipart') {
            if (is_array($body_part->parts)) {
                foreach ($body_part->parts as $ix => $sub_part) {
                    $this->decodePart($sub_part);
                }
            }
        } else if ($mimeType == 'text/plain') {
            if (!isset($body_part->disposition)) {
                $this->body .= $body_part->body . "\n"; // Gather all plain/text which doesn't have an inline or attachment disposition
            }
        } else if (in_array($mimeType, $this->allowed_mime_types)) {
            $this->saveFile($filename, $body_part->body, $mimeType);
        }
    }

    /**
     * @brief Save off a single file
     *
     * @param $filename (required) The filename to use for this file
     * @param $contents (required) The contents of the file we will save
     * @param $mimeType (required) The mime-type of the file
     */
    private function saveFile($filename, $contents, $mimeType = 'unknown') {
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);

        $unlocked_and_unique = FALSE;
        while (!$unlocked_and_unique) {
            // Find unique
            $name = time() . "_" . $filename;
            while (file_exists($this->save_directory . $name)) {
                $name = time() . "_" . $filename;
            }

            // Attempt to lock
            $outfile = fopen($this->save_directory . $name, 'w');
            if (flock($outfile, LOCK_EX)) {
                $unlocked_and_unique = TRUE;
            } else {
                flock($outfile, LOCK_UN);
                fclose($outfile);
            }
        }

        fwrite($outfile, $contents);
        fclose($outfile);

        // This is for readability for the return e-mail and in the DB
        $this->saved_files[$name] = Array(
            'size' => $this->formatBytes(filesize($this->save_directory . $name)),
            'mime' => $mimeType
        );
    }

    /**
     * @brief Format Bytes into human-friendly sizes
     *
     * @return A string with the number of bytes in the largest applicable unit (eg. KB, MB, GB, TB)
     */
    private function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }


    /**
     * @brief Save the plain text, subject and sender of an email to the database
     */
    private function saveToDb() {
    
    		$this->request_status ="Open";
    
        $insert = $this->pdo->prepare("INSERT INTO emails (fromaddr,subject,body) VALUES (?,?,?)");

        // Replace non UTF-8 characters with their UTF-8 equivalent, or drop them
        if (!$insert->execute(Array(
                    mb_convert_encoding($this->from_email, 'UTF-8', 'UTF-8'),
                    mb_convert_encoding($this->subject, 'UTF-8', 'UTF-8'),
                    mb_convert_encoding($this->body, 'UTF-8', 'UTF-8')
                ))) {
            if ($this->debug) {
                print_r($insert->errorInfo());
            }
            die("INSERT INTO emails failed!");
        }
        
	$this->bodyhtml= preg_replace('/<[^>]*>/', "\n", $this->body);
	
	
	//preg_replace('/\<[\/]?(table|tr|td)([^\>]*)\>/i', '', $text);
	
	
		$matches = array();
		// Stop the mail after seeing "From" Dont read mail tray
		$result = explode("From:",$this->bodyhtml);
		$remove_from= $result[0];
		$pieces = explode(PHP_EOL, $remove_from);
		
		//$pieces = explode(PHP_EOL, $this->body);
		$matches = preg_grep("/1033/", $pieces);
		//$results = implode(" | ",array_values($matches));
		//echo "Terminal IDs: ".$results." ";
		foreach ($matches as $columns)
		
		{
		$term=(int)$columns;
	
	/*
	$matches = array();
	preg_match_all('/([\d]+)/', $this->body, $matches);
	$matches = $matches[0];
	var_dump($matches);
	var_dump($matches[0]);
	
	$mat = $matches[0];
	*/
	
	$select = $this->pdo->query("SELECT * FROM bank_datas WHERE terminal_id = $term ");
     $select = $select->fetchAll();
 	 if(count($select) > 0) {
 	foreach($select AS $row) {
	$this->sol_id =$row['sol_id'];
 	$this->timers =$row['timers'] . "\n\n" ;
	$this->atm_name=$row['atm_name'] . "\n\n" ;
	$this->terminal_id =$row['terminal_id'] . "\n\n" ;
	$this->atm_code=$row['atm_code'];
	
	$this->atm_address=$row['address'];
	$this->atm_state =$row['state'];
	 	}
	 		 	
	 	
	 $select = $this->pdo->query("SELECT * FROM call_logs  WHERE terminal_id = $term AND request_status ='' ");
     $select = $select->fetchAll();
 	 if(count($select) > 0) {
	 echo "Call already Exist (DISCARD)";
	
	}else {
	
	$select_tech = $this->pdo->query("SELECT * FROM tbl_tech_email WHERE terminal_id = $term");
    $select_tech = $select_tech->fetchAll();
 	 
 	foreach($select_tech AS $row) {
 	
	 	$this->ce_name= $row['name'];
		$this->ce_email = $row['email'];
		$this->ce_phone =$row['phone'];
		$this->ce_techid =$row['tech_id'];
	 	}
	    $this->today = time();
		$this->time2 = date("Hi");
		$this->time = $this->time2 + 100;
		//$due_date = date('Y-m-d H:i:s', strtotime('+6 hours', $today));
	    $this->maildate= date("Y-m-d H:i:s", strtotime('+0 hours', $this->today)); //Convert to Nigeria time
	    
	    $this->mailday= date("Y-m-d", strtotime('+0 minutes', $this->today)); //Convert to Nigeria time
		//$this->mailtime= date("G.i:s", strtotime('-1 minutes', $this->today)); //Convert to Nigeria time
		
		$this->mailtime= date("H:i:sa");
	    
	    
        $this->day = date('l');
	   //	 $this->day = 'Sunday';
	if ($this->day== 'Monday' ||$this->day== 'Tuesday' ||$this->day== 'Wednesday' ||$this->day == 'Thursday' ||$this->day== 'Friday' ){
	
        if ($this->timers ==1 && $this->time >= 0000 && $this->time <= 758): 
             $this->due_date= date("Y-m-d 14:00:00",strtotime('today'));
       
        elseif ($this->timers ==1 && $this->time>= 759 && $this->time<= 1100):    	 
        	 $this->due_date= date('Y-m-d H:i:s', strtotime('+7 hours', $this->today));
        	 
        //To be closed by  the following day
        elseif ( $this->timers ==1 && $this->time >= 1101 && $this->time <= 1700):           
          $this->due_date= date('Y-m-d H:i:s', strtotime('+21 hours', $this->today));
       
        elseif ($this->timers ==1 && $this->time >= 1701 && $this->time <= 2359): //All call above 5pm should be postpone to second day
             $this->due_date= date("Y-m-d 14:00:00",strtotime('tomorrow'));
             
       // For 10 Hours SLA
       elseif ($this->timers ==2 && $this->time>= 0000 && $this->time<= 759 ):    	 
        	 $this->due_date= date('Y-m-d H:i:s', strtotime('+10 hours', $today));
        	 
        //To be closed by the following day
        elseif ($this->timers ==2 && $this->time >= 800 && $this->time <= 1659):           
          $this->due_date= date('Y-m-d H:i:s', strtotime('+25 hours', $this->today));
       
        elseif ($this->timers ==2 && $this->time >= 1701 && $this->time <= 2359): //All call above 5pm should be postpone to second day
             $this->due_date= date("Y-m-d 09:00:00",strtotime('+2 day', $this->today));
   
        else:          $this->due_date= date("Y-m-d 09:00:00",strtotime('+2 day', $this->today)); // All the call raise before 8am should start counting from 8am that day.
        endif;
	
	}
	 else {
		// This is FOR WEEKENDS
	if ($this->timers ==1): //All call above 5pm should be postpone to second day
            $this->due_date= date("Y-m-d 14:00:00",strtotime('next Monday'));
	else:   $this->due_date= date("Y-m-d 09:00:00",strtotime('next Tuesday'));
	endif;
	}
        
       
    //Select the Enginer Assigned to the Call
  /*  $select_tech = $this->pdo->query("Select * from tbl_tech_email where terminal_id = $mat ");
        $select_tech = $select_tech ->fetchAll();
        foreach($select_tech AS $row) {

		$this->tech_name=$row['name'] . "\n\n" ;
		
 	}
        
    */    
   
    
    
    	 $insertRequest = $this->pdo->prepare("INSERT INTO call_logs(fromaddress,subject,body,terminal_id,atm_state,ce_name,ce_id,ce_phone,address,ticket_no,due_at,mail_at,log_day,log_time,atm_name,request_status) VALUES 
		 (:fromaddress,:subject,:body,:terminal_id,:atm_state,:ce_name,:ce_id,:ce_phone,:address,:ticket_no,:due_at,:mail_at,:log_day,:log_time,:atm_name,:request_status)");
            $insertRequest->bindParam(':fromaddress', mb_convert_encoding($this->from_email, 'UTF-8', 'UTF-8'));
            $insertRequest->bindParam(':subject', mb_convert_encoding($this->subject, 'UTF-8', 'UTF-8'));
            $insertRequest->bindParam(':body', mb_convert_encoding($this->body, 'UTF-8', 'UTF-8'));
            $insertRequest->bindParam(':terminal_id', $this->terminal_id);
            $insertRequest->bindParam(':atm_state',  $this->atm_state);  
           $insertRequest->bindParam(':ce_name', $this->ce_name);
           $insertRequest->bindParam(':ce_id', $this->ce_techid);
            $insertRequest->bindParam(':ce_phone',  $this->ce_phone);
	   $insertRequest->bindParam(':address', $this->atm_address);
	   $insertRequest->bindParam(':ticket_no',  $this->atm_code);
	    $insertRequest->bindParam(':due_at', $this->due_date);
	    $insertRequest->bindParam(':mail_at', $this->maildate);	    
	     $insertRequest->bindParam(':log_day', $this->mailday);
	    $insertRequest->bindParam(':log_time', $this->mailtime);
	     $insertRequest->bindParam(':atm_name',  $this->atm_name);
	      $insertRequest->bindParam(':request_status', $this->request_status);
	  
	    
	     $insertRequest ->execute();

	            $this->lastsn=$this->pdo->lastInsertId(); 
	   //         $this->lastsn='10';
			/*    if (!$insertRequest->execute()) {
                if ($this->debug) {
                $this->lastsn=$this->pdo->lastInsertId(); 
                    print_r($insertRequest->errorInfo());
                }
                die("Insert file tbl_request failed!");
            }
            */
	
}
        }else {
            echo "No Terminal ID to Need to Save to call_logs ";
            die();
        }
   

    }
    }

    /**
     * @brief Send the sender a response email with a summary of what was saved
   
   
     */
     // This Function is disable
    private function sendEmail() {
        $newmsg = "Thanks! Your mail has been forwarded to our technician concern. ";
        $newmsg .= "He will be on site soonest\n\n";
        $newmsg .="We will share you his detail asap:\n\n";
//Display the message sent
 $headers = 'From: helpdesk@atm.universalhorizonng.com' . "\r\n" .
    		'Reply-To: helpdesk@atm.universalhorizonng.com' . "\r\n" .
    		'X-Mailer: PHP/' . phpversion();
//        mail($this->from_email, $this->subject, $newmsg, $headers);
    }
    
     //Send mail to All the CC -- tbl_requester
   Public function sendRequesterMail() {

	$matches = array();
		// Stop the mail after seeing "From" Dont read mail tray
		$result = explode("From:",$this->body);
		$remove_from= $result[0];
		$this->stop_reading = $result[0];
		$this->today = time();
		$this->maildate= date("Y-m-d G.i:s", strtotime('-5 minutes', $this->today)); //Convert to Nigeria time
    
 	$select = $this->pdo->query("Select * from call_logs WHERE mail_at >=  '$this->maildate' ");
        $select = $select->fetchAll();
                if(count($select) > 0) {
        
        // Build table rows...
        $msg = "The Customer Engineer Detail: \n\n";
	$msg.= "<table  width=100% border=1>";
	// Table header...
	$msg.= "<thead><tr><th>Ticket ID </th><th>ATM Name</th><th>CE Name </th><th>CE Phone No</th><th>Terminal ID</th><th>Log Day</th><th>Log Time</th></tr></thead>\n";
	
	// Open the table body
	$msg.= "<tbody>\n";
  
  
	foreach($select AS $row) {
	$sn= $row['id'];
	$ce_name= $row['ce_name'];
	//$ce_email = $row['tech_email'];
	$ce_phone =$row['ce_phone'];
	$terminal_id = $row['terminal_id'];
	$created_date=$row['log_day'];	
	$created_time=$row['log_time'];	
	$atm_name=$row['atm_name']; 
	//$due_date=$row['due_date'];
	$ticket_no=$row['ticket_no']; 
	$tech_id=$row['ce_id'];
	
	
	
	$sn = sprintf( '%04d', $sn);
	 $tech_id = sprintf( '%03d', $tech_id);
	 $ticket_no=  $tech_id .'-'. $ticket_no .'-'. $sn;
                 
   
	// Add leading Zeros to the S/N
	 $lastsn = sprintf( '%08d', $this->lastsn);

	 // Generate the Table with Data to Customer 
	// Build table rows...
        $msg.= "<tr><td><b>$ticket_no</b></td><td>$atm_name</td><td>$ce_name</td><td>$ce_phone </td><td>$terminal_id </td><td>$created_date</td><td>$created_time</td></tr>";
 	}
   // Close the table
$msg.= "</table>";


        $select = $this->pdo->query("SELECT email FROM requesters");
        $select = $select->fetchAll();
        if(count($select) > 0) {
            foreach($select AS $recipient) {
           //	$newmsg = "Dear  ". $username . ", <br\> ";
            $newmsg = "Thanks! Your mail has been forwarded to the customer engineer in-charge.. ";
        $newmsg .= "He will be on site soonest ";
		$newmsg .= "<p>";
		$newmsg .= "<br>";
		$newmsg .=$msg . "<br\>";
		$newmsg .= "<p>";
		$newmsg .= "<br>";
		
             $newmsg .= "====================================================================\n\n";
             $newmsg .= "<br>";
             $newmsg .= "<br>";
			 $newmsg .= "<p>";
             $newmsg .="$remove_from";
                                 
                    
	
           $headers = 'From: helpdesk@atm.universalhorizonng.com' . "\r\n" .
 			"MIME-Version: 1.0" . "\r\n" . 
           "Content-type: text/html; charset=UTF-8" . "\r\n";
           
                mail($recipient["email"], $this->subject, $newmsg, $headers);
            }
        } else {
            echo "No user to send email";
            die();
        }
    // Mail to CE       
        $select = $this->pdo->query("SELECT email_address1 FROM customer_engineers");
        $select = $select->fetchAll();
        if(count($select) > 0) {
            foreach($select AS $recipient) {
           	$newmsg = "Dear  CE, \n\n ";
            $newmsg .= "One of the mail below await your urgent attention. ";
       
	$newmsg .= "<p>";
	$newmsg .= "<br>";
	$newmsg .=$msg . "<br\>";
	$newmsg .= "<p>";
	$newmsg .= "<br>";
	
             $newmsg .= "====================================================================\n\n";
             $newmsg .= "<br>";
              $newmsg .= "<br>";
	$newmsg .= "<p>";
              $newmsg .=$remove_from;
           
           $headers = 'From: helpdesk@atm.universalhorizonng.com' . "\r\n" .
 			"MIME-Version: 1.0" . "\r\n" . 
           "Content-type: text/html; charset=UTF-8" . "\r\n";
           
                mail($recipient["email_address"], $this->subject, $newmsg, $headers);
            }
        } else {
            echo "No user to send email";
            die();
        }
        
       // }
        
        
   }else {
            echo "No Terminal ID to send email";
            die();
        }
        }
   
   
    //Send mail to Softworks Immediately

    /**
     * @brief Print a summary of the most recent email read
     */
    private function debugMsg() {
        print "From : $this->from_email\n";
        print "Subject : $this->subject\n";
        print "Body : $this->body\n";
        print "Saved Files : \n";
        print_r($this->saved_files);
    }

}
?>
