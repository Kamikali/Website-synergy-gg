<?php
	include_once "partials/header.php";
	include_once "partials/navbar.php";
?>
<body>
<div class="container">
	Please choose a image or video to upload.<br>
	Make sure to take a look at our <b><a href="rules.php">>>rules</a></b> before uploading!<br><br>

	<form class="form-horizontal" action="includes/upload.inc.php" method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<label class="control-label col-sm-2" style="color:white;">Titel:</label>
			<div class="col-sm-10">
				<input type="text" onkeyup="showHint(this.value)" class="form-control" name='title' placeholder='Title' id='title'>
				<span style="color:white;" id="txtHint"></span>
     		</div>
     	</div>
        <!--
		<div class="form-group">
			<label class="control-label col-sm-2" style="color:white;">Description:</label>
			<div class="col-sm-10">
				<textarea type='text' name='message' onkeyup="showHint_descr(this.value)" class="form-control" placeholder='Description (optional)'></textarea>
				<span style="color:white;" id="txtHint_descr"></span>
     		</div>
     	</div>
        -->
		<div class="form-group">
			<label class="control-label col-sm-2" style="color:white;">Select file:</label>
			<div class="col-sm-10">
				<input id="fileUpload" type="file" class="form-control" name="file">
                <div id="image-holder"></div>
     		</div>
     	</div>

        <div class="form-group">
            <?php
            $allowedRoles = array("Moderator", "Administrator");
                if(in_array($_SESSION['u_urole'], $allowedRoles)){
            ?>
            <label class="control-label col-sm-2" style="color:white;">Show on frontpage?</label>
            <?php
            }
            ?>
            <div class="checkbox">
                <div class="col-sm-10">
                    <input type="hidden" name="frontpage" value="0">
                    <?php
                    $allowedRoles = array("Moderator", "Administrator");
                        if(in_array($_SESSION['u_urole'], $allowedRoles)){
                    ?>
                            <input style="margin-left:0px;" type="checkbox" name="frontpage" value="1">
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>  

	    <div class="form-group">        
	      <div class="col-sm-offset-2 col-sm-10">
	        <button type="submit" name="submit" class="btn btn-info">Next</button>
	      </div>
	    </div>
	</form>

	<a href="news.php">Cancel</a>
</div>
<br>
	
</body>
<?php
	include_once "partials/footer.php";
?>

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
  var str = $('#title').val();
  var lastIndex = str.lastIndexOf(" ");
  str = str.substring(0, lastIndex) + " " + myMessage + " ";
  $('#title').val(str);
  $('#title').focus();
}

$("#fileUpload").on('change', function () {

    var imgPath = $(this)[0].value;
    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

    if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
        if (typeof (FileReader) != "undefined") {

            var image_holder = $("#image-holder");
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "style" : "max-height:150px;max-width:300px;",
                    "src": e.target.result,
                        "class": "thumb-image"
                }).appendTo(image_holder);

            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    }
});

</script>