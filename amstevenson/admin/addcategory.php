<?php

include_once("../classes/config.inc.php");

// Check to see if user is logged in or out
$loggedIn = $user->is_logged_in();

//if not logged in redirect to login page
if(!$loggedIn){ header('Location: login.php'); }

$pageTitle = "Add Category | AMStevenson";

// Set meta description for this page
$metaDescription = " ";

include_once("../includes/header.php");

// Set up wrapper structure
echo ' <section id="wrapper">
                        <header>
                            <div class="inner">
                                <h2>Add Category</h2>
                            </div>
                        </header>

                        <div class="wrapper" >
                            <div class="inner" >

                                <section> ';

?>
    <form action="" method="post">

        <p><label>Category Name</label><br />
            <input type="text" name="catTitle" value='<?php if(isset($error)){ echo $_POST['catTitle'];}?>'></p>

        <p><input type='submit' name='submit' value='Submit'></p>

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
if(isset($_POST['submit'])){

    $_POST = array_map( 'stripslashes', $_POST );

    //collect form data
    extract($_POST);

    //very basic validation
    if($catTitle ==''){
        $error[] = 'Please enter the name of the category.';
    }

    if(!isset($error)) {

        try {

            if($user->is_logged_in() && $user->is_user_admin()) {

                try {

                    $catSlug = slug($catTitle);

                    //insert into database
                    $stmt = $db->prepare('INSERT INTO blog_cats (catTitle,catSlug) VALUES (:catTitle, :catSlug)') ;
                    $stmt->execute(array(
                        ':catTitle' => $catTitle,
                        ':catSlug' => $catSlug
                    ));

                    //redirect to index page
                    header('Location: categories.php?action=added');
                    exit;

                } catch(PDOException $e) {
                    echo $e->getMessage();
                }


            } else
            {
                echo '<script type="text/javascript">sweetAlert("Error",';
                echo '"Operation cannot be complete as you are not logged in."' . $errorMessage . '"';
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
        echo '"We encountered a few errors: \n' . $errorMessage . '"';
        echo ' , "error");</script>';
    }
}
?>