<?php
include_once('includes/crud.php');
$db = new Database();
$db->connect();


	$sql_query = "SELECT o.id AS id,o.*,u.name AS name,u.mobile AS mobile,p.product_name AS product_name,p.price AS price,p.brand AS brand,p.mrp AS mrp,p.image AS image,o.status AS status,o.order_date FROM `orders` o,`users` u,`products` p WHERE o.product_id=p.id AND o.user_id=u.id";
	$db->sql($sql_query);
	$developer_records = $db->getResult();
	
	$filename = "Orders-data".date('Y-m-d') . ".xls";			
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=\"$filename\"");	
	$show_coloumn = false;
	if(!empty($developer_records)) {
	  foreach($developer_records as $record) {
		if(!$show_coloumn) {
		  // display field/column names in first row
		  echo implode("\t", array_keys($record)) . "\n";
		  $show_coloumn = true;
		}
		echo implode("\t", array_values($record)) . "\n";
	  }
	}
	exit;  
?>
