<?php
include_once 'db_connection.php'; // Adjust the path as necessary

// Function to validate and sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Get search and filter parameters
$searchInput = isset($_GET['searchInput']) ? sanitizeInput($_GET['searchInput']) : '';
$locDepStat = isset($_GET['locDepStat']) ? sanitizeInput($_GET['locDepStat']) : '';

// Get the current page number
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$jobsPerPage = 6; // Number of jobs per page
$offset = ($page - 1) * $jobsPerPage;

// Build query with filters
$sql = "SELECT job.job_id, job.job_title, job.position_or_unit, job.description, job.place_of_assignment, department.name, job.salary, job.status, job.created_at, job.updated_at, job.deadline
        FROM job 
        JOIN department ON job.department_id = department.department_id
        WHERE 1=1";

if (!empty($searchInput)) {
    $sql .= " AND (job.job_title LIKE ? OR department.name LIKE ?)";
}
if (!empty($locDepStat)) {
    $sql .= " AND (job.place_of_assignment LIKE ? OR department.name LIKE ? OR job.status LIKE ?)";
}

// Add pagination to the query
$sql .= " ORDER BY job.updated_at DESC LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Error preparing statement: ' . $conn->error);
}

// Bind parameters
$bindParams = [];
$bindParamsTypes = '';
if (!empty($searchInput)) {
    $searchInputParam = '%' . $searchInput . '%';
    $bindParamsTypes .= 'ss';
    array_push($bindParams, $searchInputParam, $searchInputParam);
}
if (!empty($locDepStat)) {
    $locDepStatParam = '%' . $locDepStat . '%';
    $bindParamsTypes .= 'sss';
    array_push($bindParams, $locDepStatParam, $locDepStatParam, $locDepStatParam);
}
$bindParamsTypes .= 'ii';
array_push($bindParams, $jobsPerPage, $offset);

$stmt->bind_param($bindParamsTypes, ...$bindParams);

if (!$stmt->execute()) {
    die('Error executing statement: ' . $stmt->error);
}
$stmt->bind_result($job_id, $job_title, $position_or_unit, $description, $place_of_assignment, $department_name, $salary, $status, $created_at, $updated_at, $deadline);

$jobs = [];
while ($stmt->fetch()) {
    $jobs[] = [
        'job_id' => $job_id,
        'job_title' => $job_title,
        'position_or_unit' => $position_or_unit,
        'description' => $description,
        'place_of_assignment' => $place_of_assignment,
        'department_name' => $department_name,
        'salary' => $salary,
        'status' => $status,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
        'deadline' => $deadline
    ];
}
$stmt->close();

// Fetch the total number of jobs for pagination calculation
$totalJobsSql = "SELECT COUNT(*) FROM job JOIN department ON job.department_id = department.department_id WHERE 1=1";
$bindParamsTypes = ''; // Reset bind parameters types for the second query
$bindParams = []; // Reset bind parameters for the second query

if (!empty($searchInput)) {
    $totalJobsSql .= " AND (job.job_title LIKE ? OR department.name LIKE ?)";
    $searchInputParam = '%' . $searchInput . '%';
    $bindParamsTypes .= 'ss';
    array_push($bindParams, $searchInputParam, $searchInputParam);
}
if (!empty($locDepStat)) {
    $totalJobsSql .= " AND (job.place_of_assignment LIKE ? OR department.name LIKE ? OR job.status LIKE ?)";
    $locDepStatParam = '%' . $locDepStat . '%';
    $bindParamsTypes .= 'sss';
    array_push($bindParams, $locDepStatParam, $locDepStatParam, $locDepStatParam);
}

$totalJobsStmt = $conn->prepare($totalJobsSql);
if ($totalJobsStmt === false) {
    die('Error preparing statement: ' . $conn->error);
}

if (!empty($bindParams)) {
    $totalJobsStmt->bind_param($bindParamsTypes, ...$bindParams);
}
if (!$totalJobsStmt->execute()) {
    die('Error executing statement: ' . $totalJobsStmt->error);
}
$totalJobsStmt->bind_result($totalJobs);
$totalJobsStmt->fetch();
$totalJobsStmt->close();

// Display the jobs
$counter = 0;
if (count($jobs) > 0) {
    echo '<div class="row">';
    foreach ($jobs as $job) {
        if ($counter % 2 == 0 && $counter != 0) {
            echo '</div><div class="row">';
        }
        ?>

        <div class="col-lg-6 col-md-12 pt-2 card-a">
            <!-- Single Job -->
            <a class="" href="job_description.php?job_id=<?php echo htmlspecialchars($job['job_id']); ?>">
                <div class="single-job ">
                    <div class="job-content">
                        <div class="job-title row d-flex justify-content-between">
                            <h4 class="col-lg-9 col-md-9 col-sm-9"><?php echo htmlspecialchars($job['job_title']) ?>
                                <?php echo htmlspecialchars($job['position_or_unit']) ?></h4>
                            <div class="col-lg-3 col-md-3 col-sm-3 position-relative">
                                <span class="status-span font-weight-bold"><?php echo htmlspecialchars($job['status']) ?></span>
                            </div>
                        </div>
                        <ul>
                            <li><?php echo htmlspecialchars($job['department_name']) ?></li>
                            <li>₱<?php echo htmlspecialchars(thousandsCurrencyFormat($job['salary'])) ?></li>
                            <li><?php echo htmlspecialchars($job['place_of_assignment']) ?></li>
                        </ul>
                        <p class="text-secondary">Job Posted <?php echo htmlspecialchars(time_ago($job['created_at'])) ?></p>
                        <p class="text-secondary">• Due: <?php echo htmlspecialchars(formatDate($job['deadline'])) ?></p>
                    </div>
                </div>
            </a>
            <!-- End Single Job -->
        </div>
        <!--end col-->
        <?php
        $counter++;
    }
    echo '</div>';
} else {
    ?>
    <div class="col-12 d-flex justify-content-center mt-4 pt-2">
        <div class="card border-0 bg-light rounded shadow-sm">
            <div class="card-body p-4 text-center">
                <h6>No Job Opportunities Available</h6>
                <p class="text-muted mb-0">There are no job postings available.</p>
            </div>
        </div>
    </div><!--end col-->
    <?php
}
?>
<?php
// Function to display time ago

// Function to format the date
function formatDate($date) {
    return date("F j, Y", strtotime($date)); // Adjust format as needed
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
    } elseif ($time_diff < 31536000) {
        $months = round($time_diff / 2592000);
        if ($months == 1) {
            return '1 month ago';
        } else {
            return $months . ' months ago';
        }
    } else {
        $years = round($time_diff / 31536000);
        if ($years == 1) {
            return '1 year ago';
        } else {
            return $years . ' years ago';
        }
    }
}
function thousandsCurrencyFormat($num)
{
    if ($num > 1000) {
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }
    return $num;
}
?>
