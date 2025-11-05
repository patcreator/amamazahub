<?php 
	header("Content-Type:application/json");
	include '../cogs/db.php';
	include_once '../cogs/functions.php';
	$all_results = [];
	if (isset($_POST['sql'])) 
	{
		$input = $_POST['sql'];
		foreach (explode(';',$input) as $sql) 
		{
			if (empty($sql)) 
			{
				continue;
				$all_results[] =  ["message" => "Empty data!", "type" => "danger"];
				goto end;
			}else{
					$words = explode(' ', $sql);
					$word = strtolower($words[0]);
					$data = x_retrivedata($sql);
					if ($data && count($data)>0) {
						$values = $colmns = $keep='';
							$table ="<div class='overflow-auto w-full mb-5'>
								<table class='border dark:border-gray-700'>";
							foreach ($data as $dt) {
								if (empty($colmns)) {
									$colmns = array_keys($dt);
								}
								$rows = array_values($dt);
								$v = array_map( fn($value)=> "<td class='border p-2 dark:border-gray-700'>$value</td>", $rows);
								$vl = implode('', $v);
								$values.="<tr>$vl</tr>\n";
							}
							$map = array_map(fn($v) => "<th class='border p-2 dark:border-gray-700'>$v</th>", $colmns);
							$c = implode('', $map);
							$c = "<tr>$c</tr>\n";
							$keep = $table.$c.$values."</table></div>";
							$all_results[] =  ["message"=>"Operation is done","meta"=>$keep,"type"=>"success","success" => true];
					}else{
							if (xquery_runner($sql)) {
								$all_results[] =  ["message"=>"Operation is done type=".$word,"type"=>"success","success" => true];
							}else{
								$all_results[] =  ["message"=>"Operation not done  type=".$word,"type"=>"danger"];
								goto end;
							}
					}
				}
		}
}
else
{
	$all_results[] =  ["message"=>"not sent","type"=>"danger"];
}
end:
echo json_encode($all_results??['message'=>'empty','success'=>false]);
?>