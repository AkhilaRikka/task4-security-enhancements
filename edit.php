<?php
include "db.php";

$id = $_GET['id'];

$stmt = $conn->prepare(
    "SELECT * FROM posts WHERE id=?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$message = "";

if(isset($_POST['update']))
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if(empty($title) || empty($content))
    {
        $message = "All fields are required!";
    }
    else
    {
        $updateStmt = $conn->prepare(
            "UPDATE posts
             SET title=?, content=?
             WHERE id=?"
        );

        $updateStmt->bind_param(
            "ssi",
            $title,
            $content,
            $id
        );

        if($updateStmt->execute())
        {
            $message = "Post Updated Successfully!";

            // Refresh displayed values
            $row['title'] = $title;
            $row['content'] = $content;
        }
        else
        {
            $message = "Error Updating Post!";
        }

        $updateStmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>

<h2>Edit Post</h2>

<?php
if($message != "")
{
    echo "<p><b>$message</b></p>";
}
?>

<form method="POST">

    Title:<br>
    <input
        type="text"
        name="title"
        value="<?php echo htmlspecialchars($row['title']); ?>"
        required
    >
    <br><br>

    Content:<br>
    <textarea
        name="content"
        rows="5"
        cols="30"
        required><?php echo htmlspecialchars($row['content']); ?></textarea>
    <br><br>

    <button type="submit" name="update">
        Update Post
    </button>

</form>

<br>

<a href="index.php">
    Back to Posts
</a>

</body>
</html>