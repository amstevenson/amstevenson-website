<?php

include_once('classes/config.inc.php');

$loggedIn = $user->is_logged_in();

// Set meta description for this page
$pageTitle = "Post New Category | AMStevenson";
$metaDescription = " ";

include_once('includes/header.php');


$stmt = $db->prepare('SELECT catID,catTitle FROM blog_cats WHERE catSlug = :catSlug');
$stmt->execute(array(':catSlug' => $_GET['id']));
$row = $stmt->fetch();
$category = $row['catTitle'];

//if post does not exists redirect user.
if($row['catID'] == ''){
    header('Location: ./');
    exit;
}

?>

    <section id="wrapper">
    <header>
        <div class="inner">
            <h2>Blog Categories: Posts in <?php echo $category ?> </h2>
        </div>
    </header>



            <section>

                <?php
                try {
                    $counter = 0;
                    $stmt = $db->prepare('
                    SELECT
                        blog_posts.postID, blog_posts.postTitle, blog_posts.postSlug, blog_posts.postDesc, blog_posts.postImage, blog_posts.postMember, blog_posts.postDate
                    FROM
                        blog_posts,
                        blog_post_cats
                    WHERE
                         blog_posts.postID = blog_post_cats.postID
                         AND blog_post_cats.catID = :catID
                    ORDER BY
                        postID DESC
                    ');

                    $stmt->execute(array(':catID' => $row['catID']));
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

                                <section class = "blog-projects">
                                    <h3 class="major"><a href="viewpost.php?id='.$row['postSlug'].'">'.$row['postTitle'].'</a><p style="float:right">Created by: '.$row['postMember'].'</p></h3>

                                    '; if($row['postImage'] != "empty") {
                                echo '
                                        <p><span class="image left"><img style="max-width: 400px; max-height: 450px" src="images/'.$row['postImage'].'" alt="" /></span><br /> Posted on '.date('jS M Y H:i:s', strtotime($row["postDate"]));
                                echo ' in ';

                                // Find all categories and assign them to a link
                                $stmt2 = $db->prepare('SELECT catTitle, catSlug FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
                                $stmt2->execute(array(':postID' => $row['postID']));

                                $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                $links = array();

                                foreach ($catRow as $cat){
                                    $links[] = "<a href='catpost.php?id=".$cat['catSlug']."'>".$category."</a>";
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
                                    $links[] = "<a href='catpost.php?id=".$cat['catSlug']."'>".$category."</a>";
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
                        </div> ';

                    }

                } catch(PDOException $e) {
                    echo $e->getMessage();
                }

                ?>

            </section>

    </section>



<?php include_once('includes/footer.php');?>