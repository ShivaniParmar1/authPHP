<?php
session_start();
include 'config/db.php';

//Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

//Get all users from database
$query = "SELECT id, name, email, phone_number, created_at FROM users";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?>!</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <hr>

    <h4 class="mt-4">User List:</h4>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Registered On</th>
            </tr>
        </thead>
        <tbody>
<?php while ($user = $result->fetch_assoc()): ?>
<tr>
    <td><?= $user['id']; ?></td>
    <td><?= htmlspecialchars($user['name']); ?></td>
    <td><?= htmlspecialchars($user['email']); ?></td>
    <td><?= htmlspecialchars($user['phone_number']); ?></td>
    <td><?= htmlspecialchars($user['created_at']); ?></td>
    <td>
        <a href="edit_user.php?id=<?= $user['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="delete_user.php?id=<?= $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>

    </table>
</div>

</body>
</html>
