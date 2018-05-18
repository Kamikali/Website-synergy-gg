<?php
session_start();

include_once "dbh.inc.php"; //include for msqli_real_escape_string idk this is really bad i gotta change this
$connect = new PDO('mysql:host=db735578055.db.1and1.com;dbname=db735578055', 'dbo735578055', 'ZS<Sn}IY7oDCSPsB');

$error = '';
$comment_name = '';
$comment_content = '';
$comment_country = $_SESSION['u_countryid'];
$post_id = $_POST["post_id"];

if(empty($_SESSION['u_uid'])) {
 $error .= '<p class="text-danger">You have to be logged in if you want to write a comment!</p>';
} else {
 $comment_name = $_SESSION['u_uid'];
}

if(empty($_POST["post_id"])) {
 $error .= '<p class="text-danger">Post ID is not clear!</p>';
} else {
 $post_id = $_POST["post_id"];
}

if (strpos($_POST["comment_content"], '<') !== false || strpos($_POST["comment_content"], '>') !== false) {
    $error .= '<p class="text-danger">You are not allowed to use &lt or &gt in comments!</p>';
}

if(empty($_POST["comment_content"])){
 $error .= '<p class="text-danger">Comment is required</p>';
} else {
 $comment_content = mysqli_real_escape_string($conn, $_POST["comment_content"]);
}

if($error == '')
{
 $query = "
 INSERT INTO tbl_comment 
 (parent_comment_id, comment, comment_sender_name, countryID, post_id) 
 VALUES (:parent_comment_id, :comment, :comment_sender_name, :countryID, :post_id)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':parent_comment_id' => $_POST["comment_id"],
   ':comment'    => $comment_content,
   ':comment_sender_name' => $comment_name,
   ':countryID' => $comment_country,
   ':post_id' => $post_id
  )
 );
 $error = '<label class="text-success">'.$comment_content.'</label>';
}

$data = array(
 'error'  => $error
);

echo json_encode($data);

?>