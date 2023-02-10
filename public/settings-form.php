<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnUpdate'])) {

    $name = $db->escapeString(($_POST['name']));
    $email = $db->escapeString(($_POST['email']));
    $mobile = $db->escapeString(($_POST['mobile']));
    $address = $db->escapeString(($_POST['address']));
    $linkedin = $db->escapeString(($_POST['linkedin']));
    $facebook = $db->escapeString(($_POST['facebook']));
    $twitter = $db->escapeString(($_POST['twitter']));
    $instagram = $db->escapeString(($_POST['instagram']));
    $error = array();
    
    if (empty($name)) {
        $error['name'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($email)) {
        $error['email'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($mobile)) {
        $error['mobile'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($address)) {
        $error['address'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($linkedin)) {
        $error['linkedin'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($facebook)) {
        $error['facebook'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($twitter)) {
        $error['twitter'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($instagram)) {
        $error['instagram'] = " <span class='label label-danger'>Required!</span>";
    }
       if (!empty($name) && !empty($mobile) && !empty($email) && !empty($address) && !empty($linkedin)&& !empty($twitter) && !empty($facebook) && !empty($instagram)) {
           
            $sql_query = "UPDATE settings SET name='$name',mobile='$mobile',email='$email',address='$address',linkedin='$linkedin',twitter='$twitter',facebook='$facebook',instagram='$instagram' WHERE id=1";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                
                $error['update'] = "<section class='content-header'>
                                                <span class='label label-success'>Details Updated Successfully</span> </section>";
            } else {
                $error['update'] = " <span class='label label-danger'>Failed</span>";
            }
        }
    }

    // create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM settings WHERE id = 1";
$db->sql($sql_query);
$res = $db->getResult();
?>
<section class="content-header">
    <h1>Profile Details</h1>
    <?php echo isset($error['update']) ? $error['update'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-8">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="delivery_charge" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                           <div class="row">
                                <div class="form-group">
                                   <div class="col-md-6">
                                            <label for="exampleInputEmail1">Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                            <input type="text" class="form-control" name="name" value="<?= $res[0]['name']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                            <label for="exampleInputEmail1">Mobile Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
                                            <input type="number" class="form-control" name="mobile" value="<?= $res[0]['mobile']; ?>" required>
                                    </div>
                                </div>
                           </div>
                           <br>
                           <div class="row">
                                <div class="form-group">
                                   <div class="col-md-6">
                                            <label for="exampleInputEmail1">Email</label> <i class="text-danger asterik">*</i><?php echo isset($error['email']) ? $error['email'] : ''; ?>
                                            <input type="email" class="form-control" name="email" value="<?= $res[0]['email']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                            <label for="exampleInputEmail1">Address</label> <i class="text-danger asterik">*</i><?php echo isset($error['address']) ? $error['address'] : ''; ?>
                                            <input type="text" class="form-control"  name="address" value="<?= $res[0]['address']; ?>" required>
                                    </div>
                                </div>
                                
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                   <div class="col-md-6">
                                            <label for="exampleInputEmail1">Linkedin</label> <i class="text-danger asterik">*</i><?php echo isset($error['linkedin']) ? $error['linkedin'] : ''; ?>
                                            <input type="text" class="form-control" name="linkedin" value="<?= $res[0]['linkedin']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                            <label for="exampleInputEmail1">Youtube</label> <i class="text-danger asterik">*</i><?php echo isset($error['twitter']) ? $error['twitter'] : ''; ?>
                                            <input type="text" class="form-control"  name="twitter" value="<?= $res[0]['twitter']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                   <div class="col-md-6">
                                            <label for="exampleInputEmail1">Facebook</label> <i class="text-danger asterik">*</i><?php echo isset($error['facebook']) ? $error['facebook'] : ''; ?>
                                            <input type="text" class="form-control" name="facebook" value="<?= $res[0]['facebook']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                            <label for="exampleInputEmail1">Instagram</label> <i class="text-danger asterik">*</i><?php echo isset($error['instagram']) ? $error['instgram'] : ''; ?>
                                            <input type="text" class="form-control"  name="instagram" value="<?= $res[0]['instagram']; ?>" required>
                                    </div>
                                </div>
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