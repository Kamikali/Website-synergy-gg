<?php
include_once "partials/header.php";
include_once "partials/navbar.php";
include_once "includes/setEmojis.php";
$allowedRoles = array("Moderator", "Administrator");
?>

<div class="container">
<?php
if(isset($_SESSION['u_uid'])){
?>
	<h1>Settings</h1>
	<form method="post" action="includes/setProfileText.inc.php">
		<div class="form-group">
			<div class="col-sm-8">
				<h3 style="color:white;">Edit Profile text:</h3>
	            <textarea onkeyup="showHint(this.value)" name="profile_text" rows="2" style="resize: vertical;max-height: 300px;min-height:40px" id="comment_content" class="form-control" placeholder="Enter self introduction (max 300 characters)" rows="5"></textarea>
	            <p><span style="color:white;" id="txtHint"></span></p>
	            <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
	        </div>
		</div>
	</form>

<?php
} else {
	echo "<h3>Hey, you! Yes, YOU!<br>What are you doing here?<br>You have to be logged in to see this page ¯\_(ツ)_/¯</h3>";
}
?>

</div>

<script>
function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "includes/emojiHint.inc.php?q=" + lastWord(str), true);
        xmlhttp.send();
    }
}

function lastWord(words) {
    var n = words.split(" ");
    return n[n.length - 1];
}

function jsFunction(myMessage) {
  var str = $('#comment_content').val();
  var lastIndex = str.lastIndexOf(" ");
  str = str.substring(0, lastIndex) + " " + myMessage + " ";
  $('#comment_content').val(str);
  $('#comment_content').focus();
}
</script>
</script>