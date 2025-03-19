<?php
include("../inc/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = intval($_POST["id"]);

  $stmt = $conn->prepare("DELETE FROM todo_list WHERE id = ?");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  header('Location: ../public/index.php');
  exit;
}
?>