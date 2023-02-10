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

if (empty($_POST['cart_id'])) {
    $response['success'] = false;
    $response['message'] = "Cart Id is Empty";
    print_r(json_encode($response));
    return false;
}
$cart_id = $db->escapeString($_POST['cart_id']);

$sql = "DELETE FROM cart WHERE id = '$cart_id' ";
$db->sql($sql);
$res = $db->getResult();
$response['success'] = true;
$response['message'] = "Deleted successfully";

print_r(json_encode($response));
?>