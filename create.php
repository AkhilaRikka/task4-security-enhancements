<?php
include "db.php";

$message = "";

if(isset($_POST['submit']))
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Server-side validation
    if(empty($title) || empty($content))
    {
        $message = "All fields are required!";
    }
    else
    {
        // Prepared Statement
        $stmt = $conn->prepare(
            "INSERT INTO posts(title, content)
             VALUES(?, ?)"
        );

        $stmt->bind_param(
            "ss",
            $title,
            $content
        );

        if($stmt->execute())
        {
            $message = "Post Added Successfully!";
        }
        else
        {
            $message = "Error adding post!";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
</head>
<body>

<h2>Add New Post</h2>

<?php
if($message != "")
{
    echo "<p><b>$message</b></p>";
}
?>

<form method="POST">

    Title:<br>
    <input type="text" name="title" required><br><br>

    Content:<br>
    <textarea name="content" rows="5" cols="30" required></textarea><br><br>

    <button type="submit" name="submit">
        Add Post
    </button>

</form>

<br>

<a href="dashboard.php">
    Back to Dashboard
</a>

</body>
</html>