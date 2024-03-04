<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php

if (isset($_POST['submit'])) {

    $to = "zrinka.komic@gmail.com";
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    $header = "From: " . $_POST['email'];

    // use wordwrap() if lines are longer than 70 characters
    $subject = wordwrap($subject, 70);

    // send email
    mail($to, $subject, $body, $header);
}

?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Contact</h1><br>
                        <form role="form" action="contact.php" method="post" id="contact-form" autocomplete="off">
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@email.com">
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <textarea name="body" id="body" class="form-control" placeholder="" cols="50" rows="10"></textarea>
                            </div>
                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>