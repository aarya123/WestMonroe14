<?php include('header.php') ?>
	<body onload="getEvents();">
		<form action="UserNotes.php" method="POST">
			<select id="select_event" name="select_event" onchange="getUsers(this.value);">
				<option value='0'>Select Event</option>
			</select>
			<select id='select_user' name="select_user" style='display:none' onchange="loadInvite(this.value);">
				<option value='0'>Select User</option>
			</select>
			<div id="blah" style="display:none">
				<br>
				<input type="radio" name="attended" id="Yes" value="1">Yes
				<br>
				<input type="radio" name="attended" id="No" value="0">No
				<br>
				Notes
				<br>
				<textarea type="text" name="Notes" id="Notes"></textarea>
				<br>
				<input type="submit" value="Submit">
			</div>
		</form>
	</body>
</html>
<script>
function getEvents(){
	var x = document.getElementById("select_event");
	if (window.XMLHttpRequest)
  		xmlhttp=new XMLHttpRequest();
	else
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.open("GET","list_event.php",true);
 	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4){
   			var result=JSON.parse(xmlhttp.responseText);
   			for (var i = 0; i < result.length; i++) {
   				if(result[i]!=""){
   					var option = document.createElement("option");
   					option.text = result[i]['name'];
   					option.value = result[i]['id'];
					x.add(option);
				}
			}
		}
  	}
	xmlhttp.send();
}
function getUsers(str){
	if(str==0)
		document.getElementById("select_user").style.display="none";
	else
	{
		document.getElementById("select_user").style.display="block";
		var x = document.getElementById("select_user");
		if (window.XMLHttpRequest)
  			xmlhttp=new XMLHttpRequest();
		else
  			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.open("GET","list_user.php",true);
 		xmlhttp.onreadystatechange=function() {
  			if (xmlhttp.readyState==4){
   				var result=JSON.parse(xmlhttp.responseText);
				for (i = 1; i < x.options.length; i++)
  					x.options[i] = null;
   				for (var i = 0; i < result.length; i++) {
   					if(result[i]!=""){
   						var option = document.createElement("option");
   						option.text = result[i]['name'];
   						option.value = result[i]['id'];
						x.add(option);
					}
				}
			}
  		}
		xmlhttp.send();
	}
}
function loadInvite(str){
	if(str==0)
		document.getElementById("blah").style.display="none";
	else
	{
		document.getElementById("blah").style.display="block";
		var yes = document.getElementById("Yes");
		var no = document.getElementById("No");
		if (window.XMLHttpRequest)
  			xmlhttp=new XMLHttpRequest();
		else
  			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		var x = document.getElementById("select_event");
		var evid=x.options[x.selectedIndex].value;
		var x = document.getElementById("select_user");
		var usid=x.options[x.selectedIndex].value;
		xmlhttp.open("GET","GetUserNotes.php?evid="+evid+"&usid="+usid,true);
 		xmlhttp.onload=function() {
			if(xmlhttp.responseText!="[]")
			{
				var result=JSON.parse(xmlhttp.responseText);
				console.log(result);
				var yes = document.getElementById("Yes");
				var no = document.getElementById("No");
				var notes = document.getElementById("Notes");
				if(result["attended"]==0)
					no.checked=true;
				else
					yes.checked=true;
				if(result["notes"]!=null)
					notes.value=result["notes"];
			}
			else{
				console.log("blank");
				document.getElementById("Yes").checked=false;
				document.getElementById("No").checked=false;
				document.getElementById("Notes").value="";
			}
  		}
		xmlhttp.send();
	}
}
</script>
<?php include('footer.php') ?>