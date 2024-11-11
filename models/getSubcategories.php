<?php

$selectedCategory = $_POST['category'];

include("../config/connection.php");

$stmt = $connection->prepare('SELECT * FROM subcategories WHERE category_id = :category');
$stmt->bindParam(':category', $selectedCategory);
$stmt->execute();
$subcategories = $stmt->fetchAll();
header('Content-Type: application/json');
echo json_encode($subcategories);
?>