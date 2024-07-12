<?php
include_once 'db_connection.php'; // Adjust the path as necessary

// SQL query to fetch jobs data including department name
$sql = "SELECT job.position, department.name, job.monthlysalary, job.status, job.created_at, job.updated_at
        FROM job 
        JOIN department ON job.department_id = department.department_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($position, $department_name, $monthlysalary, $status, $created_at, $updated_at);

// Check if there are rows fetched
if ($stmt->fetch()) {
    // If there are rows, display them
    do {
        ?>
       <div class="card job-card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="card-title"><?php echo htmlspecialchars($position); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($department_name); ?></h6>
                <span class="badge rounded-pill bg-primary mb-3 mb-sm-0"><?php echo strtoupper(htmlspecialchars($status)); ?></span>
            </div>
            <div class="text-right d-flex align-items-center">
                <a href="#" class="card-link d-none d-sm-block"><i class="far fa-bookmark h5"></i></a>
                <div class="dropdown d-sm-none">
                    <a class="dropdown-toggle" href="#" role="button" id="bookmarkDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v h5"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="bookmarkDropdown">
                        <li><a class="dropdown-item" href="#"><i class="far fa-bookmark"></i> Bookmark</a></li>
                        <!-- Add other options as needed -->
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-right">
            <span class='text-muted d-block'>₱ <?php echo htmlspecialchars($monthlysalary); ?></span>
            <p class="card-text"><small class="text-muted"><?php echo time_ago(htmlspecialchars($created_at)); ?></small></p>
        </div>
    </div>
</div>

        <?php
    } while ($stmt->fetch()); // Fetch next row
} else {
    // If no rows found
    echo "No jobs found.";
}
?>
<?php
function time_ago($timestamp) {
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
