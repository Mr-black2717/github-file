<?php
session_start();
include '../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows == 1 && password_verify($password, $hashed_password)) {
        $_SESSION['admin_id'] = $id;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
    $stmt->close();
}
?>

<?php include '../includes/header.php'; ?>
<h2>Admin Login</h2>
<?php if($error): ?>
    <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
<?php endif; ?>
<form method="post">
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" name="username" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" required>
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>
<?php include '../includes/footer.php'; ?>
