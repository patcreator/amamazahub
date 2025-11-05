<?php 
session_start();
if (isset($_POST['icons'])) {
	if (isset($_SESSION['icons'])) $_SESSION['icons'] = !$_SESSION['icons'];
	else $_SESSION['icons'] = 1;
	echo "done";
}else{
	echo 'Invalid method';
}
 ?>
