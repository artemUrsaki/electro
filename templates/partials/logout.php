<?php
require('../../_inc/config.php');

unset($_SESSION['logged-in']);
unset($_SESSION['is-admin']);
header('Location: ../login.php');