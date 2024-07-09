<?php
include_once 'php_connections/db_connection.php'; // Adjust the path as necessary

// SQL query to fetch jobs data including department name
$sql = "SELECT job.position, department.name, job.monthlysalary 
        FROM job 
        JOIN department ON job.department_id = department.department_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($position, $department_name, $monthlysalary);

// Check if there are rows fetched
if ($stmt->fetch()) {
    // If there are rows, display them
    do {
?>
        <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
            <div class="card border-0 bg-light rounded shadow">
                <div class="card-body p-4">
                    <span class="badge rounded-pill bg-primary float-md-end mb-3 mb-sm-0">Full time</span>
                    <h6><?php echo htmlspecialchars($position); ?></h6>
                    <div class="mt-3">
                        <span class='text-muted d-block'><i class='fa fa-building' aria-hidden='true'></i> <a href='#' target='_blank' class='text-muted'><?php echo htmlspecialchars($department_name); ?></a></span>
                        <span class='text-muted d-block'><i class='fa fa-map-marker' aria-hidden='true'></i> Php <?php echo htmlspecialchars($monthlysalary); ?></span>
                    </div>
                    <div class="mt-3">
                        <a href="#" class="btn btn-primary">View Details</a>
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

$stmt->close();
$conn->close();
?>