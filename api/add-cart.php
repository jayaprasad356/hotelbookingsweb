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
if (empty($_POST['product_id'])) {
    $response['success'] = false;
    $response['message'] = "Product Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['quantity'])) {
    $response['success'] = false;
    $response['message'] = "Quantity is Empty";
    print_r(json_encode($response));
    return false;
}
$user_id = $db->escapeString($_POST['user_id']);
$product_id = $db->escapeString($_POST['product_id']);
$quantity = $db->escapeString($_POST['quantity']);

$sql = "SELECT * FROM cart WHERE user_id = '" . $user_id . "' AND product_id = '" . $product_id . "' ";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
    $id = $res[0]['id'];
    $data = array(
        
        'quantity' => $quantity
    );
    $db->update('cart', $data, 'id=' . $id);
    $response['success'] = true;
    $response['message'] = "Cart updated successfully";
    
    print_r(json_encode($response));

}
else {
    $sql = "INSERT INTO cart(`user_id`,`product_id`,`quantity`)VALUES('$user_id','$product_id','$quantity')";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Successfully Added To Cart";
    
    print_r(json_encode($response));

}

?>