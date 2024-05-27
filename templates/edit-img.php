<?php
require_once('../_inc/config.php');

$image_obj = new Image();

if(!isset($_SESSION['is-admin']) || $_SESSION['is-admin'] == 0) {
	header('Location: error.php');
	die;
}

if(!isset($_POST['img_id']) || $image_obj->get_img($_POST['img_id']) == false) {
	header('Location: error.php');
	die;
}

if(isset($_POST['edit-img'])) {
	$img = $_POST['image'];
	$img_id = $_POST['img_id'];
	if($image_obj->edit_img($img_id, $img)) {
		$_SESSION['img-edited'] = '<p>Image is succesfully edited!</p>';
	} else {
		$_SESSION['img-edited'] = '<p>Something went wrong!</p>';
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
				<!-- row -->
				<div class="row">
                    
                    <!-- Billing Details -->
                    <div class="row">
                        <div class="center-form">
							<form method="POST">
								<div class="section-title">
									<h3 class="title">Edit Image</h3>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="image" placeholder="Image Path">
								</div>
								<input type="hidden" name="img_id" value="<?php echo $_POST['img_id'] ?>">
								<button class="primary-btn" type="submit" name="edit-img">Edit</button>
							</form>
							<div>
                            	<a href="product.php?id=<?php echo $_GET['id']; ?>">Back To Product</a>
                        	</div>

							<?php
							
							if(isset($_SESSION['img-edited'])) {
								echo $_SESSION['img-edited'];
								unset($_SESSION['img-edited']);
							}

							?>
                        </div>
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