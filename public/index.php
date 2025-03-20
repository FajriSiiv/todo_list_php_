<?php
include("../layout/navbar.php");

if (!isset($_SESSION['user_id'])) {
  header("Location: ../pages/login.php");
  exit;
}
?>

<?php


$sql = 'SELECT * from todo_list';
$result = mysqli_query($conn, $sql);
$todo_list = mysqli_fetch_all($result, MYSQLI_ASSOC);



?>

<div class="pt-20 px-20">
  <h1 class="text-5xl text-center font-bold">Todo-List</h1>
  <?php if (empty($todo_list)): ?>
    <p class="lead mt-3">There is no list</p>
  <?php endif; ?>


  <div class="grid grid-cols-5 gap-4 mt-10">
    <?php foreach ($todo_list as $todo) { ?>
      <div
        class="rounded-md h-60 border border-gray-200 flex flex-col gap-4 p-2 pt-5 justify-between relative overflow-hidden">
        <div class="absolute top-0 left-0 h-4 w-full <?php echo $todo['is_todo'] ? "bg-emerald-500" : "bg-rose-500" ?>">
        </div>
        <div class="flex flex-col gap-4">
          <h2 class="text-2xl font-semibold">
            <?php echo $todo['title'] ?>
          </h2>
          <p>
            <?php echo $todo['body'] ?>
          </p>
        </div>
        <div class="grid grid-cols-1 gap-2 text-sm">
          <form action="../actions/delete_todo.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">
            <button class="py-2 text-white bg-rose-500 rounded-md w-full">Delete</button>
          </form>
        </div>
      </div>
    <?php } ?>
  </div>

</div>




<?php include("../layout/footer.php"); ?>