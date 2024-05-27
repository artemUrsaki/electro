<?php

class Page {
    private $page;

    public function __construct($page) {
        $this->page = $page;
    }

    function redirect_homepage() {
        header ("Location: templates/home.php");
        die ("Not Found :(");
    }

    public function add_styles() :string {
        $result = '<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">';
        $result .= '<link type="text/css" rel="stylesheet" href="../assets/css/bootstrap.min.css"/>';
        switch ($this->page) {
            case 'home.php':
                $result .= '<link type="text/css" rel="stylesheet" href="../assets/css/slick.css"/>';
                $result .= '<link type="text/css" rel="stylesheet" href="../assets/css/slick-theme.css"/>';
                break;
            case 'store.php':
                $result .= '<link type="text/css" rel="stylesheet" href="../assets/css/nouislider.min.css"/>';
                break;
            case 'hot-deals.php':
                $result .= '<link type="text/css" rel="stylesheet" href="../assets/css/slick.css"/>';
                $result .= '<link type="text/css" rel="stylesheet" href="../assets/css/slick-theme.css"/>';
                break;
            case 'product.php':
                $result .= '<link type="text/css" rel="stylesheet" href="../assets/css/slick.css"/>';
                $result .= '<link type="text/css" rel="stylesheet" href="../assets/css/slick-theme.css"/>';
                break;
        }
        $result .= '<link rel="stylesheet" href="../assets/css/font-awesome.min.css">';
        $result .= '<link type="text/css" rel="stylesheet" href="../assets/css/style.css"/>';
        $result .= '<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>';
        return $result;
    }

    public function add_scripts() :string {
        $result = '<script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>';
        switch($this->page) {
            case 'home.php':
                $result .= '<script src="../assets/js/slick.min.js"></script>';
                break;
            case 'store.php':
                $result .= '<script src="../assets/js/slick.min.js"></script>
                <script src="../assets/js/nouislider.min.js"></script>';
                break;
            case 'product.php':
                $result .= '<script src="../assets/js/slick.min.js"></script>';
                break;
        }
        $result .= '<script src="../assets/js/jquery.zoom.min.js"></script>
        <script src="../assets/js/main.js"></script>';
        return $result;      
    }

    public function add_top_images(array $images) {
        $res = '';
        foreach ($images as $title=>$image) {
            $res .= '<div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="../assets/img/' .$image .'.png" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>' .$title .'</h3>
                            <a href="store.php?category='. $title .'" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>';
        }
        return $res;
    }
}

?>