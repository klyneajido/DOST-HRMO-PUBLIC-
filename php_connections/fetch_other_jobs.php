<?php
include_once 'db_connection.php'; // Adjust the path as necessary

// SQL query to fetch jobs data including department name
$sql = "SELECT job.job_id, job.position, department.name, job.salary, job.status
        FROM job 
        JOIN department ON job.department_id = department.department_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($job_id, $position, $department_name, $salary, $status);

// Check if there are rows fetched
if ($stmt->fetch()) {
    // If there are rows, display them
    do {
?>
<a href="job_description.php?job_id=<?php echo $job_id; ?>">

        <div class="col-lg col-md-10 col-12 mt-4 pt-2">
            <div class="card border-0 bg-light rounded shadow custom-card ">
                <div class="card-body p-4">
                    <span class="badge rounded-pill bg-primary float-md-end mb-3 mb-sm-0"><?php echo strtoupper(htmlspecialchars($status)); ?></span>
                    <h6><?php echo htmlspecialchars($position); ?></h6>
                    <div class="mt-3">
                        <span class='text-muted d-block'><a href='#' target='_blank' class='text-muted'><?php echo htmlspecialchars($department_name); ?></a></span>
                        <span class='text-muted d-block'>₱<?php echo htmlspecialchars(number_format($salary)); ?></span>
                    </div>

                </div>
            </div>
        </div><!--end col-->





        </a>
<?php
    } while ($stmt->fetch()); // Fetch next row
} else {
    // If no rows found
    echo "No jobs found.";
}
?>