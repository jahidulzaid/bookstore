
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookStore Inventory</title>
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
            text-align: center;
            background: #fff;
            padding: 20px 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        .container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
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
    </style>
</head>
<body>
    <div class="container">
    <form method="POST" action="create_book.php">
        Title: <input type="number" name="title"><br>
        Author: <input type="text" name="author"><br>
        Genre: <input type="text" name="genre"><br>
        Price: <input type="text" name="price"><br>
        Stock: <input type="text" name="stock"><br>
        <input type="submit" value="Create Book">
        
        <?php 
        include 'db_connect.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['title'];
            $author =$_POST['author'];
            $genre = $_POST['genre'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];

            $sql = "INSERT INTO Books (Title, Author, Genre, Price, Stock) VALUES ('$title', '$author', '$genre', $price, $stock)";
            if ($connection->query($sql) === true) {
                echo "<br> New Book Record has been inserted!";
            } else {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }
        }
        ?>
        
    </form>
    <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
