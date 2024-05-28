<?php
require_once('../_inc/config.php');

$product_obj = new Product();

if(!isset($_SESSION['is-admin']) || $_SESSION['is-admin'] == 0) {
	header('Location: error.php');
	die;
}

if(isset($_POST['desc'], $_POST['product_id'])) {
	if($product_obj->edit_product_desc($_POST['desc'], $_POST['product_id'])) {
		header('Location: product.php?id='. $_POST['product_id']);
		die;
	} else {
		$_SESSION['desc-edited'] = '<p>Something went wrong!</p>';
	}
}

if(isset($_POST['product_id'])) {
    $product = $product_obj->get_product($_POST['product_id']);
	$desc = $product->description;
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
						<h3 class="breadcrumb-header">Edit Image</h3>
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
                    <!-- Billing Details -->
                    <div class="row">
                        <div class="center-form">
							<form method="POST">
								<div class="section-title">
									<h3 class="title">Edit Description</h3>
								</div>
								<div class="form-group">
									<textarea class="input" name="desc" placeholder="Write Your Description"><?php echo $desc ?></textarea>
								</div>
								<button class="primary-btn" type="submit" name="product_id" value="<?php echo $_POST['product_id'] ?>">Save</button>
							</form>
							<div>
                            	<a href="product.php?id=<?php echo $_POST['product_id']; ?>">Back To Product</a>
                        	</div>

							<?php
							
							if(isset($_SESSION['desc-edited'])) {
								echo $_SESSION['desc-edited'];
								unset($_SESSION['desc-edited']);
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