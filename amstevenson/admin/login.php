<?php

    include_once("../classes/config.inc.php");

    // Check to see if user is logged in or out
    $loggedIn = $user->is_logged_in();

    //check if already logged in
    if($loggedIn ){ header('Location: index.php'); }

    $pageTitle = "Login | AMStevenson";

    // Set meta description for this page
    $metaDescription = "Please login to view all blog articles for this website.";

    include_once("../includes/header.php");

    // Set up wrapper structure
        echo ' <section id="wrapper">
                    <header>
                        <div class="inner">
                            <h2>Login or Register</h2>
                        </div>
                    </header>

                    <div class="wrapper" >
                        <div class="inner" >

                            <section>
                                <p>Please login to have control over the blog posts and even create your own! If you have any problems
                                 with this, feel free to let me know. </p>

                                <form action="" method="post">
                                <p><label>Username</label><input type="text" name="username" value=""  /></p>
                                <p><label>Password</label><input type="password" name="password" value=""  /></p>
                                <p><label></label><input type="submit" name="submit" value="Login"  /></p>
                                </form>

                            </section>

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

    //process login form if submitted
    if(isset($_POST['submit'])){

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if($user->login($username,$password)){

            // logged in, return to the administrative index page for blogs
            header('Location: ../blogs.php');
            exit;

        } else {
            echo '<script type="text/javascript">sweetAlert("Error",';
            echo '"Wrong username or password. "';
            echo ' , "error");</script>';
        }

    }

?>

