<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        #customers {
            font-family: "Helvetica", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 0px solid #ddd;
            padding: 0px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 0px;
            padding-bottom: 0px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>


<?php
date_default_timezone_set('Africa/Lagos');
$servername = "localhost";
$username = "uhlngcom_erp";
$password = "AxIe]4;3)AIF";
$dbname = "uhlngcom_eco";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



	$today = time();
	$due_date= date("Y-m-d G.i:s", strtotime('+0 hours', $today)); //Convert to Nigeria time
	$due_date2= date('Y-m-d H:i:s', strtotime('+23 hours', $today)); // Current Time 
	
	$close_date= date("Y-m-d 0:0:0", strtotime('+0 hours', $today)); //Convert to Nigeria time
	
	
$sql = "SELECT * FROM  `call_logs` WHERE request_status='Open' ORDER BY log_day asc ";
//$sql = "SELECT * FROM tbl_request  WHERE request_status = '' AND due_date >= '$due_date' AND  due_date <= '$due_date2' ORDER BY due_date  ASC";


//$sql = "SELECT * FROM tbl_request_dump  WHERE terminal_id ='10331377'";
//$sql="SELECT * FROM tb_xxx WHERE id_prd = '$ref_id_prd'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {  

//Count the Number of Open Calls;
$sql_count = "SELECT Count(*) As counter FROM call_logs WHERE request_status='Open' ";
$result_count=mysqli_query($conn, $sql_count);
$count_open=mysqli_fetch_assoc($result_count);
$open_call =$count_open['counter'];

//Count the Number of Closed Calls;
$sql_closed = "SELECT Count(*) As counter FROM call_logs  WHERE request_status = 'Closed'  AND closed_at >= '$close_date' ";
$result_closed=mysqli_query($conn, $sql_closed );
$count_closed=mysqli_fetch_assoc($result_closed);
$closed_call =$count_closed['counter'];


//Count the Number of SLA Violated  Calls;
//$sql_sla = "SELECT Count(*) As counter FROM tbl_request  WHERE request_status = '' AND due_date <= '$due_date'  ";
//$result_sla=mysqli_query($conn, $sql_sla );
//$count_sla=mysqli_fetch_assoc($result_sla);
//$sla_call =$count_sla['counter'];



        $text = "";

$text .= "Dear All, \n\n ";
$text .= "<p>";
$text .= "QUICK DAILY ANALYSIS. \n\n" . date("l jS \of F Y h:i:s A");
$text .= "<p>";
$text .= "Number of OPEN Calls = " .$open_call. "\n\n";
$text .= "<p>";
$text .= "Number of CLOSED Calls = " .$closed_call. "\n\n";
$text .= "<p>";
// $text .= "Number of Calls that VIOLATE SLA = " .$sla_call. "\n\n";

