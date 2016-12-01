<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: login.php");
		exit;
	}
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);
	
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
	$n_user = $_SESSION["user"];

	$query = "SELECT * FROM ratedMovies WHERE user_id='$n_user' AND movie_id='$n_id'";
	$result2 = $con->query("SELECT * FROM ratedMovies where user_id='".$n_user."' AND  movie_id='".$n_id."'");
	echo "".$result2->num_rows ."\n";
	if(($result2->num_rows) > 0){
		echo "Updated";
		$sql2 = "UPDATE ratedMovies SET rating='".$n_rating."' where user_id='".$n_user."' AND  movie_id='".$n_id."'";
	}else{
		echo "INSERTED";
		$sql3 = "INSERT INTO ratedMovies (user_id, movie_id, rating) VALUES (".$n_user.",".$n_id.",".$n_rating.")";
	}	
	$result2->close(); //Close result set

	$sql = "UPDATE movietitles SET Rating='$n_rating' where id='$n_id' ";
	if($con->query($sql) === TRUE){
		echo "Record updated successfully\n";
	}else{
		echo "Error updating record: " . $con->error ."\n";
	}

	if($con->query($sql2) === TRUE){
		echo "Record3 updated successfully";
	}else{
		echo "Error3 updating record: " . $con->error;
	}

	if($con->query($sql3) === TRUE){
		echo "Record3 updated successfully";
	}else{
		echo "Error3 updating record: " . $con->error;
	}
}
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Welcome - <?php echo $userRow['userEmail']; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!--<link rel="stylesheet" href="http://scs.ryerson.ca/~brturner/filmly/filmly.css">-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="/842/movieFinal.css" type="text/css"/>
</head>
<body>
	<div class="col-xs-12 col-xs-offset-0 col-md-8 col-md-offset-2" id="content_holder_all">
		<div class="container content_holder">
			<div class="row">
				<div class="col-xs-12 col-xs-offset-0 col-md-10 col-md-offset-1">
					<section class="header">
						<div class="menu-collapsed">
							<div class="bar"></div>
							<nav>
								<ul>
									<li><a href="/842/movieFinal.php">Home</a></li>
									<li><a href="/842/loginPage/logout.php?logout">Logout</a></li>
									
								</ul>
								<h1 class="text-center" id="main_title">Filmly</h1>
							</nav>
						</div>
					</section>
					<?php
				$i = 1; // Counter
				while($row = mysqli_fetch_array($result)){

					echo "<div class=\"row lead\">\n"; 
					echo "							<label for=\"rating\" class=\"list_items\">" . $row['Title'] . "</label>"; 
					echo "							<form action=\"/842/loginPage/Home.php\" method=\"Post\">\n"; 
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

$(".menu-collapsed").click(function() {
  $(this).toggleClass("menu-expanded");
});
</script>
</html>
<?php ob_end_flush(); ?>