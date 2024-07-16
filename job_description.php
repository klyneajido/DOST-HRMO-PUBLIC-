<?php
include_once 'php_connections/db_connection.php'; // Adjust the path as necessary

// Get the job ID from the URL and validate it
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

if ($job_id > 0) {
  // SQL query to fetch job details based on job ID
  $sql = "SELECT job.position, department.name,job.place_of_assignment, job.salary, job.status, job.description, job.education_requirement, job.experience_or_training, job.duties_and_responsibilities, job.deadline
            FROM job 
            JOIN department ON job.department_id = department.department_id
            WHERE job.job_id = ?";
  $stmt = $conn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $stmt->bind_result($position, $department_name, $place_of_assignment, $salary, $status, $description, $education_requirement, $experience_or_training, $duties_and_responsibilities, $deadline);
    $stmt->fetch();
    $stmt->close();
  } else {
    // Handle query preparation error
    die("Error preparing query: " . $conn->error);
  }
} else {
  die("Invalid job ID");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
  <title>Joblist</title>
  <link rel="icon" type="image/png" href="assets/img/dost_logo.png">
  <link rel="stylesheet" type="text/css" href="assets/css/style_jobdescription_page.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/style.default.css" />
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

  </div>
  <section id="job-title">
    <div class="container">
      <h1 class="heading"><?php echo htmlspecialchars($position) ?><br><small>of <a href="#"> <?php echo htmlspecialchars($department_name) ?></a></small></h1>
      <div class="job-detail-description"><i class="fa fa-map-marker job__location"> </i><?php echo htmlspecialchars($place_of_assignment) ?>
        | <?php echo htmlspecialchars($deadline) ?> |<span class="badge featured-badge badge-success"><?php echo htmlspecialchars($status) ?></span>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <h3>About Job</h3>
          <p><?php echo htmlspecialchars($description) ?></p>
          <h3>CSC Minimum Qualifications</h3>
          <ul>
            <li>
              <h5>Education</h5>
            </li>
            <?php echo htmlspecialchars($education_requirement) ?>
            <li>
              <h5>Experience and Training</h5>
            </li>
            <?php echo htmlspecialchars($experience_or_training) ?>
          </ul>
          <h3>Duties and Responsibilities</h3>
          <ul>
            <li><?php echo htmlspecialchars($duties_and_responsibilities) ?></li>
          </ul>
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-3">
          <h4>Monthly Rate</h4>
          <p class="job-detail__company-description">Php <?php echo htmlspecialchars(number_format($salary)) ?></p>
          <div class="job-detail__apply-top"><button class="btn">
              Apply Now
            </button></div>
        </div>
      </div>
    </div>
  </section>
  <section class="mb-5">
    <div class="container mt-5 pt-4">
   <div class="row">
   <?php include("php_connections/fetch_jobs.php")?>
   </div>
  </div>
  </section>

  <?php include("footer.php") ?>
  <script src="assets/js/script_joblist_page.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>