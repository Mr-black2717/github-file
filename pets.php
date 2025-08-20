<?php
include 'includes/db.php';
include 'includes/header.php';

$sql = "SELECT * FROM pets";
$result = $conn->query($sql);

echo "<h2>Available Pets</h2><div class='row'>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='col-md-4 mb-4'>";
        echo "<div class='card'>";
        if($row['image']) {
            echo "<img src='images/" . htmlspecialchars($row['image']) . "' class='card-img-top' alt='Pet Image'>";
        }
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . htmlspecialchars($row['name']) . "</h5>";
        echo "<p class='card-text'>" . htmlspecialchars($row['description']) . "</p>";
        echo "<p><strong>Price:</strong> ₹" . htmlspecialchars($row['price']) . "</p>";
        echo "</div></div></div>";
    }
} else {
    echo "<p>No pets available at the moment.</p>";
}
echo "</div>";

include 'includes/footer.php';
$conn->close();
?>
