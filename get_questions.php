<?php
include_once("db.php");
$sql_read_candidate = "SELECT question, answer, id FROM question WHERE interview_id=:interview_id";
$required = array('interview_id');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_read_candidate);
		$stmt->execute(array(
				':interview_id' => $_POST['interview_id']
			)
		);
		if($stmt->errorCode() != 0) {
			echo json_encode(array('error' => $stmt->errorInfo()));
			exit();
		}
		echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
?>