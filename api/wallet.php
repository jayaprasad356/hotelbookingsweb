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
if (empty($_POST['amount'])) {
    $response['success'] = false;
    $response['message'] = "Amount is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['type'])) {
    $response['success'] = false;
    $response['message'] = "Type is Empty";
    print_r(json_encode($response));
    return false;
}
$user_id = $db->escapeString($_POST['user_id']);
$amount = $db->escapeString($_POST['amount']);
$type = $db->escapeString($_POST['type']);
$date = date('Y-m-d');
$sql = "SELECT * FROM users WHERE id='$user_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if($num==1){
    if($type == 'credit'){
        $sql = "INSERT INTO wallet_transactions(`user_id`,`date`,`amount`,`type`)VALUES('$user_id','$date','$amount','$type')";
        $db->sql($sql);
        $sql = "UPDATE users SET balance= balance + $amount WHERE id=" . $user_id;
        $db->sql($sql);
    }
    else{
        $sql = "INSERT INTO wallet_transactions(`user_id`,`date`,`amount`,`type`)VALUES('$user_id','$date','$amount','$type')";
        $db->sql($sql);
        $sql = "UPDATE users SET balance= balance - $amount WHERE id=" . $user_id;
        $db->sql($sql);

    }
    $sql = "SELECT * FROM users WHERE id=" . $user_id;
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Wallet Transaction Successfully Completed";
    $response['data'] = $res;
    print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "User Not Found";
    print_r(json_encode($response));
}


?>