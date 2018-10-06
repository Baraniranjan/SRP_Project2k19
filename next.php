<html>
<body>
<table border="5" align="center">


<?php
global $i1;
global $i2;
global $i3;
global $i4;
global $i5;
global $query_result;

$i1=$_POST['day'];
$i2=$_POST['month'];
$i3=$_POST['year'];
$i4=$_POST['time'];
$i5=$_POST['query'];



if($i5 == '1')
{
echo"<tr>";
echo"<th>Date</th>";
echo"<th>From Hour</th>	";
echo"<th>No. Of Buses</th>";
echo"<th>No. Of Trips</th>";
echo"</tr>";
  
$mysqlport=getenv('S2G_MYSQL_PORT');

$dbhost="localhost:".$mysqlport;

$dbuser='root';
$dbpass='';

$connect=mysql_connect($dbhost,$dbuser,$dbpass);


mysql_select_db('mtc');



if($i1=='0' && $i4== '24' ) 
  $query_result="SELECT  TicketIssuedDate AS DATE,HOUR(TicketIssuedTime),SUM(k) AS noofbuses,SUM(l) AS nooftrips FROM(SELECT RouteId,COUNT(DISTINCT(ServiceId)) AS k,COUNT((TripNo)) AS l,TicketIssuedTime,TicketIssuedDate FROM (SELECT RouteId,ServiceId,TripNo,TicketIssuedTime,TicketIssuedDate  FROM a GROUP BY RouteId,ServiceId,TripNo)a  GROUP BY RouteId)a GROUP BY DATE,HOUR(TicketIssuedTime)";

if($i1=='0' && $i4!='24')
  $query_result="SELECT  TicketIssuedDate AS DATE,HOUR(TicketIssuedTime),SUM(k) AS noofbuses,SUM(l) AS nooftrips FROM(SELECT RouteId,COUNT(DISTINCT(ServiceId)) AS k,COUNT((TripNo)) AS l,TicketIssuedTime,TicketIssuedDate FROM (SELECT RouteId,ServiceId,TripNo,TicketIssuedTime,TicketIssuedDate  FROM a GROUP BY RouteId,ServiceId,TripNo)a  GROUP BY RouteId)a WHERE TicketIssuedTime BETWEEN '$i4:00' AND '$i4:59' GROUP BY DATE, HOUR(TicketIssuedTime)";

if($i1!='0' && $i4=='24')
  $query_result="SELECT  TicketIssuedDate AS DATE,HOUR(TicketIssuedTime),SUM(k) AS noofbuses,SUM(l) AS nooftrips FROM(SELECT RouteId,COUNT(DISTINCT(ServiceId)) AS k,COUNT((TripNo)) AS l,TicketIssuedTime,TicketIssuedDate  FROM (SELECT RouteId,ServiceId,TripNo,TicketIssuedTime,TicketIssuedDate  FROM a GROUP BY RouteId,ServiceId,TripNo)a  GROUP BY RouteId)a WHERE TicketIssuedDate='$i3-$i2-$i1' GROUP BY DATE,HOUR(TicketIssuedTime)";

if($i1!='0' && $i4!='24')
  $query_result="SELECT  TicketIssuedDate AS DATE,HOUR(TicketIssuedTime),SUM(k) AS noofbuses,SUM(l) AS nooftrips FROM(SELECT RouteId,COUNT(DISTINCT(ServiceId)) AS k,COUNT((TripNo)) AS l,TicketIssuedTime,TicketIssuedDate  FROM (SELECT RouteId,ServiceId,TripNo,TicketIssuedTime,TicketIssuedDate  FROM a GROUP BY RouteId,ServiceId,TripNo)a  GROUP BY RouteId)a WHERE TicketIssuedDate='$i3-$i2-$i1' AND TicketIssuedTime BETWEEN  '$i4:00' AND '$i4:59' GROUP BY HOUR(TicketIssuedTime)";


$result=mysql_query($query_result,$connect);
$filename = 'table';    
$file_ending = "xlsx";
header("Content-Type: application/ms-excel");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
echo"<tr>";
echo"<td>" ;echo $row['DATE'];echo"</td>";
echo"<td>" ;echo $row['HOUR(TicketIssuedTime)'];echo"</td>";
echo"<td>" ;echo $row['noofbuses'];echo"</td>";
echo"<td>" ;echo $row['nooftrips'];echo"</td>";
echo"</tr>";
}}






