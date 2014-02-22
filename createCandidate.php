<?php include('header.php'); ?>
<form id="create_candidate" method="POST" action="create_candidate.php">
	<input placeholder="Name" id="name" type="text" name="name">
	<input placeholder="Email" id="email" type="email" name="email">
	<input placeholder="School" id="school" type="text" name="school">
	<input placeholder="Major" id="major" type="text" name="major">
	<input placeholder="GPA" id="gpa" type="number" name="gpa">
	<input placeholder="Expected Graduation Date" id="grad_date" type="date" name="grad_date">
	<label for="resume">Resume:</label>
	<input id="resume" type="file" accept=".pdf" name="resume">
	<input type="submit" value="Create Candidate">
</form>
<?php include('footer.php'); ?>