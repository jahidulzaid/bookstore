<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books - BookStore Inventory</title>
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
        .btn {
            padding: 5px 5px;
            font-size: 10px;
            text-decoration: none;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-update {
            background-color: #28a745;
        }
        .btn-update:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View Books</h1>

        <?php
        include 'db_connect.php';

        if (isset($_GET['delete_id'])) {
            $book_id = $_GET['delete_id'];

            $sql = "DELETE FROM Books WHERE BookID = $book_id";
            if ($connection->query($sql) === true) {
                echo "<p>Book deleted successfully!</p>";
            } else {
                echo "Error deleting record: " . $connection->error;
            }
        }

        $sql = "SELECT * FROM Books";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Book ID</th><th>Title</th><th>Author</th><th>Genre</th><th>Price</th><th>Stock</th><th>Actions</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['BookID'] . "</td>";
                echo "<td>" . $row['Title'] . "</td>";
                echo "<td>" . $row['Author'] . "</td>";
                echo "<td>" . $row['Genre'] . "</td>";
                echo "<td>" . $row['Price'] . "</td>";
                echo "<td>" . $row['Stock'] . "</td>";
                echo "<td>
                    <a class='btn btn-update' href='update_book.php?id=" . $row['BookID'] . "'>Update</a> 
                    <a class='btn btn-delete' href='view_books.php?delete_id=" . $row['BookID'] . "' onclick=\"return confirm('Are you sure you want to delete this book?');\">Delete</a>
                    </td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No books found in the inventory!</p>";
        }

        // Close the database connection
        $connection->close();
        ?>

        <br>
        <a class="btn" href="create_book.php">Add New Book</a>
        <a class="btn" href="index.php">Main Menu</a>
    </div>
</body>
</html>