if($i5 == 2)
{
echo"<tr>";
echo"<th>Date</th>";
echo"<th>Route Id</th>	";
echo"<th>No. Of Buses</th>";
echo"<th>No. Of Trips</th>";
echo"<th>MOR Buses</th>";
echo"<th>MEX Buses</th>";
echo"<th>MDE Buses</th>";
echo"<th>MNS Buses</th>";
echo"<th>MOR Trips</th>";
echo"<th>MEX Trips</th>";
echo"<th>MDE Trips</th>";
echo"<th>MNS Trips</th>";
echo"</tr>";
  
$mysqlport=getenv('S2G_MYSQL_PORT');

$dbhost="localhost:".$mysqlport;

$dbuser='root';
$dbpass='';

$connect=mysql_connect($dbhost,$dbuser,$dbpass);


mysql_select_db('mtc');



if($i1== 0) 
  $query_result="SELECT TicketIssuedDate AS DATE,RouteId,SUM(BusNo) AS NO_OF_BUSES,SUM(TripNo) AS NO_OF_TRIPS,
	SUM(CASE WHEN ServicetypeId='MOR' THEN 1 ELSE 0 END) MOR_BUSES,SUM(CASE WHEN ServicetypeId='MEX' THEN 1 ELSE 0 END) MEX_BUSES,SUM(CASE WHEN ServicetypeId='MDE' THEN 1 ELSE 0 END) MDE_BUSES,SUM(CASE WHEN ServicetypeId='MNS' THEN 1 ELSE 0 END) MNS_BUSES,
	SUM(CASE WHEN ServicetypeId='MOR' THEN TripNo ELSE 0 END) MOR_TRIPS,SUM(CASE WHEN ServicetypeId='MEX' THEN TripNo ELSE 0 END) MEX_TRIPS,SUM(CASE WHEN ServicetypeId='MDE' THEN TripNo ELSE 0 END) MDE_TRIPS,SUM(CASE WHEN ServicetypeId='MNS' THEN TripNo ELSE 0 END) MNS_TRIPS
	FROM (SELECT COUNT(DISTINCT(TripNo))AS TripNo,COUNT(DISTINCT(ServiceId))AS BusNo,RouteId,ServicetypeId,TicketIssuedDate  FROM a GROUP BY RouteId,ServiceId) a GROUP BY TicketIssuedDate,RouteId  ";

if($i1!=0)
  $query_result="SELECT TicketIssuedDate AS DATE,RouteId,SUM(BusNo) AS NO_OF_BUSES,SUM(TripNo) AS NO_OF_TRIPS,
	SUM(CASE WHEN ServicetypeId='MOR' THEN 1 ELSE 0 END) MOR_BUSES,SUM(CASE WHEN ServicetypeId='MEX' THEN 1 ELSE 0 END) MEX_BUSES,SUM(CASE WHEN ServicetypeId='MDE' THEN 1 ELSE 0 END) MDE_BUSES,SUM(CASE WHEN ServicetypeId='MNS' THEN 1 ELSE 0 END) MNS_BUSES,
	SUM(CASE WHEN ServicetypeId='MOR' THEN TripNo ELSE 0 END) MOR_TRIPS,SUM(CASE WHEN ServicetypeId='MEX' THEN TripNo ELSE 0 END) MEX_TRIPS,SUM(CASE WHEN ServicetypeId='MDE' THEN TripNo ELSE 0 END) MDE_TRIPS,SUM(CASE WHEN ServicetypeId='MNS' THEN TripNo ELSE 0 END) MNS_TRIPS
	FROM (SELECT COUNT(DISTINCT(TripNo))AS TripNo,COUNT(DISTINCT(ServiceId))AS BusNo,RouteId,ServicetypeId,TicketIssuedDate  FROM a GROUP BY RouteId,ServiceId) a WHERE TicketIssuedDate='$i3-$i2-$i1' GROUP BY TicketIssuedDate,RouteId  ";


$result=mysql_query($query_result,$connect);
$filename = 'table';    
$file_ending = "xlsx";
header("Content-Type: application/ms-excel");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
echo"<tr>";
echo"<td>" ;echo $row['DATE'];echo"</td>";
echo"<td>" ;echo $row['RouteId'];echo"</td>";
echo"<td>" ;echo $row['NO_OF_BUSES'];echo"</td>";
echo"<td>" ;echo $row['NO_OF_TRIPS'];echo"</td>";
echo"<td>" ;echo $row['MOR_BUSES'];echo"</td>";
echo"<td>" ;echo $row['MEX_BUSES'];echo"</td>";
echo"<td>" ;echo $row['MDE_BUSES'];echo"</td>";
echo"<td>" ;echo $row['MNS_BUSES'];echo"</td>";
echo"<td>" ;echo $row['MOR_TRIPS'];echo"</td>";
echo"<td>" ;echo $row['MEX_TRIPS'];echo"</td>";
echo"<td>" ;echo $row['MDE_TRIPS'];echo"</td>";
echo"<td>" ;echo $row['MNS_TRIPS'];echo"</td>";
echo"</tr>";
}
}







