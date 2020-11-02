<?php
//date_default_timezone_set('Africa/Lagos');
$servername = "localhost";
$username = "uhlngcom_erp";
$password = "AxIe]4;3)AIF";
$dbname = "uhlngcom_eco";

$today_date=  "2019-12-20";
$conn =mysqli_connect($servername, $username, $password, $dbname);

//echo	$today_date= date("Y-m-d", strtotime('+0 hours', $today)); //Convert to Nigeria time
//
//$due_date= date("Y-m-d G.i:s", strtotime('+0 hours', $today)); //Convert to Nigeria time
//$due_date2= date('Y-m-d H:i:s', strtotime('+23 hours', $today)); // Current Time
//
//$close_date= date("Y-m-d 0:0:0", strtotime('+0 hours', $today)); //Convert to Nigeria time

echo "<br/>";

//Number of calls(Brought Forward)
$sql_count = "SELECT Count(*) As counter FROM call_logs WHERE request_status='Open' AND mail_at < '$today_date' AND closed_at='0000-00-00 00:00:00'";
$result_countbf=mysqli_query($conn, $sql_count);
$count_bf=mysqli_fetch_assoc($result_countbf);
echo $open_bf =$count_bf['counter'];

echo "<br/>";

//Number of Calls logged today
$sql_count = "SELECT Count(*) As counter FROM call_logs WHERE mail_at = '$today_date'";
$result_counttoday=mysqli_query($conn, $sql_count);
$count_today=mysqli_fetch_assoc($result_counttoday);
echo $count_today =$count_today['counter'];

echo "<br/>";

//Total number of calls open as at today
$sql_count = "SELECT Count(*) As counter FROM call_logs WHERE mail_at >= '$today_date'  AND request_status = 'open'";
$result_totalOpen = mysqli_query($conn, $sql_count);
$total_open = mysqli_fetch_assoc($result_totalOpen);
echo $total_open = $total_open['counter'];

echo "<br/>";

//Number of calls resolved today
$sql_count = "SELECT Count(*) As counter FROM call_logs WHERE  request_status='closed' AND closed_at = '$today_date'";
$result_closedtoday = mysqli_query($conn, $sql_count);
$closed_today = mysqli_fetch_assoc($result_closedtoday);
echo $closed_today= $closed_today['counter'];

echo "<br/>";

// ( Calls open for 3 days or more)

$sql_count = "SELECT Count(*) As counter FROM call_logs WHERE mail_at < '$today_date -2' AND request_status = 'open'";
$result_open3= mysqli_query($conn, $sql_count);
$open3 = mysqli_fetch_assoc($result_open3);
echo $open3= $open3['counter'];

echo "<br/>";

//Total calls still open at COB today
$still_open= $total_open - $closed_today;
echo $still_open;

//Suspended calls
$sql_count = "SELECT Count(*) As counter FROM call_logs WHERE request_status = 'suspended'";
$result_suspended = mysqli_query($conn, $sql_count);
$suspended = mysqli_fetch_assoc($result_suspended);
echo $suspended= $suspended['counter'];

echo "<br/>";

//calls for next bus. day
$sql_count = "SELECT Count(*) As counter FROM call_logs WHERE mail_at > '$today_date'";
$result_next = mysqli_query($conn, $sql_count);
$next_bus_day = mysqli_fetch_assoc($result_next);
echo $next_bus_day= $next_bus_day['counter'];

echo "<br/>";


//SLA failure rate
$TotalAtm = 300;
$failure_rate = ($TotalAtm/$open)*100;
echo $failure_rate.'%';

echo "<br/>";

// Estimated percentage uptime
$uptime = 100 - $failure_rate;
echo $uptime.'%';


//Insert Query into report_tb
$query_insert = "INSERT INTO daily_trends (id,brought_forward,calls_logged,open_call_as_today,calls_resolved_at_COB,outliers,still_open,bank_controllable,call_for_nxt_business_day,SLA_failure_rate,uptime) VALUES (null,'$open_bf','$count_today','$total_open','$closed_today','$open3','$still_open','$suspended','$next_bus_day','$failure_rate','$uptime')";

$result = mysqli_query($conn, $query_insert) or die(mysqli_error($conn));
