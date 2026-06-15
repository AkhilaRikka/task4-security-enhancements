<?php
include "db.php";

// Search
$search = "";
if(isset($_GET['search'])){
    $search = $_GET['search'];
}

// Pagination
$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$start = ($page - 1) * $limit;

// Search Query
$query = "SELECT * FROM posts
          WHERE title LIKE '%$search%'
          OR content LIKE '%$search%'
          ORDER BY id DESC
          LIMIT $start, $limit";

$result = mysqli_query($conn, $query);

// Count Total Posts
$count_query = "SELECT COUNT(*) AS total FROM posts
                WHERE title LIKE '%$search%'
                OR content LIKE '%$search%'";

$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);

$total_posts = $count_row['total'];
$total_pages = ceil($total_posts / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Posts</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-4">

    <h2 class="mb-4">All Posts</h2>

    <!-- Search Form -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search posts..."
                value="<?php echo $search; ?>"
            >
            <button class="btn btn-primary" type="submit">
                Search
            </button>
        </div>
    </form>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="card mb-3">
            <div class="card-body">

                <h5 class="card-title">
                    <?php echo $row['title']; ?>
                </h5>

                <p class="card-text">
                    <?php echo $row['content']; ?>
                </p>

                <a
                    href="edit.php?id=<?php echo $row['id']; ?>"
                    class="btn btn-warning btn-sm">
                    Edit
                </a>

                <a
                    href="delete.php?id=<?php echo $row['id']; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this post?')">
                    Delete
                </a>

            </div>
        </div>

    <?php } ?>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">

            <?php
            for($i=1; $i<=$total_pages; $i++){
            ?>

            <li class="page-item <?php if($i==$page) echo 'active'; ?>">
                <a
                    class="page-link"
                    href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>">
                    <?php echo $i; ?>
                </a>
            </li>

            <?php } ?>

        </ul>
    </nav>

    <a href="dashboard.php" class="btn btn-secondary">
        Back to Dashboard
    </a>

</div>

</body>
</html>