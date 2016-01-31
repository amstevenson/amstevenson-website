    <?php include_once("includes/header.php"); ?>


<?php
    // Database classes
    include 'classes/config.inc.php';
    include 'classes/projects/projects.php';

    // Get name
    $name = $_GET['name'];
    $name = basename($name);

    // Get each project
    $project = new Projects($db);
    $result = array();
    $result = $project->get_one_project($name);

    if(!empty($result))
    {
        // We have found a project, so unload all of the details.
        //echo var_dump($result);

        echo '
                <section id="wrapper">
						<header>
							<div class="inner">
								<h2>'.$result[0]["project_name"].'</h2>
							</div>
						</header>

                        <!-- Content -->
                        <div class="wrapper" >
                            <div class="inner" >

                                <section>
                                        <h3 class="major">Project details</h3>

                                        <span class="image left"><img src="'.$result[0]["project_main_image"].'" alt="" /></span>

                                        <div class="table-wrapper">
											<table class="alt">
												<tbody>
													<tr>
														<td>Author</td>
														<td>Adam Stevenson (addstevenson@hotmail.com)</td>
													</tr>
													<tr>
														<td>Time period</td>
														<td>'.$result[0]["project_date"].'</td>
													</tr>
													<tr>
														<td>Tags</td>
														<td>'.$result[0]["project_type"].'</td>
													</tr>
													<tr>
														<td>Status</td>
														<td> '.$result[0]["project_status"].' </td>
													</tr>
													<tr>
													    <td>Date uploaded to site</td>
													    <td>'.$result[0]["project_date_uploaded_website"].'</td>
													</tr>
												</tbody>
											</table>
										</div>

                                        <!-- Detailed information for each project goes here -->
                                        '.$result[0]["project_details"].'

                                <!-- exclude out of database -->
                                </section>

                            </div>
                        </div>

                </section>







             ';
    }
    else
    {
        // We do not have a match, so we will print out some "not found" html.
        echo '
                <section id="wrapper">
						<header>
							<div class="inner">
								<h2>Project Not Found</h2>
								<p>Thank you for your interest, but this project is in another castle!</p>
							</div>
						</header>
                </section>
             ';
    }

?>

    <!-- Footer -->
    <?php include_once("includes/footer.php"); ?>