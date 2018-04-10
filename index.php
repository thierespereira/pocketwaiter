<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pocket Waiter - No More Queues!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.4.5.min.css" />
        <script src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
    </head>
    <body>
        <div data-role="page" style="width=100%; margin:0;" data-theme="b">

            <?php
                include('header.php');
            ?>

            <div role="main" class="ui-content">
                <form action="menu.php" method="post" onsubmit="return validateMyForm(this);">
                    <center><label for="code">Enter the table code below:</label></center>
                    <input type="text" data-clear-btn="true" name="code" id="code" value="<?php echo isset($_POST['code']) ? $_POST['code'] : '' ?>">
                    <button type="submit" data-transition="slide" class="ui-btn ui-icon-check ui-btn-icon-left ui-btn-b" >OK</button>
                </form>
                <br>
                <a href="login.php" id="link" data-transition="slide" class="ui-btn ui-btn-b ui-shadow">Login</a>
                <a href="register.php" data-transition="slide" class="ui-btn ui-btn-b ui-shadow">Register</a>
            </div><!-- /content -->

            <div data-role="footer">
                <center><h5 style="color:#B0B0B0;">This web application was developed by PVP.</h5></center>
            </div><!-- /footer -->

        </div><!-- /page -->
    </body>
</html>
