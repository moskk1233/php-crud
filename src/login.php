<?php

require_once "autoload.php";

use Entities\User;
use Framework\Database\PDOConnection;
use Repositories\UserRepository;
use Usecases\UserUsecase;

session_start();
if (isset($_SESSION["authen"])) {
  header("Location: /");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $conn = PDOConnection::getConnection();
  $userRepository = new UserRepository($conn);
  $userUsecase = new UserUsecase($userRepository);
  
  $username = $_POST["username"];
  $password = $_POST["password"];

  $user = $userUsecase->getByUsername($username);

  if ($user) {
    if (password_verify($password, $user->password)) {
      $_SESSION["authen"] = new User(
        $user->id,
        $user->username,
        "",
        "",
        ""
      );

      header("Location: /");
      exit();
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>เข้าสู่ระบบ</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div
    class="d-flex align-items-center justify-content-center mt-5 mb-5"
  >
    <div class="card rounded-3 shadow" style="width: 30vw;">
      <div class="card-body">
        <form action="" method="post">
          <div class="p-2">
            <h1>เข้าสู่ระบบ</h1>
            <div class="form-floating mb-3">
              <input name="username" type="text" id="floatingInput" class="form-control" placeholder="กรอกผู้ใช้งาน" required>
              <label for="floatingInput" class="form-label">Username</label>
            </div>

            <div class="form-floating mb-3">
              <input name="password" type="password" id="floatingPassword" class="form-control" placeholder="กรอกรหัสผ่าน" required>
              <label for="floatingPassword" class="form-label">Password</label>
            </div>

            <div class="d-flex gap-4">
              <div>
                <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
              </div>
              <div class="">
                <span>ยังไม่มีบัญชีเหรอ ?</span>
                <a href="register.php">คลิ๊กที่นี่</a>
              </div>
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
  crossorigin="anonymous"
></script>
<script src="index.js"></script>
</html>