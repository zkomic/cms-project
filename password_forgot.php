<!-- PHPMailer includes -->
<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require './classes/Config.php'; ?>

<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>


<?php

if (!isset($_GET['forgot'])) {

    redirect("index");
}

if (ifMethod('post')) {

    if (isset($_POST['email'])) {

        $email = $_POST['email'];
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        $error = '';

        if (emailExists($email)) {

            $stmt = mysqli_prepare($connection, "UPDATE users SET token = ? WHERE user_email = ?");

            if ($stmt) {

                mysqli_stmt_bind_param($stmt, "ss", $token, $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = Config::SMTP_HOST;                      //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = Config::SMTP_USER;                      //SMTP username
                $mail->Password   = Config::SMTP_PASSWORD;                  //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
                $mail->Port       = Config::SMTP_PORT;                      //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('zrinka.komic@gmail.com', 'Zrinka D.');
                $mail->addAddress($email);     //Add a recipient

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Forgotten password';
                $mail->Body    =

                    '<p>Click here to reset your password: <br><br>
                    <a href="http://localhost/cms-project/password_reset.php?email=' . $email . '&token=' . $token . '">http://localhost/cms-project/reset_password.php?email=' . $email . '&token=' . $token . '"</a>
                </p>';

                $mail->AltBody = 'URL link';

                if ($mail->send()) {

                    $email_sent = true;
                } else {

                    echo "nope";
                }
            } else {

                echo "Prepare statement error: " . mysqli_error($connection);
            }
        } else {

            $error = "There is no user registered with that e-mail adress.";
        }
    }
}



?>

<!-- Navigation -->
<?php include "includes/navigation.php" ?>
<!-- Page Content -->
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <?php

                if (!empty($error)) {
                    echo "<div class='alert alert-danger' role='alert'>$error</div>";
                }

                ?>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <?php if (!isset($email_sent)) : ?>

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control" type="email" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>
                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                            <?php else :  ?>

                                <h3>Please check your e-mail.</h3>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php"; ?>

</div> <!-- /.container -->