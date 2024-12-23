<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books - BookStore Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            width: 90%;
            max-width: 900px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        input[type="text"] {
            width: 60%;
            padding: 10px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Search for Books</h1>

    <form method="GET" action="search_book.php">
        <input type="text" name="query" placeholder="Enter Title, Author, or Genre" required>
        <input type="submit" value="Search">
    </form>

    <?php
    include 'db_connect.php'; 

    if (isset($_GET['query'])) {
        $query = $_GET['query'];
        $sql = "SELECT * FROM Books 
                WHERE Title LIKE ? 
                   OR Author LIKE ? 
                   OR Genre LIKE ?";
        
        $stmt = $connection->prepare($sql);
        $searchTerm = "%$query%";
        $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
        
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Image</th><th>Title</th><th>Author</th><th>Genre</th><th>Price</th><th>Stock</th></tr>";

            while ($row = $result->fetch_assoc()) {
                $imagePath = !empty($row['Book_Image']) ? $row['Book_Image'] : 'uploads/default.png';

                echo "<tr>";
                echo "<td><img src='$imagePath' alt='Book Image'></td>";
                echo "<td>" . $row['Title'] . "</td>";
                echo "<td>" . $row['Author'] . "</td>";
                echo "<td>" . $row['Genre'] . "</td>";
                echo "<td>" . $row['Price'] . "</td>";
                echo "<td>" . $row['Stock'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found for '<strong>$query</strong>'</p>";
        }
    
        $stmt->close();
    }

    $connection->close();
    ?>
</div>

</body>
</html>
