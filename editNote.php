<?php include('header.php') ?>
<select id="selectInterview" onchange="updateInterview(this.value);">
	<option disabled selected>Select an interview</option>
	<?php include("allinterviews.php"); ?>
</select>
<select id="selectNote" onchange="updateNote();">
</select>

<form id="edit_note" method="POST" action="edit_note.php">
	<input type="hidden" id="interview_id" name="interview_id">
	<input type="hidden" id="note_id" name="note_id">
	<input disabled placeholder="Note" id="note" name="note">
	<input disabled type="submit" id = "submit" value="Update Note">
</form>


<script>
	var notes = null;
	function updateInterview(id) {
		var req = new XMLHttpRequest();
		req.onload = function() {
			document.getElementById('interview_id').value = id;
			var noteList = document.getElementById("selectNote");
			while(noteList.firstChild) {
				noteList.removeChild(noteList.firstChild);
			}
			document.getElementById('note').value = '';
			document.getElementById('note').disabled = true;
			document.getElementById('submit').disabled = true;
			notes = JSON.parse(req.responseText);
			console.log(notes);
			if(notes.length > 0) {
				var selectOption = document.createElement("option");
				selectOption.text = "Select a note";
				selectOption.disabled = true;
				noteList.appendChild(selectOption);
				for(var i = 0; i < notes.length; ++i) {
					var noteElement = document.createElement("option");
					noteElement.text = notes[i].note;
					noteList.appendChild(noteElement);
				}
				noteList.selectedIndex = 1;
				document.getElementById('note_id').value = notes[0].id;
				updateNote();
			}
			else {
				var noneOption = document.createElement("option");
				noneOption.text = "No notes available";
				noneOption.disabled = true;
				noteList.appendChild(noneOption);
			}
		}
		
		req.open('post', 'get_notes.php', true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		req.send('interview_id=' + encodeURIComponent(id));
	}

	function updateNote() {
		var curNote = notes[document.getElementById('selectNote').selectedIndex - 1];
		document.getElementById('note').value = curNote.note;
		document.getElementById('note').disabled = false;
		document.getElementById('submit').disabled = false;

	}
</script>

<?php include('footer.php') ?>