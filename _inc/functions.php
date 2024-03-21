<?php

function redirect_homepage() {
    header ("Location: templates/home.php");
    die ("Not Found :(");
}

// function add_styles() {
//     $page_name = basename($_SERVER['SCRIPT_NAME'], '.php');
//     switch ($page_name) {
//         case 'home':
//             echo ""
//     }
// }

function generate_top_header($ul_list, $left_menu, $right_menu) {
    foreach ($ul_list as $ul_name) {
        echo '<ul class="header-links pull-' .$ul_name .'">';
        if ($ul_name == 'left') {
            foreach ($left_menu as $left_name=>$left_item) {
                echo '<li>';
                switch ($left_name) {
                    case 'phone':
                        echo '<a href="tel:' .$left_item .'">';
                        break;
                    case 'envelope-o':
                        echo '<a href="mailto:' .$left_item .'">';
                        break;
                    case 'map-marker':
                        echo '<a href="https://maps.app.goo.gl/zurt86rrmY4S8pFFA">';
                        break;
                }
                echo '<i class="fa fa-' .$left_name .'"></i> '. $left_item .'</a></li>';
            }
        } else {
            foreach ($right_menu as $right_name=>$right_item) {
                echo '<li><a href="#"><i class="fa fa-' .$right_name .'"></i> '. $right_item .'</a></li>';
            }
        }
        echo '</ul>';
    }
}

function generate_input($input_list) {
    echo '<select class="input-select">';
    foreach ($input_list as $key=>$value) {
        echo '<option value="' .$key .'">' .$value .'</option>';
    }
}

function generate_cart($cart_list) {
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

?>