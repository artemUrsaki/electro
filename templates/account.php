<?php 
require_once('../_inc/config.php');

if(!isset($_SESSION['logged-in'])) {
	header('Location: error.php');
	die;
}

include_once('partials/header.php');
?>

<main>
    <h1>Admin</h1>
</main>

<?php 
include_once('partials/footer.php');
?>