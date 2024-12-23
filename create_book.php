<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"], 
        input[type="number"], 
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .error, .success {
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .error {
            color: #d9534f;
        }
        .success {
            color: #5cb85c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add a New Book</h1>
        <?php
        include 'db_connect.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                $bookImagePath = $fileUploaded ? $targetFilePath : 'NULL';
                $sql = "INSERT INTO Books (Title, Author, Genre, Price, Stock, Book_Image) 
                        VALUES ('$title', '$author', '$genre', $price, $stock, " . ($fileUploaded ? "'$bookImagePath'" : "NULL") . ")";
                if ($connection->query($sql) === true) {
                    echo "<p class='success'>New book has been added successfully!</p>";
                } else {
                    echo "<p class='error'>Error: " . $connection->error . "</p>";
                }
            }
        }
        ?>

        <form method="POST" action="create_book.php" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>

            <label for="author">Author</label>
            <input type="text" id="author" name="author" required>

            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre" required>

            <label for="price">Price</label>
            <input type="number" id="price" step="0.01" name="price" required>

            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" required>

            <label for="book_image">Image (optional)</label>
            <input type="file" id="book_image" name="book_image" accept="image/*">

            <input type="submit" value="Create Book">
        </form>

        <a class="back-link" href="view_book_with_image.php">View Books</a>
    </div>
</body>
</html>