$text .= "<p>";
$text .= "Below call are Still Pending for Closure. \n\n";
// Open the table:
$text .= "<table  bgcolor=#fff width=100% border=1>";
// Table header...
$text .= "<thead  bgcolor=#4CAF50 ><tr><th>SN</th><th>Terminal ID</th><th>ATM Name</th><th>Fault Description</th><th>CE Name</th><th>Log Date</th>
<th>Age</th><th>Hours</th><th>Brand</th><th>SLA</th><th>State</th></tr>\n";
// Open the table body
$text .= "<tbody>\n";
$no=0; 	
while($rs = mysqli_fetch_assoc($result))
//while ($rs = mysql_fetch_array($result))
	{
$no++;	
        $terminal_id=$rs['terminal_id'];
        $atm_name=$rs['atm_name'];
        $error_code=$rs['error_code'];
        $request_assign_to=$rs['ce_name'];
		$log_day=$rs['mail_at'];
	    $current_time=date("H:i");
		$log_time=$rs['log_time'];
        $remark="Open";
        	$brand=$rs['brand'];
        
        $ticket_no=$rs['ticket_no'];
        $tech_id=$rs['ce_id'];
        $sn=$rs['id'];
       
	    $atm_state=$rs['atm_state'];
		$sla_level=$rs['hour'];
		 $current_date=date("Y-m-d");
		 
	   	$datetime2 = new DateTime("$current_date");
		$datetime1 = new DateTime("$log_day");
		$interval = $datetime1->diff($datetime2);
		$days= $interval->format('%R%a');
		$day2 = $days*12;
		
		
		
		$time2 = new DateTime("$current_time");
		$time1 = new DateTime("$log_time");
		$interval = $time1->diff($time2);
		$hours= $interval->h ."<br/>";
		$age =$hours+$day2;
		
		$datetime2 = new DateTime("$current_date");
		$datetime1 = new DateTime("$log_day");
		$interval = $datetime1->diff($datetime2);
		//$hours= $interval->h . " hours ";
		$daysAge= $interval->format('%R%a days');
		//$age = $days ." ". $hours;
		
		
	 $sn  = sprintf( '%04d', $sn);
	 $tech_id = sprintf( '%03d', $tech_id);
	 $ticket_id=  $tech_id .'-'. $ticket_no .'-'. $sn;

  

        //$tech_id=$rs['work_id'];
       // $sn=$rs['id'];
	
	if ($rs['sla_level'] == 'UP_COUNTRY_SLA') {
			
		if ($age <=8 && $rs['sla_level'] = 'UP_COUNTRY_SLA')
	
		$penalty='0000';
	//	elseif ($age >5 && $age <=16)
		elseif ($age >8 && $age <=19 && $rs['sla_level'] = 'UP_COUNTRY_SLA')
	//	elseif ($age >30 && $age <=41)
		//if ($uba_down_time2 <=6 && $uba_down_time2 >=30)
		$penalty='1500';
		
	//	elseif ($age >16 && $age <=27) 
		elseif ($age >19 && $age <=30 && $rs['sla_level'] = 'UP_COUNTRY_SLA') 
	//	elseif ($age >41 && $age <=52) 
		 $penalty='3000';
		
//		elseif ($age >27 && $age <=38) 
		elseif ($age >30 && $age <=41 && $rs['sla_level'] = 'UP_COUNTRY_SLA') 
//		elseif ($age >52 && $age <=63) 
		 $penalty='6000';
		 
		 	 
//		elseif ($age >38 && $age <=49) 
		elseif ($age >41 && $age <=52 && $rs['sla_level'] = 'UP_COUNTRY_SLA') 
//		elseif ($age >63 && $age <74) 
		 $penalty='7500';
		 
//		elseif ($age >49 && $age <=60) 
		elseif ($age >52 && $age <=63 && $rs['sla_level'] = 'UP_COUNTRY_SLA') 
//		elseif ($age >74 && $age <=85) 
		 $penalty='10000';
		 
//		elseif ($age >60 && $age <=71) 
		elseif ($age >63 && $age <=74 && $rs['sla_level'] = 'UP_COUNTRY_SLA') 
//		elseif ($age >85 && $age <=96) 
		 $penalty='12500';
		 
//		elseif ($age >71 && $age <=82) 
		elseif ($age >74 && $age <=85 && $rs['sla_level'] = 'UP_COUNTRY_SLA') 
//		elseif ($age >96 && $age <=107) 
		 $penalty='15000';
		  else
		 $penalty='No Payment';
		}
		
		elseif ($rs['sla_level'] == 'BASIC_SLA') {
			
		
		//Basic
		if ($age <=5 && $rs['sla_level'] = 'BASIC_SLA')
	
		$penalty='0000';
		elseif ($age >5 && $age <=16 && $rs['sla_level'] = 'BASIC_SLA')
		$penalty='1500';
		
		elseif ($age >16 && $age <=27 && $rs['sla_level'] = 'BASIC_SLA') 
		 $penalty='3000';
		
		elseif ($age >27 && $age <=38 && $rs['sla_level'] = 'BASIC_SLA') 
		 $penalty='6000';
		 
		 	 
		elseif ($age >38 && $age <=49 && $rs['sla_level'] = 'BASIC_SLA') 
		 $penalty='7500';
		 
		elseif ($age >49 && $age <=60 && $rs['sla_level'] = 'BASIC_SLA') 
		 $penalty='10000';
		 
		elseif ($age >60 && $age <=71 && $rs['sla_level'] = 'BASIC_SLA') 
		 $penalty='12500';
		 
		elseif ($age >71 && $age <=82 && $rs['sla_level'] = 'BASIC_SLA') 
		 $penalty='15000';
		 
		 else
		 $penalty='No Payment';
		
		}
		 else {
			 
		if ($age <=30 && $rs['sla_level'] = 'HARD_SLA')
	
		$penalty='0000';
		elseif ($age >30 && $age <=41)
		$penalty='1500';
		
		elseif ($age >41 && $age <=52) 
		 $penalty='3000';
		
		elseif ($age >52 && $age <=63) 
		 $penalty='6000';
		 
		 	 
		elseif ($age >63 && $age <=74) 
		 $penalty='7500';
		 
		elseif ($age >74 && $age <=85) 
		 $penalty='10000';
		 
		elseif ($age >85 && $age <=96) 
		 $penalty='12500';
		 

		elseif ($age >96 && $age <=107) 
		 $penalty='15000';
		  else
		 $penalty='No Payment';
		}
			 
			 
		 
		 

		
           	// echo "Have a nice weekend!";
		//echo $hours . ' hours'; 
	 $sn  = sprintf( '%04d', $sn);
        
        
        
        // Build table rows...
  $text .= "<tr><td> $no</td><td>$terminal_id</td><td>$atm_name</td><td>$error_code</td>
		<td> $request_assign_to</td><td>$log_day</td><td>$daysAge</td><td>$hours</td><td>$brand</td><td>$sla_level</td><td>$atm_state</td>
		</tr>";

}
// Close the table    l jS \of F Y h:i:s A
$text .= "</table>";
$subject = "ATM DAILY REPORT - " . date("j F Y h A", time());
//$subject = "ATM SLA ALERT REPORT ";
$sql2 = "select * from uhl_report_email";
// tbl_uhl_email        tbl_uhl_report_email     tbl_tech_email_dump
$result2 = mysqli_query($conn, $sql2);
// tbl_tech_email_dump 

//$result2 = mysqli_query ("select * from tbl_uhl_email");
			if (mysqli_num_rows ($result2)>0){
				//$sender = "helpdesk@atm.universalhorizonng.com";
				$headers = 'From: helpdesk@erp.uhlng.com' . "\r\n" .
 			"MIME-Version: 1.0" . "\r\n" . 
           "Content-type: text/html; charset=UTF-8" . "\r\n";
          echo  $msg = $text;
				while ($row = mysqli_fetch_assoc($result2)){
					$email = $row ['email'];
				//	 mail("$email",$subject,$text,$headers);
				}
			} else {
				 $error = "No data in table tbl_tech_email";
			}
}
?>