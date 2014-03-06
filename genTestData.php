<?php
include_once("db.php");
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare("INSERT INTO Candidate (name, email, school, major, gpa, grad_date, offer_status) VALUES (:name, :email, :school, :major, :gpa, :grad_date, :offer_status)");
		$schools = array('purdue', 'iu', 'illinois', 'depaw', 'northwestern', 'iupui');
		$majors = array('cs', 'business', 'english', 'math', 'science', 'history', 'economics');
		$gradDates = array('2015-05-01', '2015-12-01', '2016-05-01', '2016-12-01', '2017-05-01', '2017-12-01');
		$offer_statuses = array('None', 'Pending', 'No Offer', 'Accepted', 'Rejected');
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
				echo json_encode(array('error' => $stmt->errorInfo()));
				exit();
			}
		}
		echo "ok";
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
?>