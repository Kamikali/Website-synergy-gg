<?php

include_once "dbh.inc.php";
include_once 'includes/time.inc.php';
include_once 'userstats.inc.php';

$sql = "SELECT uid, title, user_uid, country, date, thumbnail_path, ispic, coins, visible FROM posts WHERE user_id = '$uid' AND visible = 1 ORDER BY uid DESC";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
     // output data of each row
    $counter = 0;
    while($row = mysqli_fetch_assoc($result)) {
      $title = strlen($row['title']) > 20 ? substr($row['title'],0,20)."..." : $row['title'];

      $roleColour_id = $row['user_uid'];
      $roleColour_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT role FROM users WHERE name = '$roleColour_id'"));
      $roleColour = selectColour($roleColour_row['role']);

      if($row['coins'] >= 0){
        $score = '&#x25B2 ';
      } else {
        $score = '&#x25BC ';
      }
      $score .= $row['coins'];

      echo '        <div class="col-sm-3">
                         <div class="panel panel-default" style="font-size:13px;">
                            <div class="panel-heading panel-heading-custom">';
                              echo "<a href='article.php?img=".$row["uid"]."'><h3 class='panel-title'>".$title."</h3></a>";
                            echo '</div>
                            <div class="panel-body panel-body-custom">
                              <div class="row equal">';
                                  if($row['ispic']){   //IS IMAGE
                                      echo "<div class='col-md-3'><a href='article.php?img=".$row["uid"]."'><img class='img-rounded' style='width:50px;height:50px;' src='http://www.thumbnail.synergy.gg/".$row["thumbnail_path"]."'></a></div>";
                                        } else {  //IS VIDEO
                                      echo "<div class='col-md-3'><a href='article.php?img=".$row["uid"]."'><img class='img-rounded' style='width:50px;height:50px;' src='assets/img/icons/videoThumbnail.png'></a></div>";
                                        }
                                      $uploadTime = time_elapsed_string($row['date']);
                                      echo "<div style='margin-top:-3px;' class='col-md-9'><i>".$uploadTime."<br></i> by <img style='width:17px;height:15px;margin-top:-2px;' src='http://www.flag.synergy.gg/".$row['country'].".png'><a style='color:".$roleColour.";' href='../user.php?user=".$row['user_uid']."'> <b>".$row['user_uid']."</b></a><br>".$score."
                                    </div></div>";
                            echo '</div>
                          </div>
                        </div>';

        }
      } else {
        echo "This user has nothing uploaded yet.";
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


