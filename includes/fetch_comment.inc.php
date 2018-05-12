<?php

include_once "time.inc.php";


$img = $_POST['img'];

$query = "
SELECT * FROM tbl_comment 
WHERE parent_comment_id = '0' AND post_id = '$img'
ORDER BY comment_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';

foreach($result as $row) //
{

$cid = $row['comment_id'];

//GET DATA TO CREATE INFO BAR UNDER COMMENT
$likes = "SELECT isLike FROM likes WHERE comment_id = '$cid' AND isLike = 1";
$resultLikes = mysqli_query($conn, $likes);
$numLikes = mysqli_num_rows($resultLikes);

$unlikes = "SELECT isLike FROM likes WHERE comment_id = '$cid' AND isLike = 0";
$resultUnlikes = mysqli_query($conn, $unlikes);
$numUnlikes = mysqli_num_rows($resultUnlikes);

$upload_benis = $numLikes - $numUnlikes;


 $comment = str_replace('\r\n', "<br />", $row['comment']);
 $output .= '
<div class="row">

  <div class="col-sm-8" style="border-bottom: 1px solid grey;margin-top:-20px;">

                <ul style="list-style-type: none;">
                  <li id="plus" style="margin-left:-70px;margin-top:20px;">
                    <!-- LIKE BUTTON -->
                    <form method="post" id="comment_likeform">
                      <input type="hidden" id="img" value="'.$cid.'">
                      <input type="hidden" id="uid" value="'.$_SESSION['u_id'].'">
                      <button id="c_likebtn" type="submit">&#x25B2</button>
                    </form>
                  </li>
                  <li id="minus" style="margin-left:-70px;">
                    <!-- DISLIKE BUTTON -->
                    <form method="post" id="comment_dislikeform">
                      <input type="hidden" id="img" value="'.$cid.'">
                      <input type="hidden" id="uid" value="'.$_SESSION['u_id'].'">
                      <button id="c_dislikebtn" type="submit">&#x25BC</button>
                    </form>
                  </li>
                  <li style="margin-left:-45px;margin-top:-42px;">
    <div>'.replaceLinks($comment).'</div>
    <div><span class="comment_jqValue">...</span> <img style="width:17px;height:15px;margin-top:-2px;" src="../assets/img/flags/'.$row["countryID"].'.png"><a href="user.php?user='.$row["comment_sender_name"].'"><b> '.$row["comment_sender_name"].' </b></a><i>'.time_elapsed_string($row["date"]).' </i>
    <a style="cursor: pointer;" class="reply" id="'.$row["comment_id"].'"><b>Reply</b></a></div>
  </div>

                </li></ul>
</div>
';
 $output .= get_reply_comment($connect, $row["comment_id"]);
}

echo $output;

function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
{
 $query = "
 SELECT * FROM tbl_comment WHERE parent_comment_id = '".$parent_id."'
 ";
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
    $comment = str_replace('\r\n', "<br />", $row['comment']);
   $output .= '
   <div >
      <div class="row">
        <div style="margin-left:'.$marginleft.'px;margin-top:-20px;border-bottom: 1px solid grey;" class="col-sm-8">

                <ul style="list-style-type: none;">
                  <li id="plus" style="margin-left:-70px;margin-top:20px;">
                    <!-- LIKE BUTTON -->
                    <form method="post" id="comment_likeform">
                      <input type="hidden" id="img" value="'.$img.'">
                      <input type="hidden" id="uid" value="'.$_SESSION['u_id'].'">
                      <button id="c_likebtn" type="submit">&#x25B2</button>
                    </form>
                  </li>
                  <li id="minus" style="margin-left:-70px;">
                    <!-- DISLIKE BUTTON -->
                    <form method="post" id="comment_dislikeform">
                      <input type="hidden" id="img" value="'.$img.'">
                      <input type="hidden" id="uid" value="'.$_SESSION['u_id'].'">
                      <button id="c_dislikebtn" type="submit">&#x25BC</button>
                    </form>
                  </li>
                  <li style="margin-left:-45px;margin-top:-42px;">

          <div>'.replaceLinks($comment).'</div>
          <div><img style="width:17px;height:15px;margin-top:-2px;" src="../assets/img/flags/'.$row["countryID"].'.png"><a href="user.php?user='.$row["comment_sender_name"].'"><b> '.$row["comment_sender_name"].' </b></a><i>'.time_elapsed_string($row["date"]).' </i><a style="cursor: pointer;" class="reply" id="'.$row["comment_id"].'"><b>Reply</b></a></div>
       </div>

       </li></ul>
     </div>
   </div>
   ';
   $output .= get_reply_comment($connect, $row["comment_id"], $marginleft);
  }
 }
 return $output;
}

function replaceLinks($s) {
    return preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.%-=#]*(\?\S+)?)?)?)@', '<a style="color: #4fdbff;" href="$1">$1</a>', $s);
}

?>


<script>
  var numberLikes = "<?php echo $upload_benis; ?>";
  var $comment_jqValue = $('.comment_jqValue');
  $comment_jqValue.html(numberLikes); 
      
  $('#comment_likeform').submit(function(event){      
    event.preventDefault();
    var img=$.trim($('#img').val());
    var uid=$.trim($('#uid').val());
    $.ajax({ url: 'includes/comment_like.inc.php',
        data: {action:'like', uid:uid, img:img},
        type: 'post',
      success: function(output) {
          $comment_jqValue.html(output);  
            }
    });
  });

  $('#comment_dislikeform').submit(function(event){
    event.preventDefault();
    var img=$.trim($('#img').val());
    var uid=$.trim($('#uid').val());
    $.ajax({ url: 'includes/comment_like.inc.php',
          data: {action:'dislike', uid:uid, img:img},
      type: 'post',
      success: function(output) {
          $comment_jqValue.html(output);  
            }
    });
  });
</script>