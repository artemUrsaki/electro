<?php
session_start();

require_once('classes/Database.php');
require_once('classes/Slider.php');
require_once('classes/Menu.php');
require_once('classes/Page.php');
require_once('classes/Store.php');
require_once('classes/Reviews.php');
require_once('classes/Rating.php');
require_once('classes/Pagination.php');
require_once('classes/User.php');
require_once('classes/Product.php');
require_once('classes/Image.php');

$store_obj = new Store();
if (isset($_GET['action']) && $_GET['action'] == 'filter') {
	$items = $store_obj->get_store();
	$amount = count($store_obj->select());
	echo $items . " ; " . $amount;
} 