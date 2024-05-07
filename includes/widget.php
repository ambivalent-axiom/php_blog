<?php
    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $body = $_POST['body'];
        $email = escape($email);
        $subject = escape($subject);
        $body = escape($body);
        sendEmailNotification($email, $subject, $body);
    }
?>

<div class="well form-wrap">
    <h4>Contact</h4>
    <form role="form" action="" method="post" id="login-form" autocomplete="off">
        <div class="form-group">
            <label for="email" class="sr-only">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Your email">
        </div>
        <div class="form-group">
            <label for="subject" class="sr-only">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" placeholder="Your subject">
        </div>
            <div class="form-group">
            <label for="body" class="sr-only">Text field</label>
            <textarea class="form-control" name="body" id="" placeholder="Your message"></textarea>
        </div>
        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
    </form>
</div>