<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.4.5.min.css" />
        <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
        <script src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>

        <style>
        #divider {
                border-left: 1px dashed;
            }
        </style>
    </head>
    <body>
        <div data-role="page" style="width=100%; margin:0;" data-theme="b">
            <script type="text/javascript" language="javascript">
                function validateMyForm() {
                    var form = document.forms['login_form'];
                    $("#errorMessage").html('');
                    var ret = true;
                    var re_mail = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z])+$/;

                    if (!form['email'].value.trim()) {
                        $("#errorMessage").append('Please enter an email.<br>');
                        ret = false;
                    } else {
                        if (!re_mail.test(form['email'].value.trim())) {
                            $("#errorMessage").append('Please enter a valid email.<br>');
                            ret = false;
                        }
                    }

                    if(!form['password'].value.trim()) {
                        $('#errorMessage').append('Please enter a password.');
                        ret = false;
                    }
                    return ret;
                }
            </script>

            <?php

                if($_POST) {
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $error = '';

                    if($email == '') {
                        $error .= 'You must enter an email address!<br>';
                    }

                    if($password == '') {
                        $error .= 'You must enter a valid password!<br>';
                    }

                    if($error == '') {
                        // DB
                        try {
                            include('database.php');

                            $sql = "select * from user where email = ?";
                            $sth = $DBH->prepare($sql);

                            $sth->bindParam(1,$email, PDO::PARAM_INT);

                            $sth->execute();

                            if ($sth->rowCount() > 0) {
                                $rec = $sth->fetch(PDO::FETCH_ASSOC);

                                $id = $rec['id'];
                                $type = $rec['type'];
                                $passwordHashed = $rec['password'];
                                $salt = $rec['salt'];
                                $_SESSION['comp_id'] = $rec['comp_id'];
                                $newPassHashed = md5($password . $salt);

                                if ($passwordHashed == $newPassHashed) {
                                    $_SESSION['user_id'] = $id;
                                    $_SESSION['userEmail'] = $email;
                                    $_SESSION['user_type'] = $type;
                                    $_SESSION['sessionId'] = session_id();

                                    if($type == 'customer') {

                                        echo '<script>window.location = "customer.php" </script>';
                                        die;
                                    } else if($type == 'staffadmin') {
                                        echo '<script>window.location = "staffadmin.php" </script>';
                                        die;
                                    } else if($type == 'admin') {
                                        echo '<script>window.location = "administrator.php" </script>';
                                        die;
                                    } else if($type == 'kitchen') {
                                        echo '<script>window.location = "kitchen.php" </script>';
                                        die;
                                    }
                                } else {
                                    $error .= 'Invalid email / password!';
                                }
                            } else {
                                $error = 'Invalid email / password!';
                            }
                        } catch(PDOException $e) {
                            $error .= $e;
                            echo $e;
                        }
                    }
                }
            ?>

            <?php
                include('header.php');
            ?>

            <div role="main" class="ui-content">
                <div id="errorMessage" style="color:red; background-color:#FFE4E4;">
                </div>

                <?php
                    if($_POST) {
                        if($error) {
                            echo '<div id="message" style="color:red; background-color:#FFE4E4;">';
                            echo '<center><b>' . $error . '</b></center';
                            echo '</div>';
                            echo '<br>';
                        }
                    }
                ?>

                <form action="login.php" name="login_form" method="post" onsubmit="return validateMyForm();">
                    <label for="email">E-mail:</label>
                    <input type="text" data-clear-btn="true" name="email" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
                    <label for="password">Password:</label>
                    <input type="password" data-clear-btn="true" name="password" id="password" value="" autocomplete="off">  <br>
                    <!--
                    <center>
                        <label for="captcha_code">Solve this math problem:</label>
                        <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image"/><br>
                        <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[Refresh Code]</a>
                    </center>
                    <input type="text" name="captcha_code" size="10" maxlength="6" />
                    -->
                    <button type="submit" data-transition="slide" class="ui-btn ui-icon-check ui-btn-icon-left ui-btn-b">Login</button>
                    <a href="index.php" data-transition="slide" class="ui-btn ui-icon-arrow-l ui-btn-icon-left ui-btn-b" >Return</a>
                </form>
            </div><!-- /content -->

            <div data-role="footer">
                <center><h5 style="color:#B0B0B0;">This web application was developed by PVP.</h5></center>
            </div><!-- /footer -->

        </div><!-- /page -->
    </body>
</html>
