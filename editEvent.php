<?php include('header.php') ?>
<input placeholder="Search for an event" type="text" list='names'>
<datalist id="names">
	<select>
		<?php include("allevents.php"); ?>
	</select>
</datalist>

<form disabled id="create_event" method="POST" action="edit_candidate2.php">
	<input type="hidden" id="id" name="id">
	<input disabled placeholder="Name" id="name" type="text" name="name">
	<input disabled placeholder="Description" id="desc" type="text" name="desc">
	<input disabled placeholder="Location" id="location" type="text" name="location">
	<input disabled placeholder="Date" id="time" type="date" name="time">
	<input disabled type="submit" value="Update Candidate">
</form>


<script>
	function updateCandidate(id) {
		document.getElementById('selectCandidate').disabled = true;
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
		
		req.open('post', 'get_candidate.php', true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		req.send('id=' + encodeURIComponent(id));
	}
</script>
<?php include('footer.php') ?>