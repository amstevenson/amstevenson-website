<?php


    // To be used in the footer to enable comments at the bottom of the blog
    $commentType = "viewpost";

    include_once("classes/config.inc.php");

    // Check to see if user is logged in or out
    $loggedIn = $user->is_logged_in();

    $stmt = $db->prepare('SELECT postID, postSlug, postTitle, postDesc, postCont, postDate FROM blog_posts WHERE postSlug = :postSlug');
    $stmt->execute(array(':postSlug' => $_GET['id']));
    $row = $stmt->fetch();

    $pageTitle = $row['postTitle']. " | AMStevenson blogs";

    // Meta description - for viewing a post, have made this the post description for now
    $metaDescription = setMetaDescription($row['postDesc']);


    include_once("includes/header.php");

    // If we do not get any rows returned from the database, redirect back one page
    if($row['postID'] == '')
    {
        header('Location: ./');
        exit;
    }

    // Set up wrapper structure
    echo ' <section id="wrapper">
                        <header>
                            <div class="inner">
                                <h2>'.$row['postTitle'].'</h2>
                            </div>
                        </header>

                        <div class="wrapper" >
                            <div class="inner" >

                                <section>
                                    <p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>
                                    <p>'.$row['postCont'].'</p>
                                </section>

                                <div id="disqus_thread"></div>

                            </div>
                        </div>

                </section>
        ';

?>

        <!-- Footer -->
        <section id="footer">
            <div class="inner">
                <!-- The message that will before the user sends an email; default -->
                <h2 class="major" id="start_message_header">Get in touch</h2>
                <p id ="start_message_text">Please get in contact with me if you need any information about prices for work (website, mobile
                    or desktop development) or if you have feedback for either my projects or blogs that I have worked on.</p>

                <!-- The message that will appear after the user sends an email -->
                <div style="display:none;" id="return_message">
                    <h2><em>Thank you</em> for contacting me! I will get back to you soon! : )</h2>
                    <p>Please feel free to contact me on other forms of media too!</p>
                </div>

                <form id="contact-form" method="post" action="https://script.google.com/macros/s/AKfycbzT2Bu4UBWIgScyb1FIzflhxn66pIqQdMSHXKllwOK8JfxEubw/exec">
                    <div class="field">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" />
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" />
                    </div>
                    <div class="field">
                        <label for="message">Message</label>
                        <textarea name="message" id="message" rows="4"></textarea>
                    </div>
                    <ul class="actions">
                        <li><input type="submit" value="Send Message" /></li>
                    </ul>
                </form>
                <ul class="contact">
                    <li class="fa-home">
                        Adam Stevenson<br />
                        Plymouth<br />
                        Cornwall<br />
                        South-west England.
                    </li>
                    <li class="fa-envelope"><a href="#">AddStevenson@hotmail.com</a></li>
                    <li class="fa-skype"><a href="#">Adam.st18</a></li>
                </ul>
                <ul class="copyright">
                    <li>&copy; Adam Stevenson. All views presented are my own, and do not represent any companies I am affiliated with.</li>
                </ul>
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
        <script>
            var disqus_config = function () {
                this.page.url = "http://amstevenson.co.uk/viewpost.php?id= <?php echo $row['postSlug'] ?>"; // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = <?php echo $row['postSlug'] ?>; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };
            (function() { // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');

                s.src = '//amstevenson.disqus.com/embed.js';

                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>

    </body>

</html>

