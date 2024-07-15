<?php
include_once 'db_connection.php'; // Adjust the path as necessary

// Get search and filter parameters
$searchInput = isset($_GET['searchInput']) ? $_GET['searchInput'] : '';
$companySkillTag = isset($_GET['companySkillTag']) ? $_GET['companySkillTag'] : '';
$permanent = isset($_GET['permanent']) ? $_GET['permanent'] : '';
$cos = isset($_GET['cos']) ? $_GET['cos'] : '';

// Build query with filters
$sql = "SELECT job.job_id, job.position, department.name, job.monthlysalary, job.status, job.created_at, job.updated_at
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
$stmt->bind_result($job_id,$position, $department_name, $monthlysalary, $status, $created_at, $updated_at);

// Check if there are rows fetched
if ($stmt->fetch()) {
    // If there are rows, display them
    do {
?>
<a href="job_description.php?job_id=<?php echo $job_id; ?>">
<div class="card job-card">
    <div class="card-body p-1">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="d-flex align-items-center mb-3">
                    <h5 class="card-title mb-0 mr-2"><?php echo htmlspecialchars($position); ?></h5>
                    <span class="badge rounded-pill bg-primary"><?php echo strtoupper(htmlspecialchars($status)); ?></span>
                </div>
                <h6 class="card-subtitle text-muted"><?php echo htmlspecialchars($department_name); ?></h6>
            </div>
            <div class="text-right d-flex align-items-center">
                <a href="#" class="card-link d-none d-sm-block"><i class="far fa-bookmark h5"></i></a>
                <div class="dropdown d-sm-none">
                    <a class="dropdown-toggle" href="#" role="button" id="bookmarkDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v h5"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="bookmarkDropdown">
                        <li><a class="dropdown-item" href="#"><i class="far fa-bookmark"></i> Bookmark</a></li>
                        <!-- Add other options as needed -->
                    </ul>
                </div>
            </div>
        </div>

        <div
            class="text-right text-sm-left text-center mt-3 mt-sm-0 d-sm-flex justify-content-sm-between align-items-sm-center">
            <span class='text-muted d-block'>₱ <?php echo htmlspecialchars(number_format($monthlysalary)); ?></span>
            <p class="card-text mb-0"><small class="text-muted"><?php echo time_ago(htmlspecialchars($created_at)); ?></small></p>
        </div>
    </div>
</div>
</a>
<?php
    } while ($stmt->fetch()); // Fetch next row
} else {
    // If no rows found
    echo "No jobs found.";
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
