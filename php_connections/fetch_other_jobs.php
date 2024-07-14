<?php
include_once 'db_connection.php'; // Adjust the path as necessary

// SQL query to fetch jobs data including department name
$sql = "SELECT job.job_id, job.position, department.name, job.monthlysalary, job.status
        FROM job 
        JOIN department ON job.department_id = department.department_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($job_id, $position, $department_name, $monthlysalary, $status);

// Check if there are rows fetched
if ($stmt->fetch()) {
    // If there are rows, display them
    do {
?>
        <div class="card job-card mb-2">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start w-100">
                    <div class=" card-sam d-flex align-items-center mb-3 w-100">
                        <h6 class="card-title mb-0 mr-2"><?php echo htmlspecialchars($position); ?></h6>
                        <span class="badge rounded-pill bg-primary ml-auto"><?php echo strtoupper(htmlspecialchars($status)); ?></span>
                    </div>
                </div>
                <h6 class="card-subtitle text-muted"><?php echo htmlspecialchars($department_name); ?></h6>
                <div class="text-right text-sm-left text-center mt-3 mt-sm-0 d-sm-flex justify-content-sm-between align-items-sm-center w-100">
                    <span class="text-muted d-block">₱<?php echo htmlspecialchars($monthlysalary); ?></span>
                    <p class="card-text mb-0"><small class="text-muted"></small></p>
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