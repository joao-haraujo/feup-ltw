<?php

//Opens database
$dbh = new PDO('sqlite:../database.db');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //To enable error handling
$inputUsername = $_GET['username'];

//Gets the user
$stmt = $dbh->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute(array($inputUsername));
$selectedUser = $stmt->fetch();	
if($selectedUser == null){ //In case of a non-existing name
	header('Location: ../../../Error404.php?info=1');
}

//Gets the reviews
$stmt = $dbh->prepare('SELECT * FROM reviews WHERE idUser = ?');
$stmt->execute(array($selectedUser['idUser']));
$userReviews = $stmt->fetchAll();

$inputPage = $_GET['page'];

$maxResultsPerPage = 4;
$offset = ($inputPage - 1 ) * $maxResultsPerPage;
$totalPages = ceil(count($userReviews) / $maxResultsPerPage);

if(count($userReviews != 0) && $inputPage != 1){
	if($inputPage < 1 || $inputPage > $totalPages)
	{
		header('Location: ../../../Error404.php');
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$inputUsername?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../../../css/profile/viewAll.css">
</head>
<body>
	<header>
		<?php include '../header.php' ?>
	</header>
	<div id="main">
		<div id="personalData">
			<article>
				<h1>All Submitted Reviews</h1>
			</article>
		</div>
		<section id="reviews">
			<div id="allResults">
				<?php 
				if(count($userReviews) == 0){	
					?><p>This user hasn't written a review yet.</p><?php 
				} else { 
					for($i = $offset; $i < count($userReviews); $i++){ 
					//Limit number of Results Per Page
						if($i >= $offset + $maxResultsPerPage)
							break;			
					//Gets the restaurant
						$stmt = $dbh->prepare('SELECT * FROM restaurants WHERE idRestaurant = ?');
						$stmt->execute(array($userReviews[$i]['idRestaurant']));
						$selectedRestaurant = $stmt->fetch();

						$restaurantId = $selectedRestaurant['idRestaurant'];
						$restaurantName = $selectedRestaurant['restaurantName'];
						$restaurantLogo = getRestaurantLogoPath($restaurantId);
						?>

						<article id="articleReviews">
							<h3><?=$restaurantName?></h3>
							<img src=<?=$restaurantLogo?> alt=<?=$restaurantName?> width="200" height="100">
							<p><b>Rating:</b> <?=$userReviews[$i]['rating']?></p>
							<p><?=$userReviews[$i]['text']?></p>
						</article>
						<?php 
					}
					?>
				</div>
				<div id="pageButtons">
					<?php
					if($inputPage > 1){
						?>
						<a href="<?php echo $inputPage - 1?>">Previous</a> 
						<?php 
					}
					if($inputPage < $totalPages){
						?>
						<a href="<?php echo $inputPage + 1?>">Next</a> 
						<?php 
					} 
					?>
				</div>
				<p>Page <?=$inputPage?> of <?=$totalPages?></p>
				<?php 
			} ?>
		</section>
	</div>

	<footer>
		<?php include '../footer.php' ?>
	</footer>
</body>
</html>