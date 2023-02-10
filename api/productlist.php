<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../includes/crud.php');
include_once('../includes/functions.php');
$function = new functions;
include_once('../includes/custom-functions.php');
$fn = new custom_functions;

$db = new Database();
$db->connect();
if (empty($_POST['category_id'])) {
    $response['success'] = false;
    $response['message'] = "Category Id is Empty";
    print_r(json_encode($response));
    return false;
}
$category_id = $db->escapeString($_POST['category_id']);


if($category_id == 'all'){
    $sql = "SELECT *,categories.name AS category_name,products.image AS image,products.id AS id FROM `products`,`categories` WHERE products.category_id=categories.id";
    $db->sql($sql);
    $res = $db->getResult();
    $num = $db->numRows($res);
    if ($num >= 1) {
        
        foreach ($res as $row) {
            $temp['id'] = $row['id'];
            $temp['category_name'] = $row['category_name'];
            $temp['product_name'] = $row['product_name'];
            $temp['brand'] = $row['brand'];
            $temp['measurement'] = $row['measurement'];
            $temp['unit'] = $row['unit'];
            $temp['price'] = $row['price'];
            $temp['description'] = $row['description'];
            $temp['image'] = DOMAIN_URL . $row['image'];
            $temp['image1'] = DOMAIN_URL . $row['image1'];
            $temp['image2'] = DOMAIN_URL . $row['image2'];
            $rows[] = $temp;
            
        }
    
        $response['success'] = true;
        $response['message'] = "Products listed Successfully";
        $response['data'] = $rows;
        print_r(json_encode($response));
    
    }else{
        $response['success'] = false;
        $response['message'] = "No Products Found".$from.$to;
        print_r(json_encode($response));
    
    }
}
else{
    $where = "";
    if ((isset($_POST['from'])  && $_POST['from'] != '')) {
        $from = $db->escapeString($fn->xss_clean($_POST['from']));
        $where .= "AND products.price > $from ";
    }
    if ((isset($_POST['to'])  && $_POST['to'] != '')) {
        $to = $db->escapeString($fn->xss_clean($_POST['to']));
        $where .= "AND products.price <= $to ";
    }

    if ((isset($_POST['from_m'])  && $_POST['from_m'] != '')) {
        $from_m = $db->escapeString($fn->xss_clean($_POST['from_m']));
        $where .= "AND products.measurement > $from_m ";
    }
    if ((isset($_POST['to_m'])  && $_POST['to_m'] != '')) {
        $to_m = $db->escapeString($fn->xss_clean($_POST['to_m']));
        $where .= "AND products.measurement <= $to_m ";
    }
    if ((isset($_POST['brand'])  && $_POST['brand'] != '')) {
        $brand = $db->escapeString($fn->xss_clean($_POST['brand']));
        $where .= "AND products.brand='$brand' ";
    }
    if ((isset($_POST['unit'])  && $_POST['unit'] != '')) {
        $unit = $db->escapeString($fn->xss_clean($_POST['unit']));
        $where .= "AND products.unit='$unit' ";
    }
    $sql = "SELECT *,categories.name AS category_name,products.image AS image,products.id AS id FROM `products`,`categories` WHERE products.category_id=categories.id AND products.category_id='$category_id' ".$where;
    $db->sql($sql);
    $res = $db->getResult();
    $num = $db->numRows($res);
    if ($num >= 1) {
        
        foreach ($res as $row) {
            $temp['id'] = $row['id'];
            $temp['category_name'] = $row['category_name'];
            $temp['product_name'] = $row['product_name'];
            $temp['brand'] = $row['brand'];
            $temp['measurement'] = $row['measurement'];
            $temp['unit'] = $row['unit'];
            $temp['price'] = $row['price'];
            $temp['mrp'] = $row['mrp'];
            $temp['discount_percentage'] = $row['discount_percentage'];
            $temp['description'] = $row['description'];
            $temp['image'] = DOMAIN_URL . $row['image'];
            $temp['image1'] = DOMAIN_URL . $row['image1'];
            $temp['image2'] = DOMAIN_URL . $row['image2'];
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
}



?>