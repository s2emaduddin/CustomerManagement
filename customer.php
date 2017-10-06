<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> CSCI 5333.3 DBMS Spring 2016 HW#6 </title>
</head>
<?php
	//  Minimally documented.
	include('dbconfig_sakila.php');
?>
<body>
<form id="CustomerInfoForm" name="CustomerInfoForm" method="get" action="showCustomer.php">
<?php
if(array_key_exists('firstnameChar',$_GET)){
	
		$firstName=$_GET['firstnameChar'];
		
	
}
if(array_key_exists('lastnameChar',$_GET)){
	
		
		$lastName=$_GET['lastnameChar'];
	
}
?>
<p> Please click the customer link to see brief information of the customer.</p>
<?php
if($lastName ==''){
	$query= <<<__QUERY
select first_name, last_name, active, customer_id
from 
customer
where
upper(substring(first_name,1,1))=?
order by first_name;
__QUERY;
if($stmt=$conn->prepare($query)){
	$stmt->bind_param('s',$firstName);
	$stmt->bind_result($first_name,$last_name,$active,$customer_id);
	$stmt->execute();
	$stmt->store_result();
	echo"<ol> \n";
	while($stmt->fetch()){
		if($active == 1){
			echo "<li> <a href=\"showCustomer.php?customerId=$customer_id\">".
		"$first_name $last_name</a> :  active</li>\n";
		}else{
			echo "<li> <a href=\"showCustomer.php?customerId=$customer_id\">".
		"$first_name $last_name</a> : inactive</li>\n";
		}
		
	}
	$stmt->close();
}
}else if($firstName == ''){
	$query= <<<__QUERY
select first_name, last_name, active, customer_id
from 
customer
where
upper(substring(last_name,1,1))=?
order by first_name;
__QUERY;
if($stmt=$conn->prepare($query)){
	$stmt->bind_param('s',$lastName);
	$stmt->bind_result($first_name,$last_name,$active,$customer_id);
	$stmt->execute();
	$stmt->store_result();
	echo"<ol> :\n";
	while($stmt->fetch()){
		if($active == 1){
			echo "<li> <a href=\"showCustomer.php?customerId=$customer_id\">".
		"$first_name $last_name</a> :  active</li>\n";
		}else{
			echo "<li> <a href=\"showCustomer.php?customerId=$customer_id\">".
		"$first_name $last_name</a> : inactive</li>\n";
		}
		
	}
	$stmt->close();
}
}else if($lastName == '' or $firstName == ''){
	echo"Please go back and select either one of the options given. Thank you";
}else{
	echo"Please go back and select either one of the options given, not both. Thank you";
}

	?>
</ol>
<p>&nbsp;</p>
</form>
</body>
</html>