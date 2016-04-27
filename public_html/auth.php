<?php

session_start();
if (isset($_GET['do'])){
	if($_GET['do'] == 'logout'){
		unset($_SESSION['username']);
		session_destroy();
	}

	if(!$_SESSION['username']){
		header("Location: enter.php");
		exit;
	}
}

