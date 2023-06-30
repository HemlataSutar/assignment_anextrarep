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
    // Retrieve the email ID from the form submission
    $email = $_POST["email"];

    // Query the database to fetch the report path based on the email ID
    $stmt = $conn->prepare("SELECT report FROM user_reports WHERE email = ?");
    $stmt->execute([$email]);
    $row = $stmt->fetch();

    if ($row) {
        $reportPath = $row["report"];
        
        // Set the appropriate headers for the PDF file
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename='" . basename($reportPath) . "'");
        header("Content-Length: " . filesize($reportPath));
        
        // Output the PDF file
        readfile($reportPath);
    } else {
        echo "No health report found for the provided email ID.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Form</title>
</head>
<body>
    <h2>Admin Form</h2>
    <form  method="post">
        <label for="email">Email ID:</label>
        <input type="email" id="email" name="email" required>
        <input type="submit" value="Fetch Report">
    </form>
</body>
</html>
