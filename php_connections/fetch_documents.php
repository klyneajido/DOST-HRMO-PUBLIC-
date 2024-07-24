<?php
include_once 'db_connection.php'; // Adjust the path as necessary

$sql = "SELECT doc_id, name FROM documents";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($doc_id, $name);

$documents = [];
while ($stmt->fetch()) {
    $documents[] = ['doc_id' => $doc_id, 'name' => $name];
}

$stmt->close();
$conn->close();

// Pass $documents to the frontend
?>
