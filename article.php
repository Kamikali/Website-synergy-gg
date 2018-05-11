<?php
	include_once "partials/header.php";
	include_once "partials/navbar.php";
	include_once 'includes/dbh.inc.php';
	include_once 'includes/time.inc.php';
?>
<body>

<script>function goBack(){window.history.back();}</script>

<div class="container">


	<?php
			$img = $_GET['img'];
			$sql = "SELECT * FROM posts WHERE uid = $img";
			$result = mysqli_query($conn, $sql);

			while ($row = mysqli_fetch_assoc($result)){
				$uploadTime = time_elapsed_string($row['date']);
				echo "<h2>".$row['title']."</h2>";
				if($row['ispic']){ //IS IMAGE
					?>
					<div align="center">
					<?php
					echo "<br><img style='cursor: pointer;max-height:500px;max-width: 100%;' src=".$row["path"]." onclick='goBack()'><br>";
					?></div><?php
				} else {				 //IS VIDEO
										 //CREATE CUSTOM VIDEO PLAYER <-- doesnt work yet
						?>
						<div align="center">
						    <video id="video" autoplay controls loop style='cursor:pointer;max-height:500px;max-width:100%;' onclick='goBack()'>
						    	<source src='<?php echo $row["path"];?>' type="video/mp4">
						    	<source src='<?php echo $row["path"];?>' type="video/m4v">
						    	Your browser does not support HTML5 video ¯\_(ツ)_/¯
						    </video>
						</div>			
							
						<?php
				}


				//GET DATA TO CREATE INFO BAR UNDER UPLOAD
				$likes = "SELECT * FROM likes WHERE post_id = '$img' AND isLike = 1";
				$resultLikes = mysqli_query($conn, $likes);
				$numLikes = mysqli_num_rows($resultLikes);

				$unlikes = "SELECT * FROM likes WHERE post_id = '$img' AND isLike = 0";
				$resultUnlikes = mysqli_query($conn, $unlikes);
				$numUnlikes = mysqli_num_rows($resultUnlikes);

				$upload_benis = $numLikes - $numUnlikes;
				 
				if($numLikes + $numUnlikes != 0){
					$likeBarWidth = 70 / ($numLikes + $numUnlikes) * $numLikes;
				} else {
					$likeBarWidth = 70;
				}


				echo '<div class="row">';
				echo '<div class="col-sm-2">';
				echo "<ul style='list-style-type: none;><li style='float: left'>";
				if(isset($_SESSION['u_id'])){ //LIKE BUTTONS FOR USERS WHO ARE LOGGED IN
						echo   "<ul style='list-style-type: none;'>
									<li id='plus' style='margin-left:-70px;margin-top:20px;'>
										<!-- LIKE BUTTON -->
										<form method='post' id='likeform'>
											<input type='hidden' id='img' value='".$img."'>
											<input type='hidden' id='uid' value='".$_SESSION['u_id']."'>
											<button id='likebtn' type='submit'>&#x25B2</button>
										</form>
									</li>
									<li id='minus' style='margin-left:-70px;'>
										<!-- DISLIKE BUTTON -->
										<form method='post' id='dislikeform'>
											<input type='hidden' id='img' value='".$img."'>
											<input type='hidden' id='uid' value='".$_SESSION['u_id']."'>
											<button id='dislikebtn' type='submit'>&#x25BC</button>
										</form>
									</li>
								</ul>";
					} else {
							echo   "<ul style='list-style-type: none;'>
								<li id='plus' style='margin-left:-70px;margin-top:20px;'>
									<!-- LIKE BUTTON -->
									<form action='login.php' method='get'>
										<input type='hidden' name='loginrequest' value='like'>
										<button id='likebtn' type='submit'>&#x25B2</button>
									</form>
								</li>
								<li id='minus' style='margin-left:-70px;'>
									<!-- DISLIKE BUTTON -->
									<form action='login.php' method='get'>
									    <input type='hidden' name='loginrequest' value='like'>
										<button id='dislikebtn' type='submit'>&#x25BC</button>
									</form>
								</li>
							</ul>";
					}
				echo '</li><li>';
				echo "<ul style='list-style-type: none;'>
						<li style='float:left;margin-left:-15px;margin-top:-70px;' id='benis-display'><h1><span class='jqValue'>...</span></h1></li>
						<!-- LIKEBAR -->	
							<li style='float:left;margin-left:-15px;margin-top:-20px;'>				
								<svg width='70' height='5'>
									<rect x='0' y='0' width='70' height='5' style='fill:rgb(90,90,90)' />
									<rect x='0' y='0' width='".$likeBarWidth."' height='5' style='fill:rgb(156,220,256)' />
									<rect x='0' y='0' width='70' height='5' fill-opacity='0' style='stroke-width:2;stroke:rgb(20,20,20)' />
								</svg>
							</li>
						</li>
					</ul>";
				echo '</div>';
				echo '<div class="col-sm-10">';
				echo '<blockquote style="border-color:#cdcdcd;">
				    <p>'.$row['message'].'</p>
				    <footer style="color:white;"><i>'.$uploadTime.' by <img style="width:20px;height:18px;margin-top:-2px;" src="assets/img/flags/'.$row['country'].'.png"><a href="/user.php?user='.$row['user_uid'].'"></i><b>'.$row['user_uid'].'</b></a></footer>
				</blockquote>';
				echo '</div></div>';
				echo '</ul></li>';
			}
			
			include_once "comments.php";
			?>

		<br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>
</body>


<script>
	var numberLikes = "<?php echo $upload_benis; ?>";
	var $jqValue = $('.jqValue');
	$jqValue.html(numberLikes);	
			
	$('#likeform').submit(function(event){			
		event.preventDefault();
		var img=$.trim($('#img').val());
		var uid=$.trim($('#uid').val());
		$.ajax({ url: 'includes/like.inc.php',
		    data: {action:'like', uid:uid, img:img},
		    type: 'post',
			success: function(output) {
			    $jqValue.html(output);	
            }
		});
	});

	$('#dislikeform').submit(function(event){
		event.preventDefault();
		var img=$.trim($('#img').val());
		var uid=$.trim($('#uid').val());
		$.ajax({ url: 'includes/like.inc.php',
	        data: {action:'dislike', uid:uid, img:img},
			type: 'post',
			success: function(output) {
			    $jqValue.html(output);	
            }
		});
	});
</script>

<?php
	include_once "partials/footer.php";
?>

