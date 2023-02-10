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
$user_id = $db->escapeString($_POST['user_id']);
$sql = "SELECT *,cart.id AS id,products.price * cart.quantity AS price  FROM cart,products WHERE cart.product_id=products.id AND cart.user_id='$user_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if($num>=1){
    $sum = 0;
    foreach ($res as $row) {
        $sum += $row['price'];
        $temp['id'] = $row['id'];
        $temp['price'] = $row['price'];
        $temp['product_name'] = $row['product_name'];
        $temp['quantity'] = $row['quantity'];
        $temp['mrp'] = $row['mrp'];
        $temp['brand'] = $row['brand'];
        $temp['description'] = $row['description'];
        $temp['image'] = DOMAIN_URL . $row['image'];
        $rows[] = $temp;
    }
    $response['success'] = true;
    $response['message'] = "Cart listed Successfully";
    $response['total_items'] = $num;
    $response['total_price'] = $sum;
    $response['data'] = $rows;
    print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "Products Not Found in Cart";
    print_r(json_encode($response));
}


?>