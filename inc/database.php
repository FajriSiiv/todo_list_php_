<?php
define("DB_HOST", 'localhost');
define("DB_USER", 'fajri');
define("DB_PASS", 'fajri');
define("DB_NAME", "todo_list_php");


$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


if ($conn->connect_error) {
  die('Koneksi gagal' . $conn->connect_error);
}

?>