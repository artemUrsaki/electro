<?php
require('../../_inc/config.php');

unset($_SESSION['logged-in'], $_SESSION['is-admin'], $_SESSION['user-id']);
header('Location: ../login.php');