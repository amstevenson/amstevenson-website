<?php

    include_once("../classes/config.inc.php");

    // Check to see if user is logged in or out
    $loggedIn = $user->is_logged_in();

    //if not logged in redirect to login page
    if(!$loggedIn){ header('Location: adminlogin.php'); }

    $pageTitle = "Edit Post | AMStevenson";

    // Set meta description for this page
    $metaDescription = " ";

    include_once("../includes/header.php");

    // Set up wrapper structure
    echo ' <section id="wrapper">
                <header>
                    <div class="inner">
                        <h2>Edit blog post</h2>
                    </div>
                </header>

                <div class="wrapper" >
                    <div class="inner" >';

                        try {

                            $stmt = $db->prepare('SELECT postID, postTitle, postDesc, postCont FROM blog_posts WHERE postID = :postID');
                            $stmt->execute(array(':postID' => $_GET['id']));
                            $row = $stmt->fetch();

                        } catch(PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>

                        <form action='' method='post' enctype="multipart/form-data">
                            <input type='hidden' name='postID' value='<?php echo $row['postID'];?>'>

                            <p><label>Title</label><br />
                                <input type='text' name='postTitle' value='<?php echo $row['postTitle'];?>'></p>

                            <p><label id = "postDescLabel">Description</label><br />
                                <textarea name='postDesc' id = 'postDesc' cols='60' rows='10'><?php echo $row['postDesc'];?></textarea></p>

                            <p><label>Content</label><br />
                                <textarea name='postCont' id = 'postCont' cols='60' rows='10'><?php echo $row['postCont'];?></textarea></p>

                            <p><label>Blog Image (optional)</label><br />
                                <input type = "file" name = "photoFilename" id="photoFilename" value = "Browse"></p>


                            <p><label>Category</label><br />

                            <?php

                            $stmt2 = $db->query('SELECT catID, catTitle FROM blog_cats ORDER BY catTitle');
                            while($row2 = $stmt2->fetch()){

                                $stmt3 = $db->prepare('SELECT catID FROM blog_post_cats WHERE catID = :catID AND postID = :postID') ;
                                $stmt3->execute(array(':catID' => $row2['catID'], ':postID' => $row['postID']));
                                $row3 = $stmt3->fetch();

                                if($row3['catID'] == $row2['catID']){
                                    $checked = 'checked=checked';
                                } else {
                                    $checked = null;
                                }
                                ?> <input type="radio" name="catID" id = "<?php echo $row2['catTitle']?>" value="<?php echo $row2['catID'] ?>" <?php echo $checked ?>>
                                    <label for="<?php echo $row2['catTitle'] ?>"><?php echo $row2['catTitle'] ?></label> <?php

                            }

                            ?>


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
            <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
            <script>
                    tinymce.init({
                        selector: "#postCont",
                        theme: "modern",
                        plugins: [
                            "advlist autolink lists link image charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        image_advtab: true,
                        language: "en",

                        style_formats: [
                                        {title: "Bold text", inline: "b"},
                                        {title: "Red text", inline: "span", styles: {color: "#ff0000"}},
                                        {title: "Red header", block: "h1", styles: {color: "#ff0000"}},
                                        {title: "Example 1", inline: "span", classes: "example1"},
                                        {title: "Example 2", inline: "span", classes: "example2"},
                                        {title: "Table styles"},
                                        {title: "Table row 1", selector: "tr", classes: "tablerow1"}
                                    ],
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

                    });


                    // Post description (postDesc) Tinymce
                    var max_chars = 300; //max characters
                    var max_for_html = 400; //max characters for html tags
                    var allowed_keys = [8, 13, 16, 17, 18, 20, 33, 34, 35, 36, 37, 38, 39, 40, 46];
                    var chars_without_html = 0;

                    tinymce.init({
                        selector: "#postDesc",
                        theme: "modern",
                        plugins: [
                            "advlist autolink lists link image charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        image_advtab: true,
                        language: "en",

                        setup: function (ed) {
                                        ed.on("KeyDown", function (ed, evt) {
                                            chars_without_html = $.trim(tinyMCE.activeEditor.getContent().replace(/(<([^>]+)>)/ig, "")).length;
                                            chars_with_html = tinyMCE.activeEditor.getContent().length;
                                            var key = ed.keyCode;

                                            $("#chars_left").html(max_chars - chars_without_html);

                                            $("#postDescLabel").text("Description: ( Words left = " + (max_chars - chars_without_html) + " )");

                                            if (allowed_keys.indexOf(key) != -1) {
                                                alarmChars();
                                                return;
                                            }

                                            if (chars_with_html > (max_chars + max_for_html)) {
                                                ed.stopPropagation();
                                                ed.preventDefault();
                                            } else if (chars_without_html > max_chars - 1 && key != 8 && key != 46) {
                                                sweetAlert("Error", "Character limit reached for description, please revise!", "error");
                                                ed.stopPropagation();
                                                ed.preventDefault();
                                            }
                                            alarmChars();
                                        });
                                    },


                        style_formats: [
                                        {title: "Bold text", inline: "b"},
                                        {title: "Red text", inline: "span", styles: {color: "#ff0000"}},
                                        {title: "Red header", block: "h1", styles: {color: "#ff0000"}},
                                        {title: "Example 1", inline: "span", classes: "example1"},
                                        {title: "Example 2", inline: "span", classes: "example2"},
                                        {title: "Table styles"},
                                        {title: "Table row 1", selector: "tr", classes: "tablerow1"}
                                    ],
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    });

                    function alarmChars() {
                        if (chars_without_html > (max_chars - 25)) {
                            $("#postDescLabel").css("color", "red");
                        } else {
                            $("#postDescLabel").css("color", "white");
                        }
                    }
            </script>
        </body>
    </html>';

    if(isset($_POST['submit'])) {

        $_POST = array_map('stripslashes', $_POST);

        //collect form data
        extract($_POST);

        //very basic validation
        if ($postID == '') {
            $error[] = 'This post is missing a valid id!.';
        }

        if ($postTitle == '') {
            $error[] = 'Please enter the title.';
        }

        if ($postDesc == '') {
            $error[] = 'Please enter the description.';
        }

        if ($postCont == '') {
            $error[] = 'Please enter the content.';
        }

        if (!isset($error)) {


            $stmt = $db->prepare('SELECT postID, postTitle, postDesc, postCont, postMember FROM blog_posts WHERE postID = :postID');
            $stmt->execute(array(':postID' => $_GET['id']));
            $row = $stmt->fetch();

            if($user->is_user_admin() || $_SESSION['username'] == $row['postMember']) {
                try {

                    // Process the image
                    include_once("../classes/class/blog.php");
                    $blog = new blog();

                    $imagesDir = "../images/";

                    $photoName = $_FILES['photoFilename']["name"];
                    $tmpName = $_FILES['photoFilename']["tmp_name"];
                    $fileType = $_FILES['photoFilename']["type"];

                    $fullPath = $imagesDir.$photoName;

                    // Save the image to the relevant directory
                    $targetPath = $imagesDir.basename($_FILES['photoFilename']['name']);

                    if(move_uploaded_file($tmpName, $targetPath) || empty($_POST['photoFilename'])) {

                        // Determine the slug
                        $postSlug = slug($postTitle);

                        // If the picture is empty, point to a default image
                        if($_FILES['photoFilename']['error'] == 4)
                        {
                            $photoName = "empty";

                            //insert into database
                            $stmt = $db->prepare('UPDATE blog_posts SET postTitle = :postTitle, postSlug = :postSlug, postDesc = :postDesc, postCont = :postCont WHERE postID = :postID');
                            $stmt->execute(array(
                                ':postTitle' => $postTitle,
                                'postSlug' => $postSlug,
                                ':postDesc' => $postDesc,
                                ':postCont' => $postCont,
                                ':postID' => $postID
                            ));
                        }
                        else
                        {
                            //insert into database
                            $stmt = $db->prepare('UPDATE blog_posts SET postTitle = :postTitle, postSlug = :postSlug, postDesc = :postDesc, postCont = :postCont, postImage = :postImage WHERE postID = :postID');
                            $stmt->execute(array(
                                ':postTitle' => $postTitle,
                                'postSlug' => $postSlug,
                                ':postDesc' => $postDesc,
                                ':postCont' => $postCont,
                                ':postID' => $postID,
                                ':postImage' => $photoName
                            ));
                        }

                        //delete all items with the current postID
                        $stmt = $db->prepare('DELETE FROM blog_post_cats WHERE postID = :postID');
                        $stmt->execute(array(':postID' => $postID));

                        $stmt = $db->prepare('INSERT INTO blog_post_cats (postID,catID)VALUES(:postID,:catID)');
                        $stmt->execute(array(
                            ':postID' => $postID,
                            ':catID' => $catID
                        ));

                        //redirect to index page
                        header('Location: adminindex.php?action=updated');
                        exit;
                    }

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


