<?php
include_once("db.php");
try {
	$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
	$candidateData = $db->prepare('SELECT candidate.id AS id, candidate.name AS name, candidate.school AS school, candidate.major AS major, candidate.gpa AS gpa, DATE_FORMAT(candidate.grad_date, "%b %y") AS grad_date, candidate.offer_status AS offer_status, COUNT(candidate.id) AS attended_count FROM candidate LEFT JOIN event_has_candidate ON candidate.id=event_has_candidate.candidate_id GROUP BY candidate.id');
	$eventData = $db->prepare('SELECT id, name, location, DATE_FORMAT(time, "%y %b %d") AS time, description FROM event');
	$eventAttendanceData = $db->prepare('SELECT Event_id, Candidate_id, notes, attended FROM  event_has_candidate');
	$candidateData->execute();
	if($candidateData->errorCode() != 0) {
		echo json_encode(array('error' => $candidateData->errorInfo()));
		exit();
	}
	$eventData->execute();
	if($eventData->errorCode() != 0) {
		echo json_encode(array('error' => $eventData->errorInfo()));
		exit();
	}
	$eventAttendanceData->execute();
	if($eventAttendanceData->errorCode() != 0) {
		echo json_encode(array('error' => $eventAttendanceData->errorInfo()));
	}
	echo json_encode(array(
	 "candidateData" => $candidateData->fetchAll(PDO::FETCH_ASSOC),
	 "eventData" => $eventData->fetchAll(PDO::FETCH_ASSOC),
	 "eventAttendanceData" => $eventAttendanceData->fetchAll(PDO::FETCH_ASSOC)
	 ));
}
catch(PDOException $e) {
	echo json_encode(array('error' => $e->getMessage()));
}
?>