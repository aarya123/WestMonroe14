<?php
include_once("db.php");
$sql_read_candidate = "SELECT name, email, school, major, gpa, grad_date FROM Candidate WHERE id=:candidate_id";
$required = array('id');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_read_candidate);
		$stmt->execute(array(
				':candidate_id' => $_POST['id']
			)
		);
		if($stmt->errorCode() != 0) {
			echo json_encode(array('error' => $stmt->errorInfo()));
			exit();
		}
		echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
?>