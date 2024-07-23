<?php include("php_connections/fetch_job_description.php")?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>Joblist</title>
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
    <link rel="icon" type="image/png" href="assets/img/dost_logo.png">
    <link rel="stylesheet" type="text/css" href="assets/css/style_jobdescription_page.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.default.css" />
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
        <!-- Navbar -->
        <?php include("navbar.php"); ?>
        <!-- End of Navbar -->
        <div class="col-md-6">
            <!-- Empty column to create space -->
        </div>
    </div>

    <section id="job-title">
        <div class="container">
            <h1 class="heading"><?php echo htmlspecialchars($job_title) ?><br><small>of
                    <?php echo htmlspecialchars($department_name) ?></small></h1>
            <div class="job-detail-description"><i class="fa fa-map-marker job__location">
                </i><?php echo htmlspecialchars($place_of_assignment) ?>
                | Posted on <?php echo htmlspecialchars(formatDate($deadline)) ?> |<span
                    class="badge featured-badge badge-info"><?php echo htmlspecialchars($status) ?></span>
            </div>
        </div>
    </section>
    <!-- Start Job Details -->
    <div class="job-details section pb-5">
        <div class="container">
            <div class="row mb-n5">
                <!-- Job List Details Start -->
                <div class="col-lg-8 col-12">
                    <div class="job-details-inner">
                        <div class="job-details-body">
                            <h6 class="mb-3">About this Role</h6>
                            <p><?php echo htmlspecialchars($description)?></p>
                            <h6 class="mb-3 mt-4">CSC Minimum Qualifications</h6>
                            <ul>
                                <li>Education</li>
                                <ul>
                                    <?php if (!empty($requirements['education'])): ?>
                                    <?php foreach ($requirements['education'] as $requirement): ?>
                                    <li><?php echo htmlspecialchars($requirement); ?></li>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <li>No educational requirements listed.</li>
                                    <?php endif; ?>
                                </ul>
                                <li>Experience + Training</li>
                                <ul>
                                    <?php if (!empty($requirements['experience'])): ?>
                                    <?php foreach ($requirements['experience'] as $requirement): ?>
                                    <li><?php echo htmlspecialchars($requirement); ?></li>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <li>No experience or training requirements listed.</li>
                                    <?php endif; ?>
                                </ul>

                            </ul>
                            <h6 class="mb-3 mt-4">Responsibilities</h6>
                            <ul>
                                <?php if (!empty($requirements['duties'])): ?>
                                <?php foreach ($requirements['duties'] as $requirement): ?>
                                <li><?php echo htmlspecialchars($requirement); ?></li>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <li>No duties and responsibilities listed.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Job List Details End -->

                <!-- Job Sidebar Wrap Start -->
                <div class="col-lg-4 col-12">
                    <div class="job-details-sidebar">
                        <!-- Sidebar (Apply Buttons) Start -->
                        <div class="sidebar-widget">
                            <div class="inner">
                                <div class="row justify-content-center button">
                                    <div class="col-xl-auto col-lg-12 col-sm-auto col-12 p-2 ">
                                        <a href="apply_page.php?job_id=<?php echo $job_id; ?>"
                                            class="d-block text-center px-4 ">
                                            <button class=""> Apply
                                            </button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar (Apply Buttons) End -->
                        <!-- Sidebar (Job Overview) Start -->
                        <div class="sidebar-widget">
                            <div class="inner">
                                <h6 class="title">Job Overview</h6>
                                <ul class="job-overview list-unstyled">
                                    <li><strong>Deadline:</strong> <?php echo htmlspecialchars(formatDate($deadline))?>
                                    </li>
                                    <li><strong>Employment Status:</strong><?php echo htmlspecialchars($status)?></li>
                                    <li><strong>Job
                                            Location:</strong><?php echo htmlspecialchars($place_of_assignment)?></li>
                                    <li><strong>Salary:</strong>₱<?php echo htmlspecialchars(number_format($salary,2))?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar (Job Overview) End -->
                    </div>
                </div>
                <!-- Job Sidebar Wrap End -->

            </div>
        </div>
    </div>
    <!-- End Job Details -->
    <section class="mb-5 more-jobs">
        <div class="container mt-5 pt-4 ">
            <h3 class="text-center">Other Jobs</h3>
            <div class="row">
                <?php include("php_connections/fetch_other_jobs.php") ?>
            </div>
        </div>
    </section>

    <div id="footer">
        <?php include("footer.php") ?>
    </div>
    <script src="assets/js/script_joblist_page.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>