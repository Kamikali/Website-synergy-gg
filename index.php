<?php
	include_once "partials/header.php";
	include_once "partials/navbar.php";
?>
<body>

<div class="container">

	<div id="myCarousel" class="carousel slide" data-ride="carousel">
	  <!-- Indicators -->
	  <ol class="carousel-indicators">
	    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	    <li data-target="#myCarousel" data-slide-to="1"></li>
	    <li data-target="#myCarousel" data-slide-to="2"></li>
	  </ol>

	  <!-- Wrapper for slides -->
	  <div class="carousel-inner">
	    <div class="item active">
	      <img src="assets/img/slide1.jpg" alt="Los Angeles">
	    </div>

	    <div class="item">
	      <img src="assets/img/background.png" alt="Chicago">
	    </div>

	    <div class="item">
	      <img src="assets/img/background.png" alt="New York">
	    </div>
	  </div>

	  <!-- Left and right controls -->
	  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="right carousel-control" href="#myCarousel" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>

	<div class="row">
		<div class='col-md-4'>
			<br>
			<h1><a href='news.php'>Synergy News:<a></h1><br>
			<?php include_once "includes/frontpage_articles.inc.php" ?>
		</div>
		<div class='col-md-8'>
		    <div class="jumbotron" style="color:black">
		     	<h1>Join us on Discord!</h1> 
		    	<p>Join the official Synergy Discord and meet Gamers from all over the world!</p> 

				<blockquote style="border-color:#cdcdcd;">
				    <p>Mornin, fuckers!</p>
				    <footer>Moudi, everyday</footer>
				</blockquote>
				<blockquote style="border-color:#cdcdcd;">
				    <p>What do you meeaannn!?</p>
				    <footer>Justii</footer>
				</blockquote>
				<blockquote style="border-color:#cdcdcd;">
				    <p>Just another random quote.</p>
				    <footer>Anonymous</footer>
				</blockquote>

				<form target="_blank" action="https://discord.gg/Ybt7jm">
				    <button type="submit" class="btn btn-info">Join Discord</button>
				</form>
				<br>
				<a style='color:#8e8e8e;' data-toggle="modal" href="#myModal">learn more</a>
		    </div>
		</div>
	</div>

	<!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog" style="color:black;">
    	<div class="modal-dialog">
       		<!-- Modal content-->
       		<div class="modal-content">
         		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal">&times;</button>
            		<h4 class="modal-title">About Synergy</h4>
         		</div>
	         	<div class="modal-body">
	          		<p>Hmm, I don't really know if this 'read more' is a good idea ,-,<br> AND I AM HUNGRY AAAAAAAAAAAAA</p>
	         	</div>
	         	<div class="modal-footer">
	            	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        	</div>
	        </div>
        </div>
    </div>
</div>












</body>
<?php
	include_once "partials/footer.php";
?>