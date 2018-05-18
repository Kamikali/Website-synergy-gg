<?php

include_once "time.inc.php";
include_once "dbh.inc.php";
include_once "userstats.inc.php";
include_once "setEmojis.inc.php";
session_start();

$connect = new PDO('mysql:host=db735578055.db.1and1.com;dbname=db735578055', 'dbo735578055', 'ZS<Sn}IY7oDCSPsB');

$img = $_POST['img'];

//ARRAY FOR ROLES THAT HAVE THE PERMISSION TO DELETE COMMENTS
$allowedRoles = array("Moderator", "Administrator");
$userRole = $_SESSION["u_urole"];

$query = "
SELECT * FROM tbl_comment 
WHERE parent_comment_id = '0' AND post_id = '$img' AND visible = 1
ORDER BY coins DESC, comment_id ASC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';

foreach($result as $row) //
{

$cid = $row['comment_id'];

//GET DATA TO CREATE INFO BAR UNDER COMMENT
$comment_likes = "SELECT isLike FROM comment_likes WHERE comment_id = '$cid' AND isLike = 1";
$comment_resultLikes = mysqli_query($conn, $comment_likes);
$comment_numLikes = mysqli_num_rows($comment_resultLikes);


$comment_unlikes = "SELECT isLike FROM comment_likes WHERE comment_id = '$cid' AND isLike = 0";
$comment_resultUnlikes = mysqli_query($conn, $comment_unlikes);
$comment_numUnlikes = mysqli_num_rows($comment_resultUnlikes);

$uid = $_SESSION['u_id'];
$colour = '';
$comment_isLiked = "SELECT isLike FROM comment_likes WHERE comment_id = '$cid' AND user_id = '$uid'";
$comment_result = mysqli_query($conn, $comment_isLiked);
if(mysqli_num_rows($comment_result) == 0){
   $colour = '#ffffff';
} else {
while($row2 = mysqli_fetch_assoc($comment_result)) {
  if($row2['isLike'] == 0){
      $colour = '#707070';
    } else {
      $colour = '#4fdbff';
    }
  }
}

$roleColour_name = $row['comment_sender_name'];
$roleColour_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT role FROM users WHERE name = '$roleColour_name'"));
$roleColour = selectColour($roleColour_row['role']);

$comment_upload_benis = $comment_numLikes - $comment_numUnlikes;

 //$comment = 

 $points = 'Points';
 if($comment_upload_benis == 1 || $comment_upload_benis == -1){
  $points = 'Point';
 }

if(isset($_SESSION['u_id'])){
 $output .= '
<div class="row">

  <div class="col-sm-8" style="border-bottom: 1px solid grey;margin-top:-20px;">

                <ul style="list-style-type: none;">
                  <li id="plus" style="margin-left:-70px;margin-top:20px;">
                    <!-- LIKE BUTTON -->
                    <form method="post" id="comment_likeform'.$cid.'">
                      <input type="hidden" id="c_img'.$cid.'" value="'.$cid.'">
                      <input type="hidden" id="c_uid'.$cid.'" value="'.$_SESSION['u_id'].'">
                      <button id="c_likebtn'.$cid.'" type="submit">&#x25B2</button>
                    </form>
                  </li>
                  <li id="minus" style="margin-left:-70px;">
                    <!-- DISLIKE BUTTON -->
                    <form method="post" id="comment_dislikeform'.$cid.'">
                      <input type="hidden" id="c_img'.$cid.'" value="'.$cid.'">
                      <input type="hidden" id="c_uid'.$cid.'" value="'.$_SESSION['u_id'].'">
                      <button id="c_dislikebtn'.$cid.'" type="submit">&#x25BC</button>
                    </form>
                  </li>
                  <li style="margin-left:-45px;margin-top:-42px;">
    <div>'.setEmojis(replaceLinks(replaceLinebreaks($row['comment']))).'</div>
    <div><b><i style="color:'.$colour.';"><span class="comment_jqValue'.$cid.'">...</span></i></b> <img style="width:17px;height:15px;margin-top:-2px;" src="http://www.flag.synergy.gg/'.$row["countryID"].'.png"><a style="color:'.$roleColour.';" href="user.php?user='.$row["comment_sender_name"].'"><b> '.$row["comment_sender_name"].' </b></a><i>'.time_elapsed_string($row["date"]).' </i>
    <a style="color:#4fdbff;cursor: pointer;" class="reply" id="'.$cid.'"><b>Reply</b></a>';

    if(in_array($userRole, $allowedRoles)){
      $output .='<form method="post" action="includes/delete.inc.php">
                    <input type="hidden" name="commentNumber" value="'.$cid.'">
                    <input type="hidden" name="toDel" value="comment">
                 <button style="float:right;margin-top:-18px;margin-right:-15px;" name="submit" type="submit">Delete</button>';
    }

    $output .='</div>
  </div>

                </li></ul>
</div>

   <script>
  var comment_numberLikes = "'.$comment_upload_benis.' '.$points.'";
  var $comment_jqValue'.$cid.' = $(".comment_jqValue'.$cid.'");
  $comment_jqValue'.$cid.'.html(comment_numberLikes); 
      
  $("#comment_likeform'.$cid.'").submit(function(event){      
    event.preventDefault();
    var img=$.trim($("#c_img'.$cid.'").val());
    var uid=$.trim($("#c_uid'.$cid.'").val());
    $.ajax({ url: "includes/comment_like.inc.php",
        data: {action:"like", uid:uid, img:img},
        type: "post",
      success: function(output) {
          $comment_jqValue'.$cid.'.html(output);  
            }
    });
  });

  $("#comment_dislikeform'.$cid.'").submit(function(event){
    event.preventDefault();
    var img=$.trim($("#c_img'.$cid.'").val());
    var uid=$.trim($("#c_uid'.$cid.'").val());
    $.ajax({ url: "includes/comment_like.inc.php",
          data: {action:"dislike", uid:uid, img:img},
      type: "post",
      success: function(output) {
          $comment_jqValue'.$cid.'.html(output);  
            }
    });
  });
</script>

';
} else {
  $output .='<div class="row">

  <div class="col-sm-8" style="border-bottom: 1px solid grey;margin-top:-20px;">

                <ul style="list-style-type: none;">
                  <li id="plus" style="margin-left:-70px;margin-top:20px;">
                    <!-- LIKE BUTTON -->
                    <form action="login.php" method="get">
                      <input type="hidden" name="loginrequest" value="like">
                      <button type="submit">&#x25B2</button>
                    </form>
                  </li>
                  <li id="minus" style="margin-left:-70px;">
                    <!-- DISLIKE BUTTON -->
                    <form action="login.php" method="get">
                      <input type="hidden" name="loginrequest" value="like">
                      <button type="submit">&#x25BC</button>
                    </form>
                  </li>
                  <li style="margin-left:-45px;margin-top:-42px;">
    <div>'.setEmojis(replaceLinks(replaceLinebreaks($row['comment']))).'</div>
    <div><b><i style="color:'.$colour.';"><span class="comment_jqValue'.$cid.'">...</span></i></b> <img style="width:17px;height:15px;margin-top:-2px;" src="http://www.flag.synergy.gg/'.$row["countryID"].'.png"><a style="color:'.$roleColour.';" href="user.php?user='.$row["comment_sender_name"].'"><b> '.$row["comment_sender_name"].' </b></a><i>'.time_elapsed_string($row["date"]).' </i>
    <a style="color:#4fdbff;cursor: pointer;" class="reply" id="'.$row["comment_id"].'"><b>Reply</b></a></div>
  </div>

                </li></ul>
</div>

   <script>
  var comment_numberLikes = "'.$comment_upload_benis.' '.$points.'";
  var $comment_jqValue'.$cid.' = $(".comment_jqValue'.$cid.'");
  $comment_jqValue'.$cid.'.html(comment_numberLikes); 
  </script>
';
}
 $output .= get_reply_comment($connect, $row["comment_id"]);

}

