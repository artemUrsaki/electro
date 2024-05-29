<?php
require_once('../_inc/config.php');

if(isset($_POST['logout'])) {
	unset($_SESSION['logged-in'], $_SESSION['is-admin'], $_SESSION['user-id']);
}

if(isset($_SESSION['logged-in'])) {
	$cart_obj = new Cart($_SESSION['user-id']);
}

if(isset($_POST['cart_product_id'])) {
	if(isset($_SESSION['logged-in'])) {
		$product_id = $_POST['cart_product_id'];
		$qty = isset($_POST['qty']) ? $_POST['qty'] : 1;
		$cart_obj->add_cart($product_id, $qty);
	} else {
		header('Location: login.php');
	}
}

if(isset($_POST['del_cart_item'])) {
	$cart_item = $_POST['del_cart_item'];
	$cart_obj->delete_cart($cart_item);
} 
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
						<?php 
							if(isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) {
								echo '<li><form method="POST"><button name="logout">Log Out</button></form></li>';
							} else {
								echo '<li><a href="login.php"><i class="fa fa-user-o"></i> My Account</a></li>';
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
						<div class="col-md-9">
							<div class="header-logo">
								<a href="home.php" class="logo">
									<img src="../assets/img/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->
						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Cart -->
								<div class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
									</a>
									<div class="cart-dropdown">
										
										<?php
										if(isset($_SESSION['logged-in'])) {
											echo($cart_obj->get_cart());
										} else {
											echo '<div class="center-form">
											<a href="login.php" class="primary-btn">Log In</a>
											</div>';
										}
										?>
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