if($i5 == 3)
{
echo"<tr>";
echo"<th>Date</th>";
echo"<th>From Hour</th>	";
echo"<th>No. Of Passengers</th>";
echo"</tr>";
  
$mysqlport=getenv('S2G_MYSQL_PORT');

$dbhost="localhost:".$mysqlport;

$dbuser='root';
$dbpass='';

$connect=mysql_connect($dbhost,$dbuser,$dbpass);


mysql_select_db('mtc');



if($i1== '0' && $i4== '24' ) 
  $query_result="SELECT TicketIssuedDate,HOUR(TicketIssuedTime) AS FROM_HOUR, SUM(Adult+Child) AS NO_OF_PASSENGERS FROM (SELECT Adult,Child,TicketIssuedTime,TicketIssuedDate FROM a)a GROUP BY TicketIssuedDate,HOUR(TicketIssuedTime)";

if($i1=='0' && $i4!='24')
  $query_result="SELECT TicketIssuedDate,HOUR(TicketIssuedTime) AS FROM_HOUR, SUM(Adult+Child) AS NO_OF_PASSENGERS FROM (SELECT Adult,Child,TicketIssuedTime,TicketIssuedDate FROM a)a WHERE TicketIssuedTime BETWEEN '$i4:00' AND '$i4:59' GROUP BY TicketIssuedDate,HOUR(TicketIssuedTime)";

if($i1!='0' && $i4=='24')
  $query_result="SELECT TicketIssuedDate,HOUR(TicketIssuedTime) AS FROM_HOUR, SUM(Adult+Child) AS NO_OF_PASSENGERS FROM (SELECT Adult,Child,TicketIssuedTime,TicketIssuedDate FROM a)a WHERE TicketIssuedDate='$i3-$i2-$i1' GROUP BY TicketIssuedDate,HOUR(TicketIssuedTime)";

if($i1!='0' && $i4!='24')
  $query_result="SELECT TicketIssuedDate,HOUR(TicketIssuedTime) AS FROM_HOUR, SUM(Adult+Child) AS NO_OF_PASSENGERS FROM (SELECT Adult,Child,TicketIssuedTime,TicketIssuedDate FROM a)a WHERE TicketIssuedDate='$i3-$i2-$i1' AND TicketIssuedTime BETWEEN '$i4:00' AND '$i4:59' GROUP BY TicketIssuedDate,HOUR(TicketIssuedTime)";


$result=mysql_query($query_result,$connect);
$filename = 'table';    
$file_ending = "xlsx";
header("Content-Type: application/ms-excel");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
echo"<tr>";
echo"<td>" ;echo $row['TicketIssuedDate'];echo"</td>";
echo"<td>" ;echo $row['FROM_HOUR'];echo"</td>";
echo"<td>" ;echo $row['NO_OF_PASSENGERS'];echo"</td>";
echo"</tr>";
}}





if($i5 == 4)
{
echo"<tr>";
echo"<th>Route Id</th>";
echo"<th>Date</th>";
echo"<th>From Hour</th>	";
echo"<th>No. Of Passengers</th>";
echo"<th>MOR Passengers</th>";
echo"<th>MEX Passengers</th>";
echo"<th>MDE Passengers</th>";
echo"<th>MNS Passengers</th>";
echo"</tr>";
  
$mysqlport=getenv('S2G_MYSQL_PORT');

$dbhost="localhost:".$mysqlport;

$dbuser='root';
$dbpass='';

$connect=mysql_connect($dbhost,$dbuser,$dbpass);


mysql_select_db('mtc');



if($i1== '0' && $i4== '24' ) 
  $query_result="SELECT RouteId,TicketIssuedDate,HOUR(TicketIssuedTime) AS FROM_HOUR,SUM(Adult+Child) AS NO_OF_PASSENGERS,SUM(CASE WHEN ServicetypeId='MOR' THEN Adult+Child ELSE 0 END) MOR_PASSENGERS,SUM(CASE WHEN ServicetypeId='MEX' THEN Adult+Child ELSE 0 END) MEX_PASSENGERS,SUM(CASE WHEN ServicetypeId='MDE' THEN Adult+Child ELSE 0 END) MDE_PASSENGERS,SUM(CASE WHEN ServicetypeId='MNS' THEN Adult+Child ELSE 0 END) MNS_PASSENGERS
	FROM (SELECT Adult,Child,TicketIssuedTime,RouteId,ServicetypeId,TicketIssuedDate FROM a)a GROUP BY RouteId,TicketIssuedDate,HOUR(TicketIssuedTime)";

if($i1=='0' && $i4!='24')
  $query_result="SELECT RouteId,TicketIssuedDate,HOUR(TicketIssuedTime) AS FROM_HOUR,SUM(Adult+Child) AS NO_OF_PASSENGERS,SUM(CASE WHEN ServicetypeId='MOR' THEN Adult+Child ELSE 0 END) MOR_PASSENGERS,SUM(CASE WHEN ServicetypeId='MEX' THEN Adult+Child ELSE 0 END) MEX_PASSENGERS,SUM(CASE WHEN ServicetypeId='MDE' THEN Adult+Child ELSE 0 END) MDE_PASSENGERS,SUM(CASE WHEN ServicetypeId='MNS' THEN Adult+Child ELSE 0 END) MNS_PASSENGERS
	FROM (SELECT Adult,Child,TicketIssuedTime,RouteId,ServicetypeId,TicketIssuedDate FROM a)a WHERE TicketIssuedTime BETWEEN '$i4:00' AND '$i4:59' GROUP BY RouteId,TicketIssuedDate,HOUR(TicketIssuedTime)";

if($i1!='0' && $i4=='24')
  $query_result="SELECT RouteId,TicketIssuedDate,HOUR(TicketIssuedTime) AS FROM_HOUR,SUM(Adult+Child) AS NO_OF_PASSENGERS,SUM(CASE WHEN ServicetypeId='MOR' THEN Adult+Child ELSE 0 END) MOR_PASSENGERS,SUM(CASE WHEN ServicetypeId='MEX' THEN Adult+Child ELSE 0 END) MEX_PASSENGERS,SUM(CASE WHEN ServicetypeId='MDE' THEN Adult+Child ELSE 0 END) MDE_PASSENGERS,SUM(CASE WHEN ServicetypeId='MNS' THEN Adult+Child ELSE 0 END) MNS_PASSENGERS
	FROM (SELECT Adult,Child,TicketIssuedTime,RouteId,ServicetypeId,TicketIssuedDate FROM a)a WHERE TicketIssuedDate='$i3-$i2-$i1' GROUP BY RouteId,TicketIssuedDate,HOUR(TicketIssuedTime)";

if($i1!='0' && $i4!='24')
  $query_result="SELECT RouteId,TicketIssuedDate,HOUR(TicketIssuedTime) AS FROM_HOUR,SUM(Adult+Child) AS NO_OF_PASSENGERS,SUM(CASE WHEN ServicetypeId='MOR' THEN Adult+Child ELSE 0 END) MOR_PASSENGERS,SUM(CASE WHEN ServicetypeId='MEX' THEN Adult+Child ELSE 0 END) MEX_PASSENGERS,SUM(CASE WHEN ServicetypeId='MDE' THEN Adult+Child ELSE 0 END) MDE_PASSENGERS,SUM(CASE WHEN ServicetypeId='MNS' THEN Adult+Child ELSE 0 END) MNS_PASSENGERS
	FROM (SELECT Adult,Child,TicketIssuedTime,RouteId,ServicetypeId,TicketIssuedDate FROM a)a WHERE TicketIssuedDate='$i3-$i2-$i1'  AND TicketIssuedTime BETWEEN '$i4:00' AND '$i4:59' GROUP BY RouteId,TicketIssuedDate,HOUR(TicketIssuedTime)";


$result=mysql_query($query_result,$connect);
$filename = 'table';    
$file_ending = "xlsx";
header("Content-Type: application/ms-excel");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
echo"<tr>";
echo"<td>" ;echo $row['RouteId'];echo"</td>";
echo"<td>" ;echo $row['TicketIssuedDate'];echo"</td>";
echo"<td>" ;echo $row['FROM_HOUR'];echo"</td>";
echo"<td>" ;echo $row['NO_OF_PASSENGERS'];echo"</td>";
echo"<td>" ;echo $row['MOR_PASSENGERS'];echo"</td>";
echo"<td>" ;echo $row['MEX_PASSENGERS'];echo"</td>";
echo"<td>" ;echo $row['MDE_PASSENGERS'];echo"</td>";
echo"<td>" ;echo $row['MNS_PASSENGERS'];echo"</td>";
echo"</tr>";
}
}






