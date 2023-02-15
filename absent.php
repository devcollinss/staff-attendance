<?php
include '../connection.php';
if (!isset($_GET['key'])) {
    echo "Invalid input";
    exit();
}

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


$date_today = date('Y-m-d');
while($date_stmt->fetch()) {

}
if ($date === $date_today && $present !== NULL) {
    echo "<b class='error'>Already Marked for today</b>";
} else {
    $date_stmt->free_result();
    // Prepare statement
       $stmt = $conn->prepare("UPDATE staff SET present = ?, date = ? WHERE id = ?");
       $stmt->bind_param("ssi", $new_value, $date_today, $id);
   
   
       // Set parameters and execute statement
       $new_value = 0;
       $id = $_GET['key'];
       $stmt->execute();
   
       // Check for errors
       if ($stmt->error) {
           echo "Error updating data: " . $stmt->error;
       } else {
       
   
           // Prepare statement to select pay row from database
           $select_stmt = $conn->prepare("SELECT pay FROM staff WHERE id = ?");
           $select_stmt->bind_param("i", $id);
   
           // Set parameter and execute statement
           $select_stmt->execute();
   
           // Bind result variables and fetch row
           $select_stmt->bind_result($pay);
           $select_stmt->fetch();
   
           // Close select statement
           $select_stmt->close();
   
           // Subtract a number from pay
           
           // 1. Determine the number of days in the given month
           $year = date("Y");
           $month = date("m"); // February
           $num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
       
           // 2. Loop through each day in the month and check if it's a working day
           $working_days = 0;
           for ($day = 1; $day <= $num_days; $day++) {
               $timestamp = strtotime("$year-$month-$day");
               $day_of_week = date('N', $timestamp);
               if ($day_of_week >= 1 && $day_of_week <= 5) { // Monday to Friday
                   $working_days++;
               }
           }
   
           $day_pay = 10000 / $working_days;
           $new_pay = $pay - $day_pay;
           // Prepare statement to update pay row in database
           $update_stmt = $conn->prepare("UPDATE staff SET pay = ? WHERE id = ?");
           $update_stmt->bind_param("ii", $new_pay, $id);
   
           // Set parameters and execute statement
           $update_stmt->execute();
   
           // Check for errors
           if ($update_stmt->error) {
               echo "Error updating data: " . $update_stmt->error;
           } else {
               
               echo "<b class='success'>Data updated successfully</b>";
           }
           
           // Close update statement and connection
           $update_stmt->close();
   
           // 3. Return the total number of working days
       }
       $stmt->close();
}

// Close statement and connection
$conn->close();
?>