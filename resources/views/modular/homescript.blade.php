<script>
function upvote(id) {
    handleVote(id,1);
}

function downvote(id) {
    handleVote(id,0);
}

function handleVote(id,type) {
 var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {

        var x = JSON.parse(this.responseText);
        if (x.success == false ) {
            if (x.message == "not logged in") {
                window.location.replace("/login/?error=4");
            } else {
                alert(x.message);
            }
        } else {
            if (x.uvb == true) {
                $("#uvb" + id).removeClass("btn-secondary");
                $("#uvb" + id).addClass("btn-success");
                $("#dvb" + id).addClass("btn-secondary");
                $("#dvb" + id).removeClass("btn-danger");
            } else if (x.dvb == true) {
                $("#dvb" + id).removeClass("btn-secondary");
                $("#dvb" + id).addClass("btn-danger");
                $("#uvb" + id).addClass("btn-secondary");
                $("#uvb" + id).removeClass("btn-success");
            } else {
                $("#dvb" + id).addClass("btn-secondary");
                $("#dvb" + id).removeClass("btn-danger");
                $("#uvb" + id).addClass("btn-secondary");
                $("#uvb" + id).removeClass("btn-success");
            }
            $("#vc" + id).html(x.vc);

        }

      }
    };
    var data = { '_token' : "{{ csrf_token() }}" ,'id': id, 'type': type };

    xmlhttp.open("POST", "/vote/", true);
    xmlhttp.onload = function () {
       
    }
    xmlhttp.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    xmlhttp.send(JSON.stringify(data));
    }

function comment(id) {
    var myModal = new bootstrap.Modal(document.getElementById('cModal'), {
  keyboard: true
})
    myModal.show();
    loadComment(id);
}

function loadComment(id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

       $("#commentlist").html(this.responseText);
        $("#exampleModalLabel").html("Comment");
        
        @if ($username != "")
        $("#commentbox").show();
        $("#commentbutton").show();
        $("#commentbutton").attr("onclick","doComment(" +id +")");
        @endif

        }
        setTimeout(function(){

            $("#commentlist").animate({ scrollTop: $('#commentlist').prop("scrollHeight") }, "slow");
}, 500); 
      
  return false;
    };
    var data = { '_token' : "{{ csrf_token() }}" ,'id': id};

    xmlhttp.open("POST", "/getcomment/", true);
  
        $("#commentlist").html('<div class="d-flex align-items-center"><strong>Loading...</strong><div class="spinner-border ms-auto" role="status" aria-hidden="true"></div></div>');
        @if ($username != "")
        $("#commentbox").hide();
        $("#commentbutton").hide();
        @endif
    
    xmlhttp.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    xmlhttp.send(JSON.stringify(data));

}

function doComment(id) {
    var comment = $("#commentbox").val();
    if (comment == "") {
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          
            var x = JSON.parse(this.responseText);
         if (x.success == false ) {
            if (x.message == "not logged in") {
                window.location.replace("/login/?error=4");
            } else {
                alert(x.message);
                
            }
         } else {
            $("#commentbox").val("");
         }
         
         loadComment(id);
        @if ($username != "")
        $("#commentbox").show();
        $("#commentbutton").show();
       
        @endif

        }
    };
   
    xmlhttp.open("POST", "/docomment/", true);
  
        $("#commentlist").html('<div class="d-flex align-items-center"><strong>Submitting Comment..</strong><div class="spinner-border ms-auto" role="status" aria-hidden="true"></div></div>');
        @if ($username != "")
        $("#commentbox").hide();
        $("#commentbutton").hide();
        @endif
       
    var data = { '_token' : "{{ csrf_token() }}" ,'id': id,'comment': comment};

    xmlhttp.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    xmlhttp.send(JSON.stringify(data));
}

var clipboard = new ClipboardJS('#cpbtn');


clipboard.on('success', function(e) {
    console.info('Action:', e.action);
    console.info('Text:', e.text);
    console.info('Trigger:', e.trigger);

    e.clearSelection();
    $("#copytoastmessage").html("Link Copied Successfully!");
    alert("Link Copied Successfully!")
});

clipboard.on('error', function(e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
});


</script>


<!-- Comment modal -->
<div class="modal fade" id="cModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable">
<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Comment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="cModal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="commentlist">

    

      </div>
      <div class="modal-footer">
       @if ($username != "")
         <input autocomplete="off" type="text" id="commentbox" class="form-control" placeholder="Write a Comment">

        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="commentbutton" class="btn btn-primary">Comment</button>
        @else

        <p class="w-100">You need to login before commenting on a posts</p>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
         <a href='/login' class="btn btn-primary">Login</a>
        @endif
      </div>
    </div>
</div>
</div>