if($i5 == 5)
{
echo"<tr>";
echo"<th>Date</th>";
echo"<th>Route Id</th>	";
echo"<th>Service Id</th>";
echo"<th>Trip No.</th>";
echo"<th>Trip first purchased</th>";
echo"<th>Trip last purchased</th>";
echo"<th>No. of Passengers travelled</th>";
echo"</tr>"; 
  
$mysqlport=getenv('S2G_MYSQL_PORT');

$dbhost="localhost:".$mysqlport;

$dbuser='root';
$dbpass='';

$connect=mysql_connect($dbhost,$dbuser,$dbpass);


mysql_select_db('mtc');



if($i1== 0) 
  $query_result="SELECT TicketIssuedDate,RouteId,ServiceId,(TripNo),MIN(TicketIssuedTime) AS TRIP_FIRST_TICKET,MAX(TicketIssuedTime) AS TRIP_LAST_TICKET,SUM(Adult+Child) AS NO_OF_PASSENGERS FROM (SELECT RouteId,(ServiceId),TripNo,TicketIssuedTime,Adult,Child,TicketIssuedDate FROM a )a GROUP BY TicketIssuedDate,RouteId,ServiceId,TripNo";

if($i1!=0)
  $query_result="SELECT TicketIssuedDate,RouteId,ServiceId,(TripNo),MIN(TicketIssuedTime) AS TRIP_FIRST_TICKET,MAX(TicketIssuedTime) AS TRIP_LAST_TICKET,SUM(Adult+Child) AS NO_OF_PASSENGERS FROM (SELECT RouteId,(ServiceId),TripNo,TicketIssuedTime,Adult,Child,TicketIssuedDate FROM a )a WHERE TicketIssuedDate='$i3-$i2-$i1' GROUP BY TicketIssuedDate,RouteId,ServiceId,TripNo ";


$result=mysql_query($query_result,$connect);
$filename = 'table';    
$file_ending = "xlsx";
header("Content-Type: application/ms-excel");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
echo"<tr>";
echo"<td>" ;echo $row['TicketIssuedDate'];echo"</td>";
echo"<td>" ;echo $row['RouteId'];echo"</td>";
echo"<td>" ;echo $row['ServiceId'];echo"</td>";
echo"<td>" ;echo $row['TripNo'];echo"</td>";
echo"<td>" ;echo $row['TRIP_FIRST_TICKET'];echo"</td>";
echo"<td>" ;echo $row['TRIP_LAST_TICKET'];echo"</td>";
echo"<td>" ;echo $row['NO_OF_PASSENGERS'];echo"</td>";
echo"</tr>";
}
}





