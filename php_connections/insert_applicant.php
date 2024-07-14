<?php
include_once 'php_connections/db_connection.php'; // Adjust the path as necessary

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs (add more validation as needed)
    $lastname = htmlspecialchars($_POST['lastname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $middlename = htmlspecialchars($_POST['middlename']);
    $sex = htmlspecialchars($_POST['sex']);
    $address = htmlspecialchars($_POST['address']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $contact_number = htmlspecialchars($_POST['contact_number']);

    // Prepare SQL statement using a prepared statement
    $sql = "INSERT INTO applicants (lastname, firstname, middlename, sex, address, email, contact_number) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sssssss", $lastname, $firstname, $middlename, $sex, $address, $email, $contact_number);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Application submitted successfully.";
            // Redirect or display success message
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
