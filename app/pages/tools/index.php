<?php 
	if (isset($_GET['tool'])) {
		$tool = $_GET['tool'];
		include file_exists($tool.'.html')?$tool.'.html':$tool.'.php';
	}else{
		echo "Select tool";
	}
 ?>