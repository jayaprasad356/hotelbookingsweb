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
if (empty($_POST['search'])) {
    $response['success'] = false;
    $response['message'] = "Search is Empty";
    print_r(json_encode($response));
    return false;
}
$search = $db->escapeString($_POST['search']);

$sql = "SELECT * FROM `products`WHERE product_name like '%" . $search . "%'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    
    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['product_name'] = $row['product_name'];
        $temp['brand'] = $row['brand'];
        $temp['price'] = $row['price'];
        $temp['mrp'] = $row['mrp'];
        $temp['discount_percentage'] = $row['discount_percentage'];
        $temp['description'] = $row['description'];
        $temp['image'] = DOMAIN_URL . $row['image'];
        $rows[] = $temp;
        
    }

    $response['success'] = true;
    $response['message'] = "Products listed Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No Products Found";
    print_r(json_encode($response));

}

?>