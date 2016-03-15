<?php

include_once('../classes/config.inc.php');

$loggedIn = $user->is_logged_in();

$pageTitle = "All Categories | AMStevenson";

// Set meta description for this page
$metaDescription = " ";

include_once('../includes/header.php');

//if not logged in redirect to login page
if(!$loggedIn){ header('Location: login.php'); }

    // Set up wrapper structure
    echo '
    <section id="wrapper">
        <header>
            <div class="inner">
                <h2>Categories - Admin</h2>
            </div>
        </header>

    <div class="wrapper" >
        <div class="inner" >';

            if($user->is_logged_in() && $user->is_user_admin()) {

                echo '
                    <ul class="actions" style="margin-top: -2em; text-align: left">
                        <li><a href="adminindex.php" class="button special">Dashboard</a></li>
                        <li><a href="addcategory.php" class="button special">Add Categories</a></li>
                        <li><a href="../catpost.php" class="button special">All Category posts</a></li>
                    </ul>
                    ';

            }

            echo '

            <div class="table-wrapper">
                <table class="alt">
                    <tbody>
                        <tr>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                        ';
                        try {
                        $stmt = $db->query('SELECT catID, catTitle, catSlug FROM blog_cats ORDER BY catTitle DESC');
                        while($row = $stmt->fetch()) {
                            echo '<tr>';
                            echo '<td>'.$row['catTitle'].'</td>';
                            ?>

                            <td>
                                <?php if($user->is_user_admin())
                                { ?>
                                    <a href="editcategory.php?id=<?php echo $row['catID'];?>">Edit</a>

                                    | <a href="javascript:delCat('<?php echo $row['catID'];?>','<?php echo $row['catSlug'];?>')">Delete</a>
                                    <?php

                                }
                                ?>
                            </td>

                            <?php
                            echo '</tr>';

                        }

                        } catch(PDOException $e) {
                            echo $e->getMessage();
                        }

                        echo '
                    </tbody>
                </table>
            </div>
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
    <script src="../js/sweetalert.min.js"></script>';

    //show message from add / edit page
    if($user->is_user_admin()) {
        if (isset($_GET['delCat'])) {

            $stmt = $db->prepare('DELETE FROM blog_cats WHERE catID = :catID');
            $stmt->execute(array(':catID' => $_GET['delCat']));

            header('Location: categories.php?action=deleted');
            exit;
        }

        // If the user has just registered, notify them of options.
        if (isset($_GET['action'])) {
            if($_GET['action'] == "added")
                echo '<script type="text/javascript">swal("Success!", "The category has been added successfully!", "success")</script>';
            if($_GET['action'] == "updated")
                echo '<script type="text/javascript">swal("Success!", "The category has been updated successfully!", "success")</script>';
        }
    }

    ?>
    <script language="JavaScript" type="text/javascript">
        function delCat(id, title)
        {


            swal({   title: "Are you sure you want to delete '" + title + "'",   text: "You will not be able to revert this decision!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Confirm",   cancelButtonText: "Cancel",   closeOnConfirm: false,   closeOnCancel: false},
                function(isConfirm){
                    if (isConfirm) {
                        swal("Deleted!", "This category has been deleted.", "success");
                        window.location.href = 'users.php?delUser=' + id;

                    } else{
                        swal("Cancelled", "Deleting the category has been cancelled.", "error");
                    }
                });
        }
    </script>
    </body>
</html>;