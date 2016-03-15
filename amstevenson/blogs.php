<?php

    include_once("classes/config.inc.php");

    // Check to see if user is logged in or out
    $loggedIn = $user->is_logged_in();

    $pageTitle = "All Blogs | AMStevenson";

    // Set meta description for this page
    $metaDescription = "Want to check out some interesting and quirky blogs? Here you will find many interesting articles on Computer-Science and video game related content.";

    include_once("includes/header.php");

    // Set up wrapper structure
    echo ' <section id="wrapper">
                <header>
                    <div class="inner">
                        <h2>The blog corner</h2>
                        <p>If you want to post your own blogs here, all you have to do is register : )</p>
                    </div>
                </header>';


    //
    // Loop through each post and display the title, description, date posted and a link to the full post.
    //
    $counter = 0;
    $stmt = $db->query('SELECT postID, postTitle, postSlug, postDesc, postDate, postMember, postImage FROM blog_posts ORDER BY postDate DESC');
    while($row = $stmt->fetch()){

        echo '

                <!-- Content -->
                <div class="wrapper" >

                    <div class="inner" style="padding-bottom: 20em;">

                        ';

                        if($user->is_logged_in()) {
                            if ($counter == 0) {
                                echo '<ul class="actions" style="margin-top: -1em; margin-bottom: 4em; text-align: left">
                                       <li><a href="admin/addpost.php" class="button special">Post Blog</a></li>
                                       <li><a href="admin/adminindex.php" class="button special">Dashboard</a></li>
                                  </ul>';
                            }
                            $counter++;
                        }

        echo '

                        <section class = "blog-projects" >

                                <h3 class="major"><a href="viewpost.php?id='.$row['postSlug'].'">'.$row['postTitle'].'</a><p style="float:right">Created by: '.$row['postMember'].'</p></h3>

                                '; if($row['postImage'] != "empty") {
                                    echo '
                                    <p><span class="image left"><img style="max-width: 400px; max-height: 450px" src="images/'.$row['postImage'].'" alt="" /></span><br /> Posted on '.date('jS M Y H:i:s', strtotime($row["postDate"]));
                                    echo ' in ';

                                    // Find all categories and assign them to a link
                                    $stmt2 = $db->prepare('SELECT catTitle, catSlug    FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
                                    $stmt2->execute(array(':postID' => $row['postID']));

                                    $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                    $links = array();

                                    foreach ($catRow as $cat){
                                        $links[] = "<a href='catpost.php?id=".$cat['catSlug']."'>".$cat['catTitle']."</a>";
                                    }

                                    echo implode(", ", $links);
                                    echo $row["postDesc"];
                                    echo ' </p>';
                                }

                                else {
                                    echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in ';

                                    // Find all categories - this one is without image
                                    $stmt2 = $db->prepare('SELECT catTitle, catSlug    FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
                                    $stmt2->execute(array(':postID' => $row['postID']));

                                    $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                    $links = array();

                                    foreach ($catRow as $cat){
                                        $links[] = "<a href='catpost.php?id=".$cat['catSlug']."'>".$cat['catTitle']."</a>";
                                    }

                                    echo implode(", ", $links);
                                    echo '</p><p> '.$row['postDesc'].' </p>';
                                }
                                echo '

                                <ul class="actions">
                                       <li><a href="viewpost.php?id='.$row['postSlug'].'" class="button" >Read More</a></li>
                                </ul>
                        </section>

                    </div>
                </div>

                ';

    }

    // End wrapper section
    echo '</section> ';



?>

<?php include_once("includes/footer.php"); ?>