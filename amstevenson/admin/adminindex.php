<?php

    include_once("../classes/config.inc.php");

    // Check to see if user is logged in or out
    $loggedIn = $user->is_logged_in();

    //if not logged in redirect to login page
    if(!$loggedIn){ header('Location: login.php'); }

    $pageTitle = "Admin Page | AMStevenson";

    // Set meta description for this page
    $metaDescription = " ";

    include_once("../includes/header.php");

    // Set up wrapper structure
    echo ' <section id="wrapper">
                <header>
                    <div class="inner">
                        <h2>Blog Dashboard</h2>
                    </div>
                </header>

                <div class="wrapper" >
                    <div class="inner" >

                        <section>
                            ';

                            if($user->is_logged_in()) {

                        echo '
                            <ul class="actions" style="margin-top: -1em; text-align: left">
                                <li><a href="categories.php" class="button special">Categories</a></li>
                                <li><a href="addpost.php" class="button special">Post Blog</a></li>
                                <li><a href="../blogs.php" class="button special">All blogs</a></li>
                            </ul>';

                            }

                        echo '

                            <p>Welcome to the administration section! Please be careful when deleting posts, theres no going back. If you are unsure, make sure to ask me first, thanks!</p>

                            <div class="table-wrapper">
                                <table class="alt">
                                    <tbody>
                                        <tr>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Action</th>';

                                            if($user->is_user_admin()){
                                                echo '<th>Created by</th>';
                                            }

                                echo ' </tr>';

                                        try{

                                            // Get each blog, and add it to the table
                                            $stmt = $db->query('SELECT postID, postTitle, postSlug, postDate, postMember FROM blog_posts ORDER BY postID DESC');
                                            while($row = $stmt->fetch()){

                                                // Separate rows based on who created the blog, and roles
                                                if($user->is_user_admin() || $_SESSION['username'] == $row['postMember'])  {

                                                    echo '
                                                    <tr>
                                                    <td> <a href="../viewpost.php?id='.$row['postSlug'].'">'.$row['postTitle'].'</a></td>
                                                    <td>' . date('jS M Y', strtotime($row['postDate'])) . '</td>';
                                                    ?>

                                                    <td>
                                                        <a href="editpost.php?id=<?php echo $row['postID']; ?>">Edit</a>
                                                        |
                                                        <a href="javascript:delPost('<?php echo $row['postID']; ?>','<?php echo $row['postTitle']; ?>')">Delete</a>
                                                    </td>
                                                    <?php if($user->is_user_admin() ) {?>
                                                    <td>
                                                        <?php echo $row['postMember']; ?>
                                                    </td>

                                                    <?php } ?>

                                                    <?php
                                                    echo '</tr>';
                                                }

                                            }

                                        } catch(PDOException $e){
                                            echo $e->getMessage();
                                        }

    echo '
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
        </section>
        ';

?>
<?php include_once("../includes/footer.php");

    if (isset($_GET['delPost'])) {

        $stmt = $db->prepare('SELECT postMember FROM blog_posts WHERE postID = :postID');
        $stmt->execute(array(':postID' => $_GET['delPost']));
        $row = $stmt->fetch();

        if($user->is_user_admin() ||  $_SESSION['username'] == $row['postMember']){

            $stmt = $db->prepare('DELETE FROM blog_posts WHERE postID = :postID');
            $stmt->execute(array(':postID' => $_GET['delPost']));

            //delete post categories.
            $stmt = $db->prepare('DELETE FROM blog_post_cats WHERE postID = :postID');
            $stmt->execute(array(':postID' => $_GET['delpost']));

            header('Location: adminindex.php?action=deleted');
            exit;
        }
    }

    // If the user has just registered, notify them of options.
    if (isset($_GET['action'])) {
        if($_GET['action'] == "added")
            echo '<script type="text/javascript">swal("Success!", "Your account has been registered. You are currently in your blogs dashboard. Please feel free to make your own blogs and moderate them, have fun! ", "success")</script>';
        if($_GET['action'] == "posted")
            echo '<script type="text/javascript">swal("Success!", "Your new blog post has been added successfully!", "success")</script>';
        if($_GET['action'] == "updated")
            echo '<script type="text/javascript">swal("Success!", "The details of your blog post have been updated.", "success")</script>';
    }

?>

<script language="JavaScript" type="text/javascript">
    function delPost(id, title)
    {
        swal({   title: "Are you sure you want to delete '" + title + "'",   text: "You will not be able to recover this once it is gone!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Confirm",   cancelButtonText: "Cancel",   closeOnConfirm: false,   closeOnCancel: false},
            function(isConfirm){
                if (isConfirm) {
                    swal("Deleted!", "This blog has been deleted.", "success");
                    window.location.href = 'adminindex.php?delPost=' + id;

                } else{
                    swal("Cancelled", "Your blog is safe...for now!", "error");
                }
        });
    }
</script>


