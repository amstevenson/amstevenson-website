<?php

include_once("../classes/config.inc.php");

// Check to see if user is logged in or out
$loggedIn = $user->is_logged_in();

//if not logged in redirect to login page
if(!$loggedIn){ header('Location: adminlogin.php'); }

$pageTitle = "Edit Category | AMStevenson";

// Set meta description for this page
$metaDescription = " ";

include_once("../includes/header.php");

// Set up wrapper structure
echo ' <section id="wrapper">
                <header>
                    <div class="inner">
                        <h2>Edit Category</h2>
                    </div>
                </header>

                <div class="wrapper" >
                    <div class="inner" >';

try {

    $stmt = $db->prepare('SELECT catID, catTitle FROM blog_cats WHERE catID = :catID') ;
    $stmt->execute(array(':catID' => $_GET['id']));
    $row = $stmt->fetch();

} catch(PDOException $e) {
    echo $e->getMessage();
}
?>

    <form action='' method='post' >
        <input type='hidden' name='catID' value='<?php echo $row['catID'];?>'>

        <p><label>Title</label><br />
            <input type='text' name='catTitle' value='<?php echo $row['catTitle'];?>'></p>

        <p><input type='submit' name='submit' value='Update'></p>

    </form>

<?php
echo '          </div>
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

        </body>
    </html>';

if(isset($_POST['submit'])) {

    $_POST = array_map('stripslashes', $_POST);

    //collect form data
    extract($_POST);

    //very basic validation
    if($catID ==''){
        $error[] = 'This post is missing a valid id!.';
    }

    if($catTitle ==''){
        $error[] = 'Please enter the title.';
    }

    if (!isset($error)) {

        if($user->is_user_admin() ) {
            try {

                $catSlug = slug($catTitle);

                //insert into database
                $stmt = $db->prepare('UPDATE blog_cats SET catTitle = :catTitle, catSlug = :catSlug WHERE catID = :catID') ;
                $stmt->execute(array(
                    ':catTitle' => $catTitle,
                    ':catSlug' => $catSlug,
                    ':catID' => $catID
                ));

                //redirect to index page
                header('Location: categories.php?action=updated');
                exit;

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        else {

            // Echo as an alert...a sweet alert!
            echo '<script type="text/javascript">sweetAlert("Oops...",';
            echo '"You are not authorised to use this command."';
            echo ' , "error");</script>';
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


