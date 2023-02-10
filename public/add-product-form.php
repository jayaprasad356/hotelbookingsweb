<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$sql = "SELECT id, name FROM categories ORDER BY id ASC";
$db->sql($sql);
$res = $db->getResult();

?>
<?php
if (isset($_POST['btnAdd'])) {

        $category = $db->escapeString(($_POST['category']));
        $product_name = $db->escapeString($_POST['product_name']);
        $measurement = $db->escapeString($_POST['measurement']);
        $unit = $db->escapeString($_POST['unit']);
        $brand = $db->escapeString($_POST['brand']);
        $price = $db->escapeString($_POST['price']);
        $mrp = $db->escapeString($_POST['mrp']);
        $description = $db->escapeString($_POST['description']);
        $error = array();
        
        // get image info
        $menu_image = $db->escapeString($_FILES['product_image']['name']);
        $image_error = $db->escapeString($_FILES['product_image']['error']);
        $image_type = $db->escapeString($_FILES['product_image']['type']);

        //image1 info
        $menu_image = $db->escapeString($_FILES['image1']['name']);
        $image_error = $db->escapeString($_FILES['image1']['error']);
        $image_type = $db->escapeString($_FILES['image1']['type']);

        //image2 info
        $menu_image = $db->escapeString($_FILES['image2']['name']);
        $image_error = $db->escapeString($_FILES['image2']['error']);
        $image_type = $db->escapeString($_FILES['image2']['type']);

        // common image file extensions
        $allowedExts = array("gif", "jpeg", "jpg", "png");

        // get image file extension
        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["product_image"]["name"]));

        //get image1 file extension
        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["image1"]["name"]));

        //get image2 file extension
        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["image2"]["name"]));
        
        if (empty($category)) {
            $error['category'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($product_name)) {
            $error['product_name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($measurement)) {
            $error['measurement'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($unit)) {
            $error['unit'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($brand)) {
            $error['brand'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($price)) {
            $error['price'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($mrp)) {
            $error['mrp'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($description)) {
            $error['description'] = " <span class='label label-danger'>Required!</span>";
        }
        if($mrp < $price){
            $error['add_product'] = " <span class='label label-danger'>MRP not less than price</span>";
        }
       
       
       if (!empty($category) && !empty($product_name)&& !empty($measurement)&& !empty($unit) && !empty($brand)&& !empty($price) && !empty($mrp)  && !empty($description) &&  ($mrp >= $price)) {
                $result = $fn->validate_image($_FILES["product_image"]);
                // create random image file name
                $string = '0123456789';
                $file = preg_replace("/\s+/", "_", $_FILES['product_image']['name']);
                $menu_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;
        
                // upload new image
                $upload = move_uploaded_file($_FILES['product_image']['tmp_name'], 'upload/products/' . $menu_image);
        
                // insert new data to menu table
                $upload_image = 'upload/products/' . $menu_image;
                $upload_image1 ='';
                $upload_image2 ='';

                //image1 info
                if ($_FILES['image1']['size'] != 0 && $_FILES['image1']['error'] == 0 && !empty($_FILES['image1'])){
                        // create random image1 file name
                        $string = '0123456789';
                        $file = preg_replace("/\s+/", "_", $_FILES['image1']['name']);
                        $image1 = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;
        
                        //upload new image1
                        $upload = move_uploaded_file($_FILES['image1']['tmp_name'], 'upload/products/' . $image1);
        
                        // insert new data to menu table
                        $upload_image1 = 'upload/products/' . $image1;
                   
                }
                //image2 info
                if ($_FILES['image2']['size'] != 0 && $_FILES['image2']['error'] == 0 && !empty($_FILES['image2'])){
                        // create random image2 file name
                        $string = '0123456789';
                        $file = preg_replace("/\s+/", "_", $_FILES['image2']['name']);
                        $image2 = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;
            
                        //upload new image2
                        $upload = move_uploaded_file($_FILES['image2']['tmp_name'], 'upload/products/' . $image2);
            
                        // insert new data to menu table
                        $upload_image2 = 'upload/products/' . $image2;
    
                }

            $discount_percentage= $price / $mrp *100;
           
            $sql_query = "INSERT INTO products (category_id,product_name,brand,measurement,unit,price,mrp,discount_percentage,description,image,image1,image2)VALUES('$category','$product_name','$brand','$measurement','$unit','$price','$mrp','$discount_percentage','$description','$upload_image','$upload_image1','$upload_image2')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                
                $error['add_product'] = "<section class='content-header'>
                                                <span class='label label-success'>Product Added Successfully</span> </section>";
            } else {
                $error['add_product'] = " <span class='label label-danger'>Failed</span>";
            }
        }
    }
?>
<section class="content-header">
    <h1>Add Product <small><a href='products.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Products</a></small></h1>

    <?php echo isset($error['add_product']) ? $error['add_product'] : ''; ?>
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
                    <h3 class="box-title">Add Product</h3>

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="add_product" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                           <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                            <label for="exampleInputEmail1">Product Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['product_name']) ? $error['product_name'] : ''; ?>
                                            <input type="text" class="form-control" name="product_name" required>
                                    </div>
                                    <div class='col-md-4'>
                                        <label for="">Category</label> <i class="text-danger asterik">*</i>
                                        <select id='category' name="category" class='form-control' required>
                                            <option value="">Select</option>
                                                <?php
                                                    $sql = "SELECT * FROM `categories`WHERE status=1";
                                                    $db->sql($sql);
                                                    $result = $db->getResult();
                                                    foreach ($result as $value) {
                                                ?>
                                                    <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Brand</label> <i class="text-danger asterik">*</i><?php echo isset($error['brand']) ? $error['brand'] : ''; ?>
                                        <select  name="brand" id="brand" class="form-control" required>
                                            <option value="">Select</option>
                                                <?php
                                                    $sql = "SELECT * FROM `brands`";
                                                    $db->sql($sql);
                                                    $result = $db->getResult();
                                                    foreach ($result as $value) {
                                                ?>
                                                    <option value='<?= $value['brand'] ?>'><?= $value['brand'] ?></option>
                                                <?php } ?>

                                         </select>  
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                   <div class="col-md-3">
                                        <label for="exampleInputEmail1">Measurement</label> <i class="text-danger asterik">*</i><?php echo isset($error['measurement']) ? $error['measurement'] : ''; ?>
                                        <input type="number" class="form-control" name="measurement" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="unit">Unit</label> <i class="text-danger asterik">*</i>
                                         <select  name="unit" id="unit" class="form-control" required>
                                            <option value="">-- Select Unit --</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Gm">Gm</option>
                                            <option value="Ltr">Ltr</option>
                                            <option value="Ml">Ml</option>
                                            <option value="Pcs">Pcs</option>
                                         </select>  
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Price</label> <i class="text-danger asterik">*</i><?php echo isset($error['price']) ? $error['price'] : ''; ?>
                                        <input type="number" class="form-control" name="price" required />
                                    </div>

                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Max.Retail.Price(MRP)</label> <i class="text-danger asterik">*</i><?php echo isset($error['mrp']) ? $error['mrp'] : ''; ?>
                                        <input type="number" class="form-control" name="mrp" required />
                                    </div>
                                    <div class="col-md-6">
                                            <label for="exampleInputEmail1">Description</label> <i class="text-danger asterik">*</i><?php echo isset($error['description']) ? $error['description'] : ''; ?>
                                            <textarea type="text" class="form-control" rows="3" name="description" required></textarea>
                                    </div>
                                 </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                         <label for="exampleInputFile">Image</label> <i class="text-danger asterik">*</i><?php echo isset($error['product_image']) ? $error['product_image'] : ''; ?>
                                        <input type="file" name="product_image" onchange="readURL(this);" accept="image/png,  image/jpeg" id="product_image" required/>
                                        <img id="blah" src="#" alt="" />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputFile">Image1</label><?php echo isset($error['image1']) ? $error['image1'] : ''; ?>
                                        <input type="file" name="image1" accept="image/png,  image/jpeg" id="image1" />
                                        <div class="form-group">
                                            <img id="blan" src="#" alt="image" />

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputFile">Image2</label><?php echo isset($error['image2']) ? $error['image2'] : ''; ?>
                                        <input type="file" name="image2" accept="image/png,  image/jpeg" id="image2"/>
                                        <div class="form-group">
                                            <img id="blas" src="#" alt="image" />

                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset" onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_product').validate({

        ignore: [],
        debug: false,
        rules: {
            product_name: "required",
            brand: "required",
            price,"required",
            category_image: "required",
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<script>
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>

<?php $db->disconnect(); ?>