<?php

include_once "dbh.inc.php";
include_once 'includes/time.inc.php';

$sql = "SELECT uid, title, user_uid, country, date, thumbnail_path, ispic FROM posts ORDER BY uid DESC";
	$result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
  	 // output data of each row
   	$counter = 0;
   	while($row = mysqli_fetch_assoc($result)) {
      $title = strlen($row['title']) > 20 ? substr($row['title'],0,20)."..." : $row['title'];

      echo '        <div class="col-sm-3">
                         <div class="panel panel-default">
                            <div class="panel-heading panel-heading-custom">';
                              echo "<a href='article.php?img=".$row["uid"]."'><h3 class='panel-title'>".$title."</h3></a>";
                            echo '</div>
                            <div class="panel-body panel-body-custom">
                              <div class="row equal">';
                                  if($row['ispic']){   //IS IMAGE
                                      echo "<div class='col-md-3'><a href='article.php?img=".$row["uid"]."'><img class='img-rounded' style='width:50px;height:50px;' src=".$row["thumbnail_path"]."></a></div>";
                                        } else {  //IS VIDEO
                                      echo "<div class='col-md-3'><a href='article.php?img=".$row["uid"]."'><img class='img-rounded' style='width:50px;height:50px;' src='assets/img/icons/videoThumbnail.png'></a></div>";
                                        }
                                      $uploadTime = time_elapsed_string($row['date']);
                                      echo "<div class='col-md-9'><i>".$uploadTime."<br></i> by <img style='width:17px;height:15px;margin-top:-2px;' src='assets/img/flags/".$row['country'].".png'><a href='../user.php?user=".$row['user_uid']."'> <b>".$row['user_uid']."</b></a><br>
                                    </div></div>";
                            echo '</div>
                          </div>
                        </div>';

      
   		
        

  		  }
		  } else {
        echo "There are no articles posted yet.";
			}

	mysqli_close($conn);

?>
<style>
.equal {  
    display: -webkit-flex;
    display: flex;
}

.panel-default {
    border-color: black;
    border: 1px;
}

.panel-default > .panel-heading-custom {
    background: #222222; 
    border-color: black;
}

.panel-default > .panel-body-custom {
    background: #424242; 
    border-color: black;
}

</style>


