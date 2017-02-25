<?php

ob_start();
session_start();

if ($_POST['id']) {
	$_SESSION['i2c_teams']['id'] = $_POST['id'];
	$_SESSION['i2c_teams']['i2c_category_id'] = $_POST['i2c_category_id'];
}

?>