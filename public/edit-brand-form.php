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

		$name = $db->escapeString(($_POST['name']));
		$error = array();

		if (empty($name)) {
			$error['name'] = " <span class='label label-danger'>Required!</span>";
		}
		

		if (!empty($name)) {
			
             $sql_query = "UPDATE brands SET brand='$name' WHERE id =  $ID";
			 $db->sql($sql_query);
             $update_result = $db->getResult();
			if (!empty($update_result)) {
				$update_result = 0;
			} else {
				$update_result = 1;
			}

			// check update result
			if ($update_result == 1) {
				$error['update_brand'] = " <section class='content-header'><span class='label label-success'>Brand updated Successfully</span></section>";
			} else {
				$error['update_brand'] = " <span class='label label-danger'>Failed update category</span>";
			}
		}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM brands WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "brands.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Brand<small><a href='brands.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Brands</a></small></h1>
	<small><?php echo isset($error['update_brand']) ? $error['update_brand'] : ''; ?></small>
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
</section>
<section class="content">
	<!-- Main row -->

	<div class="row">
		<div class="col-md-6">
		
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
					
				</div><!-- /.box-header -->
				<!-- form start -->
				<form id="edit_brand_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
							<div class="form-group">
								<label for="exampleInputEmail1">Name</label><?php echo isset($error['name']) ? $error['name'] : ''; ?><i class="text-danger asterik">*</i>
								<input type="text" class="form-control" name="name" value="<?php echo $res[0]['brand']; ?>">
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
