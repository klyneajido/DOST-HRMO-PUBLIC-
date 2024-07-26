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

    <section id="title">
        <div class="container">
            <p class="h1 header"><?php echo htmlspecialchars($job_title) ?>
                <?php echo htmlspecialchars($position_or_unit) ?><br><small>of
                    <?php echo htmlspecialchars($department_name) ?></small></p>
            <div class="header-description"><?php echo htmlspecialchars($place_of_assignment) ?>
                | Posted on <?php echo htmlspecialchars(formatDate($created_at)) ?> |<span
                    class="badge featured-badge badge-info">
                    <?php 
                if ($status == 'Permanent') {
                    echo 'Permanent:';
                } elseif ($status == 'COS') {
                    echo 'Contract  of Service';
                }
            ?>
                </span>
            </div>
        </div>
    </section>
    <div class="info-job section pb-4">
        <div class="container">
            <div class="row mb-n5">
                <!-- Job List Details Start -->
                <div class="col-lg-8 col-12">
                    <div class="info-job-2">
                        <div class="info-job-body">
                            <h6 class="mb-3"><strong>About this Role</strong></h6>
                            <p><?php echo htmlspecialchars($description)?></p>
                            <h6 class="mb-3 mt-4"><strong>CSC Minimum Qualifications</strong></h6>
                            <ul>
                                <strong>Education</strong>
                                <ul>
                                    <?php if (!empty($requirements['education'])): ?>
                                    <?php foreach ($requirements['education'] as $requirement): ?>
                                    <li><?php echo htmlspecialchars($requirement); ?></li>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <li>No educational requirements listed.</li>
                                    <?php endif; ?>
                                </ul>
                                <strong>Experience and Training</strong>
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
                            <h6 class="mb-3 mt-4"><strong>Responsibilities</strong></h6>
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
                    <div class="sidebar">
                        <!-- Sidebar (Apply Buttons) Start -->
                        <div class="sidebar-body">
                            <div class="content">
                                <div class="row justify-content-center button">
                                    <div class="col-xl-auto col-lg-12 col-sm-auto col-12 p-2 ">
                                        <?php if ($deadlinePassed): ?>
                                        <!-- Deadline has passed, button is disabled -->
                                        <button class="btn btn-secondary text-center"disabled>Expired</button>
                                        <?php else: ?>
                                        <!-- Deadline has not passed, button is enabled -->
                                        <a href="apply_page.php?job_id=<?php echo $job_id; ?>"
                                            class="d-block text-center px-4">
                                            <button class="apply-button btn btn-primary">Apply</button>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-body">
                            <div class="content">
                                <h6 class="overview-title mb-4"><strong>Job Overview</strong></h6>
                                <div class="mb-2"><strong>Posted on:</strong>
                                <?php echo htmlspecialchars(formatDate($created_at))?></div>
                                <div class="mb-2"><strong>Deadline:</strong>
                                    <?php echo htmlspecialchars(formatDate($deadline))?>, 5:00 PM</div>
                                <div class="mb-2"><strong>Employment Status:</strong>
                                    <?php echo htmlspecialchars($status)?></div>
                                <div class="mb-2"><strong>Held at:</strong>
                                    <?php echo htmlspecialchars($place_of_assignment)?></div>
                                <div class="mb-2"><strong>
                                        <?php 
                if ($status == 'Permanent') {
                    echo 'Monthly Salary:';
                } elseif ($status == 'COS') {
                    echo 'Daily Salary:';
                } else {
                    echo 'Salary:';
                }
            ?>
                                    </strong>
                                    ₱<?php echo htmlspecialchars(number_format($salary,2))?></div>
                            </div>
                        </div>

                    </div>
                </div>


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
<script>
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/job-description.js"></script>
</body>

</html>