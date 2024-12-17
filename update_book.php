<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book - BookStore Inventory</title>
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
            max-width: 400px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #0056b3;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Book</h1>

        <?php
        // Include the database connection file
        include 'db_connect.php';

        // Check if 'id' is provided in the URL
        if (isset($_GET['id'])) {
            $book_id = $_GET['id'];

            // Retrieve the book's current information
            $sql = "SELECT * FROM Books WHERE BookID = $book_id";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                $book = $result->fetch_assoc();
            } else {
                echo "<p>Book not found!</p>";
                exit;
            }
        }

        // Handle form submission to update the book's details
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $book_id = $_POST['book_id'];
            $title = $_POST['title'];
            $author = $connection->real_escape_string($_POST['author']);
            $genre = $connection->real_escape_string($_POST['genre']);
            $price = $connection->real_escape_string($_POST['price']);
            $stock = $connection->real_escape_string($_POST['stock']);

            // Update the book details in the database
            $sql = "UPDATE Books 
                    SET Title='$title', Author='$author', Genre='$genre', Price=$price, Stock=$stock 
                    WHERE BookID=$book_id";

            if ($connection->query($sql) === true) {
                echo "<p>Book details updated successfully!</p>";
                echo '<a class="btn" href="view_books.php">View All Books</a>';
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }
        }
        ?>

        <!-- Display the update form with pre-filled values -->
        <form method="POST" action="update_book.php">
            <input type="hidden" name="book_id" value="<?php echo $book['BookID']; ?>">
            
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo $book['Title']; ?>" required>
            
            <label for="author">Author:</label>
            <input type="text" name="author" value="<?php echo $book['Author']; ?>" required>
            
            <label for="genre">Genre:</label>
            <input type="text" name="genre" value="<?php echo $book['Genre']; ?>" required>
            
            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" value="<?php echo $book['Price']; ?>" required>
            
            <label for="stock">Stock:</label>
            <input type="number" name="stock" value="<?php echo $book['Stock']; ?>" required>
            
            <input class="btn" type="submit" value="Update Book">
        </form>

        <a class="back-link" href="view_books.php">Back to View Books</a>
    </div>
</body>
</html>
