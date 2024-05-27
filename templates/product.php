<?php
include_once('../_inc/config.php');

$slider_obj = new Slider();
$reviews_obj = new Reviews(); 
$rating_obj = new Rating();
$product_obj = new Product();
$pagination_obj = new Pagination(5);
$image_obj = new Image();
$product = $product_obj->get_product();

if(isset($_POST['del-img'])) {
	$img_id = $_POST['del-img'];
	$image_obj->delete_img($img_id);
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
						<ul class="breadcrumb-tree">
							<li><a href="#">Home</a></li>
							<li class="active"><?php echo $product->product_name; ?></li>
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
					<!-- Product main img -->
					<div class="col-md-5 col-md-push-2">
						<div id="product-main-img">
							<?php 
							
							$imgs = $product_obj->get_item_imgs($product->id);
							foreach ($imgs as $img) {
								echo'<div class="product-preview">';

								if(isset($_SESSION['is-admin']) && $_SESSION['is-admin'] == 1) {
									echo '<div class="product-edits">
									<form action="edit-img.php?id=' .$product->id .'" method="POST">
									<button class="admin-btn" type="submit" name="img_id" value="' .$img->image_id .'"><i class="fa fa-pencil" aria-hidden="true"></i></button>
									</form>
									<form action="" method="POST">
									<button class="admin-btn" type="submit" name="del-img" value="'. $img->image_id .'"><i class="fa fa-trash" aria-hidden="true"></i></button>
									</form>
									</div>';
								}
								
								echo '
								<img src="' .$img->image_url .'" alt="">
								</div>';
							}
							
							?>
						</div>
					</div>
					<!-- /Product main img -->

					<!-- Product thumb imgs -->
					<div class="col-md-2  col-md-pull-5">
						<div id="product-imgs">
							<?php 
							
							foreach ($imgs as $img) {
								echo'<div class="product-preview">
								<img src="' .$img->image_url .'" alt="">
								</div>';
							}
							
							?>
						</div>
					</div>
					<!-- /Product thumb imgs -->

					<!-- Product details -->
					<div class="col-md-5">
						<div class="product-details">
							<h2 class="product-name"><?php echo $product->product_name; ?></h2>
							<div>
								<div class="product-rating">
									<?php echo $rating_obj->avg_rating($product->id, true); ?>
								</div>
								<a class="review-link" href="#"><?php echo count($reviews_obj->select($product->id)) ?> Review(s) | Add your review</a>
							</div>
							<div>
								<h3 class="product-price"><?php echo $product->price; ?></h3>
								<span class="product-available">In Stock</span>
							</div>
							<p><?php echo $product->description; ?></p>

							<div class="product-options">
								<?php 
								if($product->size > 0) {
									echo '<label>Size: <b>'. $product->size .'</b></label>';
								}
								?>
								<label>
									<?php echo 'Color: <b>'. $product->colour .'</b>'; ?>
								</label>
							</div>

							<div class="add-to-cart">
								<form action="">
									<div class="qty-label">
										Qty
										<div class="input-number">
											<input type="number" value="1" max="<?php echo 	$product->qty; ?>">
											<span class="qty-up">+</span>
											<span class="qty-down">-</span>
										</div>
									</div>
									<button type="submit" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
								</form>
							</div>

							<ul class="product-btns">
								<li><a href="#"><i class="fa fa-heart-o"></i> add to wishlist</a></li>
							</ul>

							<ul class="product-links">
								<li>Category:</li>
								<li><a href="store.php?category=<?php echo $product->category_name; ?>"><?php echo $product->category_name; ?></a></li>
							</ul>
						</div>
					</div>
					<!-- /Product details -->

					<?php if(isset($_SESSION['logged-in']) && $_SESSION['is-admin'] == 1): ?>
					<div class="col-md-12">
						<form class="admin-details" action="add-img.php" method="POST">
							<button class="admin-btn primary-btn" type="submit" name="product_id", value="<?php echo $product->product_id ?>">Add image</button>
						</for>
					</div>
					<?php endif; ?>

					<!-- Product tab -->
					<div class="col-md-12">
						<div id="product-tab">
							<!-- product tab nav -->
							<ul class="tab-nav">
								<li><a data-toggle="tab" href="#tab1">Reviews (<?php echo count($reviews_obj->select($product->id)) ?>)</a></li>
							</ul>
							<!-- /product tab nav -->

							<!-- product tab content -->
							<div class="tab-content">
								<!-- tab1 -->
								<div id="tab1" class="tab-pane fade in">
									<div class="row">
										<?php if(count($reviews_obj->select($product->id)) > 0): ?>
											<!-- Rating -->
											<div class="col-md-3">
												<div id="rating">
													<div class="rating-avg">
														<span><?php echo $rating_obj->avg_rating($product->id); ?></span>
														<div class="rating-stars">
															<?php echo $rating_obj->avg_rating($product->id, true); ?>
														</div>
													</div>
													<ul class="rating">

														<?php 
														
														$amount = $rating_obj->count_reviews($product->id);
														for ($i = 5; $i > 0; $i--) {
															$rating_amount = $rating_obj->count_rating($product->id, $i);

															echo '<li>
															<div class="rating-stars">';

															echo $rating_obj->show_rating($i);

															echo '</div>
															<div class="rating-progress">
																<div style="width: '. $rating_amount*100/$amount .'%;"></div>
															</div>
															<span class="sum">'. $rating_amount .'</span>
															</li>';
														}
														
														?>
													</ul>
												</div>
											</div>
											<!-- /Rating -->

											<!-- Reviews -->
											<div class="col-md-6">
												<div id="reviews">
													<ul class="reviews">
														<?php echo $reviews_obj->get_reviews($product->id); ?>
													</ul>
													<ul class="reviews-pagination">
														<?php $pagination_obj->pagination(); ?> 
													</ul>
												</div>
											</div>
											<!-- /Reviews -->
										<?php endif; ?>

											<!-- Review Form -->
											<div class="col-md-3">
												<div id="review-form">
													<form class="review-form">
														<textarea class="input" placeholder="Your Review"></textarea>
														<div class="input-rating">
															<span>Your Rating: </span>
															<div class="stars">
																<input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
																<input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
																<input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
																<input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
																<input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
															</div>
														</div>
														<button class="primary-btn">Submit</button>
													</form>
												</div>
											</div>
										<!-- /Review Form -->
									</div>
								</div>
								<!-- /tab1  -->
							</div>
							<!-- /product tab content  -->
						</div>
					</div>
					<!-- /product tab -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- Section -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<div class="col-md-12">
						<div class="section-title text-center">
							<h3 class="title">Related Products</h3>
						</div>
					</div>

					<!-- product -->
					<div class="col-md-12">
						<div class="products-tabs">
							<!-- tab -->
							<div id="tab2" class="tab-pane fade in active">
								<div class="products-slick" data-nav="#slick-nav-2">
									<?php echo $slider_obj->get_slider_items($product->category_name); ?>
								</div>
							</div>
							<!-- /tab -->
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /Section -->

<?php
include_once('partials/footer.php');
?>