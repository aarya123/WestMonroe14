<?php
	include_once("db.php");
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$sql_stmt = <<<'EOT'
SELECT `name` from `Candidate`
EOT;
		$stmt = $db->prepare($sql_stmt);
		$stmt->execute();
		if($stmt->errorCode() != 0) {
			echo json_encode(array('error' => $stmt->errorInfo()));
			exit();
		}
		$users = $stmt->fetchAll();
		foreach ($users as $user) {
			$name = $user['name'];
			echo "<option value='$name'></option>";
		}
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
?>