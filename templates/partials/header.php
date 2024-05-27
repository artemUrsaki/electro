<?php
require_once('../_inc/config.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Electro</title>

		<?php
		$page = basename($_SERVER['SCRIPT_NAME']);
		$page_obj = new Page($page);
		echo $page_obj->add_styles();
		?>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
		WARNING: Respond.js doesn't work if you view the page via file://
		[if lt IE 9]> -->
		<!-- <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> -->
		<!-- [endif] -->
    </head>
    <body>
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
                    <?php
                    
					$categories = array('Laptops', 'Smartphones', 'Cameras', 'Accessories');
					$nav_list = array(
						'home.php'=>'Home',
						'hot-deals.php'=>'Hot Deals',
						'#'=>'Categories',
						'store.php'=>'Shop',
					);
					$left_menu = array(
						'phone'=>'+021-95-51-84',
						'envelope-o'=>'email@email.com',
						'map-marker'=>'1734 Stonecoal Road',
					);
					
					$menu_obj = new Menu($nav_list, $categories, $left_menu);

                    echo $menu_obj->generate_left_menu();

                    ?>

					<ul class="header-links pull-right">
						<li><a href="login.php"><i class="fa fa-user-o"></i> My Account</a></li>
						<?php 
							if(isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) {
								echo '<li><a href="partials/logout.php">Log Out</a></li>';
							}
						?>
					</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="home.php" class="logo">
									<img src="../assets/img/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<form>
                                    <?php
 
									echo $menu_obj->generate_input();

                                    ?>
									<input class="input" placeholder="Search here">
									<button class="search-btn">Search</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								<div>
									<a href="#">
										<i class="fa fa-heart-o"></i>
										<span>Your Wishlist</span>
										<div class="qty">2</div>
									</a>
								</div>
								<!-- /Wishlist -->

								<!-- Cart -->
								<div class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
										<div class="qty">3</div>
									</a>
									<div class="cart-dropdown">
										<?php
											$cart_list = array(
												'product01'=>array('Headphones','$980.00'),
												'product02'=>array('Laptop','$1200.00'),
											);
											echo($menu_obj->generate_cart($cart_list));
										?>
										<div class="cart-summary">
											<small>3 Item(s) selected</small>
											<h5>SUBTOTAL: $2940.00</h5>
										</div>
										<div class="cart-btns">
											<a href="cart.php">View Cart</a>
											<a href="checkout.php">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
								</div>
								<!-- /Cart -->

								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->
        
		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<?php
					echo $menu_obj->generate_nav();
					?>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->