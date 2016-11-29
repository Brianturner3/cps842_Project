<?php
$con=mysqli_connect("localhost","root","","lessmovies");
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con,"SELECT * FROM movietitles");

if(isset($_POST["updateRating"])){
	$n_rating = $_POST["rating"];
	$n_id = $_POST["id"];
	echo "$n_id\n";
	$sql = "UPDATE movietitles SET Rating='$n_rating' where id='$n_id' ";
	if($con->query($sql) === TRUE){
		echo "Record updated successfully";
	}else{
		echo "Error updating record: " . $con->error;
	}
}
$con->close();
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>CPS842 Project</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://scs.ryerson.ca/~brturner/filmly/filmly.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="col-xs-12 col-xs-offset-0 col-md-8 col-md-offset-2" id="content_holder_all">
		<div class="container content_holder">
			<div class="row">
				<div class="col-xs-12 col-xs-offset-0 col-md-10 col-md-offset-1">
					<section class="header">
						<div> 
							<div class="hamburger_menu" onclick="myFunction(this)">
								<div class="bar1"></div>
								<div class="bar2"></div>
								<div class="bar3"></div>
							</div>
							<h1 class="text-center" id="main_title">Filmly</h1>
						</div>
					</section>
					<?php
				$i = 1; // Counter
				while($row = mysqli_fetch_array($result)){

					echo "<div class=\"row lead\">\n"; 
					echo "							<label for=\"rating\" class=\"list_items\">" . $row['Title'] . "</label>"; 
					echo "							<form action=\"movieFinal.php\" method=\"Post\">\n"; 
					echo " 								<input type=\"hidden\" name=\"id\" value=\"$i\">\n";
					echo "								<input type=\"radio\" name=\"rating\" id=\"rating1\"value=\"1\"> 1\n"; 
					echo "								<input type=\"radio\" name=\"rating\" id=\"rating2\"value=\"2\"> 2\n"; 
					echo "								<input type=\"radio\" name=\"rating\" id=\"rating3\"value=\"3\"> 3\n"; 
					echo "								<input type=\"radio\" name=\"rating\" id=\"rating4\"value=\"4\"> 4\n"; 
					echo "								<input type=\"radio\" name=\"rating\" id=\"rating5\"value=\"5\"> 5\n"; 
					echo "								<input type=\"submit\" name=\"updateRating\" id=\"rate\" value=\"Rate\">\n"; 
					echo "							</form>\n"; 
					echo "								<p id=\"lblRating$i\">The current rating is " . $row['Rating'] ."</p>";
					echo "							<hr>\n"; 
					echo "						</div>\n";
					$i++;
				}
				
				?>
				
			</div>
		</div>
	</div>	
</div>

</body>
<!--Animation for hamburger menu-->
<script>
	function myFunction(x) {
		x.classList.toggle("change");
	}
</script>
</html>