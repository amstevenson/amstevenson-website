    <!-- create the panel to store projects, then populate... -->
    <?php
    include 'classes/config.inc.php';
    include 'classes/class/projects.php';

    // Check to see if user is logged in or out
    $loggedIn = $user->is_logged_in();

    $pageTitle = "Project Gallery | AMStevenson";

    // Set meta description for this page
    $metaDescription = "Browsing through my project gallery will give you an insight into what services I can offer you. I have experience primarilly in areas involving .Net, Android, Java, C#, C++, C and various other programming languages.";

    include_once("includes/header.php");

    $projects   = new Projects($db);

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
                    <form id="project-form" name="project-form" method="post" action="" >
                        <div class="row uniform">
                            <div class="6u 12u$(xsmall)" style="z-index: 1;">
                                <label for="search_name" class="center">Name</label>
                                <input type="text" name="search_name" id="search_name" value=""/>
                            </div>
                            <div class="12u$">
                                <label for="status" class="center">Status</label>
                                <div class="select-wrapper">
                                    <select name="status" id="status">
                                        <option value="0">-</option>
                                        <option value="1">Ongoing</option>
                                        <option value="2">Completed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="12u$">
                                <label for="category" class="center">Category</label>
                                <div class="select-wrapper">
                                    <select name="category" id="category">

                                        <option value="0">-</option>

                                        <?php

                                        $counter = 1;

                                        // Get each project category
                                        $projectCats = array();
                                        $projectCats = $projects->get_project_categories();

                                        for($i = 0; $i < count($projectCats); $i++)
                                        {
                                            echo '<option value="'.$projectCats[$i]['projCatID'].'">'.$projectCats[$i]["projCatTitle"].'</option>';
                                            $counter++;
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="12u$">
                                <label for="date" class="center">Date</label>
                                <div class="select-wrapper">
                                    <select name="date" id="date">
                                        <option value="0">-</option>
                                        <option value="1">2013</option>
                                        <option value="2">2014</option>
                                        <option value="3">2015</option>
                                        <option value="4">2016</option>
                                    </select>
                                </div>
                            </div>
                            <div class="12u$"  style="z-index: 1;">
                                <ul class="actions">
                                    <li><input type="submit" name="submit" value="Search" class="special" style="margin-top: 2em"/></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </section>

                <section class="wrapper alt style1">

                    <div class="inner alt1" >

                        <section class="projects" id = "projects" >

                        <?php

                        if(isset($_GET['status']) || isset($_GET['category']) || isset($_GET['date']) || isset($_GET['name']))  {

                            // Show elements that have been searched for
                            $isStatus = isset($_GET['status']);
                            $isCategory = isset($_GET['category']);
                            $isDate = isset($_GET['date']);
                            $isName = isset($_GET['name']);

                            // Create sql query and execute bind array
                            $counter = 0;
                            $sqlSymbol = '';

                            $sqlArray = array();

                            //$projects->array_put_to_position($sqlArray, 'test3', 1, ':test3');
                            //$sqlArray[':test3'] = 'test3';

                            $query = 'SELECT * FROM Projects WHERE ';

                            if($isStatus)
                            {
                                $query .= 'project_status = :project_status';
                                $sqlArray[':project_status'] = $_GET['status'];
                                $counter++;
                            }

                            if($isCategory)
                            {
                                if($counter != 0) $sqlSymbol = ' AND ';

                                $query .= $sqlSymbol . "project_type LIKE concat('%', :project_type ,'%')";
                                $sqlArray[':project_type'] = $_GET['category'];
                                $counter++;
                            }

                            if($isDate)
                            {
                                if($counter != 0) $sqlSymbol = ' AND ';

                                $query .= $sqlSymbol . "project_date LIKE concat('%', :project_date ,'%')";
                                $sqlArray[':project_date'] = $_GET['date'];
                                $counter++;
                            }

                            if($isName)
                            {
                                if($counter != 0) $sqlSymbol = ' AND ';

                                $query .= $sqlSymbol . "project_name LIKE concat('%', :project_name ,'%')";
                                $sqlArray[':project_name'] = $_GET['name'];
                            }

                            $projectQuery = $db->prepare($query);
                            $projectQuery->execute($sqlArray);

                            $searchProjects = $projectQuery->fetchAll(PDO::FETCH_ASSOC);

                            // Populate the projects section based on the results found
                            if($searchProjects)
                            {
                                // Show all
                                for ($i = 0; $i < count($searchProjects); $i++) {
                                    $linkUrl = "/project.php?name=" . strtolower($searchProjects[$i]["project_name"]);

                                    echo '<article>';
                                    echo '    <a href="#" class="image"><img src="' . $searchProjects[$i]["project_main_image"] . '" alt="" /></a>';
                                    echo '    <h3 class="major">' . $searchProjects[$i]["project_name"] . '</h3>';
                                    echo '    <p>Status: ' . $searchProjects[$i]["project_status"] . '</p>';
                                    echo '    <p>' . $searchProjects[$i]["project_description"] . '</p>';
                                    echo '    <a href= "' . $linkUrl . '" class="special">Learn more</a>';
                                    echo '</article>';
                                }
                            }
                            else echo '<p> Unfortunately, no projects have been found, please revise and try again! </p>';

                        }
                        else {

                            // Get each project
                            $result = array();
                            $result = $projects->get_projects();

                            // Randomise the array...for funky funky times
                            $projects->array_shuffle($result);

                            // Show all
                            for ($i = 0; $i < count($result); $i++) {
                                $linkUrl = "/project.php?name=" . strtolower($result[$i]["project_name"]);

                                echo '<article>';
                                echo '    <a href="#" class="image"><img src="' . $result[$i]["project_main_image"] . '" alt="" /></a>';
                                echo '    <h3 class="major">' . $result[$i]["project_name"] . '</h3>';
                                echo '    <p>Status: ' . $result[$i]["project_status"] . '</p>';
                                echo '    <p>' . $result[$i]["project_description"] . '</p>';
                                echo '    <a href= "' . $linkUrl . '" class="special">Learn more</a>';
                                echo '</article>';
                            }
                        }

                        ?>

                        </section>
                    </div>
                </section>
            </div>
        </div>

    </section>


    <?php

    // echo "<pre>" . print_r($_GET['status'], true) . "</pre>";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['submit'])) {

        // Get all of the get parameters for the page and add them to the URL above
        // This can be improved upon in the future I am sure. It would be better to
        // not refresh each time after all.
        // Using Javascript inner html events discloses database column names
        $_POST = array_map('stripslashes', $_POST);

        //collect form data
        extract($_POST);

        // Keep count of and extract post data to be appended to the URL Location
        // redirection
        $counter = 0;
        $symbol = "";
        $redirectLocation = "projectgallery.php?";

        // Category
        if (!empty($category)) {

            $selectedCategory = array();
            $selectedCategory = $projects->get_project_category($category);

            if (!empty($selectedCategory)) {
                $counter++;
                $redirectLocation .= 'category=' . urlencode($selectedCategory[0]['projCatTitle']) . '';
            }
        }

        // Status - 0, 1 (ongoing) and 2 (completed)
        if (!empty($status)) {

            if ($counter != 0) $symbol = "&";

            switch ($status) {

                case 0:

                    break;

                case 1:

                    $redirectLocation .= $symbol . 'status=Ongoing.';
                    $counter++;
                    break;

                case 2:

                    $redirectLocation .= $symbol . 'status=Completed.';
                    $counter++;
                    break;

                default:
                    break;
            }
        }

        // Date - 0, 1 (2013), 2 (2014), 3 (2015), 4 (2016)
        if (!empty($date)) {

            if ($counter != 0) $symbol = "&";

            switch ($date) {

                case 0:

                    break;

                case 1:

                    $redirectLocation .= $symbol . 'date=2013';
                    $counter++;
                    break;

                case 2:

                    $redirectLocation .= $symbol . 'date=2014';
                    $counter++;
                    break;

                case 3:

                    $redirectLocation .= $symbol . 'date=2015';
                    $counter++;
                    break;

                case 4:

                    $redirectLocation .= $symbol . 'date=2016';
                    $counter++;
                    break;

                default:
                    break;
            }
        }

        // Name
        if (!empty($search_name)) {
            if ($counter != 0) $symbol = "&";
            $redirectLocation .= $symbol . 'name=' . urlencode($search_name) . '';
        }

        // Use redirect url (with get headers included)
        header('Location: ' . $redirectLocation . '');
    }
    ?>

    <!-- Footer -->
    <?php include_once("includes/footer.php"); ?>
