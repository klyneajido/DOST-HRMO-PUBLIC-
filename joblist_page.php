<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>Joblist</title>
    <link rel="icon" type="image/png" href="assets/img/dost_logo.png">
    <link rel="stylesheet" type="text/css" href="assets/css/style_joblist_page.css" />
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
        <?php include ("navbar.php"); ?>
        <!-- End of Navbar -->
    </div>

    <section class="find-job section">
        <div class="search-job">
            <div class="container">
                <form method="GET" action="">
                    <div class="search-nner">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-xs-12">
                                <input type="text" class="form-control" name="searchInput" placeholder="Job Name"
                                    value="<?php echo isset($_GET['searchInput']) ? htmlspecialchars($_GET['searchInput']) : ''; ?>">
                            </div>
                            <div class="col-lg-5 col-md-4 col-xs-12">
                                <input type="text" class="form-control" name="locDepStat"
                                    placeholder="Location, Department, Status"
                                    value="<?php echo isset($_GET['locDepStat']) ? htmlspecialchars($_GET['locDepStat']) : ''; ?>">
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-12 button">
                                <button type="submit" class="btn col-lg-12 col-md-12 col-sm-12">Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="job-card-container container">
            <div class="single-head ">
                <div class="row d-flex justify-content-center">
                    <?php include ("php_connections/fetch_jobs_joblist_page.php"); ?>
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-12 ">
                        <div class="pagination center d-flex justify-content-center">
                            <ul class="pagination-list">
                                <?php if ($page > 1): ?>
                                <li><a href="?page=<?php echo $page - 1; ?>"><i class="fa-solid fa-angle-left"></i></a>
                                </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= ceil($totalJobs / $jobsPerPage); $i++): ?>
                                <li class="<?php echo ($i == $page) ? 'active' : ''; ?>"><a
                                        href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php endfor; ?>

                                <?php if ($page < ceil($totalJobs / $jobsPerPage)): ?>
                                <li><a href="?page=<?php echo $page + 1; ?>"><i class="fa-solid fa-angle-right"></i></a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /End Pagination -->


            </div>
        </div>
    </section>
    <!-- /End Find Job Area -->
    <div id="footer">
        <?php include("footer.php") ?>
    </div>
    <script src="assets/js/script_joblist_page.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>