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
    $sql = "SELECT job.job_title, department.name AS department_name, job.place_of_assignment, job.salary, job.status, job.description, job.deadline, job.created_at
            FROM job 
            JOIN department ON job.department_id = department.department_id
            WHERE job.job_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $job_id);
        $stmt->execute();
        $stmt->bind_result($job_title, $department_name, $place_of_assignment, $salary, $status, $description, $deadline, $created_at);
        $stmt->fetch();
        $stmt->close();
    } else {
        // Handle query preparation error
        die("Error preparing query: " . $conn->error);
    }

    // Fetch requirements
    $requirements_sql = "SELECT requirement_text, requirement_type FROM job_requirements WHERE job_id = ?";
    $requirements_stmt = $conn->prepare($requirements_sql);
    if ($requirements_stmt) {
        $requirements_stmt->bind_param("i", $job_id);
        $requirements_stmt->execute();
        $requirements_result = $requirements_stmt->get_result();
        $requirements = [];
        while ($row = $requirements_result->fetch_assoc()) {
            $requirements[$row['requirement_type']][] = $row['requirement_text'];
        }
        $requirements_stmt->close();
    } else {
        // Handle query preparation error
        die("Error preparing query: " . $conn->error);
    }
} else {
    die("Invalid job ID");
}

function time_ago($timestamp)
{
    $current_time = time();
    $timestamp = strtotime($timestamp);
    $time_diff = $current_time - $timestamp;

    if ($time_diff < 60) {
        return 'Just now';
    } elseif ($time_diff < 3600) {
        $minutes = round($time_diff / 60);
        if ($minutes == 1) {
            return '1 minute ago';
        } else {
            return $minutes . ' minutes ago';
        }
    } elseif ($time_diff < 86400) {
        $hours = round($time_diff / 3600);
        if ($hours == 1) {
            return '1 hour ago';
        } else {
            return $hours . ' hours ago';
        }
    } elseif ($time_diff < 2592000) {
        $days = round($time_diff / 86400);
        if ($days == 1) {
            return '1 day ago';
        } else {
            return $days . ' days ago';
        }
    } else {
        return date('F j, Y', $timestamp);
    }
}
?>
