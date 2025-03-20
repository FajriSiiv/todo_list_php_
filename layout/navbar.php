<?php
session_start();

include("../inc/database.php");
?>


<!doctype html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
  <div class="w-full h-[60px] static top-0 left-0  px-10 bg-gray-900 text-white flex justify-between items-center">
    <h1>Todolist</h1>
    <ul class="flex gap-10 items-center">
      <li><a href="../public/index.php">Home</a></li>
      <li><a href="../pages/add.php">Add Todo</a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li><a href="../actions/logout.php" class="bg-red-500 text-white px-4 py-2 rounded">Logout</a></li>
      <?php else: ?>
        <li><a href="../pages/login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>