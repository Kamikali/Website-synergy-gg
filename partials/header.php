<?php
  session_start();
?>
<!DOCTYPE html>
<html lang='en'>
<head>
  	<title>Synergy</title>
  	<meta charset="utf-8">
   	<meta name="viewport" content="width=device-width, initial-scale=1">
   	<!-- Site icon -->
   	<link rel="icon" href="assets/img/icons/owlicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/icons/owlicon.png">
   	<!-- Stylesheets -->
   	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
   	<!-- Scripts -->
   	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="jquery-3.3.1.min.js"></script>
    
     <?php
      $geo = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
      $country = $geo[geoplugin_countryCode];
    ?>
</head>
