<?php

use Entities\User;
use Framework\Database\PDOConnection;
use Repositories\UserRepository;
use Usecases\UserUsecase;

require_once "autoload.php";

session_start();
if (isset($_SESSION["authen"])) {
  header("Location: /");
  exit();
}

$conn = PDOConnection::getConnection();
$userRepository = new UserRepository($conn);
$userUsecase = new UserUsecase($userRepository);

if (isset($_SESSION["authen"])) {
  header("Location: /");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $existedUser = $userUsecase->getByUsername($username);

  if (!$existedUser) {
    $user = new User(
      0,
      $username,
      $hashedPassword,
      "",
      ""
    );

    $userUsecase->create($user);
    // echo "Create Successfully";
  }
  header("Location: /login.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ลงทะเบียนผู้ใช้งาน</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div
    class="container mt-5 mb-5 mx-auto"
    style="width: 80vh;">
    <div class="card rounded-3 shadow">
      <div class="card-body">
        <form action="" method="post">
          <div class="p-2">
            <h1>ลงทะเบียน</h1>
            <div>
              <div class="form-floating mb-3">
                <input name="username" type="text" class="form-control" id="floatingInput" placeholder="กรอก Username">
                <label for="floatingInput">Username</label>
              </div>
              <div class="form-floating mb-3">
                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="กรอก Password">
                <label for="floatingPassword">Password</label>
              </div>
              <div>
                <button type="submit" class="btn btn-primary">ลงทะเบียน</button>
              </div>
            </div>

        </form>
      </div>
    </div>
  </div>
</body>
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
  crossorigin="anonymous"></script>
<script src="index.js"></script>

</html>