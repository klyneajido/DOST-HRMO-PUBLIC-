<?php
include_once 'db_connection.php'; // Adjust the path as necessary

// Get search and filter parameters
$searchInput = isset($_GET['searchInput']) ? $_GET['searchInput'] : '';
$companySkillTag = isset($_GET['companySkillTag']) ? $_GET['companySkillTag'] : '';
$permanent = isset($_GET['permanent']) ? $_GET['permanent'] : '';
$cos = isset($_GET['cos']) ? $_GET['cos'] : '';

// Build query with filters
$sql = "SELECT job.job_id, job.position, job.description, job.place_of_assignment, department.name, job.salary, job.status, job.created_at, job.updated_at
        FROM job 
        JOIN department ON job.department_id = department.department_id
        WHERE 1=1";

if (!empty($searchInput)) {
    $sql .= " AND (job.position LIKE '%$searchInput%' OR department.name LIKE '%$searchInput%')";
}
if (!empty($companySkillTag)) {
    $sql .= " AND (job.company LIKE '%$companySkillTag%' OR job.skills LIKE '%$companySkillTag%' OR job.tags LIKE '%$companySkillTag%')";
}
if (!empty($permanent)) {
    $sql .= " AND job.status = 'Permanent'";
}
if (!empty($cos)) {
    $sql .= " AND job.status = 'COS'";
}

$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($job_id, $position, $description, $place_of_assignment, $department_name, $salary, $status, $created_at, $updated_at);

// Check if there are rows fetched
$counter = 0;
if ($stmt->fetch()) {
    echo '<div class="row">';
    // If there are rows, display them
    do {
        if ($counter % 2 == 0 && $counter != 0) {
            echo '</div><div class="row">';
        }
?><div class="col-lg-6 col-md-6 col-12 mt-4 pt-2 border border-warning">
<div class="card border-0 bg-light rounded shadow">
    <div class="card-body p-4">
        <span class="badge rounded-pill bg-primary float-md-end mb-3 mb-sm-0"><?php echo strtoupper(htmlspecialchars($status)); ?></span>
        <h6><?php echo htmlspecialchars($position); ?></h6>
        <div class="mt-3">
            <span class='text-muted d-block'><i class='fa fa-building' aria-hidden='true'></i> <a href='#' target='_blank' class='text-muted'><?php echo htmlspecialchars($department_name); ?></a></span>
            <span class='text-muted d-block'><i class="fa-solid fa-money-bill"></i> ₱<?php echo htmlspecialchars(number_format($salary)); ?></span>
        </div>
        <div class="mt-3">
            <a href="job_description.php?job_id=<?php echo $job_id; ?>" class="btn btn-primary">View Details</a>
        </div>
    </div>
</div>
</div><!--end col-->
<?php
        $counter++;
    } while ($stmt->fetch()); // Fetch next row
    echo '</div>';
} else {
    // If no rows found
    echo "No jobs found.";
}

// Function to display time ago
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