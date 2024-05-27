<?php
include_once('partials/header.php');
$store_obj = new Store();
$pagination_obj = new Pagination(20);
?>

		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<input type="hidden" id="page" value="<?php echo isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1 ?>"> 
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree">
							<li><a href="#">Home</a></li>
							<li class="active">Shop</li>
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
					<!-- ASIDE -->
					<div id="aside" class="col-md-3">
						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Categories</h3>
							<div class="checkbox-filter">
								<?php echo $store_obj->category_filter(); ?>
							</div>
						</div>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Price</h3>
							<div class="price-filter">
								<div id="price-slider"></div>
								<div class="input-number price-min">
									<input id="price-min" type="number" value="<?php echo $store_obj->slider_getPrice("min")?>">
									<span class="qty-up">+</span>
									<span class="qty-down">-</span>
								</div>
								<span>-</span>
								<div class="input-number price-max">
									<input id="price-max" type="number" value="<?php echo $store_obj->slider_getPrice("max")?>">
									<span class="qty-up">+</span>
									<span class="qty-down">-</span>
								</div>
							</div>
						</div>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Brand</h3>
							<div class="checkbox-filter">
								<?php echo $store_obj->brand_filter(); ?> 
							</div>
						</div>
						<!-- /aside Widget -->
					</div>
					<!-- /ASIDE -->

					<!-- STORE -->
					<div id="store" class="col-md-9">
						<div class="store-filter clearfix">
							<div class="store-sort">
								<label>
									Sort By:
									<select class="sorting input-select">
										<option value="rating">Rating</option>
										<option value="price-low">Price: lowest</option>
										<option value="price-high">Price: highest</option>
									</select>
								</label>
							</div>
						</div>

						<div class="row store-items">
							
						</div>

						<?php 
							if(isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && $_SESSION['is-admin'] == 1) {
								echo '<div>
								<a href="add-product.php" class="primary-btn">Add Product</a>
								</div>';
							}
						?>

						<div class="store-filter clearfix">
							<span class="store-qty">

							</span>
							<ul class="store-pagination">
								<?php $pagination_obj->pagination(); ?>
							</ul>	
						</div>
					</div>
					
					<!-- /STORE -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

<?php
include_once('partials/footer.php');
?>