if($i5 == 6)
{
echo"<tr>";
echo"<th>Date</th>";
echo"<th>From Hour</th>	";
echo"<th>Route Id</th>	";
echo"<th>From Stage</th>";
echo"<th>To Stage</th>";
echo"<th>No. Of Passengers</th>";
echo"<th>MOR Passengers</th>";
echo"<th>MEX Passengers</th>";
echo"<th>MDE Passengers</th>";
echo"<th>MNS Passengers</th>";
echo"</tr>"; 
  
$mysqlport=getenv('S2G_MYSQL_PORT');

$dbhost="localhost:".$mysqlport;

$dbuser='root';
$dbpass='';

$connect=mysql_connect($dbhost,$dbuser,$dbpass);


mysql_select_db('mtc');



if($i1== '0' && $i4== '24' ) 
  $query_result="SELECT TicketIssuedDate,HOUR(TicketIssuedTime)AS FROM_HOUR,RouteId,FromStage,ToStage,SUM(Adult+Child) AS NO_OF_PASSENGERS,SUM(CASE WHEN ServicetypeId='MOR' THEN Adult+Child ELSE 0 END) MOR_PASSENGERS,SUM(CASE WHEN ServicetypeId='MEX' THEN Adult+Child ELSE 0 END) MEX_PASSENGERS,SUM(CASE WHEN ServicetypeId='MDE' THEN Adult+Child ELSE 0 END) MDE_PASSENGERS,SUM(CASE WHEN ServicetypeId='MNS' THEN Adult+Child ELSE 0 END) MNS_PASSENGERS
	FROM (SELECT RouteId,Adult,TicketIssuedTime,Child,ServicetypeID,FromStage,ToStage,TicketIssuedDate FROM a) a GROUP BY TicketIssuedDate,HOUR(TicketIssuedTime), RouteID,FromStage, ToStage";

if($i1=='0' && $i4!='24')
  $query_result="SELECT TicketIssuedDate,HOUR(TicketIssuedTime)AS FROM_HOUR,RouteId,FromStage,ToStage,SUM(Adult+Child) AS NO_OF_PASSENGERS,SUM(CASE WHEN ServicetypeId='MOR' THEN Adult+Child ELSE 0 END) MOR_PASSENGERS,SUM(CASE WHEN ServicetypeId='MEX' THEN Adult+Child ELSE 0 END) MEX_PASSENGERS,SUM(CASE WHEN ServicetypeId='MDE' THEN Adult+Child ELSE 0 END) MDE_PASSENGERS,SUM(CASE WHEN ServicetypeId='MNS' THEN Adult+Child ELSE 0 END) MNS_PASSENGERS
	FROM (SELECT RouteId,Adult,TicketIssuedTime,Child,ServicetypeID,FromStage,ToStage,TicketIssuedDate FROM a) a WHERE TicketIssuedTime BETWEEN '$i4:00' AND '$i4:59' GROUP BY TicketIssuedDate,HOUR(TicketIssuedTime), RouteID,FromStage, ToStage";

if($i1!='0' && $i4=='24')
  $query_result="SELECT TicketIssuedDate,HOUR(TicketIssuedTime)AS FROM_HOUR,RouteId,FromStage,ToStage,SUM(Adult+Child) AS NO_OF_PASSENGERS,SUM(CASE WHEN ServicetypeId='MOR' THEN Adult+Child ELSE 0 END) MOR_PASSENGERS,SUM(CASE WHEN ServicetypeId='MEX' THEN Adult+Child ELSE 0 END) MEX_PASSENGERS,SUM(CASE WHEN ServicetypeId='MDE' THEN Adult+Child ELSE 0 END) MDE_PASSENGERS,SUM(CASE WHEN ServicetypeId='MNS' THEN Adult+Child ELSE 0 END) MNS_PASSENGERS
	FROM (SELECT RouteId,Adult,TicketIssuedTime,Child,ServicetypeID,FromStage,ToStage,TicketIssuedDate FROM a) a WHERE TicketIssuedDate='$i3-$i2-$i1' GROUP BY TicketIssuedDate,HOUR(TicketIssuedTime), RouteID,FromStage, ToStage";

if($i1!='0' && $i4!='24')
  $query_result="SELECT TicketIssuedDate,HOUR(TicketIssuedTime)AS FROM_HOUR,RouteId,FromStage,ToStage,SUM(Adult+Child) AS NO_OF_PASSENGERS,SUM(CASE WHEN ServicetypeId='MOR' THEN Adult+Child ELSE 0 END) MOR_PASSENGERS,SUM(CASE WHEN ServicetypeId='MEX' THEN Adult+Child ELSE 0 END) MEX_PASSENGERS,SUM(CASE WHEN ServicetypeId='MDE' THEN Adult+Child ELSE 0 END) MDE_PASSENGERS,SUM(CASE WHEN ServicetypeId='MNS' THEN Adult+Child ELSE 0 END) MNS_PASSENGERS
	FROM (SELECT RouteId,Adult,TicketIssuedTime,Child,ServicetypeID,FromStage,ToStage,TicketIssuedDate FROM a) a WHERE TicketIssuedDate='$i3-$i2-$i1' AND TicketIssuedTime BETWEEN '$i4:00' AND '$i4:59' GROUP BY TicketIssuedDate,HOUR(TicketIssuedTime), RouteID,FromStage, ToStage";


$result=mysql_query($query_result,$connect);
$filename = 'table';    
$file_ending = "xlsx";
header("Content-Type: application/ms-excel");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
echo"<tr>";
echo"<td>" ;echo $row['TicketIssuedDate'];echo"</td>";
echo"<td>" ;echo $row['FROM_HOUR'];echo"</td>";
echo"<td>" ;echo $row['RouteId'];echo"</td>";
echo"<td>" ;echo $row['FromStage'];echo"</td>";
echo"<td>" ;echo $row['ToStage'];echo"</td>";
echo"<td>" ;echo $row['NO_OF_PASSENGERS'];echo"</td>";
echo"<td>" ;echo $row['MOR_PASSENGERS'];echo"</td>";
echo"<td>" ;echo $row['MEX_PASSENGERS'];echo"</td>";
echo"<td>" ;echo $row['MDE_PASSENGERS'];echo"</td>";
echo"<td>" ;echo $row['MNS_PASSENGERS'];echo"</td>";
echo"</tr>";
}}







