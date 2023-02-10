<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnUpdate'])) {
        //$id = $db->escapeString($fn->xss_clean_array());
        for ($i = 0; $i < count($_POST['id']); $i++) {
            $id = $db->escapeString($fn->xss_clean($_POST['id'][$i]));
            $from = $db->escapeString($fn->xss_clean($_POST['from'][$i]));
            $to = $db->escapeString($fn->xss_clean($_POST['to'][$i]));
            $delivery_charge = $db->escapeString($fn->xss_clean($_POST['delivery_charge'][$i]));
            $sql_query = "UPDATE delivery_charges SET `from` = $from , `to` = $to , `delivery_charge` = $delivery_charge WHERE id = $id";
            $db->sql($sql_query);

        }
           
        $error['update'] = "<section class='content-header'>
        <span class='label label-success'>Delivery Charge Updated Successfully</span> </section>";
        }
    

    // create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM delivery_charges";
$db->sql($sql_query);
$res = $db->getResult();
?>
<section class="content-header">
    <h1>Delivery Charge</h1>
    <?php echo isset($error['update']) ? $error['update'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="delivery_charge" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                           <div class="row">
                               <?php
                                    $sql = "SELECT * FROM `delivery_charges`";
                                    $db->sql($sql);
                                    $result = $db->getResult();
                                    foreach ($result as $value) {
                                ?>
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="id[]" value="<?= $value['id']; ?>" readonly>
                                   <div class="col-md-4">
                                            <label for="exampleInputEmail1">Charge Limit From</label> <i class="text-danger asterik">*</i>
                                            <input type="text" class="form-control" name="from[]" value="<?= $value['from']; ?>" readonly>
                                    </div>
                                    <div class="col-md-4">
                                            <label for="exampleInputEmail1">Charge Limit To</label> <i class="text-danger asterik">*</i>
                                            <input type="text" class="form-control" name="to[]" value="<?= $value['to']; ?>" readonly>
                                    </div>
                                    <div class="col-md-4">
                                            <label for="exampleInputEmail1">Delivery Charge</label> <i class="text-danger asterik">*</i><?php echo isset($error['delivery_charge']) ? $error['delivery_charge'] : ''; ?>
                                            <input type="number" class="form-control" name="delivery_charge[]" value="<?= $value['delivery_charge']; ?>" required>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                    </div>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnUpdate">Update</button>
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>