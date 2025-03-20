<?php include('../layout/navbar.php') ?>
<?php

if (!isset($_SESSION['user_id'])) {
  header("Location: ../pages/login.php");
  exit;
}

$titleErr = $taskErr = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $task = $_POST["task"];
  $title = $_POST["title"];
  $is_todo = isset($_POST["isTodo"]) ? (int) $_POST["isTodo"] : 0;


  if (strlen($title) === 0) {
    $titleErr = "Title tidak boleh kosong atau hanya berisi spasi!";
  } else if (strlen($task) === 0) {
    $taskErr = "Task tidak boleh kosong atau hanya berisi spasi!";
  } else {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $task = filter_input(INPUT_POST, 'task', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $stmt = $conn->prepare("INSERT INTO todo_list (title, body, is_todo) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $task, $is_todo);
    $stmt->execute();
    $stmt->close();

    header("Location: ../public/index.php");
    exit;
  }
}
?>

<div class=" max-w-[1056px] mx-auto pt-40">
  <h2 class="text-xl font-bold text-gray-700 mb-4">Tambah Todo</h2>
  <form action="" method="POST">
    <div class="mb-4">
      <label for="title" class="block text-gray-600 font-medium">Judul</label>
      <input type="text" id="title" name="title"
        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
        placeholder="Masukkan judul todo">
      <?php if (!empty($titleErr)): ?>
        <p class="text-red-500 text-sm mt-1"><?php echo $titleErr; ?></p>
      <?php endif; ?>
    </div>

    <div class="mb-4">
      <label for="task" class="block text-gray-600 font-medium">Tugas</label>
      <textarea id="task" name="task" rows="3"
        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
        placeholder="Masukkan tugas"></textarea>
      <?php if (!empty($taskErr)): ?>
        <p class="text-red-500 text-sm mt-1"><?php echo $taskErr; ?></p>
      <?php endif; ?>
    </div>

    <div class="mb-4 flex items-center">
      <input type="checkbox" id="isTodo" name="isTodo" value="1"
        class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
      <label for="isTodo" class="ml-2 text-gray-600 cursor-pointer select-none">Sudah selesai?</label>
    </div>

    <button type="submit"
      class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Tambah</button>
  </form>

</div>



<?php include('../layout/footer.php') ?>