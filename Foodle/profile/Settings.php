<?php
include '../resources/resources.php';
include '../Utilities.php';

session_start();

if(!isLoggedIn())
	header('Location: ../Error404.html');

//Opens database
$dbh = new PDO('sqlite:../database.db');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //To enable error handling
$inputUsername = getCurrentUser();

//Gets the user
$stmt = $dbh->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute(array($inputUsername));
$selectedUser = $stmt->fetch();	
if($selectedUser == null){ //In case of a non-existing name
	header('Location: ../Error404.php');
}

//Get the infos needed
$userId = $selectedUser['idUser'];
$userName = $selectedUser['name'];
$userPassword = $selectedUser['password'];
$userPhoto = getProfilePicturePath($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Edit Profile</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../css/profile/Settings.css">

	<script src="../js/lib/jquery-1.11.3.min.js"></script>
	<script src="../js/lib/jquery.form.js"></script>
	<script src="../js/editProfile.js"></script>

</head>
<body>
	<header>
		<?php include '../header.php' ?>
	</header>
	<div id="main">
		<div id="settings">
			<article>
				<h2>Settings</h2>
			</article>
		</div>
		<div id="editProfile">
			<section id="editImage">
				<h3>Change Image</h3>
				<div class="notification" id="currentPhoto">
					<?php echo '<p class="myImage"><img src="'.$userPhoto.'" width=250 height=250 alt="" /></p>';?>
				</div>
				<p>
					<form method="post" enctype="multipart/form-data" id="editImageForm">
						<div>
							<b>Add / change your profile image: </b>
						</div>
						<div>
							<input type='hidden' name='userId' value="<?PHP echo $userId; ?>" />
							<input type="file" name="imageProfile" id="imageProfile"/>
							<button type="submit" id="submitImage">Change Image</button>
						</div>
					</form>
				</p>
				<p>Maximum size : <b>512 Kb</b></p>
				<p>Formats accepted : <b>jpg</b>, <b>jpeg</b>, <b>png</b></p>
			</section>

			<section id="editData">
				<h3>Change User Details</h3>
				<div class="notification" id="editNotification"></div>
				<p>
					<form method="post" id="editDetailsForm">
						<input type='hidden' name='username' value=<?=$inputUsername?> />
						Change Name:<br><input type="text" contenteditable="true" value="<?php echo $userName?>" name="fullname"><br>
						Change Password:<br><input type="password" name="newPassword"><br>
						Confirm New Password:<br><input type="password" name="newPasswordConfirm">
						<br>
						Current Password:<input type="password" name="currentPassword"><br>
						Confirm Password:<input type="password" name="currentPasswordConfirm"><br>
						<button type="submit" id="submitChanges">Confirm Changes</button>
					</form>
				</p>
			</section>
			<section id="addRestaurant">
				<h2>Add Restaurant</h2>
				<div class="notification" id="addNotification"></div>
				<p>
					<form method="post" id="addRestaurantForm">
						<input type='hidden' name='userId' value=<?=$userId?> />
						Restaurant Name:<br><input type="text" name="restaurantName"><br>
						<button type="submit" id="createRestaurant">Create Restaurant</button>
					</form>
				</p>
			</section>
		</div>
	</div>

	<footer>
		<?php include '../footer.php' ?>
	</footer>
</body>
</html>