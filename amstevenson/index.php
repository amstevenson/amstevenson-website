            <?php include_once("includes/header.php"); ?>

            <!-- create the panel to store projects, then populate... -->
            <?php
            include 'classes/config.inc.php';
            include 'classes/projects/projects.php';
            $projects   = new Projects($db);

            // Get each project
            $result = array();
            $result = $projects->get_projects();

            $projects->array_shuffle($result);
            ?>

            <!-- Banner -->
            <section id="banner">
                <div class="inner">
                    <div class="logo"><span class="icon fa-book"></span></div>
                    <h2>Adam Stevenson </h2>
                    <p>Welcome to my corner of the internet. <br> Feel free to browse through my software development projects and nerdy blogs!</p>
                </div>
            </section>

            <!-- Wrapper -->
            <section id="wrapper">

                <!-- One -->
                <section id="one" class="wrapper spotlight style1">
                    <div class="inner">
                        <a href="#" class="image"><img src="images/profilepicture.jpg" alt="" /></a>
                        <div class="content">
                            <h2 class="major">Who am I?</h2>
                            <p>I am a software developer with more than three years experience under my belt. I have designed android apps, created websites for clients, and have various interesting projects
                            that have been developed in a variety of languages. Feel free to check out some of them below!</p>
                            <a id = 'aboutme' href="#" class="special" data-target = "four">Learn more</a>
                        </div>
                    </div>
                </section>

                <!-- Two -->
                <section id="two" class="wrapper alt spotlight style2">
                    <div class="inner">
                        <a href="#" class="image"><img src="images/services2.png" alt="" /></a>
                        <div class="content">
                            <h2 class="major">Services</h2>
                            <p>If you are in need of a hardworking, experienced individual who puts customer interaction and software quality above all else, look no further.
                                I always strive to add elements of uniqueness and innovation to the projects I work on. By messaging your details below, we can begin to
                            discuss creative ideas for the design and implementation of the vision you have in your mind for the specific service you are aiming to provide. This I do,
                            free of charge, so why not get in touch? You have nothing to lose.</p>
                            <a id = 'services' href="#" class="special" data-target = "footer">Get In Touch</a>
                        </div>
                    </div>
                </section>

                <!-- Three -->
                <section id="three" class="wrapper spotlight style3">
                    <div class="inner">
                        <a href="#" class="image"><img src="images/blog.png" alt=""  /></a>
                        <div class="content">
                            <h2 class="major">My blog</h2>
                            <p>If you want to have a look at some of my blogs, that are most likely related to all types of random projects that I have been working on, video games, or a mixture, feel free too!
                            If you want to leave a comment on the articles that are of interest to you, it would be most appreciated! </p>
                            <a id = "blog" href="articles.php" class="special" >Learn more</a>
                        </div>
                    </div>
                </section>

                <!-- Four -->
                <section id="four" class="wrapper alt style1">
                    <div class="inner">
                        <h2 class="major">Projects</h2>
                        <p>Ten pieces of work have been implemented through a combination of working with clients, self research/exploration and from the experiences accumulated throughout my time spent at University.
                        Please look at some of the examples below, or view them all should you have the time to do so!</p>
                        <section class="projects" id = "projects">

                            <?php

                            for($i = 0; $i < 4; $i++)
                            {
                                // Print out first four projects as a sort of template.
                                $linkUrl = "/project.php?name=".strtolower($result[$i]["project_name"]);

                                echo '<article>';
                                echo '    <a href="#" class="image"><img src="'.$result[$i]["project_main_image"].'" alt="" /></a>';
                                echo '    <h3 class="major">'.$result[$i]["project_name"].'</h3>';
                                echo '    <p>Status: '.$result[$i]["project_status"].'</p>';
                                echo '    <p>'.$result[$i]["project_description"].'</p>';
                                echo '    <a href= "'.$linkUrl.'" class="special">Learn more</a>';
                                echo '</article>';
                            }

                            ?>

                        </section>

                        <ul class="actions">
                            <li><a href="projectgallery.php" class="button">Browse All</a></li>
                        </ul>
                    </div>
                </section>

            </section>

            <!-- Footer -->
            <?php include_once("includes/footer.php"); ?>
