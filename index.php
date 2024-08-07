<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>Home</title>
    <link rel="icon" type="image/png" href="assets/img/dost_logo.png">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"
        rel="stylesheet" />

    <script src="https://kit.fontawesome.com/0dcd39d035.js" crossorigin="anonymous"></script>
</head>

<body class="scrollbar" id="style-5">
    <div class="force-overflow">
        <!-- Header -->
        <?php include("navbar.php"); ?>
        <!-- ? Introduction  -->
        <section id="intro">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="titles">
                            <h1>Department Of Science & Technology Region 1</h1>
                            <p>Human Resource Management Office</p>
                        </div>
                        <div class="intro-btn">
                            <button class="btn flash-slide flash-slide--blue">
                            <a href="https://region1.dost.gov.ph/">Learn More</a>    
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Empty column to create space -->
                    </div>
                </div>
            </div>
        </section>
        <!-- ? End of Introduction  -->

        <!-- Job list Section (6 items) -->
        <section id="job-list">
            <div class="container mt-5 pt-4">
                <div class="row align-items-end mb-4 pb-2">
                    <div class="col-md-8">
                        <div class="section-title text-center text-md-start">
                            <h4 class="title mb-4">Here are the latest Job Opportunities</h4>
                            <p class="text-muted mb-0 para-desc">Begin your career at DOST Region 1, where innovation
                                meets
                                opportunity. Join our dynamic team dedicated to advancing science and technology at the
                                forefront of
                                regional development.</p>
                        </div>
                    </div>

                    <div class="col-md-4 mt-4 mt-sm-0 d-none d-md-block">
                        <div class="text-center text-md-end">
                            <a href="joblist_page.php" class="text-primary">View more Jobs
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-arrow-right fea icon-sm">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php include_once 'php_connections/fetch_jobs.php'; ?>
                </div>

                <div class="col-12 mt-4 pt-2 d-block d-md-none text-center">
                    <a href="joblist_page.php" class="btn btn-primary">View more Jobs
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-arrow-right fea icon-sm">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- End of Job list Section (6 items) -->

        <div class="col-md-6">
            <!-- Empty column to create space -->
        </div>

        <!-- Announcement -->
        <section id="slider">
            <div class="container mt-5 pt-4">
                <h1 class="text-center"><b>Announcements</b></h1>
                <div class="slider" id="announcements">
                    <div class="owl-carousel">
                        <?php
            include 'php_connections/fetch_announcement.php';
            ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Site footer -->
    <div id="footer"><?php include("footer.php")?></div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>

</html>