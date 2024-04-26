$(document).ready(function() {
    $('#selectAllBoxes').click(function() {
        if(this.checked) {
            $('.checkBoxes').each(function() {
                this.checked = true;
            });
        } else {
            $('.checkBoxes').each(function() {
                this.checked = false;
            });
        }
    });

    $('#summernote').summernote();

    const div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $('body').prepend(div_box);
    $('#load-screen').delay(100).fadeOut(500, function () {
        $(this).remove();
    });
});

function loadUsersOnline() {
    $.get("includes/functions.php?onlineusers", function(data) {
        $(".usersonline").text(data);
    });
}
setInterval(function() {
    loadUsersOnline();
}, 500);
