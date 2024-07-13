<?php
include_once 'php_connections/db_connection.php'; // Adjust the path as necessary

// Get the job ID from the URL
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

// SQL query to fetch job details based on job ID
$sql = "SELECT job.position, department.name, job.monthlysalary, job.status, job.description
        FROM job 
        JOIN department ON job.department_id = department.department_id
        WHERE job.job_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$stmt->bind_result($position, $department_name, $monthlysalary, $status, $description);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
  <title>Joblist</title>
  <link rel="icon" type="image/png" href="assets/img/dost_logo.png">
  <link rel="stylesheet" type="text/css" href="assets/css/style_jobdescription_page.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />

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
    <section id="job_description" class="container-l row px-5">
      <div class="main col-lg-8">
        <div class="container d-flex justify-content-between">
          <div class="title">
            <h3><?php echo htmlspecialchars($position); ?></h3>
          </div>
          <div class="buttons d-flex">
            <div class="apply-btn p-1">
              <button type="button" class="btn btn-primary px-5">Apply</button>
            </div>
          </div>
        </div>

        <div class="department container d-flex mb-3 ">
          <div class="title mr-3"><?php echo htmlspecialchars($department_name); ?></div>
          <div class="location d-flex justify-content-center text-center align-items-center">
            <i class="fa-solid fa-location-dot mr-2"></i>
            <p class="m-0 text-secondary">San Fernando City</p>
          </div>
        </div>
        <div class="container mt-4">
          <div class="title">
          <p class="h4">About this role</p>
          </div>
          <div class="description">
            <p><?php echo htmlspecialchars($description); ?></p>
          </div>
        </div>

        <div class="container">
          <div class="title">
          <p class="h4">Requirements</p>
          </div>
          <div class="requirements">
            <ul>
              <li>Requirement 1</li>
              <li>Requirement 2</li>
              <li>Requirement 3</li>
              <li>Requirement 4</li>
              <li>Requirement 5</li>
            </ul>
          </div>
        </div>

        <div class="container">
          <div class="title">
            <p class="h4">Responsibility</p>
          </div>
          <div class="responsibility">
            <ul>
              <li>Responsibility 1</li>
              <li>Responsibility 2</li>
              <li>Responsibility 3</li>
              <li>Responsibility 4</li>
              <li>Responsibility 5</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="more col-lg-4">
        <div class="container">
          <div class="title">
            <h4>Other Jobs</h4>
          </div>
          <div class="container">
            <div class="card job-card mb-2">
              <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start w-100">
                  <div class=" card-sam d-flex align-items-center mb-3 w-100">
                    <h6 class="card-title mb-0 mr-2">Programmer</h6>
                    <span class="badge rounded-pill bg-primary ml-auto">PERMANENT</span>
                  </div>
                </div>
                <h6 class="card-subtitle text-muted">ITSM</h6>
                <div class="text-right text-sm-left text-center mt-3 mt-sm-0 d-sm-flex justify-content-sm-between align-items-sm-center w-100">
                  <span class="text-muted d-block">₱ 100000</span>
                  <p class="card-text mb-0"><small class="text-muted"></small></p>
                </div>
              </div>
            </div>

            <div class="card job-card mb-2">
              <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start w-100">
                  <div class=" card-sam d-flex align-items-center mb-3 w-100">
                    <h6 class="card-title mb-0 mr-2">Programmer</h6>
                    <span class="badge rounded-pill bg-primary ml-auto">PERMANENT</span>
                  </div>
                </div>
                <h6 class="card-subtitle text-muted">ITSM</h6>
                <div class="text-right text-sm-left text-center mt-3 mt-sm-0 d-sm-flex justify-content-sm-between align-items-sm-center w-100">
                  <span class="text-muted d-block">₱ 100000</span>
                  <p class="card-text mb-0"><small class="text-muted"></small></p>
                </div>
              </div>
            </div>

            <div class="card job-card mb-2">
              <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start w-100">
                  <div class=" card-sam d-flex align-items-center mb-3 w-100">
                    <h6 class="card-title mb-0 mr-2">Programmer</h6>
                    <span class="badge rounded-pill bg-primary ml-auto">PERMANENT</span>
                  </div>
                </div>
                <h6 class="card-subtitle text-muted">ITSM</h6>
                <div class="text-right text-sm-left text-center mt-3 mt-sm-0 d-sm-flex justify-content-sm-between align-items-sm-center w-100">
                  <span class="text-muted d-block">₱ 100000</span>
                  <p class="card-text mb-0"><small class="text-muted"></small></p>
                </div>
              </div>
            </div>

            <div class="card job-card mb-2">
              <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start w-100">
                  <div class=" card-sam d-flex align-items-center mb-3 w-100">
                    <h6 class="card-title mb-0 mr-2">Programmer</h6>
                    <span class="badge rounded-pill bg-primary ml-auto">PERMANENT</span>
                  </div>
                </div>
                <h6 class="card-subtitle text-muted">ITSM</h6>
                <div class="text-right text-sm-left text-center mt-3 mt-sm-0 d-sm-flex justify-content-sm-between align-items-sm-center w-100">
                  <span class="text-muted d-block">₱ 100000</span>
                  <p class="card-text mb-0"><small class="text-muted"></small></p>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </section>
  </div>
  <script src="assets/js/script_joblist_page.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>