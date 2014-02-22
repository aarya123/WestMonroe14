<?php
	include_once("db.php");
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$sql_stmt = "SELECT Name, id FROM Interview";
		$stmt = $db->prepare($sql_stmt);
		$stmt->execute();
		if($stmt->errorCode() != 0) {
			echo json_encode(array('error' => $stmt->errorInfo()));
			exit();
		}
		$interviews = $stmt->fetchAll();
		foreach ($interviews as $interview) {
			$name = $interview['Name'];
			$id = $interview['id'];
			echo "<option value='$id' label='$name'></option>";
		}
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
?>