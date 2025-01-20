<?php
// Establish a database connection
$conn = new mysqli("localhost", "root", "", "bmi_comment");

// Check if the connection is successful
if ($conn->connect_error) {
    exit("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize data from the form
    $email = $conn->real_escape_string($_POST['user']); // Matches 'user' from the HTML form
    $comments = $conn->real_escape_string($_POST['txt']); // Matches 'txt' from the HTML form

    // Use prepared statements to insert data into the database
    $stmt = $conn->prepare("INSERT INTO comments (email, comment) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $comments);

    if ($stmt->execute()) {
        // Display a success alert with the current date and redirect
        echo "<script>
                let date = new Date();
                alert('Your comment has been stored on ' + date.toLocaleString());
                window.location.href = 'contactus.html';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
