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

	//Get the average rating for user id = "500565238"
	$A_avg = "SELECT AVG(rating) AS rating FROM ratedMovies WHERE user_id='500565238'";
	$result2 = $con->query($A_avg);

	if($result2->num_rows > 0){
		while($row = $result2->fetch_assoc()){
			echo "rating: ".$row["rating"]."<br>";
		}
	}else{
		echo "0 results";
	}

	$B_avg;

	//Retrieve list of movies rated by both users
	$ref = "SELECT rm.user_id ,rm.movie_id ,rm.rating FROM ratedmovies rm WHERE (SELECT COUNT(*) FROM ratedmovies rm2 WHERE rm.movie_id=rm2.movie_id)>1";
	$result3 = $con->query($ref);
	$B_users = result3->num_rows; //#number of users for B
	if($result3->num_rows > 0){
		while($row= $result3->fetch_assoc()){
			echo "rating: ".$row["rating"]."<br>";
		}
	}else{
		echo "err";
	}


	/*
	$avgB= "SELECT AVG(rating) AS rating FROM ratedMovies WHERE user_id='500565239'";
	$result3 = $con->query($avgB);

	if($result2->num_rows > 0){
		while($row = $result3->fetch_assoc()){
			echo "rating: ".$row["rating"]."<br>";
		}
	}else{
		echo "0 results";
	}/*
	

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
									<li><a href="/842/loginPage/home.php">Home</a></li>
									<li><a href="/842/loginPage/recommendedMovies.php">Recommeded Movies</a></li>
									<li><a href="/842/loginPage/logout.php?logout">Logout</a></li>
									
								</ul>
								<h1 class="text-center" id="main_title">Filmly</h1>
							</nav>
						</div>
					</section>

				
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