<?php 
include 'db_connect.php';

if (isset($_GET['id'])) {
    $std_id = $_GET['id'];

    $sql = "DELETE FROM students WHERE student_id = '$std_id'";
    if ($connection->query($sql) === true) {
        echo "<br> Student Record with ID $std_id has been deleted!";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}
?>
<a href="view_students.php">Back to Student List</a>
