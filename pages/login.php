<?php include('../layout/navbar.php') ?>

<?php
if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_SESSION['user_id'])) {
  header("Location: ../public/index.php");
  exit;
}

$usernameErr = $passwordErr = $loginErr = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Akses tidak sah! CSRF token tidak valid.");
  }

  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);

  if (strlen($username) === 0) {


    $usernameErr = "Username tidak boleh kosong";
  } elseif (strlen($password) === 0) {
    $passwordErr = "Password tidak boleh kosong";

  } else {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows === 1) {
      $user = $result->fetch_assoc();


      if ($password === $user["password"]) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];


        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        setcookie('username', $user['username'], time() + 3600, '/');
        setcookie('user_id', $user['id'], time() + 3600, '/');


        header('Location: ../public/index.php');
        exit;
      } else {
        $loginErr = "Password salah!";
      }
    } else {
      $loginErr = "Username tidak ditemukan!";
    }

    $stmt->close();
  }
}
?>


<div class="px-5 py-20">
  <h2 class="text-center text-3xl font-bold">Login</h2>

  <form action="" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <div class="mb-4">
      <label for="username" class="block text-gray-600 font-medium">Username</label>
      <input type="text" id="username" name="username"
        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
        placeholder="username..">
      <?php if (!empty($usernameErr)): ?>
        <p class="text-red-500 text-sm mt-1"><?php echo $usernameErr; ?></p>
      <?php endif; ?>
    </div>

    <div class="mb-4">
      <label for="password" class="block text-gray-600 font-medium">Password</label>
      <input id="password" name="password"
        class=" mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
        placeholder="password..." type="text"></input>
      <?php if (!empty($passwordErr)): ?>
        <p class="text-red-500 text-sm mt-1"><?php echo $passwordErr; ?></p>
      <?php endif; ?>
    </div>


    <?php if (!empty($loginErr)): ?>
      <p class="text-red-500 text-sm mt-1"><?php echo $loginErr; ?></p>
    <?php endif; ?>
    <button type="submit"
      class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Login</button>

  </form>

</div>








<?php include('../layout/footer.php') ?>