echo $output;

function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
{


    

 $query = "SELECT * FROM tbl_comment WHERE visible = 1 AND parent_comment_id = '".$parent_id."' ORDER BY coins DESC, comment_id ASC";
 $output = '';
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $count = $statement->rowCount();
 if($parent_id == 0)
 {
  $marginleft = 0;
 }
 else
 {
  $marginleft = $marginleft + 20;
 }
 if($count > 0)
 {
  foreach($result as $row)
  {
    $r_cid = $row['comment_id'];

    //GET DATA TO CREATE INFO BAR UNDER COMMENT
    $r_comment_likes = "SELECT isLike FROM comment_likes WHERE comment_id = '$r_cid' AND isLike = 1";
    $r_comment_resultLikes = $connect->prepare($r_comment_likes);
    $r_comment_resultLikes->execute();
    $r_comment_numLikes = $r_comment_resultLikes->rowCount();

    $r_comment_unlikes = "SELECT isLike FROM comment_likes WHERE comment_id = '$r_cid' AND isLike = 0";
    $r_comment_resultUnlikes = $connect->prepare($r_comment_unlikes);
    $r_comment_resultUnlikes->execute();
    $r_comment_numUnlikes = $r_comment_resultUnlikes->rowCount();
    

    $uid = $_SESSION['u_id'];
    $colour = '';
    $r_comment_isLiked = "SELECT isLike FROM comment_likes WHERE comment_id = '$r_cid' AND user_id = '$uid'";
    $r_comment_result = $connect->prepare($r_comment_isLiked);
    $r_comment_result->execute();
    $r_comment_isLikedBool = $r_comment_result->rowCount();
    

    if($r_comment_isLikedBool == 0){
       $colour = '#ffffff';
    } else {
    foreach ($r_comment_result as $row2) {
      if($row2['isLike'] == 0){
          $colour = '#707070';
        } else {
          $colour = '#4fdbff';
        }
      }
    }
    
    $r_roleColour_name = $row['comment_sender_name'];
    $r_roleColourSQL = "SELECT role FROM users WHERE name = '$r_roleColour_name'";
    $r_roleColourStatement = $connect->prepare($r_roleColourSQL);
    $r_roleColourStatement->execute();
    $r_roleColourResult = $r_roleColourStatement->fetchAll();
    foreach ($r_roleColourResult as $r_roleColour_row){
      $roleColour = selectColour($r_roleColour_row['role']);
    }
    

    $r_comment_upload_benis = $r_comment_numLikes - $r_comment_numUnlikes;

    $points = 'Points';
    if($r_comment_upload_benis == 1 || $r_comment_upload_benis == -1){
      $points = 'Point';
    }

   if(isset($_SESSION['u_id'])){
   $output .= '
   <div >
      <div class="row">
        <div style="margin-left:'.$marginleft.'px;margin-top:-20px;border-bottom: 1px solid grey;" class="col-sm-8">


                                <ul style="list-style-type: none;">
                  <li id="plus" style="margin-left:-70px;margin-top:20px;">
                    <!-- LIKE BUTTON -->
                    <form method="post" id="comment_likeform'.$r_cid.'">
                      <input type="hidden" id="c_img'.$r_cid.'" value="'.$r_cid.'">
                      <input type="hidden" id="c_uid'.$r_cid.'" value="'.$_SESSION['u_id'].'">
                      <button id="c_likebtn'.$r_cid.'" type="submit">&#x25B2</button>
                    </form>
                  </li>
                  <li id="minus" style="margin-left:-70px;">
                    <!-- DISLIKE BUTTON -->
                    <form method="post" id="comment_dislikeform'.$r_cid.'">
                      <input type="hidden" id="c_img'.$r_cid.'" value="'.$r_cid.'">
                      <input type="hidden" id="c_uid'.$r_cid.'" value="'.$_SESSION['u_id'].'">
                      <button id="c_dislikebtn'.$r_cid.'" type="submit">&#x25BC</button>
                    </form>
                  </li>
                  <li style="margin-left:-45px;margin-top:-42px;">

    <div>'.setEmojis(replaceLinks(replaceLinebreaks($row['comment']))).'</div>
    <div><b><i style="color:'.$colour.';"><span class="comment_jqValue'.$r_cid.'">...</span></i></b> <img style="width:17px;height:15px;margin-top:-2px;" src="http://www.flag.synergy.gg/'.$row["countryID"].'.png"><a style="color:'.$roleColour.';" href="user.php?user='.$row["comment_sender_name"].'"><b> '.$row["comment_sender_name"].' </b></a><i>'.time_elapsed_string($row["date"]).' </i>
    <a style="color:#4fdbff;cursor: pointer;" class="reply" id="'.$row["comment_id"].'"><b>Reply</b></a>';
    if($_SESSION['u_urole'] == 'Administrator' || $_SESSION['u_urole'] == 'Moderator'){
      $output .='<form method="post" action="includes/delete.inc.php">
                    <input type="hidden" name="commentNumber" value="'.$cid.'">
                    <input type="hidden" name="toDel" value="comment">
                 <button style="float:right;margin-top:-18px;margin-right:-15px;" name="submit" type="submit">Delete</button>';
    }

    $output .='</div>
  </div>

                </li></ul>
</div>

   <script>
  var comment_numberLikes = "'.$r_comment_upload_benis.' '.$points.'";
  var $comment_jqValue'.$r_cid.' = $(".comment_jqValue'.$r_cid.'");
  $comment_jqValue'.$r_cid.'.html(comment_numberLikes); 
      
  $("#comment_likeform'.$r_cid.'").submit(function(event){      
    event.preventDefault();
    var img=$.trim($("#c_img'.$r_cid.'").val());
    var uid=$.trim($("#c_uid'.$r_cid.'").val());
    $.ajax({ url: "includes/comment_like.inc.php",
        data: {action:"like", uid:uid, img:img},
        type: "post",
      success: function(output) {
          $comment_jqValue'.$r_cid.'.html(output);  
            }
    });
  });

  $("#comment_dislikeform'.$r_cid.'").submit(function(event){
    event.preventDefault();
    var img=$.trim($("#c_img'.$r_cid.'").val());
    var uid=$.trim($("#c_uid'.$r_cid.'").val());
    $.ajax({ url: "includes/comment_like.inc.php",
          data: {action:"dislike", uid:uid, img:img},
      type: "post",
      success: function(output) {
          $comment_jqValue'.$r_cid.'.html(output);  
            }
    });
  });
</script>
';
} else {
    $output .='<div class="row">

  <div class="col-sm-8" style="margin-left:'.$marginleft.'px;border-bottom: 1px solid grey;margin-top:-20px;">

                <ul style="list-style-type: none;">
                  <li id="plus" style="margin-left:-70px;margin-top:20px;">
                    <!-- LIKE BUTTON -->
                    <form action="login.php" method="get">
                      <input type="hidden" name="loginrequest" value="like">
                      <button type="submit">&#x25B2</button>
                    </form>
                  </li>
                  <li id="minus" style="margin-left:-70px;">
                    <!-- DISLIKE BUTTON -->
                    <form action="login.php" method="get">
                      <input type="hidden" name="loginrequest" value="like">
                      <button type="submit">&#x25BC</button>
                    </form>
                  </li>
                  <li style="margin-left:-45px;margin-top:-42px;">
    <div>'.setEmojis(replaceLinks(replaceLinebreaks($row['comment']))).'</div>
    <div><b><i style="color:'.$colour.';"><span class="comment_jqValue'.$r_cid.'">...</span></i></b> <img style="width:17px;height:15px;margin-top:-2px;" src="http://www.flag.synergy.gg/'.$row["countryID"].'.png"><a style="color:'.$roleColour.';" href="user.php?user='.$row["comment_sender_name"].'"><b> '.$row["comment_sender_name"].' </b></a><i>'.time_elapsed_string($row["date"]).' </i>
    <a style="color:#4fdbff;cursor: pointer;" class="reply" id="'.$row["comment_id"].'"><b>Reply</b></a></div>
  </div>

                </li></ul>
</div>

   <script>
  var comment_numberLikes'.$cid.' = "'.$r_comment_upload_benis.' '.$points.'";
  var $comment_jqValue'.$r_cid.' = $(".comment_jqValue'.$r_cid.'");
  $comment_jqValue'.$r_cid.'.html(comment_numberLikes); 
  </script>
';
}
   $output .= get_reply_comment($connect, $row["comment_id"], $marginleft);
  }
 }
 return $output;
}

function replaceLinks($s) {
    return preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.%-=#]*(\?\S+)?)?)?)@', '<a style="color: #4fdbff;" href="$1">$1</a>', $s);
}

function replaceLinebreaks($s) {
    return str_replace('\r\n', "\t<br />", $s);
}
  
?>

