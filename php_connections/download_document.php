<?php
include("db_connection.php");

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$doc_id = intval($_GET['id']);

// Fetch document details from the database
$query = "SELECT name, content FROM documents WHERE doc_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $doc_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($file_name, $file_content);

if ($stmt->num_rows > 0) {
    $stmt->fetch();

    // Set headers to force download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($file_content));
    flush(); // Flush system output buffer
    echo $file_content;
    exit;
} else {
    die("Document not found.");
}
?>
