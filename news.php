<?php
	include_once "partials/header.php";
	include_once "partials/navbar.php";
?>
<body>
<div class="container">
	<?php
	if(isset($_SESSION['u_id'])){
		echo '<a href="newarticle.php">>>new article</a>';
	}
	?>
<br>
	<?php
		include_once "includes/articles.inc.php";
	?>
</div>
</body>
<?php
	include_once "partials/footer.php";
?>