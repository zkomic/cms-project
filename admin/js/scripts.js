$(document).ready(function () {
  $("#summernote").summernote({
    height: 250,
  });
});

$(document).ready(function () {
  $("#selectAllBoxes").click(function (event) {
    if (this.checked) {
      $(".checkBox").each(function () {
        this.checked = true;
      });
    } else {
      $(".checkBox").each(function () {
        this.checked = false;
      });
    }
  });

  var div_box = "<div id='load-screen'><div id='loading'></div></div>";
  $("body").prepend(div_box);
  $("#load-screen")
    .delay(300)
    .fadeOut(100, function () {
      $(this).remove();
    });
});

function loadUsersOnline() {
  $.get("functions.php?onlineUsers=result", function (data) {
    $(".usersOnline").text(data);
  });
}

setInterval(function () {
  loadUsersOnline();
}, 500);//milisec
