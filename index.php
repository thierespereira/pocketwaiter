<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pocket Waiter - No More Queues!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.4.5.min.css" />
        <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
        <script src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
    </head>
    <body>
        <div data-role="page" style="width=100%; margin:0;" data-theme="b">
            <script type="text/javascript" language="javascript">
                function validateMyForm() {
                    var form = document.forms['index_form'];
                    $("#errorMessage").html('');
                    var ret = true;

                    if(!form['code'].value.trim()) {
                        $('#errorMessage').append('Please enter a table code.');
                        ret = false;
                    }
                    return ret;
                }
            </script>

            <?php
                include('header.php');
            ?>

            <?php
                if($_POST){
                    $_SESSION['cart'] = array();
                    $code = $_POST['code'];
                    $error = '';

                    if($code == ''){
                        $error .= "Please enter a code table";
                    }

                    if($error == '') {
                        try{
                            include('database.php');

                            $sql = "select * from comptable where comptable.code = ?;";
                            $sth = $DBH->prepare($sql);

                            $sth->bindParam(1,$code, PDO::PARAM_INT);

                            $sth->execute();

                            if($sth->rowCount() > 0){
                                $row = $sth->fetch(PDO::FETCH_ASSOC);
                                $_SESSION['table_id'] = $row['id'];
                                echo '<script>window.location = "menu.php?code=' . $row['code'] . '" </script>';
                                die;
                            } else {
                                $error .= "Table code is incorrect or was not found.";
                            }

                        } catch(PDOException $e) {
                            $error .= $e;
                            echo $e;
                        }
                    }
                }

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

                <form action="index.php" name="index_form" method="post" onsubmit="return validateMyForm(this);">
                    <center><label for="code">Enter table code</label></center>
                    <input type="text" data-clear-btn="true" name="code" id="code" value="<?php echo isset($_POST['code']) ? $_POST['code'] : '' ?>">
                    <button type="submit" data-transition="slide" class="ui-btn ui-btn-b" >OK</button>
                    <br>
                    <center>Or log in to continue</center>
                    <a href="login.php" id="link" data-transition="slide" class="ui-btn ui-btn-b ui-shadow">Login</a>
                    <a href="register.php" data-transition="slide" class="ui-btn ui-btn-b ui-shadow">Register</a>
                </form>
            </div><!-- /content -->

            <div data-role="footer">
                <center><h5 style="color:#B0B0B0;">This web application was developed by PVP.</h5></center>
            </div><!-- /footer -->

        </div><!-- /page -->
    </body>
</html>
