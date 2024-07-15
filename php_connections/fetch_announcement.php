<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'db_connection.php'; // Adjust the path as necessary

// SQL query to fetch announcements data
$sql = "SELECT title, description_announcement, link, image_announcement FROM announcements";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->execute();
$stmt->bind_result($title, $description, $link, $image);

// Initialize a variable to track if any rows are fetched
$rowsFetched = false;

// Fetch and display rows
while ($stmt->fetch()) {
    $rowsFetched = true;
    ?>
   
    <div class="slider-card">
        <div class="d-flex justify-content-center align-items-center mb-4">
        <a href="<?php echo htmlspecialchars($link); ?>"target="_blank">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" alt="Announcement Image">
            </a>
        </div>
        <h5 class="mb-0 text-center"><b><?php echo htmlspecialchars($title); ?></b></h5>
        <p class="text-center p-4"><?php echo htmlspecialchars($description); ?></p>
    </div>
   
    <?php
}
if (!$rowsFetched) {
    echo "<p>No announcements found.</p>";
}

$stmt->close();
$conn->close();
?>