<?php
include_once 'php_connections/db_connection.php'; // Adjust the path as necessary

// Function to format dates
function formatDate($date) {
    return date("F j, Y", strtotime($date));
}

// Get the job ID from the URL and validate it
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

if ($job_id > 0) {
  // SQL query to fetch job details based on job ID
  $sql = "SELECT job.job_title, department.name, job.place_of_assignment, job.salary, job.status, job.description, job.education_requirement, job.experience_or_training, job.duties_and_responsibilities, job.deadline, job.created_at
            FROM job 
            JOIN department ON job.department_id = department.department_id
            WHERE job.job_id = ?";
  $stmt = $conn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $stmt->bind_result($job_title, $department_name, $place_of_assignment, $salary, $status, $description, $education_requirement, $experience_or_training, $duties_and_responsibilities, $deadline, $created_at);
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
