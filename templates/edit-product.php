<?php
require_once('../_inc/config.php');

if(!isset($_SESSION['is-admin']) || $_SESSION['is-admin'] == 0) {
    header('Location: error.php');
    die;
}

$product_obj = new Product();
if(isset($_POST['product_id'], $_POST['brand'])) {
    $brand = $_POST['brand'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $colour = $_POST['colour'];
    $size = $_POST['size'];
    $qty = $_POST['qty'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $product_item_id = $_POST['product_id'];

    if($product_obj->edit($brand, $name, $category, $colour, $size, $qty, $image, $price, $product_item_id)) {
        $_SESSION['product-saved'] = true;
    } else {
        $_SESSION['product-saved'] = false;
    }
}

if(isset($_POST['product_id'])) {
    $product = $product_obj->get_product($_POST['product_id']);
}

include_once('partials/header.php');
?>

<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<h3 class="breadcrumb-header">Add Product</h3>
						<ul class="breadcrumb-tree">
							<li><a href="home.php">Home</a></li>
							<li class="active">Admin</li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
                    <!-- Billing Details -->
                    <div class="row">
                        <div class="center-form">
							<form action="" method="POST">
								<div class="section-title">
									<h3 class="title">Edit Product</h3>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="brand" value="<?php echo $product->brand; ?>" placeholder="Brand" required>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="name" value="<?php echo $product->product_name; ?>" placeholder="Name" required>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="category" value="<?php echo $product->category_name; ?>" placeholder="Category" required>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="colour" value="<?php echo $product->colour; ?>" placeholder="Colour" required>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="size" value="<?php echo $product->size; ?>" placeholder="Size" required>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="qty" value="<?php echo $product->qty; ?>" placeholder="Quantity" required>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="image" value="<?php echo $product->image; ?>" placeholder="Image path">
								</div>
								<div class="form-group">
									<input class="input" type="text" name="price" value="<?php echo $product->price; ?>" placeholder="Price" required>
								</div>
								<button class="primary-btn" type="submit" name="product_id" value="<?php echo $product->id; ?>">Save</button>
							</form>

							<?php
							if(isset($_SESSION['product-saved'])) {
								if($_SESSION['product-saved'] == true) {
									echo '<div><p>Product is succesfully saved!</p></div>';
								} else {
									echo '<div><p>Something went wrong!</p></div>';
								}
								unset($_SESSION['product-saved']);
							}
							?>
                        </div>
                    </div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

<?php 
include_once('partials/footer.php');
?>