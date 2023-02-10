<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/crud.php');

$db = new Database();
$db->connect();

if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['method'])) {
    $response['success'] = false;
    $response['message'] = "Method  is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['delivery_charges'])) {
    $response['success'] = false;
    $response['message'] = "Delivery charges  is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['address'])) {
    $response['success'] = false;
    $response['message'] = "Address  is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['mobile'])) {
    $response['success'] = false;
    $response['message'] = "Mobile  is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['grand_total'])) {
    $response['success'] = false;
    $response['message'] = "Grand Total  is Empty";
    print_r(json_encode($response));
    return false;
}
$user_id = $db->escapeString($_POST['user_id']);
$method = $db->escapeString($_POST['method']);
$delivery_charges = $db->escapeString($_POST['delivery_charges']);
$address = $db->escapeString($_POST['address']);
$mobile = $db->escapeString($_POST['mobile']);
$grand_total = $db->escapeString($_POST['grand_total']);
$date = date('Y-m-d');
$sql = "SELECT *,cart.id AS id  FROM cart,products WHERE cart.product_id=products.id AND cart.user_id='$user_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if($num>=1){
    foreach ($res as $row) {
        $id = $row['id'];
        $product_id = $row['product_id'];
        $total = $row['price'];
        $quantity = $row['quantity'];
        $order_number = uniqid();

        // Check if order number already exists in the orders table
        $sql = "SELECT order_number FROM orders WHERE order_number = '$order_number'";
        $db->sql($sql);
        $result = $db->getResult();
        $numRows = $db->numRows($result);
    
        // If the order number already exists, generate a new one
        while($numRows > 0) {
            $order_number = uniqid();
        }


    
        $sql = "INSERT INTO orders (`user_id`,`product_id`,`method`,`total`,`quantity`,`grand_total`,`address`,`mobile`,`delivery_charges`,`status`,`order_number`,`order_date`)VALUES('$user_id','$product_id','$method','$total','$quantity','$grand_total','$address','$mobile','$delivery_charges','0','$order_number','$date')";
        $db->sql($sql);
        $sql = "DELETE FROM cart WHERE id = '$id'";
        $db->sql($sql);


    }
    if($method == 'Wallet'){
        $type = 'Upi';
        $sql = "INSERT INTO wallet_transactions(`user_id`,`date`,`grand_total`,`type`)VALUES('$user_id','$date','$grand_total','$type')";
        $db->sql($sql);
        $sql = "UPDATE users SET balance= balance - $grand_total WHERE id=" . $user_id;
        $db->sql($sql);
    
    }
    $response['success'] = true;
    $response['message'] = "Order Placed Successfully ";
    print_r(json_encode($response));

}






?>