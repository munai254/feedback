<?php
// Step 2: Establish a connection to the campaign_feedback database
$servername = "localhost";
$username = "home";
$password = "eUITzQc0K!x4c)*!";
$dbname = "campaign_feedback";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 3: Write a SQL query to select all records from the feedback table
$limit = 10; // Number of entries to show in a page.
if (isset($_GET["page"])) {
    $page  = $_GET["page"]; 
} else { 
    $page = 1; 
};  
$start_from = ($page - 1) * $limit;

$sql = "SELECT * FROM feedback ORDER BY created_at DESC LIMIT $start_from, $limit";
$result = $conn->query($sql);

// Step 4: Display the retrieved data in an HTML table on the web page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 80%;
            max-width: 800px;
            margin: auto;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .pagination {
            display: flex;
            justify-content: center;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ccc;
            color: #333;
            border-radius: 4px;
        }
        .pagination a.active {
            background-color: #28a745;
            color: #fff;
            border: 1px solid #28a745;
        }
        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Feedback List</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Feedback</th>
                <th>Rating</th>
                <th>Date</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['feedback']}</td>
                            <td>{$row['rating']}</td>
                            <td>{$row['created_at']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No feedback found</td></tr>";
            }
            ?>
        </table>
        <div class="pagination">
            <?php
            $result_db = $conn->query("SELECT COUNT(id) FROM feedback");
            $row_db = $result_db->fetch_row();  
            $total_records = $row_db[0];  
            $total_pages = ceil($total_records / $limit); 
            $pagLink = "";

            for ($i=1; $i<=$total_pages; $i++) {
                if ($i==$page) {
                    $pagLink .= "<a class='active' href='view_feedback.php?page=".$i."'>".$i."</a>";
                } else  {
                    $pagLink .= "<a href='view_feedback.php?page=".$i."'>".$i."</a>";  
                }
            }
            echo $pagLink;
            ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
