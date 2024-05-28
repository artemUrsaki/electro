<?php
require_once('../_inc/config.php');

$review_obj = new Reviews();

if(!isset($_SESSION['logged-in']) && $_SESSION['is-admin'] == 0) {
	header('Location: error.php');
	die;
}

if(isset($_POST['review_id'])) {
    $review = $review_obj->select_single($_POST['review_id']);
}

if(isset($_POST['review_id'], $_POST['review'], $_POST['rating'])) {
    $review_id = $_POST['review_id'];
    $text = $_POST['review'];
    $rating = $_POST['rating'];
	if($review_obj->edit_review($review_id, $text, $rating)) {
		header('Location: product.php?id='. $review->product_item_id);
        die;
	} else {
		$_SESSION['rev-edited'] = '<p>Something went wrong!</p>';
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
						<h3 class="breadcrumb-header">Edit Review</h3>
						<ul class="breadcrumb-tree">
							<li><a href="home.php">Home</a></li>
							<li class="active">Review</li>
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
                            <form class="review-form" method="POST">
                                <div class="section-title">
									<h3 class="title">Edit Review</h3>
								</div>
                                <textarea class="input" name="review" placeholder="Your Review"><?php echo $review->review_text; ?></textarea>
                                <div class="input-rating">
                                    <span>Your Rating: </span>
                                    <div class="stars">
                                        <?php

                                        for($i = 5; $i >= 1; $i--) {
                                            echo '<input id="star'. $i .'" name="rating" value="'. $i .'" type="radio"';

                                            if($i == $review->rate) echo ' checked="checked"';

                                            echo '><label for="star'. $i .'"></label>';
                                        }
                                        
                                        ?>
                                    </div>
                                </div>
                                <button class="primary-btn" name="review_id" value="<?php echo $_POST['review_id']; ?>">Submit</button>
                            </form>
							<div>
                            	<a href="product.php?id=<?php echo $review->product_item_id; ?>">Back To Product</a>
                        	</div>

							<?php
							
							if(isset($_SESSION['rev-edited'])) {
								echo $_SESSION['rev-edited'];
								unset($_SESSION['rev-edited']);
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