<?php 
if(isset($_POST))
{
	$number = $_POST['num'];

	echo $number;
}
?>

<form method="post">
<input type="number" name="num">
<input type="submit" value="Kirim">
</form>