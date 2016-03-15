<?php

include_once("../classes/config.inc.php");

    // Check to see if user is logged in or out
    $loggedIn = $user->is_logged_in();

    //if not logged in redirect to login page
    if(!$loggedIn){ header('Location: login.php'); }

    $pageTitle = "Edit User | AMStevenson";

    // Set meta description for this page
    $metaDescription = " ";

    include_once("../includes/header.php");

// Set up wrapper structure
echo ' <section id="wrapper">
                        <header>
                            <div class="inner">
                                <h2>Edit a user</h2>
                            </div>
                        </header>

                        <div class="wrapper" >
                            <div class="inner" >

                                <section> ';

?>
                            <?php
                            try {

                                $stmt = $db->prepare('SELECT memberID, username, email, role FROM blog_members WHERE memberID = :memberID') ;
                                $stmt->execute(array(':memberID' => $_GET['id']));
                                $row = $stmt->fetch();

                            } catch(PDOException $e) {
                                echo $e->getMessage();
                            }
                            ?>

                            <form action='' method='post'>
                                <input type='hidden' name='memberID' value='<?php echo $row['memberID'];?>'>

                                <p><label>Username</label><br />
                                    <input type='text' name='username' value='<?php echo $row['username'];?>'></p>

                                <?php if(!$user->is_user_admin()) { ?>
                                <p><label>Old Password</label></p>
                                    <input type='password' name='oldPassword' value=''></p>
                                <?php } ?>

                                <p><label>New Password (only to change)</label><br />
                                    <input type='password' name='password' value=''></p>

                                <p><label>Confirm New Password</label><br />
                                    <input type='password' name='passwordConfirm' value=''></p>

                                <p><label>Email</label><br />
                                    <input type='text' name='email' value='<?php echo $row['email'];?>'></p>

                                <p><input type='submit' name='submit' value='Update User'></p>

                            </form>
<?php


echo '                      </section>

                            </div>
                        </div>

                </section>

                <!-- Scripts -->
                <script src="../js/skel.min.js"></script>
                <script src="../js/jquery.min.js"></script>
                <script src="../js/jquery.scrollex.min.js"></script>
                <script src="../js/util.js"></script>
                <!--[if lte IE 8]>
                <script src="../js/ie/respond.min.js"></script><![endif]-->
                <script src="../js/main.js"></script>
                <script src="../js/sweetalert.min.js"></script>

            </body>

        </html>
            ';


// If the form has been submitted, process it.
if(isset($_POST['submit'])) {

    $_POST = array_map('stripslashes', $_POST);

    //collect form data
    extract($_POST);

    if ($username == '') {
        $error[] = 'Please enter the name of the user.';
    }

    if ($password == '') {
        $error[] = 'Please enter the password.';
    }

    if ($oldPassword == '') {
        $error[] = 'Please enter your old password.';
    }

    if(!$user->is_user_admin()) {

        $stmt = $db->prepare('SELECT password FROM blog_members WHERE memberID = :memberID') ;
        $stmt->execute(array(':memberID' => $_GET['id']));
        $row = $stmt->fetch();

        $hashedOldPassword = $user->create_hash($oldPassword);

        if (!($hashedOldPassword == $row['password'])) {
            $error[] = 'Your old password does not match the one stored in the database.';
        }
    }

    if ($passwordConfirm == '') {
        $error[] = 'Please repeat the password.';
    }

    if($password != $passwordConfirm){
        $error[] = 'Passwords do not match.';
    }

    if ($email == '') {
        $error[] = 'Please enter the email address.';
    }

    if(!isset($error)) {
        if (isset($password)) {

            $hashedPassword = $user->create_hash($password);

            //update into database
            $stmt = $db->prepare('UPDATE blog_members SET username = :username, password = :password, email = :email WHERE memberID = :memberID');
            $stmt->execute(array(
                ':username' => $username,
                ':password' => $hashedPassword,
                ':email' => $email,
                ':memberID' => $memberID
            ));


        } else {

            //update database
            $stmt = $db->prepare('UPDATE blog_members SET username = :username, email = :email WHERE memberID = :memberID');
            $stmt->execute(array(
                ':username' => $username,
                ':email' => $email,
                ':memberID' => $memberID
            ));

        }

        echo '<script type="text/javascript">swal("Success!", "Your profile details have been changed.", "success")</script>';

    }

    if (isset($error)) {

        // Construct the alerts message.
        $errorMessage = "";

        foreach ($error as $error) {
            $errorMessage .= $error . '\n';
        }

        // Echo as an alert...a sweet alert!
        echo '<script type="text/javascript">sweetAlert("Oops...",';
        echo '"We encountered a few errors: \n' . $errorMessage . '"';
        echo ' , "error");</script>';
    }

}



?>
