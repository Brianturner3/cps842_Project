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

	//Retrieve list of movies rated by the first user
$refA = "SELECT rm.user_id ,rm.movie_id ,rm.rating FROM ratedmovies rm WHERE (SELECT COUNT(*) FROM ratedmovies rm2 WHERE rm.movie_id=rm2.movie_id)>1 AND rm.user_id=500565238";
$result3 = $con->query($refA);
$numA_movies;
$avgA = 0;
$ratingA_list = array();
$ratingAk = 0;
if($result3->num_rows > 0){
	while($row= $result3->fetch_assoc()){
		$avgA += $row["rating"];
		$numA_movies++;
		array_push($ratingA_list,$row["rating"]);
	}
}else{
	echo "err";
}

	//Retrieve list of movies rated by the second user
$refB ="SELECT rm.user_id ,rm.movie_id ,rm.rating FROM ratedmovies rm WHERE (SELECT COUNT(*) FROM ratedmovies rm2 WHERE rm.movie_id=rm2.movie_id)>1 AND rm.user_id=500565239";
$resB = $con->query($refB);
$numB_movies;
$avgB = 0;
$ratingB_list = array();
$ratingBk = 0;
if($resB->num_rows > 0){
	while($row= $resB->fetch_assoc()){
		$avgB += $row["rating"];
		$numB_movies++;
		array_push($ratingB_list,$row["rating"]);
	}
}else{
	echo "err";
}

	//Calc. avg. rating for user B
$avgA = $avgA/$numA_movies;

	//Calc. avg. rating for user B
$avgB = $avgB/$numB_movies;

	//Calculate Pearson Coefficient
$pearsonTop = 0;
$pearsonBottomA = 0;
$pearsonBottomB = 0;
$maxPearson = sizeof($ratingB_list);
for($i = 0; $i < $maxPearson; $i++){
	$tmpA = $ratingA_list[$i] - $avgA;
	$tmpB = $ratingB_list[$i] - $avgB;
	$pearsonBottomA = $pearsonBottomA + ($tmpA ** 2);
	$pearsonBottomB = $pearsonBottomB + ($tmpB ** 2);
	$pearsonTop = $pearsonTop + ($tmpA*$tmpB);
}
$pearsonBottom = sqrt($pearsonBottomA*$pearsonBottomB);
$pearsonTotal = $pearsonTop/$pearsonBottom;
	//End of Pearson Coefficent	

	//Calculate ratings for movies not watched by first user
$refDiff = "SELECT rm.user_id ,rm.movie_id ,rm.rating FROM ratedmovies rm WHERE (SELECT COUNT(*) FROM ratedmovies rm2 WHERE rm.movie_id=rm2.movie_id)=1 AND rm.user_id='500565239'";
$resC = $con->query($refDiff);
$rating_Not_Watched= array();
$rating_Not_Watched_ID = array();
if($resC->num_rows > 0){
	while($diffRow = $resC->fetch_assoc()){
		array_push($rating_Not_Watched_ID,$diffRow['movie_id']);
		array_push($rating_Not_Watched,$diffRow['rating']);
	}
}

print_r($rating_Not_Watched);
$maxNotWatched = sizeof($rating_Not_Watched);
$ratingsList = array();
for($i = 0; $i < $maxNotWatched; $i++){
	echo "rate".$rating_Not_Watched[$i]."\n";
	$top = $rating_Not_Watched[$i] * $pearsonTotal;
	$totRating = $top / $pearsonTotal;
	array_push($ratingsList, $totRating);
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