<?php
include_once("db.php");
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$db->beginTransaction();
		$stmt = $db->prepare("INSERT INTO Candidate (name, email, school, major, gpa, grad_date, offer_status) VALUES (:name, :email, :school, :major, :gpa, :grad_date, :offer_status)");
		$eventStmt = $db->prepare("INSERT INTO Event (name, location, time, description) VALUES (:name, :location, :time, :description)");
		$eventCandidateStmt = $db->prepare("INSERT INTO Event_has_Candidate (Event_id, Candidate_id, notes, attended) VALUES (:event_id, :candidate_id, :notes, :attended)");
		$schools = array('purdue', 'iu', 'illinois', 'depaw', 'northwestern', 'iupui');
		$majors = array('cs', 'business', 'english', 'math', 'science', 'history', 'economics');
		$gradDates = array('2015-05-01', '2015-12-01', '2016-05-01', '2016-12-01', '2017-05-01', '2017-12-01');
		$eventDates = array('2015-02-01', '2015-03-01', '2015-04-01', '2015-01-01');
		$eventLocations = array('loc a', 'loc b', 'loc c');
		$offer_statuses = array('None', 'Pending', 'No Offer', 'Accepted', 'Rejected');
		$candidateId = array();
		$eventId = array();
		for($i = 0; $i < 200; ++$i) {
			$name = (string)rand(0, 200);
			$email = ((string)rand(0, 200)) . '@' . ((string)rand(0, 200)) . '.com';
			$school = $schools[rand(0, count($schools) - 1)];
			$major = $majors[rand(0, count($majors) - 1)];
			$gpa = rand(1, 4);
			$grad_date = $gradDates[rand(0, count($gradDates) - 1)];
			$offer_status = $offer_statuses[rand(0, count($offer_statuses) - 1)];
			$stmt->execute(array(
				':name' => $name,
				':email' => $email,
				':school' => $school,
				':major' => $major,
				':gpa' => $gpa,
				':grad_date' => $grad_date,
				':offer_status' => $offer_status
			));
			if($stmt->errorCode() != 0) {
				throw new Exception($stmt->errorInfo());
			}
			array_push($candidateId, $db->lastInsertId());
		}
		for($i = 0; $i < 50; ++$i) {
			$name = (string)rand(0, 200);
			$location = $eventLocations[rand(0, count($eventLocations) - 1)];
			$time = $eventDates[rand(0, count($eventDates) - 1)];
			$desc = (string)rand(0, 200);
			$eventStmt->execute(array(
				':name' => $name,
				':location' => $location,
				':time' => $time,
				':description' => $desc
			));
			if($stmt->errorCode() != 0) {
				throw new Exception($stmt->errorInfo());
			}
			array_push($eventId, $db->lastInsertId());
		}
		for($i = 0; $i < 100; ++$i) {
			$notes = (string)rand(0, 200);
			$curCandidateId = $candidateId[rand(0, count($candidateId) - 1)];
			$curEventId = $eventId[rand(0, count($eventId) - 1)];
			$attended = rand(0, 1);
			$eventCandidateStmt->execute(array(
				':notes' => $notes,
				':candidate_id' => $curCandidateId,
				':event_id' => $curEventId,
				':attended' => $attended
			));
		}
		$db->commit();
		echo "ok";
	}
	catch(Exception $e) {
		$db->rollback();
		echo json_encode(array('error' => $e->getMessage()));
	}
?>