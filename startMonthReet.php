<?php
// Connect to the MySQL database
include './connection.php';
// Prepare the statement that updates the data
$stmt = $conn->prepare("UPDATE staff SET pay = ?, present = ?");

// Get the current date and check if it's the start of the month
if (date('d') !== 1) {
    // Set the new value for the column
    $present = NULL;
    $pay = 10000;

    // Set the ID of the row to update

    // Bind the parameters to the statement
    $stmt->bind_param("ii", $pay, $present);

    // Execute the statement to update the data
    $stmt->execute();

    // Check for errors and close the statement and connection
    if ($stmt->error) {
        echo "Error updating data: " . $stmt->error;
    } else {
        echo "<b class='success'>Data reset successfully</b>";
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
