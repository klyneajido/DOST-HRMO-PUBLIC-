<?php
session_start();
include_once 'PHP_Connections/db_connection.php';

// Function to check if user has exceeded the daily application limit
function hasExceededApplicationLimit() {
    $maxApplicationsPerDay = 3;
    $currentTime = time();

    // Initialize session variable if not set
    if (!isset($_SESSION['applications'])) {
        $_SESSION['applications'] = [];
    }

    $_SESSION['applications'] = array_filter($_SESSION['applications'], function($timestamp) use ($currentTime) {
        return ($currentTime - $timestamp) < 86400;
    });

    return count($_SESSION['applications']) >= $maxApplicationsPerDay;
}

// Function to check if a file is a PDF
function isPdf($file) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE); 
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    return $mime_type === 'application/pdf';
}

// Function to handle file uploads and get file content
function getFileContent($file) {
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        if (!isPdf($file)) {
            die("Only PDF files are allowed for " . $file['name']);
        }

        if ($file['size'] > 5 * 1024 * 1024) { // 5MB limit
            die("File size exceeds the maximum limit of 5MB for " . $file['name']);
        }

        return file_get_contents($file['tmp_name']);
    } else {
        return null; // Return null if file is not uploaded or there's an error
    }
}

// Get the job ID from the URL and validate it
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 17;
$job_title = '';
$position_or_unit = '';

if ($job_id > 0) {
    $sql = "SELECT job_title, position_or_unit FROM job WHERE job_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $job_id);
        $stmt->execute();
        $stmt->bind_result($job_title, $position_or_unit);
        if (!$stmt->fetch()) {
            die("Job not found.");
        }
        $stmt->close();
    } else {
        die("Error preparing query");
    }
} else {
    die("Invalid job ID");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (hasExceededApplicationLimit()) {
        die("You have exceeded the maximum limit of applications per day.");
    }

    $lastname = htmlspecialchars($_POST['lastname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $middlename = htmlspecialchars($_POST['middlename']);
    $sex = isset($_POST['sex']) ? htmlspecialchars($_POST['sex']) : ''; // Handle optional field
    $address = htmlspecialchars($_POST['address']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $contact_number = htmlspecialchars($_POST['contact_number']);
    $course = htmlspecialchars($_POST['course']);
    $years_of_experience = htmlspecialchars($_POST['years_of_experience']);
    $hours_of_training = htmlspecialchars($_POST['hours_of_training']);
    $eligibility = htmlspecialchars($_POST['eligibility']);
    $list_of_awards = htmlspecialchars($_POST['list_of_awards']);
    $status = "Shortlisted";

    // Get file contents, handle optional files
    $application_letter = isset($_FILES['application_letter']) ? getFileContent($_FILES['application_letter']) : null;
    $personal_data_sheet = isset($_FILES['pds']) ? getFileContent($_FILES['pds']) : null;
    $performance_rating = isset($_FILES['performance_rating']) ? getFileContent($_FILES['performance_rating']) : null;
    $eligibility_rating_license = isset($_FILES['certificate_eligibility']) ? getFileContent($_FILES['certificate_eligibility']) : null;
    $transcript_of_records = isset($_FILES['transcript_records']) ? getFileContent($_FILES['transcript_records']) : null;
    $certificate_of_employment = isset($_FILES['certificate_of_employment']) ? getFileContent($_FILES['certificate_of_employment']) : null;
    $proof_of_trainings_seminars = isset($_FILES['trainings_seminars']) ? getFileContent($_FILES['trainings_seminars']) : null;
    $proof_of_rewards = isset($_FILES['awards']) ? getFileContent($_FILES['awards']) : null;

    // Prepare SQL statement using a prepared statement
    $sql = "INSERT INTO applicants (
        job_title, position_or_unit, lastname, firstname, middlename, sex, address, email, contact_number, course, years_of_experience, hours_of_training, eligibility, list_of_awards, status, 
        application_letter, personal_data_sheet, performance_rating, eligibility_rating_license, transcript_of_records, certificate_of_employment, proof_of_trainings_seminars, proof_of_rewards, 
        job_id, application_date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, NOW())";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters securely
        $stmt->bind_param(
            "ssssssssssssssssssssssbi", // Adjusted to match the number of parameters and types
            $job_title, $position_or_unit, $lastname, $firstname, $middlename, $sex, $address, $email, $contact_number, $course, $years_of_experience, $hours_of_training, $eligibility, $list_of_awards, $status,
            $application_letter, $personal_data_sheet, $performance_rating, $eligibility_rating_license, $transcript_of_records, $certificate_of_employment, $proof_of_trainings_seminars, $proof_of_rewards, $job_id
        );
    

        // Execute the statement
        if ($stmt->execute()) {
            // Log the application timestamp
            $_SESSION['applications'][] = time();
            echo "Application submitted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$conn->close();
?>
