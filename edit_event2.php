<?php
$sql_update_field = "UPDATE Event SET name=:name, location=:location, time=:time, description=:description WHERE id=:event_id";
include_once("db.php");
	$required = array('id', 'name', 'location', 'time', 'description');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_update_field);
		$stmt->execute(array(
				':name' => $_POST['name'],
				':location' => $_POST['location'],
				':time' => $_POST['time'],
				':description' => $_POST['description'],
				':event_id' => $_POST['id']
			)
		);
		if($stmt->errorCode() != 0) {
			echo json_encode(array('error' => $stmt->errorInfo()));
			exit();
		}
		echo json_encode(array('ok' => ""));
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
header('Location: /');
?>