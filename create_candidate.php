<?php
$sql_stmt = <<<'EOT'
INSERT INTO Candidate (name, email, school, major, gpa, grad_date)
VALUES (:name, :email, :school, :major, :gpa, :grad_date)
EOT;
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
				':grad_date' => $_POST['grad_date']
			)
		);
		if($stmt->errorCode() != 0) {
			echo json_encode(array('error' => $stmt->errorInfo()));
			exit();
		}
		echo json_encode(array('user_id' => $db->lastInsertId()));
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
?>