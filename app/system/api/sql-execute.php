<?php 
require_once "../cogs/db.php";
header("Content-type:application/json");
	if (isset($_POST['sql'])) {
		if (empty($_POST['sql'])) {
			echo json_encode(['success'=>false, 'message'=>"PLEASE ENTER SOMETHING"]);
			exit;
		}
		$data = [];
		try {
			// $pdo->exec($_POST['sql']??'');
			foreach (explode(';', $_POST['sql']) as $query) {
				if (empty($sql)) continue;
			    $stmt = $pdo->query($query);
			    $stmt->execute();
			    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			    if ($row) {
			    	$data[] = $row;
			    }
			}
			if ($data) {
				echo json_encode(['success'=>true, 'message'=>'operation done', 'data'=>json_encode($data)]);
			}else{
				echo json_encode(['success'=>true, 'message'=>'operation done']);
			}
		} catch (Exception $e) {
			echo json_encode(['success'=>false, 'message'=>$e->getMessage()]);
		}
	}else{
		echo json_encode(['success'=>false, 'message'=>'Invalid method']);
	}
 ?>