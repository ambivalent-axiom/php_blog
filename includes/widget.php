<?php
    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $body = $_POST['body'];
        $email = escape($email);
        $subject = escape($subject);
        $body = wordwrap(escape($body), 70);
        //turned off for now due to spam
        //sendEmailNotification($email, $subject, $body);
        
    }
?>

<div class="well form-wrap">
    <h4>Contact</h4>
    <form role="form" action="" method="post" id="login-form" autocomplete="off">
        <div class="form-group">
            <label for="email" class="sr-only">Email</label>
            <input type="email" name="email" id="email" class="form-control sender" placeholder="Your email">
        </div>
        <div class="form-group">
            <label for="subject" class="sr-only">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" placeholder="Your subject">
        </div>
            <div class="form-group">
            <label for="body" class="sr-only">Text field</label>
            <textarea class="form-control message" name="body" id="" placeholder="Your message"></textarea>
        </div>
        <input onclick="javascript:void(0)" type="button" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block send-email" value="Send">
    </form>
</div>

<script>
    $(document).ready(function() {
        $(".send-email").on('click', function(){
            const sender = $('.sender').val();
            const act_msg = "Thank You " + sender;
            const button_name = "Send";
            const msgs = $('.message').val();
            $('.btn.btn-danger').text(button_name);
            $('.modal-title').text(act_msg);
            $('.modal-body').text(msgs);
            $("#myModal").modal('show');
        });
    });

</script>