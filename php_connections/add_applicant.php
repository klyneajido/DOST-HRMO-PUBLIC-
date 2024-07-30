<?php
session_start();
include_once 'PHP_Connections/db_connection.php';

function handlePostSizeLimit() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postMaxSize = ini_get('post_max_size');
        $postMaxSizeBytes = convertToBytes($postMaxSize);

        if ($_SERVER['CONTENT_LENGTH'] > $postMaxSizeBytes) {
            $_SESSION['message'] = "The uploaded files exceed the maximum allowed size.";
            $_SESSION['message_type'] = "danger";
            header("Location: " . $_SERVER['PHP_SELF'] . "?job_id=" . htmlspecialchars($_GET['job_id']));
            exit();
        }
    }
}

function convertToBytes($sizeStr) {
    $sizeStr = trim($sizeStr);
    $last = strtolower($sizeStr[strlen($sizeStr) - 1]);
    switch ($last) {
        case 'g': return (int)$sizeStr * 1024 * 1024 * 1024;
        case 'm': return (int)$sizeStr * 1024 * 1024;
        case 'k': return (int)$sizeStr * 1024;
        default: return (int)$sizeStr;
    }
}

handlePostSizeLimit();

function hasExceededApplicationLimit() {
    $maxApplicationsPerDay = 3;
    $currentTime = time();

    if (!isset($_SESSION['applications'])) {
        $_SESSION['applications'] = [];
    }

    $_SESSION['applications'] = array_filter($_SESSION['applications'], function($timestamp) use ($currentTime) {
        return ($currentTime - $timestamp) < 86400;
    });

    return count($_SESSION['applications']) >= $maxApplicationsPerDay;
}

function isPdf($file) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE); 
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    return $mime_type === 'application/pdf';
}

