<?php

function isRestaurant($name){
	global $dbh;

	$stmt = $dbh->prepare('SELECT * FROM restaurants WHERE restaurantName = ? OR
		address = ?');
	$stmt->execute(array($name));
	$result=$stmt->fetch();

	return ($result != null);
}

function getRestaurantId($name){
	global $dbh;

	$stmt = $dbh->prepare('SELECT * FROM restaurants WHERE restaurantName = ? OR
		address = ?');
	$stmt->execute(array($name));
	$result=$stmt->fetch();

	if($result==null){
		echo 'Restaurant not found, try again';
		return false;
	}
	else{
		return $result['idRestaurant'];
	}
}

function getRestaurantName($id){
	global $dbh;

	$stmt = $dbh->prepare('SELECT * FROM restaurants WHERE idRestaurant = ?');
	$stmt->execute(array($id));
	$result=$stmt->fetch();

	if($result==null){
		echo 'restaurant not found, try again';
		return false;
	}
	else{
		return $result['restaurantName'];
	}
}

function bestRestaurantsLastWeek(){
	global $dbh;

	$stmt=$dbh->prepare("SELECT * FROM restaurants WHERE updateDate BETWEEN datetime('now', '-6 days') AND datetime('now', 'localtime') ORDER BY averageRating DESC LIMIT 5");
	$stmt->execute();
	$result=$stmt->fetchAll();

	$array=array();
	foreach($result as $row){
		$array[]=array($row['idRestaurant'], $row['restaurantName'], $row['averageRating']);
	}
	return $array;
}

function newRestaurants(){
	global $dbh;

	$stmt=$dbh->prepare("SELECT * FROM restaurants ORDER BY creationDate DESC LIMIT 5");
	$stmt->execute();
	$result=$stmt->fetchAll();

	$array=array();
	foreach($result as $row){
		$array[]=array($row['idRestaurant'], $row['restaurantName'], $row['averageRating']);
	}
	return $array;
}

?>