<?php
require_once('../_inc/config.php');

$product_obj = new Product();
$image_obj = new Image();

if(!isset($_SESSION['is-admin']) || $_SESSION['is-admin'] == 0) {
	header('Location: error.php');
	die;
}

if(!isset($_POST['product_id'])) {
	header('Location: error.php');
	die;
}

if(isset($_POST['product_id'], $_POST['image'])) {
	$img = $_POST['image'];
	if($image_obj->add_img($_POST['product_id'], $img)) {
		$_SESSION['img-added'] = '<p>Image is succesfully added!</p>';
	} else {
		$_SESSION['img-added'] = '<p>Something went wrong!</p>';
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
						<h3 class="breadcrumb-header">Add Image</h3>
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
							<form method="POST">
								<div class="section-title">
									<h3 class="title">Add Image</h3>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="image" placeholder="Image Path">
								</div>
								<button class="primary-btn" type="submit" name="product_id" value="<?php echo $_POST['product_id'] ?>">Add</button>
							</form>
							<div>
                            	<a href="product.php?id=<?php echo $_POST['product_id']; ?>">Back To Product</a>
                        	</div>

							<?php
							
							if(isset($_SESSION['img-added'])) {
								echo $_SESSION['img-added'];
								unset($_SESSION['img-added']);
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