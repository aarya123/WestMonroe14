<?php include('header.php'); ?>
<input type="text" list='names'>
<datalist id="names">
	<select>
		<?php include("allnames.php"); ?>
	</select>
</datalist>
<?php include('footer.php') ?>