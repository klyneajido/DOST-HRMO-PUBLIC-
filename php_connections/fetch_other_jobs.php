<?php
include_once 'db_connection.php'; // Adjust the path as necessary

// Get the current job ID from the query parameters
$current_job_id = isset($_GET['job_id']) ? (int)$_GET['job_id'] : 0;

// SQL query to fetch other jobs excluding the current job
$sql = "SELECT job.job_id, job.job_title, department.name, job.salary, job.status
        FROM job 
        JOIN department ON job.department_id = department.department_id
        WHERE job.job_id != ?
        LIMIT 6";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $current_job_id);
$stmt->execute();
$stmt->bind_result($job_id, $job_title, $department_name, $salary, $status);

// Check if there are rows fetched
if ($stmt->fetch()) {
    do {
?>
        <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
            <div class="card border-0 bg-light rounded shadow">
                <div class="card-body p-4">
                    <span class="status-badge badge rounded-pill float-md-end mb-3 mb-sm-0"><?php echo strtoupper(htmlspecialchars($status)); ?></span>
                    <h6><?php echo htmlspecialchars($job_title); ?></h6>
                    <div class="mt-3">
                        <span class='text-muted d-block'><i class='fa fa-building' aria-hidden='true'></i> <a href='#' target='_blank' class='text-muted'><?php echo htmlspecialchars($department_name); ?></a></span>
                        <span class='text-muted d-block'><i class="fa-solid fa-money-bill"></i> ₱<?php echo htmlspecialchars(number_format($salary)); ?></span>
                    </div>
                    <div class="mt-3">
                        <a href="job_description.php?job_id=<?php echo $job_id; ?>" class="btn btn-primary" style="background-color: rgb(0, 24, 97)">View Details</a>
                    </div>
                </div>
            </div>
        </div><!--end col-->
<?php
    } while ($stmt->fetch()); // Fetch next row
} else {
    // If no rows found
    echo "No jobs found.";
}
?>