if($i5 == 7)
{
echo"<tr>";
echo"<th>Date</th>";
echo"<th>From Hour</th>	";
echo"<th>Total Collection</th>";
echo"</tr>";
  
$mysqlport=getenv('S2G_MYSQL_PORT');

$dbhost="localhost:".$mysqlport;

$dbuser='root';
$dbpass='';

$connect=mysql_connect($dbhost,$dbuser,$dbpass);


mysql_select_db('mtc');



if($i1== '0' && $i4== '24' ) 
  $query_result="SELECT TicketIssuedDate,HOUR(TicketIssuedTime) AS FROM_HOUR, SUM(TotalAmount) AS TOTAL_COLLECTION from (SELECT TotalAmount,TicketIssuedTime,TicketIssuedDate FROM a)a GROUP BY TicketIssuedDate,HOUR(TicketIssuedTime)";

if($i1=='0' && $i4!='24')
  $query_result="SELECT TicketIssuedDate,HOUR(TicketIssuedTime) AS FROM_HOUR, SUM(TotalAmount) AS TOTAL_COLLECTION from (SELECT TotalAmount,TicketIssuedTime,TicketIssuedDate FROM a)a WHERE TicketIssuedTime BETWEEN '$i4:00' AND '$i4:59' GROUP BY TicketIssuedDate,HOUR(TicketIssuedTime)";

if($i1!='0' && $i4=='24')
  $query_result="SELECT TicketIssuedDate,HOUR(TicketIssuedTime) AS FROM_HOUR, SUM(TotalAmount) AS TOTAL_COLLECTION from (SELECT TotalAmount,TicketIssuedTime,TicketIssuedDate FROM a)a WHERE TicketIssuedDate='$i3-$i2-$i1' GROUP BY TicketIssuedDate,HOUR(TicketIssuedTime)";

if($i1!='0' && $i4!='24')
  $query_result="SELECT TicketIssuedDate,HOUR(TicketIssuedTime) AS FROM_HOUR, SUM(TotalAmount) AS TOTAL_COLLECTION from (SELECT TotalAmount,TicketIssuedTime,TicketIssuedDate FROM a)a WHERE TicketIssuedDate='$i3-$i2-$i1' AND TicketIssuedTime BETWEEN '$i4:00' AND '$i4:59' GROUP BY TicketIssuedDate,HOUR(TicketIssuedTime)";


$result=mysql_query($query_result,$connect);
$filename = 'table';    
$file_ending = "xlsx";
header("Content-Type: application/ms-excel");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
echo"<tr>";
echo"<td>" ;echo $row['TicketIssuedDate'];echo"</td>";
echo"<td>" ;echo $row['FROM_HOUR'];echo"</td>";
echo"<td>" ;echo $row['TOTAL_COLLECTION'];echo"</td>";
echo"</tr>";
}}







