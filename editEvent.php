<?php include('header.php') ?>
<select id="selectEvent" onchange="updateEvent(this.value);">
	<option disabled selected>Select an event</option>
	<?php include("allevents.php"); ?>
</select>

<form id="create_event" method="POST" action="edit_event2.php">
	<input type="hidden" id="id" name="id">
	<input disabled placeholder="Name" id="name" type="text" name="name">
	<input disabled placeholder="Description" id="description" type="text" name="description">
	<input disabled placeholder="Location" id="location" type="text" name="location">
	<input disabled placeholder="Date" id="time" type="date" name="time">
	<input disabled type="submit" value="Update Event">
</form>


<script>
	function updateEvent(id) {
		var req = new XMLHttpRequest();
		req.onload = function() {
			document.getElementById('id').value = id;
			var candidate = JSON.parse(req.responseText);
			for(var name in candidate) {
				document.getElementById(name).setAttribute("value", candidate[name].split(" ")[0]);
			}
			var formInputs = document.querySelectorAll('#create_event input');
			for (var i = 0; i < formInputs.length; i++) {
				formInputs[i].removeAttribute('disabled');
			}
		}
		
		req.open('post', 'get_event.php', true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		req.send('id=' + encodeURIComponent(id));
	}
	if(window.location.hash) {
		var id = window.location.hash.slice(1);
		var select = document.querySelector("#selectEvent");
		for(var i = 0; i < select.options.length; ++i) {
			if(select.options[i].value == id) {
				select.selectedIndex = i;
				updateEvent(id);
				break;
			}
		}
	}
</script>
<?php include('footer.php') ?>