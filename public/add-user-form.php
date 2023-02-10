<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnAdd'])) {


        $name = $db->escapeString($_POST['name']);
        $mobile = $db->escapeString($_POST['mobile']);
        $email = $db->escapeString($_POST['email']);
        $password = $db->escapeString($_POST['password']);
        $address = $db->escapeString($_POST['address']);
        $pincode = $db->escapeString($_POST['pincode']);
        $district = $db->escapeString($_POST['district']);


        

        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($mobile)) {
            $error['mobile'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($email)) {
            $error['email'] = " <span class='label label-danger'>Required!</span>";
        }
       

      

        if (!empty($name) && !empty($mobile) && !empty($email) && !empty($address) && !empty($district) && !empty($pincode)) {
    
            $sql_query = "INSERT INTO users (name,email,mobile,password,address,district,pincode)VALUES('$name','$email','$mobile','$password','$address','$district','$pincode')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_user'] = " <section class='content-header'><span class='label label-success'>User Added Successfully</span></section>";
            } else {
                $error['add_user'] = " <span class='label label-danger'>Failed add User</span>";
            }
            }
        }
?>
<section class="content-header">
    <h1>Add User <small><a href='users.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Users</a></small></h1>

    <?php echo isset($error['add_user']) ? $error['add_user'] : ''; ?>
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

                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="add_user_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                     <label for="exampleInputEmail1"> Name</label><i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                     <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-4">
                                     <label for="exampleInputEmail1"> Mobile</label><i class="text-danger asterik">*</i><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
                                     <input type="nummber" class="form-control" name="mobile" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                     <label for="exampleInputEmail1"> Email</label><i class="text-danger asterik">*</i><?php echo isset($error['email']) ? $error['email'] : ''; ?>
                                     <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-md-4">
                                     <label for="exampleInputEmail1"> Password</label><i class="text-danger asterik">*</i><?php echo isset($error['password']) ? $error['password'] : ''; ?>
                                     <input type="text" class="form-control" name="password" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                     <label for="exampleInputEmail1"> Address</label><i class="text-danger asterik">*</i><?php echo isset($error['address']) ? $error['address'] : ''; ?>
                                     <textarea type="text"  rows="2" class="form-control" name="address" required></textarea>
                                </div>
                                <div class="col-md-4">
                                     <label for="exampleInputEmail1"> District</label><i class="text-danger asterik">*</i><?php echo isset($error['district']) ? $error['district'] : ''; ?>
                                     <input type="text" class="form-control" name="district" required>
                                </div>
                                <div class="col-md-4">
                                     <label for="exampleInputEmail1"> Pincode</label><i class="text-danger asterik">*</i><?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?>
                                     <input type="number" class="form-control" name="pincode" required>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset"  onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>
<?php $db->disconnect(); ?>