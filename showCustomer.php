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
<?php
if(array_key_exists('customerId',$_GET)){
	$custId = $_GET['customerId'];
}
$query= <<<__QUERY
select c.name, count(fc.film_id) from 
category c, film_category fc, inventory i, rental r, customer cu where 
i.inventory_id = r.inventory_id  and 
r.customer_id = cu.customer_id and 
c.category_id = fc.category_id and i.film_id = fc.film_id and cu.customer_id =?
group by c.name order by count(fc.film_id) desc;
__QUERY;

$query1 =<<<__QUERY1
select sum(cnt),a.first,a.last from
( select c.name as Category, count(fc.film_id) as cnt ,cu.first_name as first,cu.last_name as last from 
category c, film_category fc, inventory i, rental r, customer cu where 
i.inventory_id = r.inventory_id  and 
r.customer_id = cu.customer_id and 
c.category_id = fc.category_id and i.film_id = fc.film_id and cu.customer_id =?
group by c.name order by count(fc.film_id) desc)a;
__QUERY1;
if($stmt = $conn->prepare($query1)){
	$stmt->bind_param('i',$custId);
	$stmt->bind_result($sum,$firstName,$lastName);
	$stmt->execute();
	$stmt->store_result();
	$hasResult=$stmt->fetch();
	if(!$hasResult){
		echo "No films";
	}
}
if($stmt = $conn->prepare($query)){
	$stmt->bind_param('i',$custId);
	$stmt->bind_result($category,$rentalCount);
	$stmt->execute();
	$stmt->store_result();
	
	echo "The customer $firstName $lastName (id " . $custId .") has rented " . $sum ." films in " . $stmt->num_rows ." categories";
	echo"<table border=1>";
	echo "<tr><td> Category</td><td>Number of films rented</td></tr>";
	while($stmt->fetch()){
		echo"<tr> <td> $category </td> <td> $rentalCount</td></tr>";
	}
	echo"</table>";
}
$stmt->close();
//$stmt->free_result();
?>
</body>
</html>