<?php
require_once('../_inc/config.php');

if(isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) {
	header('Location: account.php');
	die;
}

$user_obj = new User();
if(isset($_POST['log-in'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	if($user_obj->login($email, $password)) {
		header('Location: account.php');
		die;
	} else {
        $_SESSION['login-fault'] = '<p>Wrong email or password</p>';
	}
}

include_once('partials/header.php');
?>

        <div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<h3 class="breadcrumb-header">Account</h3>
						<ul class="breadcrumb-tree">
							<li><a href="home.php">Home</a></li>
							<li class="active">Account</li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->
		<!-- SECTION -->
		<div class="section others-section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
                    <div class="center-form">
                        <form method="POST">
                            <div class="section-title">
                                <h3 class="title">LOG IN</h3>
                            </div>
                            <div class="form-group">
                                <input class="input" type="email" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="password" placeholder="Password">
                            </div>
                            <button class="primary-btn" type="submit" name="log-in">Log In</button>
                        </form>
                        <div>
                            <a href="register.php">Register</a>
                        </div>
                        <?php 
                            if(isset($_SESSION['login-fault'])) {
                                echo $_SESSION['login-fault'];
                                unset($_SESSION['login-fault']);
                            }
                        ?>
                    </div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->
<?php 
include_once('partials/footer.php');
?>