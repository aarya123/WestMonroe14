<?php include('header.php'); ?>
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
<?php include('footer.php'); ?>