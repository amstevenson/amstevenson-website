<?php

    include_once("../classes/config.inc.php");

    // Check to see if user is logged in or out
    $loggedIn = $user->is_logged_in();

    //if not logged in redirect to login page
    if(!$loggedIn){ header('Location: login.php'); }

    $pageTitle = "Users | AMStevenson";

    // Set meta description for this page
    $metaDescription = " ";

    include_once("../includes/header.php");

    // Set up wrapper structure
    echo ' <section id="wrapper">
                    <header>
                        <div class="inner">
                            <h2>Users</h2>
                        </div>
                    </header>

                    <div class="wrapper" >
                        <div class="inner" >

                            <p>This page is for admins only, to moderate users. Before deleting any user for misconduct, make sure to contact me first, thanks : )</p>

                            <div class="table-wrapper">
                                <table class="alt">
                                    <tbody>
                                        <tr>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Functions</th>
                                        </tr>
                        ';

                        $stmt = $db->query('SELECT memberID, username, email, role FROM blog_members ORDER BY username');
                        while($row = $stmt->fetch()) {
                            echo '<tr>';
                            echo '<td>'.$row['username'].'</td>';
                            echo '<td>'.$row['email'].'</td>';
                            ?>

                            <td>
                                <?php if($user->is_user_admin())
                                { ?>
                                    <a href="edituser.php?id=<?php echo $row['memberID'];?>">Edit</a>
                                    <?php if($row['memberID'] != 1){?>
                                        | <a href="javascript:delUser('<?php echo $row['memberID'];?>','<?php echo $row['username'];?>')">Delete</a>
                                    <?php } ?>
                                <?php } ?>
                            </td>

                            <?php
                            echo '</tr>';

                        }
?>



                        <?php
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

?>
                <script language="JavaScript" type="text/javascript">
                    function delUser(id, title)
                    {


                        swal({   title: "Are you sure you want to delete '" + title + "'",   text: "You will not be able to revert this decision!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Confirm",   cancelButtonText: "Cancel",   closeOnConfirm: false,   closeOnCancel: false},
                            function(isConfirm){
                                if (isConfirm) {
                                    swal("Deleted!", "This blog has been deleted.", "success");
                                    window.location.href = 'users.php?delUser=' + id;

                                } else{
                                    swal("Cancelled", "Deleting the user has been cancelled.", "error");
                                }
                            });
                    }
                </script>
            </body>
        </html>;

<?php

    // If the user is an admin, perform the method to delete the user from the database
    if($user->is_user_admin()) {
        if (isset($_GET['delUser'])) {

            //if user id is 1 ignore
            if ($_GET['delUser'] != '1') {

                $stmt = $db->prepare('DELETE FROM blog_members WHERE memberID = :memberID');
                $stmt->execute(array(':memberID' => $_GET['delUser']));

                header('Location: users.php?action=deleted');
                exit;

            }
        }
    }

?>



