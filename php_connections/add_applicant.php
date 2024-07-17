<?php
session_start(); // Start or resume a session
include_once 'php_connections/db_connection.php'; // Adjust the path as necessary

// Define session variables
if (!isset($_SESSION['applications'])) {
    $_SESSION['applications'] = array(); // Initialize an array to store application timestamps
}

// Function to check if user has exceeded the daily application limit
function hasExceededApplicationLimit() {
    $maxApplicationsPerDay = 3;
    $currentTime = time();

    // Filter out timestamps that are older than 24 hours
    $_SESSION['applications'] = array_filter($_SESSION['applications'], function($timestamp) use ($currentTime) {
        return ($currentTime - $timestamp) < 86400; // 86400 seconds = 24 hours
    });

    // Check if number of remaining timestamps exceeds the limit
    return count($_SESSION['applications']) >= $maxApplicationsPerDay;
}

// Function to check if a file is a PDF
function isPdf($file) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE); 
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    return $mime_type === 'application/pdf';
}

// Function to handle file uploads with directory creation
function uploadFile($file, $upload_dir, $lastname, $firstname, $job_title) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        if (!isPdf($file)) {
            die("Only PDF files are allowed for " . $file['name']);
        }

        $tmp_name = $file['tmp_name'];
        $file_name = basename($file['name']);

        // Create directory based on applicant's name and job title
        $applicant_folder = $upload_dir . $lastname . '_' . $firstname . '_' . $job_title . '/';
        if (!is_dir($applicant_folder)) {
            mkdir($applicant_folder, 0755, true); // Adjust directory permissions as necessary
        }

        $upload_path = $applicant_folder . uniqid() . '_' . $file_name;

        if (move_uploaded_file($tmp_name, $upload_path)) {
            return $upload_path;
        } else {
            die("File upload failed for " . $file['name']);
        }
    } else {
        die("File upload error for " . $file['name'] . ": " . $file['error']);
    }
}

// Get the job ID from the URL and validate it
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

if ($job_id > 0) {
    // SQL query to fetch job title based on job ID
    $sql = "SELECT position FROM job WHERE job_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $job_id);
        $stmt->execute();
        $stmt->bind_result($job_title);
        if ($stmt->fetch()) {
            // Proceed with form processing
        } else {
            die("Job not found.");
        }
        $stmt->close();
    } else {
        // Handle query preparation error securely
        die("Error preparing query");
    }
} else {
    die("Invalid job ID");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user has exceeded the daily application limit
    if (hasExceededApplicationLimit()) {
        die("You have exceeded the maximum limit of applications per day.");
    }

    // Sanitize and validate inputs (example fields, adjust as per your form)
    $lastname = htmlspecialchars($_POST['lastname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $middlename = htmlspecialchars($_POST['middlename']);
    $sex = htmlspecialchars($_POST['sex']);
    $address = htmlspecialchars($_POST['address']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $contact_number = htmlspecialchars($_POST['contact_number']);
    $course = htmlspecialchars($_POST['course']);
    $years_of_experience = htmlspecialchars($_POST['years_of_experience']);
    $hours_of_training = htmlspecialchars($_POST['hours_of_training']);
    $eligibility = htmlspecialchars($_POST['eligibility']);
    $list_of_awards = htmlspecialchars($_POST['list_of_awards']);

    // Directory for file uploads
    $upload_dir = '"Users/User/OneDrive - lorma.edu/Desktop/uploads"';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true); // Adjust directory permissions as necessary
    }

    // Upload files and get their paths
    $application_letter = uploadFile($_FILES['application_letter'], $upload_dir, $lastname, $firstname, $job_title);
    $personal_data_sheet = uploadFile($_FILES['pds'], $upload_dir, $lastname, $firstname, $job_title);
    $performance_rating = isset($_FILES['performance_rating']) ? uploadFile($_FILES['performance_rating'], $upload_dir, $lastname, $firstname, $job_title) : null;
    $eligibility_rating_license = uploadFile($_FILES['certificate_eligibility'], $upload_dir, $lastname, $firstname, $job_title);
    $transcript_of_records = uploadFile($_FILES['transcript_records'], $upload_dir, $lastname, $firstname, $job_title);
    $certificate_of_employment = uploadFile($_FILES['certificate_employment'], $upload_dir, $lastname, $firstname, $job_title);
    $proof_of_ratings_seminars = isset($_FILES['trainings_seminars']) ? uploadFile($_FILES['trainings_seminars'], $upload_dir, $lastname, $firstname, $job_title) : null;
    $proof_of_rewards = isset($_FILES['awards']) ? uploadFile($_FILES['awards'], $upload_dir, $lastname, $firstname, $job_title) : null;

    // Prepare SQL statement using a prepared statement
    $sql = "INSERT INTO applicants (lastname, firstname, middlename, sex, address, email, contact_number, course, years_of_experience, hours_of_training, eligibility, list_of_awards, application_letter, personal_data_sheet, performance_rating, eligibility_rating_license, transcript_of_records, certificate_of_employment, proof_of_ratings_seminars, proof_of_rewards, job_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters securely
        $stmt->bind_param("ssssssssssssssssssssi", $lastname, $firstname, $middlename, $sex, $address, $email, $contact_number, $course, $years_of_experience, $hours_of_training, $eligibility, $list_of_awards, $application_letter, $personal_data_sheet, $performance_rating, $eligibility_rating_license, $transcript_of_records, $certificate_of_employment, $proof_of_ratings_seminars, $proof_of_rewards, $job_id);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Application submitted successfully.";
            // Redirect or display success message
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>
