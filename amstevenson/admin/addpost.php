<?php

    include_once("../classes/config.inc.php");

    // Check to see if user is logged in or out
    $loggedIn = $user->is_logged_in();

    //if not logged in redirect to login page
    if(!$loggedIn){ header('Location: login.php'); }

    $pageTitle = "Add Post | AMStevenson";

    // Set meta description for this page
    $metaDescription = "If you require a free service for blog posting, all you have to do is fill in this form. Your blog will shortly appear afterwards.";

    include_once("../includes/header.php");

    // Set up wrapper structure
    echo ' <section id="wrapper">
                        <header>
                            <div class="inner">
                                <h2>Add blog post</h2>
                            </div>
                        </header>

                        <div class="wrapper" >
                            <div class="inner" >

                                <section> ';

                                   ?>
                                    <form action="" method="post" enctype="multipart/form-data">

                                        <p><label>Title</label><br />
                                            <input type="text" name="postTitle" value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>

                                        <p><label id = postDescLabel>Description</label><br />
                                            <textarea name='postDesc' id = 'postDesc' cols='4' rows='4' maxlength="100"><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

                                        <p><label>Content</label><br />
                                            <textarea name='postCont' id = 'postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>

                                        <p><label>Blog Image (optional)</label><br />
                                            <input type = "file" name = "photoFilename" id="photoFilename" value = "Browse"></p>

                                        <p><label>Category</label><br />

                                            <?php
                                            $stmt2 = $db->query('SELECT catID, catTitle FROM blog_cats ORDER BY catTitle ASC');
                                            while($row2 = $stmt2->fetch()){

                                                $checked = "";
                                                if(isset($_POST['catID'])){
                                                    if(in_array($row2['catID'], $_POST['catID'])){
                                                        $checked="checked='checked'";
                                                    }else{
                                                        $checked = null;
                                                    }
                                                }
                                                ?> <input type="radio" name="catID" id = "<?php echo $row2['catTitle']?>" value="<?php echo $row2['catID'] ?>" <?php echo $checked ?>>
                                                    <label for="<?php echo $row2['catTitle'] ?>"><?php echo $row2['catTitle'] ?></label>


                                            <?php
                                            }
                                            ?>
                                        </p>

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
                <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
                <script>

                    tinymce.init({
                        selector: "#postCont",
                        theme: "modern",
                        plugins: [
                            "advlist autolink lists link charmap print preview anchor",
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
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"

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
    if($postTitle ==''){
        $error[] = 'Please enter the title.';
    }

    if($postDesc ==''){
        $error[] = 'Please enter the description.';
    }

    if(empty($_POST['catID'])) {
        $error[] = 'Please select the category of the blog.';
    }

    if(count($postDesc) > 255)
    {
        $error[] = 'The description can only be 255 characters or less.';
    }

    if($postCont ==''){
        $error[] = 'Please enter the content.';
    }

    if(!isset($error)) {

        try {



            if($user->is_logged_in()) {

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

                if(move_uploaded_file($tmpName, $targetPath) || empty($_POST['photoFilename']))
                {
                    // If the picture is empty, point to a default image
                    if($_FILES['photoFilename']['error'] == 4)
                        $photoName = "empty";

                    // Get the slug for this page
                    $postSlug = slug($postTitle);

                    // Insert the blog into the database
                    $stmt = $db->prepare('INSERT INTO blog_posts (postTitle, postSlug, postDesc,postCont,postDate,postMember, postImage) VALUES (:postTitle, :postSlug, :postDesc, :postCont, :postDate, :postMember, :postImage)');

                    $stmt->execute(array(
                        ':postTitle' => $postTitle,
                        ':postSlug' => $postSlug,
                        ':postDesc' => $postDesc,
                        ':postCont' => $postCont,
                        ':postDate' => date('Y-m-d H:i:s'),
                        ':postMember' => $_SESSION['username'],
                        ':postImage' => $photoName
                    ));

                    // Lastly, create a thumbnail of the image - or resize it.
                    $blog->create_thumbnail($photoName, "thumb_".$photoName, 600, 400);

                    // Get the ID of the last row that was inserted
                    $postID = $db->lastInsertId();

                    //add category
                    $stmt = $db->prepare('INSERT INTO blog_post_cats (postID, catID) VALUES (:postID,:catID)');
                    $stmt->execute(array(
                        ':postID' => $postID,
                        ':catID' => $catID
                    ));

                    //redirect to index page
                    header('Location: adminindex.php?action=posted');
                    exit;
                }
                else{
                    // The image has failed to be saved
                    echo '<script type="text/javascript">sweetAlert("Error",';
                    echo '"There has been a problem saving the image."';
                    echo ' , "error");</script>';
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