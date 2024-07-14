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
        <section id="job-list">

            <div class="container-fluid hero">

                <div class="container-wide">
                    <h1 class="mb-4">Find Your Dream Job Here</h1>
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                        <div class="search-bar d-flex">
    <input type="text" id="searchInput" name="searchInput" class="form-control" placeholder="Job title or keyword">
    <button class="btn btn-primary ml-2" onclick="applyFilters()">Search</button>
</div>

<div class="container-wide mt-5">
    <div class="row">
        <div class="col-lg-3">
            <h5>Filter</h5>
            <input type="text" id="companySkillTag" name="companySkillTag" class="form-control mb-3" placeholder="Company, skill, tag...">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permanent" id="permanent">
                <label class="form-check-label" for="permanent">
                    Permanent
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="cos" id="cos">
                <label class="form-check-label" for="cos">
                    COS
                </label>
            </div>
        </div>
        <div class="col-lg-9" id="job-list-container">
            <!-- Job cards will be displayed here -->
            <?php include("./php_connections/fetch_jobs_joblist_page.php"); ?>
        </div>
    </div>
</div>

        </section>
    </div>
    <?php include("footer.php") ?>
    <script src="assets/js/script_joblist_page.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>