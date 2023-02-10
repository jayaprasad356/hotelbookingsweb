<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
// session_start();
$order_id = $_GET['id'];
$sql = "SELECT *,orders.id AS id,orders.status AS status,users.village AS village,users.address AS address,users.pincode AS pincode FROM `orders`,`products`,`users` WHERE orders.user_id=users.id AND orders.product_id=products.id  AND orders.id = '$order_id'";
$db->sql($sql);
$res = $db->getResult();
?>
<section class="content-header">
    <h1>View Order</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
<div class="row">
            <div class="col-md-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Order Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px">ID</th>
                                <td><?php echo $res[0]['id'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Shayak Name</th>
                                <td><?php echo $res[0]['name'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Mobile</th>
                                <td><?php echo $res[0]['mobile'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Product Name</th>
                                <td><?php echo $res[0]['product_name'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Brand</th>
                                <td><?php echo $res[0]['brand'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Measurement</th>
                                <td><?php echo $res[0]['measurement'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Unit</th>
                                <td><?php echo $res[0]['unit'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Price</th>
                                <td><?php echo $res[0]['price'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">MRP(Max.Retail.Price)</th>
                                <td><?php echo $res[0]['mrp'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Delivery Charge</th>
                                <td><?php echo $res[0]['delivery_charges'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Village Address</th>
                                <td><?php echo $res[0]['address'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">PinCode</th>
                                <td><?php echo $res[0]['pincode'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">District</th>
                                <td><?php echo $res[0]['district'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Status</th>
                                <td>
                                    <?php 
                                    if($res[0]['status']==0){ ?>
                                    <p class="text text-info">Booked</p>
                                    <?php
                                    }
                                    else if($res[0]['status']==1){?>
                                    <p class="text text-success">Confirmed</p>
                                    <?php
                                    }
                                    else if($res[0]['status']==2){
                                        ?>
                                        <p class="text text-primary">Completed</p>
                                <?php
                                    }
                                    else{
                                        ?>
                                         <p class="text text-danger">Cancelled</p>
                                    <?php }
                                    ?>

                                </td>
                            </tr>
                         </table>
    
                    </div><!-- /.box-body -->
                    <?php
                    $order_id = $_GET['id'];

                    if (isset($_POST['btnUpdate'])) {
                        
                        $seller_id = $ID;
                        $status = $db->escapeString($_POST['status']);    
                    
                            $sql = "UPDATE orders SET `status` = '$status' WHERE id = '" . $order_id . "'";
                            $db->sql($sql);
                            $order_result = $db->getResult();
                            if (!empty($order_result)) {
                                $order_result = 0;
                            } else {
                                $order_result = 1;
                            }
                            if ($order_result == 1 ) {
                                $error['add_menu'] = "<section class='content-header'>
                                                                    <span id='success' class='label label-success'>Updated Successfully</span>
                                                                    
                                                                     </section>";
                            } else {
                                $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
                            }
                    
                    }
                    $sql_query = "SELECT status FROM orders WHERE id = '" . $order_id . "'";
                    $db->sql($sql_query);
                    
                    $res = $db->getResult();
                    
                    ?>
                    <section class="content-header">
                        <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
                    </section>
                <form id='add_product_form' method="post" enctype="multipart/form-data">
                
                    
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label for="exampleInputEmail1">Status</label><i class="text-danger asterik">*</i><?php echo isset($error['status']) ? $error['status'] : ''; ?>
                                <select name="status" class="form-control" required>
                                <option value="0" <?php if ($res[0]['status'] == "0") {echo "selected";} ?>>Booked</option>
                                <option value="1" <?php if ($res[0]['status'] == "1") {echo "selected";} ?>>Confirmed</option>         
                                <option value="2" <?php if ($res[0]['status'] == "2") {echo "selected";} ?>>Completed</option>
                                <option value="3" <?php if ($res[0]['status'] == "3") {echo "selected";} ?>>Cancelled</option>                                                                                                                                                        
                                </select>
                            </div>
                       </div>
                    </div>
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Update" name="btnUpdate" />
                        <!--<div  id="res"></div>-->
                    </div>
                </form>
            </div><!--box--->

            </div>
        </div>
</section>
<div class="separator"> </div>

<script>
    if ($("#success").text() == "Updated Successfully")
    {
        setTimeout(showpanel, 1000);
        
    }
    function showpanel() {     
        window.location.replace("orders.php");
 }
</script>
