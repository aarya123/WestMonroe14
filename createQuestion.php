 <?php include('header.php'); ?>

<form id="create_question" method="POST" action="create_question.php">
	<select id="selectInterview" name="interview_id">
	<option disabled selected>Select a interview</option>
	<?php include("allinterviews.php"); ?>
	</select>
	<input placeholder="Question" id="question" type="text" name="question">
	<input placeholder="Answer" id="answer" type="text" name="answer">
	<input type="submit" value="Create Question">
</form>
<?php include('footer.php'); ?>