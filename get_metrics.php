<?php
include_once("db.php");
try {
	$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
	$candidateData = $db->prepare('SELECT candidate.id AS id, candidate.name AS name, candidate.school AS school, candidate.major AS major, candidate.gpa AS gpa, DATE_FORMAT(candidate.grad_date, "%b %y") AS grad_date, candidate.offer_status AS offer_status, SUM(ifnull(event_has_candidate.attended, 0)) AS attended_count FROM candidate LEFT JOIN event_has_candidate ON candidate.id=event_has_candidate.candidate_id GROUP BY candidate.id');
	$eventData = $db->prepare('SELECT event.id AS id, event.name AS name, event.location AS location, DATE_FORMAT(event.time, "%d %b, %y") AS time, SUM(ifnull(event_has_candidate.attended, 0)) AS attended_count FROM event LEFT JOIN event_has_candidate ON event.id=event_has_candidate.event_id GROUP BY event.id');
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
	echo json_encode(array(
	 "candidateData" => $candidateData->fetchAll(PDO::FETCH_ASSOC),
	 "eventData" => $eventData->fetchAll(PDO::FETCH_ASSOC)
	));
}
catch(PDOException $e) {
	echo json_encode(array('error' => $e->getMessage()));
}
?>