<?php
include_once("db.php");
try {
	$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
	$stmt = $db->prepare('SELECT id, name, school, major, gpa, DATE_FORMAT(grad_date, "%b %y") AS grad_date, offer_status FROM candidate');
	$stmt->execute();
	if($stmt->errorCode() != 0) {
		echo json_encode(array('error' => $stmt->errorInfo()));
		exit();
	}
	echo json_encode(array("select" => array("school", "major", "gpa", "grad_date", "offer_status"), "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
}
catch(PDOException $e) {
	echo json_encode(array('error' => $e->getMessage()));
}
?>