if($i5 == 8)
{
echo"<tr>";
echo"<th>Date</th>";
echo"<th>Route Id</th>	";
echo"<th>Service Id</th>";
echo"<th>Service Type ID</th>";
echo"<th>Trip No</th>";
echo"<th>$5</th>";
echo"<th>$6</th>";
echo"<th>$7</th>";
echo"<th>$8</th>";
echo"<th>$9</th>";
echo"<th>$10</th>";
echo"<th>$11</th>";
echo"<th>$12</th>";
echo"<th>$13</th>";
echo"<th>$14</th>";
echo"<th>$15</th>";
echo"<th>$16</th>";
echo"<th>$17</th>";
echo"<th>$18</th>";
echo"<th>$19</th>";
echo"<th>$20</th>";
echo"<th>$21</th>";
echo"<th>$22</th>";
echo"<th>$23</th>";
echo"<th>$24</th>";
echo"<th>$25</th>";
echo"<th>$26</th>";
echo"<th>$27</th>";
echo"<th>$28</th>";
echo"<th>$29</th>";
echo"<th>$30</th>";
echo"<th>$31</th>";
echo"<th>Total Collection</th>";
echo"</tr>"; 
  
$mysqlport=getenv('S2G_MYSQL_PORT');

$dbhost="localhost:".$mysqlport;

$dbuser='root';
$dbpass='';

$connect=mysql_connect($dbhost,$dbuser,$dbpass);


mysql_select_db('mtc');



if($i1== 0) 
  $query_result="SELECT TicketIssuedDate,RouteId,ServiceId,ServicetypeID,TripNo,
	5*SUM(CASE WHEN Denomination='5' THEN (Adult+Child) ELSE 0 END) '$5',
	6*SUM(CASE WHEN Denomination='6' THEN (Adult+Child) ELSE 0 END) '$6',
	7*SUM(CASE WHEN Denomination='7' THEN (Adult+Child) ELSE 0 END) '$7',
	8*SUM(CASE WHEN Denomination='8' THEN (Adult+Child) ELSE 0 END) '$8',
	9*SUM(CASE WHEN Denomination='9' THEN (Adult+Child) ELSE 0 END) '$9',
	10*SUM(CASE WHEN Denomination='10' THEN (Adult+Child) ELSE 0 END) '$10',
	11*SUM(CASE WHEN Denomination='11' THEN (Adult+Child) ELSE 0 END) '$11',
	12*SUM(CASE WHEN Denomination='12' THEN (Adult+Child) ELSE 0 END) '$12',
	13*SUM(CASE WHEN Denomination='13' THEN (Adult+Child) ELSE 0 END) '$13',
	14*SUM(CASE WHEN Denomination='14' THEN (Adult+Child) ELSE 0 END) '$14',
	15*SUM(CASE WHEN Denomination='15' THEN (Adult+Child) ELSE 0 END) '$15',
	16*SUM(CASE WHEN Denomination='16' THEN (Adult+Child) ELSE 0 END) '$16',
	17*SUM(CASE WHEN Denomination='17' THEN (Adult+Child) ELSE 0 END) '$17',
	18*SUM(CASE WHEN Denomination='18' THEN (Adult+Child) ELSE 0 END) '$18',
	19*SUM(CASE WHEN Denomination='19' THEN (Adult+Child) ELSE 0 END) '$19',
	20*SUM(CASE WHEN Denomination='20' THEN (Adult+Child) ELSE 0 END) '$20',
	21*SUM(CASE WHEN Denomination='21' THEN (Adult+Child) ELSE 0 END) '$21',
	22*SUM(CASE WHEN Denomination='22' THEN (Adult+Child) ELSE 0 END) '$22',
	23*SUM(CASE WHEN Denomination='23' THEN (Adult+Child) ELSE 0 END) '$23',
	24*SUM(CASE WHEN Denomination='24' THEN (Adult+Child) ELSE 0 END) '$24',
	25*SUM(CASE WHEN Denomination='25' THEN (Adult+Child) ELSE 0 END) '$25',
	26*SUM(CASE WHEN Denomination='26' THEN (Adult+Child) ELSE 0 END) '$26',
	27*SUM(CASE WHEN Denomination='27' THEN (Adult+Child) ELSE 0 END) '$27',
	28*SUM(CASE WHEN Denomination='28' THEN (Adult+Child) ELSE 0 END) '$28',
	29*SUM(CASE WHEN Denomination='29' THEN (Adult+Child) ELSE 0 END) '$29',
	30*SUM(CASE WHEN Denomination='30' THEN (Adult+Child) ELSE 0 END) '$30',
	31*SUM(CASE WHEN Denomination='31' THEN (Adult+Child) ELSE 0 END) '$31',
	SUM(TotalAmount) AS Total_Collection FROM (SELECT RouteId,Denomination,(ServiceId),ServicetypeID,TripNo AS TripNo,TotalAmount,Adult,Child,TicketIssuedDate FROM a)a GROUP BY TicketIssuedDate,RouteId,ServiceId,TripNo";

if($i1!=0)
  $query_result="SELECT TicketIssuedDate,RouteId,ServiceId,ServicetypeID,TripNo,
	5*SUM(CASE WHEN Denomination='5' THEN (Adult+Child) ELSE 0 END) '$5',
	6*SUM(CASE WHEN Denomination='6' THEN (Adult+Child) ELSE 0 END) '$6',
	7*SUM(CASE WHEN Denomination='7' THEN (Adult+Child) ELSE 0 END) '$7',
	8*SUM(CASE WHEN Denomination='8' THEN (Adult+Child) ELSE 0 END) '$8',
	9*SUM(CASE WHEN Denomination='9' THEN (Adult+Child) ELSE 0 END) '$9',
	10*SUM(CASE WHEN Denomination='10' THEN (Adult+Child) ELSE 0 END) '$10',
	11*SUM(CASE WHEN Denomination='11' THEN (Adult+Child) ELSE 0 END) '$11',
	12*SUM(CASE WHEN Denomination='12' THEN (Adult+Child) ELSE 0 END) '$12',
	13*SUM(CASE WHEN Denomination='13' THEN (Adult+Child) ELSE 0 END) '$13',
	14*SUM(CASE WHEN Denomination='14' THEN (Adult+Child) ELSE 0 END) '$14',
	15*SUM(CASE WHEN Denomination='15' THEN (Adult+Child) ELSE 0 END) '$15',
	16*SUM(CASE WHEN Denomination='16' THEN (Adult+Child) ELSE 0 END) '$16',
	17*SUM(CASE WHEN Denomination='17' THEN (Adult+Child) ELSE 0 END) '$17',
	18*SUM(CASE WHEN Denomination='18' THEN (Adult+Child) ELSE 0 END) '$18',
	19*SUM(CASE WHEN Denomination='19' THEN (Adult+Child) ELSE 0 END) '$19',
	20*SUM(CASE WHEN Denomination='20' THEN (Adult+Child) ELSE 0 END) '$20',
	21*SUM(CASE WHEN Denomination='21' THEN (Adult+Child) ELSE 0 END) '$21',
	22*SUM(CASE WHEN Denomination='22' THEN (Adult+Child) ELSE 0 END) '$22',
	23*SUM(CASE WHEN Denomination='23' THEN (Adult+Child) ELSE 0 END) '$23',
	24*SUM(CASE WHEN Denomination='24' THEN (Adult+Child) ELSE 0 END) '$24',
	25*SUM(CASE WHEN Denomination='25' THEN (Adult+Child) ELSE 0 END) '$25',
	26*SUM(CASE WHEN Denomination='26' THEN (Adult+Child) ELSE 0 END) '$26',
	27*SUM(CASE WHEN Denomination='27' THEN (Adult+Child) ELSE 0 END) '$27',
	28*SUM(CASE WHEN Denomination='28' THEN (Adult+Child) ELSE 0 END) '$28',
	29*SUM(CASE WHEN Denomination='29' THEN (Adult+Child) ELSE 0 END) '$29',
	30*SUM(CASE WHEN Denomination='30' THEN (Adult+Child) ELSE 0 END) '$30',
	31*SUM(CASE WHEN Denomination='31' THEN (Adult+Child) ELSE 0 END) '$31',
	SUM(TotalAmount) AS Total_Collection FROM (SELECT RouteId,Denomination,(ServiceId),ServicetypeID,TripNo AS TripNo,TotalAmount,Adult,Child,TicketIssuedDate FROM a)a WHERE TicketIssuedDate='$i3-$i2-$i1' GROUP BY TicketIssuedDate,RouteId,ServiceId,TripNo";


$result=mysql_query($query_result,$connect);
$filename = 'table';    
$file_ending = "xlsx";
header("Content-Type: application/ms-excel");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
echo"<tr>";
echo"<td>" ;echo $row['TicketIssuedDate'];echo"</td>";
echo"<td>" ;echo $row['RouteId'];echo"</td>";
echo"<td>" ;echo $row['ServiceId'];echo"</td>";
echo"<td>" ;echo $row['ServicetypeID'];echo"</td>";
echo"<td>" ;echo $row['TripNo'];echo"</td>";
echo"<td>" ;echo $row['$5'];echo"</td>";
echo"<td>" ;echo $row['$6'];echo"</td>";
echo"<td>" ;echo $row['$7'];echo"</td>";
echo"<td>" ;echo $row['$8'];echo"</td>";
echo"<td>" ;echo $row['$9'];echo"</td>";
echo"<td>" ;echo $row['$10'];echo"</td>";
echo"<td>" ;echo $row['$11'];echo"</td>";
echo"<td>" ;echo $row['$12'];echo"</td>";
echo"<td>" ;echo $row['$13'];echo"</td>";
echo"<td>" ;echo $row['$14'];echo"</td>";
echo"<td>" ;echo $row['$15'];echo"</td>";
echo"<td>" ;echo $row['$16'];echo"</td>";
echo"<td>" ;echo $row['$17'];echo"</td>";
echo"<td>" ;echo $row['$18'];echo"</td>";
echo"<td>" ;echo $row['$19'];echo"</td>";
echo"<td>" ;echo $row['$20'];echo"</td>";
echo"<td>" ;echo $row['$21'];echo"</td>";
echo"<td>" ;echo $row['$22'];echo"</td>";
echo"<td>" ;echo $row['$23'];echo"</td>";
echo"<td>" ;echo $row['$24'];echo"</td>";
echo"<td>" ;echo $row['$25'];echo"</td>";
echo"<td>" ;echo $row['$26'];echo"</td>";
echo"<td>" ;echo $row['$27'];echo"</td>";
echo"<td>" ;echo $row['$28'];echo"</td>";
echo"<td>" ;echo $row['$29'];echo"</td>";
echo"<td>" ;echo $row['$30'];echo"</td>";
echo"<td>" ;echo $row['$31'];echo"</td>";
echo"<td>" ;echo $row['Total_Collection'];echo"</td>";
echo"</tr>";
}
}


?>
</body>
</html>