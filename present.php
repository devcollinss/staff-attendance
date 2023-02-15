<?php

include './connection.php';

$ids = filter_var($_GET['key'], FILTER_SANITIZE_NUMBER_INT);
if (!$ids) {
    echo "Invalid input";
    exit();
}

$date_stmt = $conn->prepare("SELECT date, present FROM staff WHERE id = ?");
$date_stmt->bind_param("i", $ids);

if (!$date_stmt->execute()) {
    echo "Error retrieving data: " . $date_stmt->error;
    exit();
}

$date_stmt->bind_result($date, $present);

while($date_stmt->fetch()) {
    $date_today = date('Y-m-d');
    
    if ($date === $date_today && $present !== NULL) {
        echo "<b class='error'>Already marked for today</b>";
    } else {
        $date_stmt->free_result();
    
        $stmt = $conn->prepare("UPDATE staff SET present = ?, date = ? WHERE id = ?");
        $new_value = 1;
        $id = $ids;
        $stmt->bind_param("isi", $new_value, $date_today, $id);
    
        if (!$stmt->execute()) {
            echo "Error updating data: " . $stmt->error;
        } else {
            echo "<b class='success'>Data updated successfully</b>";
        }
    
        $stmt->close();
    }
    exit();
}


$date_stmt->close();
$conn->close();

?>
