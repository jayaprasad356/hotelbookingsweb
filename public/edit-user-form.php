<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php

if (isset($_GET['id'])) {
    $ID = $db->escapeString($_GET['id']);
} else {
    // $ID = "";
    return false;
    exit(0);
}
if (isset($_POST['btnEdit'])) {

		$name = $db->escapeString($_POST['name']);
		$mobile = $db->escapeString($_POST['mobile']);
		$email = $db->escapeString($_POST['email']);
		$password = $db->escapeString($_POST['password']);
		$address = $db->escapeString($_POST['address']);
		$pincode = $db->escapeString($_POST['pincode']);
		$district = $db->escapeString($_POST['district']);
		$error = array();

		if (empty($name)) {
			$error['name'] = " <span class='label label-danger'>Required!</span>";
		}
		if (empty($mobile)) {
			$error['mobile'] = " <span class='label label-danger'>Required!</span>";
		}

		

		if (!empty($name) && !empty($mobile) && !empty($email) && !empty($address) && !empty($district) && !empty($pincode)) {		
			
             $sql_query = "UPDATE users SET name='$name',mobile='$mobile',email='$email',password='$password',address='$address',district='$district',pincode='$pincode' WHERE id =  $ID";
			 $db->sql($sql_query);
             $update_result = $db->getResult();
			if (!empty($update_result)) {
				$update_result = 0;
			} else {
				$update_result = 1;
			}

			// check update result
			if ($update_result == 1) {
				$error['update_user'] = " <section class='content-header'><span class='label label-success'>User updated Successfully</span></section>";
			} else {
				$error['update_user'] = " <span class='label label-danger'>Failed update Users</span>";
			}
		}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM users WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "categories.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit User<small><a href='users.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Users</a></small></h1>
	<small><?php echo isset($error['update_user']) ? $error['update_user'] : ''; ?></small>
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
</section>
<section class="content">
	<!-- Main row -->

	<div class="row">
		<div class="col-md-12">
		
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
					
				</div><!-- /.box-header -->
				<!-- form start -->
				<form id="edit_category_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
						<div class="row">
							<div class="form-group">
								<div class="col-md-4">
									<label for="exampleInputEmail1"> Name</label><?php echo isset($error['name']) ? $error['name'] : ''; ?><i class="text-danger asterik">*</i>
									<input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>">
								</div>
								<div class="col-md-4">
									<label for="exampleInputEmail1"> Mobile Number</label><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="mobile" value="<?php echo $res[0]['mobile']; ?>">
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="form-group">
								<div class="col-md-4">
									<label for="exampleInputEmail1"> Email</label><?php echo isset($error['email']) ? $error['email'] : ''; ?><i class="text-danger asterik">*</i>
									<input type="email" class="form-control" name="email" value="<?php echo $res[0]['email']; ?>">
								</div>
								<div class="col-md-4">
									<label for="exampleInputEmail1">Password</label><?php echo isset($error['password']) ? $error['password'] : ''; ?><i class="text-danger asterik">*</i>
									<input type="text" class="form-control" name="password" value="<?php echo $res[0]['password']; ?>">
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="form-group">
								<div class="col-md-6">
									<label for="exampleInputEmail1"> Address</label><?php echo isset($error['address']) ? $error['address'] : ''; ?><i class="text-danger asterik">*</i>
									<textarea rows="3" type="text" class="form-control" name="address" ><?php echo $res[0]['address']; ?></textarea>
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">District</label><?php echo isset($error['district']) ? $error['district'] : ''; ?><i class="text-danger asterik">*</i>
									<input type="text" class="form-control" name="district" value="<?php echo $res[0]['district']; ?>">
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Pincode</label><?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="pincode" value="<?php echo $res[0]['pincode']; ?>">
								</div>
							</div>
						</div>

					</div><!-- /.box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="btnEdit">Update</button>
					
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
