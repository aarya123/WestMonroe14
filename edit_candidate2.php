<?php
$sql_update_field = "UPDATE Candidate SET name=:name, email=:email, school=:school, major=:major, gpa=:gpa, grad_date=:grad_date, offer_status=:offer_status WHERE id=:candidate_id";
include_once("db.php");
	$required = array('id', 'name', 'email', 'school', 'major', 'gpa', 'grad_date', 'offer_status');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_update_field);
		$stmt->execute(array(
				':name' => $_POST['name'],
				':email' => $_POST['email'],
				':school' => $_POST['school'],
				':major' => $_POST['major'],
				':gpa' => $_POST['gpa'],
				':grad_date' => $_POST['grad_date'],
				':candidate_id' => $_POST['id'],
				':offer_status' => $_POST['offer_status']
			)
		);
		if($stmt->errorCode() != 0) {
			echo json_encode(array('error' => $stmt->errorInfo()));
			exit();
		}
		header("Location: editCandidate.php");
 		die();
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
?>
