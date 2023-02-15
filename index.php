<?php
include '../connection.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve data from the database
$sql = "SELECT id, name, role, pay, present FROM staff";
$stmt = $conn->prepare($sql);

// Execute the query

$stmt->execute();

// Bind the results
$stmt->bind_result($id, $name, $role, $pay, $present);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Staff Attendance</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class="table">
        <section class="table__header">
            <h1>Staff Attendance</h1>
            <div class="announcement"></div>
            <div class="input-group">
                <input type="search" placeholder="Search Staff...">
                <img src="images/search.png" alt="">
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Id</th>
                        <th> Staff Name</th>
                        <th> Role</th>
                        <th> Expected Salary </th>
                        <th> Actual Salary  </th>
                        <th> Mark for today </th>
                        <th> Attendance Status </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($stmt->fetch()) {
                        echo "<tr>";
                        echo "<td>" . $id . "</td>";
                        echo "<td>" . $name . "</td>";
                        echo "<td>" . $role . "</td>";
                        echo "<td>10,000</td>";
                        echo "<td>" . $pay . "</td>";
                        echo "<td>
                                <button onclick='present(" . $id . ")' class='btn prt'>Present</button>
                                <button onclick='absent(" . $id . ")' class='btn abt'>Absent</button>
                            </td>";
                        echo "<td>";
                        echo $present == '1' ? '<b class="success">Present</b>' : ($present == '0' ? '<b class="error">Absent</b>' : 'Not marked for today');
                        echo "</td>";
                        echo "</tr>";
                    }
                    $stmt->close();
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
        <div style="text-align: center;">

            <button class="btn" style="text-align: center; width: 100px; background: orange; font-weight: bold" onclick="resetData()">Reset</button>
        </div>
    </main>
    <script src="./script.js"></script>
</body>

</html>
