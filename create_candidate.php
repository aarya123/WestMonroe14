<?php
	include_once("db.php");
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$sql_stmt = <<<'EOT'
INSERT INTO candidates (name, email, school, major, gpa, grad_date)
VALUES (:name, :email, :school, :major, :gpa, :grad_date)
EOT;
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
		echo json_encode(array('user_id' => $db->lastInsertId()));
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
?>