function getFieldName($key) {
    $fieldNames = [
        'application_letter' => 'Application Letter',
        'pds' => 'Personal Data Sheet',
        'performance_rating' => 'Performance Rating',
        'certificate_eligibility' => 'Certificate of Eligibility',
        'transcript_records' => 'Transcript of Records',
        'certificate_of_employment' => 'Certificate of Employment',
        'trainings_seminars' => 'Trainings and Seminars',
        'awards' => 'Awards'
    ];

    return isset($fieldNames[$key]) ? $fieldNames[$key] : ucfirst(str_replace('_', ' ', $key));
}
function validateAndGetFileContent($file, $fieldName, $isOptional = false) {
    static $pdfErrorDisplayed = false; // Track if PDF error has been shown

    $errors = [];
    $maxSize = 5 * 1024 * 1024; // 5MB in bytes

    if ($file['error'] === UPLOAD_ERR_OK) {
        if (!isPdf($file)) {
            if (!$pdfErrorDisplayed) {
                $errors[] = "You can only upload PDF files.";
                $pdfErrorDisplayed = true; // Mark PDF error as shown
            }
        }

        if ($file['size'] > $maxSize) {
            $errors[] = "File must be 5MB or smaller.";
        }

        if (empty($errors)) {
            return [file_get_contents($file['tmp_name']), []];
        } else {
            return [null, $errors];
        }
    } elseif ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
        return [null, ["File size exceeds the maximum allowed size."]];
    } elseif ($file['error'] === UPLOAD_ERR_NO_FILE && $isOptional) {
        return [null, []];
    } else {
        return [null, ["An error occurred while uploading the file."]];
    }
}


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
            $_SESSION['message'] = "Job not found.";
            $_SESSION['message_type'] = "danger";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error preparing query.";
        $_SESSION['message_type'] = "danger";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
} else {
    $_SESSION['message'] = "Invalid job ID.";
    $_SESSION['message_type'] = "danger";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    if (hasExceededApplicationLimit()) {
        $_SESSION['message'] = "You have exceeded the maximum limit of applications per day.";
        $_SESSION['message_type'] = "danger";
        header("Location: " . $_SERVER['PHP_SELF'] . "?job_id=" . htmlspecialchars($_GET['job_id']));
        exit();
    }

    $requiredFields = ['lastname', 'firstname', 'address', 'email', 'contact_number', 'course', 'years_of_experience', 'hours_of_training', 'eligibility'];
    $missingFields = [];

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            $missingFields[] = ucfirst(str_replace('_', ' ', $field));
        }
    }
    if (!empty($missingFields)) {
        $_SESSION['message'] = "Please fill in the following required fields: " . implode(', ', $missingFields) . ".";
        $_SESSION['message_type'] = "danger";
        header("Location: " . $_SERVER['PHP_SELF'] . "?job_id=" . htmlspecialchars($_GET['job_id']));
        exit();
    }

    $lastname = htmlspecialchars($_POST['lastname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $middlename = htmlspecialchars($_POST['middlename']);
    $sex = isset($_POST['sex']) ? htmlspecialchars($_POST['sex']) : ''; 
    $address = htmlspecialchars($_POST['address']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $contact_number = htmlspecialchars($_POST['contact_number']);
    $course = htmlspecialchars($_POST['course']);
    $years_of_experience = isset($_POST['years_of_experience']) ? htmlspecialchars($_POST['years_of_experience']) : '0';
    $hours_of_training = isset($_POST['hours_of_training']) ? htmlspecialchars($_POST['hours_of_training']) : '0';
    $eligibility = htmlspecialchars($_POST['eligibility']);
    $list_of_awards = htmlspecialchars($_POST['list_of_awards']);
    $status = "Shortlisted";

    $files = [
        'application_letter' => $_FILES['application_letter'],
        'pds' => $_FILES['pds'],
        'performance_rating' => $_FILES['performance_rating'],
        'certificate_eligibility' => $_FILES['certificate_eligibility'],
        'transcript_records' => $_FILES['transcript_records'],
        'certificate_of_employment' => $_FILES['certificate_of_employment'],
        'trainings_seminars' => $_FILES['trainings_seminars'],
        'awards' => $_FILES['awards']
    ];

    $fileContents = [];
    $errors = [];
    foreach ($files as $key => $file) {
        $isOptional = ($key === 'performance_rating' || $key === 'awards');
        $fieldName = getFieldName($key);
        list($content, $fileErrors) = validateAndGetFileContent($file, $fieldName, $isOptional);
        if ($content === null) {
            $errors = array_merge($errors, $fileErrors);
        } else {
            $fileContents[$key] = $content;
        }
    }

    if (!empty($errors)) {
        $_SESSION['message'] = implode('<br>', $errors);
        $_SESSION['message_type'] = "danger";
        header("Location: " . $_SERVER['PHP_SELF'] . "?job_id=" . htmlspecialchars($_GET['job_id']));
        exit();
    }

    $sql = "INSERT INTO applicants (
        job_title, position_or_unit, lastname, firstname, middlename, sex, address, email, contact_number, course, years_of_experience, hours_of_training, eligibility, list_of_awards, status, 
        application_letter, personal_data_sheet, performance_rating, eligibility_rating_license, transcript_of_records, certificate_of_employment, proof_of_trainings_seminars, proof_of_rewards, 
        job_id, application_date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $application_letter = $fileContents['application_letter'] ?? null;
        $pds = $fileContents['pds'] ?? null;
        $performance_rating = $fileContents['performance_rating'] ?? null;
        $certificate_eligibility = $fileContents['certificate_eligibility'] ?? null;
        $transcript_records = $fileContents['transcript_records'] ?? null;
        $certificate_of_employment = $fileContents['certificate_of_employment'] ?? null;
        $trainings_seminars = $fileContents['trainings_seminars'] ?? null;
        $awards = $fileContents['awards'] ?? null;

        $stmt->bind_param(
            "sssssssssssssssssssssssi",
            $job_title, $position_or_unit, $lastname, $firstname, $middlename, $sex, $address, $email, $contact_number, $course, $years_of_experience, $hours_of_training, $eligibility, $list_of_awards, $status,
            $application_letter,
            $pds,
            $performance_rating,
            $certificate_eligibility,
            $transcript_records,
            $certificate_of_employment,
            $trainings_seminars,
            $awards,
            $job_id
        );

        if ($stmt->execute()) {
            $_SESSION['applications'][] = time();
            $_SESSION['message'] = "Application submitted successfully.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Application submission failed.";
            $_SESSION['message_type'] = "danger";
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Error preparing statement.";
        $_SESSION['message_type'] = "danger";
    }

    header("Location: " . $_SERVER['PHP_SELF'] . "?job_id=" . htmlspecialchars($_GET['job_id']));
    exit();
}
?>
