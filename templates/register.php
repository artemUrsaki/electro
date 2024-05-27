<?php
require_once('../_inc/config.php');

$user_obj = new User();
if(isset($_POST['user_register'])) {
    $fname = $_POST['first-name'];
    $lname = $_POST['last-name'];
    $email = $_POST['email'];
    $phone = $_POST['tel'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $hnumber = $_POST['house_number'];
    $postal = $_POST['postal'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if($password == $confirm_password) {
        if($user_obj->register($fname, $lname, $email, $phone, $country, $city, $street, $hnumber, $postal, $password)) {
            header('Location: /login.php');
			die;
		} else {
            $_SESSION['register-fault'] = '<p>Something went wrong. Try again please.</p>'; 
        }
    } else {
        $_SESSION['register-fault'] = '<p>The passwords do not match. Please try again.</p>';
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
                                <h3 class="title">Register</h3>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="first-name" placeholder="First Name" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="last-name" placeholder="Last Name" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="tel" name="tel" placeholder="Phone Number" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="country" placeholder="Country" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="city" placeholder="City" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="street" placeholder="Street" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="house_number" placeholder="House Number" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="postal" placeholder="Postal Code" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="password" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="confirm-password" placeholder="Confirm Password" required>
                            </div>
                            <button class="primary-btn" type="submit" name="user_register">Register</button>
                        </form>
                        <div>
                            <a href="login.php">Log in</a>
                        </div>
                        <?php 
                            if(isset($_SESSION['register-fault'])) {
                                echo $_SESSION['register-fault'];
                                unset($_SESSION['register-fault']);
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