<?php
$sql_stmt = "INSERT INTO Candidate (name, email, school, major, gpa, grad_date, offer_status) VALUES (:name, :email, :school, :major, :gpa, :grad_date, :offer_status)";
	include_once("db.php");
	$required = array('name', 'email', 'school', 'major', 'gpa', 'grad_date');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_stmt);
		$stmt->execute(array(
				':name' => $_POST['name'],
				':email' => $_POST['email'],
				':school' => $_POST['school'],
				':major' => $_POST['major'],
				':gpa' => $_POST['gpa'],
				':grad_date' => $_POST['grad_date'],
				':offer_status' => $_POST['offer_status']
			)
		);
		if($stmt->errorCode() != 0) {
			echo json_encode(array('error' => $stmt->errorInfo()));
			exit();
		}
		header("Location: createCandidate.php");
		die();
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
?>
