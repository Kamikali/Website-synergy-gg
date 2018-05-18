  
  <br />
   <form method="POST" id="comment_form">
    <div class="form-group">
      <div class="row">
        <div class="col-sm-8">
          <textarea onkeyup="showHint(this.value)" name="comment_content" rows="2" style="resize: vertical;max-height: 300px;min-height:40px" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5"></textarea>
          <p><span style="color:white;" id="txtHint"></span></p>
        </div>
      </div>
     
    </div>
    <div class="form-group">
     <input type="hidden" name="comment_id" id="comment_id" value="0" />
     <?php echo '<input type="hidden" name="post_id" id="post_id" value="'.$img.'" />' ?>
     <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
    </div>
   </form>
   <span id="comment_message"></span>
   <br />
   <div style="margin-left:20px;" id="display_comment"></div>


<script>
$(document).ready(function(){
 
 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"includes/add_comment.inc.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    if(data.error != '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');
     load_comment(<?php echo $img ?>);
    }
   }
  })
 });

 load_comment(<?php echo $img ?>);

 function load_comment(img)
 {
  $.ajax({
   url:"includes/fetch_comment.inc.php",
   method:"POST",
   data: { img },
   success:function(data)
   {
    $('#display_comment').html(data);
   }
  })
 }

 $(document).on('click', '.reply', function(){
  var comment_id = $(this).attr("id");
  $('#comment_id').val(comment_id);
  $('#comment_content').focus();
 });
 
});


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