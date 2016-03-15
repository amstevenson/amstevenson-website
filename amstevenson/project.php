<?php
    // Database classes
    include 'classes/config.inc.php';
    include 'classes/class/projects.php';

    // Check to see if user is logged in or out
    $loggedIn = $user->is_logged_in();

    // Get name
    $name = $_GET['name'];
    $name = basename($name);

    // Get each project
    $project = new Projects($db);
    $result = array();
    $result = $project->get_one_project($name);

    $pageTitle = "Selected Project | ".$result[0]['project_name'];

    // Set meta description for the page
    $metaDescription = substr($result[0]['project_description'], 0, 155);

    // Header for page
    include_once("includes/header.php");

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
<!--<p><span class="image left"><img src="images/pic01.jpg" alt="" /></span>Morbi mattis mi consectetur tortor elementum, varius pellentesque velit convallis. Aenean tincidunt lectus auctor mauris maximus, ac scelerisque ipsum tempor. Duis vulputate ex et ex tincidunt, quis lacinia velit aliquet. Duis non efficitur nisi, id malesuada justo. Maecenas sagittis felis ac sagittis semper. Curabitur purus leo, tempus sed finibus eget, fringilla quis risus. Maecenas et lorem quis sem varius sagittis et a est. Maecenas iaculis iaculis sem. Donec vel dolor at arcu tincidunt bibendum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce ut aliquet justo. Donec id neque ipsum. Integer eget ultricies odio. Nam vel ex a orci fringilla tincidunt. Aliquam eleifend ligula non velit accumsan cursus. Etiam ut gravida sapien. Morbi mattis mi consectetur tortor elementum, varius pellentesque velit convallis. Aenean tincidunt lectus auctor mauris maximus, ac scelerisque ipsum tempor. Duis vulputate ex et ex tincidunt, quis lacinia velit aliquet. Duis non efficitur nisi, id malesuada justo. Maecenas sagittis felis ac sagittis semper. Curabitur purus leo, tempus sed finibus eget, fringilla quis risus. Maecenas et lorem quis sem varius sagittis et a est. Maecenas iaculis iaculis sem. Donec vel dolor at arcu tincidunt bibendum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce ut aliquet justo. Donec id neque ipsum. Integer eget ultricies odio. Nam vel ex a orci fringilla tincidunt. Aliquam eleifend ligula non velit accumsan cursus. Etiam ut gravida sapien.</p>
										-->
                                        <!-- Detailed information for each project goes here -->
                                        '.$result[0]["project_details"].'







                                <!-- exclude out of database -->
                                    <div id="disqus_thread"></div>
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
                    this.page.url = "http://amstevenson.co.uk/project.php?name=<?php echo $_GET['name'] ?>"; // Replace PAGE_URL with your page's canonical URL variable
                    this.page.identifier = <?php echo str_replace(' ', '', $_GET['name']); ?>; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
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