<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";

// Create a new PDO instance for database connection
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $age = $_POST["age"];
    $weight = $_POST["weight"];
    $email = $_POST["email"];

    // Upload file to the designated directory
    $uploadDir = "uploads/";
    $uploadFile = $uploadDir . basename($_FILES["report"]["name"]);
    move_uploaded_file($_FILES["report"]["tmp_name"], $uploadFile);

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO user_reports (name, age, weight, email, report) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $age, $weight, $email, $uploadFile]);

    echo "Data inserted into the database successfully.";
}
?>
