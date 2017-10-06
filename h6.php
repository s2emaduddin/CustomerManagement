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
<h3>Customer Information: Main</h3>

<p>Please select the first character of the last name or the first character of the first name of the customer:</p>
<form id="CustomerForm" name="CustomerForm" method="get" action="customer.php">

  <label for="LastName">First char of last name:  </label>
  <select name="lastnameChar" value=" ">

<?php  
	/* Populate drop down menu list  */
$query = <<<__QUERY
select distinct upper(left(c.last_name,1)) as FirstChar
from customer c
order by FirstChar;
__QUERY;
if ($stmt = $conn->prepare($query)) {
	echo "hello";
    $stmt->execute();
	if(!$stmt->execute()){
		echo "Exectution failed";
	}
    $stmt->bind_result($lastnameChar);
	echo "<option value=\"\">$lastName</option>\n";
    while ($stmt->fetch()) {
		// Assume no special HTML character
		echo "<option value=\"" . $lastnameChar . "\">$lastnameChar</option>\n";
    }
    $stmt->close();
}
?>	
  </select>
  <br> <br>
  OR
  <br> <br>
  <label for="FirstName">First char of first name:  </label>
  <select name="firstnameChar">

<?php  
	/* Populate drop down menu list  */
$query = <<<__QUERY
select distinct upper(left(c.first_name,1)) as FirstChar
from customer c
order by FirstChar;
__QUERY;
if ($stmt = $conn->prepare($query)) {
	echo "hello";
    $stmt->execute();
	if(!$stmt->execute()){
		echo "Exectution failed";
	}
    $stmt->bind_result($firstnameChar);
	echo "<option value=\"\">$lastName</option>\n";
    while ($stmt->fetch()) {
		// Assume no special HTML character
		echo "<option value=\"" . $firstnameChar . "\">$firstnameChar</option>\n";
    }
    $stmt->close();
}
?>	
  </select>
  
  <br> <br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit"  value="Submit"></input>
</form>
<p>&nbsp;</p>
</body>
</html>