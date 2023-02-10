<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
// session_start();
$address_id = $_GET['id'];
?>
<section class="content-header">
    <h1>View Address</h1>
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
=                    </div><!-- /.box-header -->
                    <div class="box-body">
                    <table class="table table-bordered">
                        <?php
                        $sql = "SELECT * FROM addresses WHERE id = $address_id";
                        $db->sql($sql);
                        $res = $db->getResult();
                        $num = $db->numRows();
                        if($num >= 1){

                            $sql = "SELECT *,addresses.id AS id FROM addresses,users WHERE addresses.user_id=users.id AND addresses.id = $address_id";
                            $db->sql($sql);
                            $res = $db->getResult();
                            ?>
                            <tr>
                                <th style="width: 200px">ID</th>
                                <td><?php echo $res[0]['id'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Name</th>
                                <td><?php echo $res[0]['name'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Mobile</th>
                                <td><?php echo $res[0]['mobile'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Email</th>
                                <td><?php echo $res[0]['email'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Occupation</th>
                                <td><?php echo $res[0]['occupation'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Address</th>
                                <td><?php echo $res[0]['address'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Landmark</th>
                                <td><?php echo $res[0]['landmark'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">City</th>
                                <td><?php echo $res[0]['city'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">District</th>
                                <td><?php echo $res[0]['district'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Pincode</th>
                                <td><?php echo $res[0]['pincode']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">State</th>
                                <td><?php echo $res[0]['state']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Country</th>
                                <td><?php echo $res[0]['country']; ?></td>
                            </tr>
                           
                            <?php
                        }
                        else{
                            echo "<tr><td colspan='2'>No Data Found</td></tr>";
                        }
                        ?>
    
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="addresses.php" class="btn btn-sm btn-default btn-flat pull-left">Back</a>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    document.getElementById('valid').valueAsDate = new Date();

</script>
