<?php include('header.php'); ?>
<form id="create_event" method="POST" action="create_event.php">
	<input placeholder="Name" id="name" type="text" name="name">
	<input placeholder="Description" id="desc" type="text" name="desc">
	<input placeholder="Location" id="location" type="text" name="location">
	<input placeholder="Date" id="time" type="date" name="time">
	<input type="submit" value="Create Event">
</form>
<?php include('footer.php'); ?>