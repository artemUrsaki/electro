<?php
require('../_inc/config.php');
$product_obj = new Product();

if(!isset($_SESSION['is-admin']) && $_SESSION['is-admin'] == 0) {
    header('Location: error.php');
    die;
}

if($_POST['product_id']) {
    $product_obj->delete($_POST['product_id']);
    header('Location: ');
}