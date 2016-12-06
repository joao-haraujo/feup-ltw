<!DOCTYPE html>
<html>
<?php
session_start();
include_once("database/connection");
include_once("database/get_users");
include_once("action_login.php");
?>
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="HomePage.css">
</head>

<body>
    <section>
        <div id="Login">
          <?php
            if(isset($_SESSION['username'])&&$_SESSION['loggedin']){
           ?>
           <p class="LogOut"><a href="LogOut.html">LogOut </a></p>
           <?php
         }
         else{
           ?>
            <p class="SignIn"><a href="SignIn.html">Sign In</a></p>
            <p class="SignUp"><a href="SignUp.html">Sign Up</a></p>

          <?php }?>
        </div>
        <header id="header">
            <h1>RestaurantRating</h1>
            <p class="Search"><input type="text" name="search" placeholder="Search Restaurants by name, location,food,menu"></p>
        </header>
    </section>
    <div class="Colecoes">
        <h2>Curiositys</h2>
        <img src="topSemana.jpg" alt="Image" style="width:104px;height:58px;">Top of the Week
        <p><img src="./resources/restaurantCur.jpg" alt="Image" style="width:104px;height:58px;">News</p>
    </div>
</body>

</html>