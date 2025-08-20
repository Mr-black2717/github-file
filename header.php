<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
include '../includes/db.php';

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $species = $_POST['species'] ?? '';
    $breed = $_POST['breed'] ?? '';
    $age = intval($_POST['age'] ?? 0);
    $price = floatval($_POST['price'] ?? 0);
    $description = $_POST['description'] ?? '';
    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        $target_dir = "../images/";
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }

    $stmt = $conn->prepare("INSERT INTO pets (name, species, breed, age, price, description, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssids", $name, $species, $breed, $age, $price, $description, $image);

    if ($stmt->execute()) {
        $success = "Pet added successfully!";
    } else {
        $error = "Error adding pet.";
    }
    $stmt->close();
}

include '../includes/header.php';
?>

<h2>Add New Pet</h2>

<?php if($success): ?>
  <div class="alert alert-success"><?=htmlspecialchars($success)?></div>
<?php endif; ?>

<?php if($error): ?>
  <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Species</label>
    <input type="text" name="species" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Breed</label>
    <input type="text" name="breed" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Age (years)</label>
    <input type="number" name="age" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Price (₹)</label>
    <input type="number" step="0.01" name="price" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control" rows="3"></textarea>
  </div>
  <div class="mb-3">
    <label>Image</label>
    <input type="file" name="image" class="form-control">
  </div>
  <button type="submit" class="btn btn-primary">Add Pet</button>
</form>

<?php include '../includes/footer.php'; ?>