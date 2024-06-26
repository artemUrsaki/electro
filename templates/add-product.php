<?php
require_once('../_inc/config.php');

if(!isset($_SESSION['logged-in']) || $_SESSION['is-admin'] == 0) {
    header('Location: error.php');
    die;
}

$product_obj = new Product();
if(isset($_POST['add-product'])) {
    $brand = strtoupper($_POST['brand']);
    $name = $_POST['name'];
    $category = $_POST['category'];
    $colour = ucfirst($_POST['colour']);
    $size = $_POST['size'];
    $qty = $_POST['qty'];
    $image = $_POST['image'];
    $price = $_POST['price'];

    if($product_obj->add($brand, $name, $category, $colour, $size, $qty, $image, $price)) {
        $_SESSION['product-added'] = true;
    } else {
        $_SESSION['product-added'] = false;
    }
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
									<h3 class="title">Add Product</h3>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="brand" placeholder="Brand" required>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="name" placeholder="Name" required>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="category" placeholder="Category" required>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="colour" placeholder="Colour" required>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="size" placeholder="Size">
								</div>
								<div class="form-group">
									<input class="input" type="text" name="qty" placeholder="Quantity" required>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="image" placeholder="Image path">
								</div>
								<div class="form-group">
									<input class="input" type="text" name="price" placeholder="Price" required>
								</div>
								<button class="primary-btn" type="submit" name="add-product">Add</button>
							</form>

							<?php
							if(isset($_SESSION['product-added'])) {
								if($_SESSION['product-added'] == true) {
									echo '<div><p>Product is succesfully added!</p></div>';
								} else {
									echo '<div><p>Something went wrong!</p></div>';
								}
								unset($_SESSION['product-added']);
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