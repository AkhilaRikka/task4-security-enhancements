<?php
include "db.php";

$message = "";

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $stmt = $conn->prepare(
        "DELETE FROM posts WHERE id=?"
    );

    $stmt->bind_param("i", $id);

    if($stmt->execute())
    {
        echo "Post Deleted Successfully!";
    }
    else
    {
        echo "Error Deleting Post!";
    }

    $stmt->close();
}
?>

<br><br>

<a href="index.php">Back to Posts</a>