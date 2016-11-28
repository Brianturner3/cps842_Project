<?php
$con=mysqli_connect("localhost","root","","lessmovies");
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM movietitles");

$sql = "UPDATE movietitles SET Rating='1' where id='1' ";

?>