<?php
require_once('config.php');

$page = basename($_SERVER['SCRIPT_NAME']);

function redirect_homepage() {
    header ("Location: templates/home.php");
    die ("Not Found :(");
}

function add_styles() {
    echo '<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">';
    echo '<link type="text/css" rel="stylesheet" href="../assets/css/bootstrap.min.css"/>';
    echo '<link rel="stylesheet" href="../assets/css/font-awesome.min.css">';
    echo '<link type="text/css" rel="stylesheet" href="../assets/css/style.css"/>';
    switch ($GLOBALS['page']) {
        case 'home.php':
            echo '<link type="text/css" rel="stylesheet" href="../assets/css/slick.css"/>';
            echo '<link type="text/css" rel="stylesheet" href="../assets/css/slick-theme.css"/>';
        case 'store.php':
            echo '<link type="text/css" rel="stylesheet" href="../assets/css/nouislider.min.css"/>';
    }
}

// function add_scripts() {

// }

function generate_top_header(array $ul_list, array $left_menu, array $right_menu) {
    foreach ($ul_list as $ul_name) {
        echo '<ul class="header-links pull-' .$ul_name .'">';
        if ($ul_name == 'left') {
            icon_menu($left_menu);
        } else {
            foreach ($right_menu as $right_name=>$right_item) {
                echo '<li><a href="#"><i class="fa fa-' .$right_name .'"></i> '. $right_item .'</a></li>';
            }
        }
        echo '</ul>';
    }
}

function icon_menu(array $list) {
    foreach ($list as $name=>$item) {
        echo '<li>';
        switch ($name) {
            case 'phone':
                echo '<a href="tel:' .$item .'">';
                break;
            case 'envelope-o':
                echo '<a href="mailto:' .$item .'">';
                break;
            case 'map-marker':
                echo '<a href="https://maps.app.goo.gl/zurt86rrmY4S8pFFA">';
                break;
        }
        echo '<i class="fa fa-' .$name .'"></i> '. $item .'</a></li>';
    }
}

function generate_input(array $input_list) {
    echo '<select class="input-select">';
    foreach ($input_list as $key=>$value) {
        echo '<option value="' .$key .'">' .$value .'</option>';
    }
}

function generate_cart(array $cart_list) {
    echo '<div class="cart-list">';
    foreach ($cart_list as $cart_item=>$product_list) {
        echo '<div class="product-widget">';
        echo '<div class="product-img"><img src="../assets/img/' .$cart_item .'.png" alt=""></div>';
        echo '<div class="product-body">';
        echo '<h3 class="product-name"><a href="#">' .$product_list[0] .'</a></h3>';
        echo '<h4 class="product-price"><span class="qty">1x</span>' .$product_list[1] .'</h4>';
        echo '</div>';
        echo '<button class="delete"><i class="fa fa-close"></i></button>';
        echo '</div>';
    }
    echo '</div>';
} 

// function generate_nav(array $nav_list) {
//     echo '<ul class="main-nav nav navbar-nav">';
//     foreach ($nav_list as $nav_url=>$nav_name) {
//         if ($GLOBALS['page'] == $nav_url) {
//             echo '<li class="active"><a href="' .$nav_url .'">' .$nav_name .'</a></li>';
//         } else {
//             echo '<li><a href="' .$nav_url .'">' .$nav_name .'</a></li>';
//         }
//     }
//     echo '</ul>';
// }

function generate_follow(array $follow_list) {
    echo '<ul class="newsletter-follow">';
    foreach ($follow_list as $fname=>$furl) {
        echo '<li><a href="' .$furl .'"><i class="fa fa-' .$fname .'"></i></a></li>';
    }
    echo '</ul>';
}

function generate_footer(int $cols, array $footer_list) {
    $col_size = intdiv(12, $cols);
    echo '<div class="row">';
    foreach ($footer_list as $footer_name=>$footer_urls) {
        echo '<div class="col-md-' .$col_size .' col-xs-6">
                <div class="footer">
                    <h3 class="footer-title">' .$footer_name .'</h3>';
        if ($footer_name == 'About Us') {
            echo '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>
                  <ul class="footer-links">';
            icon_menu($footer_urls);
        } else {
            echo '<ul class="footer-links">';
            foreach ($footer_urls as $name=>$value) {
                echo '<li><a href="' .$value .'">' .$name .'</a></li>';
            }
        }
        echo '</ul>
              </div>
              </div>';
    }
    echo '</div>';
}

function add_cards(array $cards) {
    echo '<ul class="footer-payments">';
    foreach ($cards as $card_name=>$card_url) {
        echo '<li><a href="' .$card_url .'"><i class="fa fa-' .$card_name .'"></i></a></li>';
    }
    echo '</ul>';
}

function add_top_images(array $images) {
    foreach ($images as $title=>$image) {
        echo '<div class="col-md-4 col-xs-6">
                <div class="shop">
                    <div class="shop-img">
                        <img src="../assets/img/' .$image .'.png" alt="">
					</div>
					<div class="shop-body">
						<h3>Laptop<br>' .$title .'</h3>
						<a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>';
    }
}

function new_products_filters() {
    $product_filters = array('Laptops', 'Smartphones', 'Cameras', 'Accessories');
    echo '<ul class="section-tab-nav tab-nav">';
    foreach ($product_filters as $filter) {
        if ($filter == 'Laptops') {
            echo '<li class="active"><a data-toggle="tab" href="#tab1">' .$filter .'</a></li>';
        } else {
            echo '<li><a data-toggle="tab" href="#tab1">' .$filter .'</a></li>';
        }
    }
}

?>