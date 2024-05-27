<?php

class Menu {
    private $pages;
    private $categories;
    private $left_links;

    public function __construct($pages, $categories, $left_links) {
        $this->pages = $pages;
        $this->categories = $categories;
        $this->left_links = $left_links;
    }

    public function generate_nav() :string {
        $active = basename($_SERVER['SCRIPT_NAME']);
        $result = '<ul class="main-nav nav navbar-nav">';
        foreach ($this->pages as $nav_url=>$nav_name) {
            if ($active == $nav_url) {
                $result .= '<li class="active"><a href="' .$nav_url .'">' .$nav_name .'</a></li>';
            } else if ($nav_name == 'Categories') {
                $result .= '<li id="categories-link"><a>' .$nav_name .'</a><div><div class="container"><ul class="main-nav nav navbar-nav">';
                foreach ($this->categories as $category_name) {
                    $result .= '<li><a class="category-link" href="store.php?category=' .$category_name .'">' .$category_name .'</a></li>';
                }
                $result .= '</ul></div></div></li>';
            } else {
                $result .= '<li><a href="' .$nav_url .'">' .$nav_name .'</a></li>';
            }
        } 
        $result .= '</ul>';
        return $result;
    }

    public function generate_input() :string {
        $result = '<select class="input-select"><option value="0">All Categories</option>';
        for ($i = 0; $i < count($this->categories); $i++) {
            $result .= '<option value="' .$i .'">' .$this->categories[$i] .'</option>';
        }
        return $result;
    }

    public function generate_left_menu() :string {
        $result = '<ul class="header-links pull-left">';
        $result .= $this->icon_menu($this->left_links);
        $result .= '</ul>';
        return $result;
    }

    function icon_menu(array $list) :string {
        $result = '';
        foreach ($list as $name=>$item) {
            $result .= '<li>';
            switch ($name) {
                case 'phone':
                    $result .= '<a href="tel:' .$item .'">';
                    break;
                case 'envelope-o':
                    $result .= '<a href="mailto:' .$item .'">';
                    break;
                case 'map-marker':
                    $result .= '<a href="https://maps.app.goo.gl/zurt86rrmY4S8pFFA">';
                    break;
            }
            $result .= '<i class="fa fa-' .$name .'"></i> '. $item .'</a></li>';
        }
        return $result;
    }
    
    function generate_cart(array $cart_list) :string {
        $res = '<div class="cart-list">';
        foreach ($cart_list as $cart_item=>$product_list) {
            $res .=  '<div class="product-widget">';
            $res .=  '<div class="product-img"><img src="../assets/img/' .$cart_item .'.png" alt=""></div>';
            $res .=  '<div class="product-body">';
            $res .=  '<h3 class="product-name"><a href="#">' .$product_list[0] .'</a></h3>';
            $res .=  '<h4 class="product-price"><span class="qty">1x</span>' .$product_list[1] .'</h4>';
            $res .=  '</div>';
            $res .=  '<button class="delete"><i class="fa fa-close"></i></button>';
            $res .=  '</div>';
        }
        $res .= '</div>';
        return $res;
    } 
    
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
                echo '<p>Welcome to Electro, your ultimate online destination for all things electronic!</p>
                      <ul class="footer-links">';
                $this->icon_menu($footer_urls);
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
}