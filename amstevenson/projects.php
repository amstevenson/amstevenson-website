    <?php include_once("includes/header.php"); ?>

    <!-- create the panel to store projects, then populate... -->
    <?php
    include 'classes/config.inc.php';
    include 'classes/projects/projects.php';
    $projects   = new Projects($db);

    // Get each project
    $result = array();
    $result = $projects->get_tutorials();

    // Randomise the array...for funky funky times
    // $projects->array_shuffle($result);
    ?>

    <!-- Wrapper -->
    <section id="wrapper">
        <header>
            <div class="inner">
                <h2>Projects</h2>
                <p>Because they have to go somewhere else on the internet besides GitHub.</p>
            </div>
        </header>

        <!-- Content -->
        <div class="wrapper" >
            <div class="inner" >

                <p>I have endeavoured to provide a short description for each and every one. I suppose there is a combination of a multitude of personal, academic and commercial works, so if anyone wants to know more information with regards to this, feel free to ask by sending me a message.</p>
                <p> Some pieces of work could easily be expanded upon and improved to incorporate new features. If you want me to send you any of these projects, please ask! Or go to my GitHub and download them from there.</p>
                <p>In the future I will probably endeavour to add a GitHub link for each one, however there are still a few that are locked up in private repositories for one reason or another, so this will be a future plan. For now, you can simply go over to GitHub.com/amstevenson to view all the public works.</p>

                <p>Thank you for your interest in my random world of coding and - in some cases - banging my head repeatedly against a wall! </p>


                <section>
                    <form method="post" action="#" >
                        <div class="row uniform" style="display: flex; justify-content: center; align-items: center;">
                            <div class="6u 12u$(xsmall)">
                                <label for="demo-name" class="center">Name</label>
                                <input type="text" name="demo-name" id="demo-name" value="" />
                            </div>
                            <div class="12u$">
                                <label for="demo-category" class="center">Status</label>
                                <div class="select-wrapper">
                                    <select name="demo-category" id="demo-category">
                                        <option value="0">-</option>
                                        <option value="1">Manufacturing</option>
                                        <option value="2">Shipping</option>
                                        <option value="3">Administration</option>
                                        <option value="4">Human Resources</option>
                                        <option value="5">Administration</option>
                                        <option value="6">Human Resources</option>
                                    </select>
                                </div>
                            </div>
                            <div class="12u$">
                                <label for="demo-category" class="center">Type</label>
                                <div class="select-wrapper">
                                    <select name="demo-category" id="demo-category">
                                        <option value="0">-</option>
                                        <option value="1">Manufacturing</option>
                                        <option value="2">Shipping</option>
                                        <option value="3">Administration</option>
                                        <option value="4">Human Resources</option>
                                        <option value="5">Administration</option>
                                        <option value="6">Human Resources</option>
                                    </select>
                                </div>
                            </div>
                            <div class="12u$">
                                <label for="demo-category" class="center">Date</label>
                                <div class="select-wrapper">
                                    <select name="demo-category" id="demo-category">
                                        <option value="0">-</option>
                                        <option value="1">Manufacturing</option>
                                        <option value="2">Shipping</option>
                                        <option value="3">Administration</option>
                                        <option value="4">Human Resources</option>
                                        <option value="5">Administration</option>
                                        <option value="6">Human Resources</option>
                                    </select>
                                </div>
                            </div>
                            <div class="12u$">
                                <ul class="actions">
                                    <li><input type="submit" value="Search" class="special" style="margin-top: 25px" /></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </section>

                <section class="wrapper alt style1">

                    <div class="inner alt1" style="margin-top: 100px">

                        <section class="projects" id = "projects" >

                        <?php

                        for($i = 0; $i < 4; $i++)
                        {
                            // Print out first four projects as a sort of template.
                            // TODO: randomise in the future
                            echo '<article>';
                            echo '    <a href="#" class="image"><img src="'.$result[$i]["project_image"].'" alt="" /></a>';
                            echo '    <h3 class="major">'.$result[$i]["project_name"].'</h3>';
                            echo '    <p>'.$result[$i]["project_status"].'</p>';
                            echo '    <p>'.$result[$i]["project_description"].'</p>';
                            echo '    <a href="#" class="special">Learn more</a>';
                            echo '</article>';
                        }

                        ?>

                        </section>
                    </div>
                </section>
            </div>
        </div>

    </section>

    <!-- Footer -->
    <?php include_once("includes/footer.php"); ?>