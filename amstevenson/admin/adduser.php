<?php

include_once("../classes/config.inc.php");

    // Check to see if user is logged in or out
    $loggedIn = $user->is_logged_in();

    //if not logged in redirect to login page
    if($loggedIn){ header('Location: login.php'); }

    $pageTitle = "Add User | AMStevenson";

    // Set meta description for this page
    $metaDescription = " ";

    include_once("../includes/header.php");

// Set up wrapper structure
echo ' <section id="wrapper">
                        <header>
                            <div class="inner">
                                <h2>User registration</h2>
                            </div>
                        </header>

                        <div class="wrapper" >
                            <div class="inner" >

                                <section> ';

?>
                                    <form action='' method='post'>

                                        <p><label>Username</label><br />
                                            <input type='text' name='username' value='<?php if(isset($error)){ echo $_POST['username'];}?>'></p>

                                        <p><label>Password</label><br />
                                            <input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>

                                        <p><label>Confirm Password</label><br />
                                            <input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

                                        <p><label>Email</label><br />
                                            <input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>

                                        <p><input type='submit' name='submit' value='Register'></p>

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

?>

<?php

// If the form has been submitted, process it.
if(isset($_POST['submit'])) {

    $_POST = array_map('stripslashes', $_POST);

    //collect form data
    extract($_POST);

    //very basic validation
    if ($username == '') {
        $error[] = 'Please enter the name of the user.';
    }

    if ($password == '') {
        $error[] = 'Please enter the password.';
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

    if (!isset($error)) {

        $hashedPassword = $user->create_hash($password);

        try {

            //Insert new user into the database
            $stmt = $db->prepare('INSERT INTO blog_members (username,password,email,role) VALUES (:username, :password, :email, :role)');
            $stmt->execute(array(
                ':username' => strtolower($username),
                ':password' => $hashedPassword,
                ':email' => $email,
                ':role' => "user"
            ));

            //login and then direct to blogs page
            if($user->login($username, $password))
            {
                header('Location: adminindex.php?action=added');
                exit;
            }
            else
            {
                // Echo as an alert...a sweet alert!
                echo '<script type="text/javascript">sweetAlert("Oops...",';
                echo '"Error logging in."';
                echo ' , "error");</script>';
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    if (isset($error)) {

        // Construct the alerts message.
        $errorMessage = "";

        foreach ($error as $error) {
            $errorMessage .= $error . '\n';
        }

        // Echo as an alert...a sweet alert!
        echo '<script type="text/javascript">sweetAlert("Oops...",';
        echo '"We have encountered a few errors: \n' . $errorMessage . '"';
        echo ' , "error");</script>';
    }
}