<!DOCTYPE html>
<html>
<head>
</head>
<body>
<form id="create_event" method="POST" action="create_event.php">
	<label for="name">Name:</label>
	<input id="name" type="text" name="name">
	<label for="desc">Description:</label>
	<input id="desc" type="text" name="desc">
	<label for="location">Location:</label>
	<input id="location" type="text" name="location">
	<label for="time">Date:</label>
	<input id="time" type="date" name="time">
	<input type="submit" value="Create Event">
</form>
<form id="create_candidate" method="POST" action="create_candidate.php">
	<label for="name">Name:</label>
	<input id="name" type="text" name="name">
	<label for="email">Email:</label>
	<input id="email" type="email" name="email">
	<label for="school">School:</label>
	<input id="school" type="text" name="school">
	<label for="major">Major:</label>
	<input id="major" type="text" name="major">
	<label for="gpa">GPA:</label>
	<input id="gpa" type="number" name="gpa">
	<label for="grad_date">Expected Graduation Date:</label>
	<input id="grad_date" type="date" name="grad_date">
	<label for="resume">Resume:</label>
	<input id="resume" type="file" accept=".pdf" name="resume">
	<input type="submit" value="Create Candidate">
</form>

<input type="text" list='names'>
<datalist id="names">
	<select>
		<?php include("allnames.php"); ?>
	</select>
</datalist>

</body>
</html>