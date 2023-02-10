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
$sql = "SELECT * FROM orders WHERE user_id='$user_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1){
    
        $sql = "SELECT *,orders.id AS id,orders.status AS status FROM orders,products WHERE orders.product_id = products.id AND orders.user_id='$user_id'";
        $db->sql($sql);
        $res = $db->getResult();
        $num = $db->numRows($res);
        
            foreach ($res as $row) {
                $temp['id'] = $row['id'];
                $temp['user_id'] = $row['user_id'];
                $temp['product_id'] = $row['product_id'];
                $temp['method'] = $row['method'];
                $temp['total'] = $row['total'];
                $temp['quantity'] =$row['quantity'];
                $temp['address'] = $row['address'];
                $temp['mobile'] = $row['mobile'];
                $temp['delivery_charges'] = $row['delivery_charges'];
                $temp['status'] = $row['status'];
                $temp['category_id'] = $row['category_id'];
                $temp['product_name'] = $row['product_name'];
                $temp['price'] = $row['price'];
                $temp['mrp'] = $row['mrp'];
                $temp['brand'] = $row['brand'];
                $temp['description'] = $row['description'];
                $temp['image'] = DOMAIN_URL . $row['image'];
                $temp['order_date'] = $row['order_date'];
                $rows[] = $temp;
                
            }
        
            $response['success'] = true;
            $response['message'] = "Orders listed Successfully";
            $response['data'] = $rows;
            print_r(json_encode($response));
 }

else {
    $response['success'] = false;
    $response['message'] = "No Orders Found";
    print_r(json_encode($response));

}

?>