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
            max-width: 500px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], input[type="file"] {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
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
        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Update Book</h1>

    <?php
    include 'db_connect.php';

    if (isset($_GET['id'])) {
        $book_id = $_GET['id'];

        $sql = "SELECT * FROM Books WHERE BookID = $book_id";
        $result = $connection->query($sql);
        $book = $result->fetch_assoc();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $book_id = $_POST['book_id'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $genre = $_POST['genre'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        $targetDir = "uploads/"; 
        $fileUploaded = !empty($_FILES["book_image"]["name"]);
        $fileName = $fileUploaded ? basename($_FILES["book_image"]["name"]) : null;
        $targetFilePath = $fileUploaded ? $targetDir . uniqid() . "_" . $fileName : null;
        $fileType = $fileUploaded ? strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION)) : null;

        $uploadSuccess = true;

        if ($fileUploaded) {
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileType, $allowedTypes)) {
                if (!move_uploaded_file($_FILES["book_image"]["tmp_name"], $targetFilePath)) {
                    echo "<p class='error'>There was an error uploading the image.</p>";
                    $uploadSuccess = false;
                }
            } else {
                echo "<p class='error'>Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.</p>";
                $uploadSuccess = false;
            }
        }

        if ($uploadSuccess) {
            $bookImagePath = $fileUploaded ? $targetFilePath : $book['Book_Image'];

            $sql = "UPDATE Books 
                    SET Title = '$title', 
                        Author = '$author', 
                        Genre = '$genre', 
                        Price = $price, 
                        Stock = $stock, 
                        Book_Image = " . ($fileUploaded ? "'$bookImagePath'" : "Book_Image") . " 
                    WHERE BookID = $book_id";

            if ($connection->query($sql) === true) {
                echo "<p class='success'>Book updated successfully!</p>";
            } else {
                echo "<p class='error'>Error updating record: " . $connection->error . "</p>";
            }
        }
    }
    ?>

    <form method="POST" enctype="multipart/form-data">
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

        <label for="book_image">Current Image:</label>
        <?php if ($book['Book_Image']): ?>
            <img src="<?php echo $book['Book_Image']; ?>" alt="Book Image">
        <?php else: ?>
            <p>No image uploaded for this book.</p>
        <?php endif; ?>

        <label for="book_image">Update Image (optional):</label>
        <input type="file" name="book_image" accept="image/*">

        <input type="submit" value="Update Book">
    </form>

    <a href="view_books.php">Back to Book List</a>
</div>

</body>
</html>
