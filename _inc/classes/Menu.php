<?php

class Menu {

    private $pages;
    private $categories;

    public function __construct($pages, $categories) {
        $this->pages = $pages;
        $this->categories = $categories;
    }

    public function generate_nav() :string{
        $active = basename($_SERVER['SCRIPT_NAME']);
        $result = '<ul class="main-nav nav navbar-nav">';
        foreach ($this->pages as $nav_url=>$nav_name) {
            if ($active == $nav_url) {
                $result .= '<li class="active"><a href="' .$nav_url .'">' .$nav_name .'</a></li>';
            } else if ($nav_name == 'Categories') {
                $result .= '<li id="categories-link"><a>' .$nav_name .'</a><div><div class="container"><ul class="main-nav nav navbar-nav">';
                foreach ($this->categories as $category_name) {
                    $result .= '<li><a href="store.php">' .$category_name .'</a></li>';
                }
                $result .= '</ul></div></div></li>';
            } else {
                $result .= '<li><a href="' .$nav_url .'">' .$nav_name .'</a></li>';
            }
        } 
        $result .= '</ul>';
        return $result;
    }

}

?>