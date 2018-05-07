<?php

include_once "time.inc.php";

$connect = new PDO('host;dbname=dbname', 'username', 'pw');

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
  $comment = str_replace('\r\n', "<br />", $row['comment']);
 $output .= '
<div class="row">
  <div class="col-sm-8" style="border-bottom: 1px solid grey;">
    <div><img style="width:17px;height:15px;margin-top:-2px;" src="../assets/img/flags/'.$row["countryID"].'.png"><a href="user.php?user='.$row["comment_sender_name"].'"><b> '.$row["comment_sender_name"].' </b></a><i>'.time_elapsed_string($row["date"]).'</i></div>
    <div>'.replaceLinks($comment).'</div>
    <div><a style="cursor: pointer;" class="reply" id="'.$row["comment_id"].'"><b><i>Reply</b></i></a></div>
  </div>
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
        <div style="margin-left:'.$marginleft.'px;border-bottom: 1px solid grey;" class="col-sm-8">
          <div><img style="width:17px;height:15px;margin-top:-2px;" src="../assets/img/flags/'.$row["countryID"].'.png"><a href="user.php?user='.$row["comment_sender_name"].'"><b> '.$row["comment_sender_name"].' </b></a><i>'.time_elapsed_string($row["date"]).'</i></div>
          <div>'.replaceLinks($comment).'</div>
          <div><a style="cursor: pointer;" class="reply" id="'.$row["comment_id"].'"><b><i>Reply</b></i></a></div>
       </div>
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
