<?php
include_once("db.php");
	$required = array('id', 'field_name', 'field_value');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	$allowed = array('name', 'location', 'time');
	if(!in_array($_POST['field_name'], $allowed)) {
		echo json_encode(array('error' => 'invalid field name'));
		exit();
	}
	$sql_update_field = "UPDATE Event SET ${_POST['field_name']}=:field_value WHERE id=:candidate_id";
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_update_field);
		$stmt->execute(array(
				':field_value' => $_POST['field_value'],
				':candidate_id' => $_POST['id']
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