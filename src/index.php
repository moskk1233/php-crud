<?php

require_once "autoload.php";
require_once "test_input.php";

use Framework\Database\PDOConnection;
use Repositories\StudentRepository;
use Usecases\StudentUsecase;


session_start();
if (!isset($_SESSION["authen"])) {
  header("Location: /login.php");
  exit();
}

$conn = PDOConnection::getConnection();
$studentRepository = new StudentRepository($conn);
$studentUsecase = new StudentUsecase($studentRepository);

$page = isset($_GET["page"]) ? (int)test_input($_GET["page"]) : 1;
$page = $page > 0 ? $page : 1;
$limit = 10;

function getTotalPage(StudentUsecase $studentUsecase, $limit)
{
  $count = $studentUsecase->getAllStudentCount();

  return ceil($count / $limit);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP CRUD</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2/dist/sweetalert2.min.css">
</head>

<body>
  <?php require_once "Components/navbar.php" ?>

  <div class="container">
    <div id="header">
      <h1 class="text-center p-5">
        PHP CRUD
      </h1>
    </div>

    <div class="card shadow">
      <div class="card-body">
        <div id="add-btn">
          <a href="add.php">
            <button class="btn btn-success fs-3" style="width: 100%;">เพิ่มข้อมูล</button>
          </a>
        </div>
        <form action="gendata.php" method="post">
          <div class="row mt-3">
            <div class="col">
              <input
                type="number"
                name="gen_data"
                class="form-control"
                placeholder="กรอกจำนวนข้อมูลที่ต้องการ Mock"
                aria-label="กรอกจำนวนข้อมูลที่ต้องการ Mock"
                min=0
                max=1000
                required />
            </div>
            <div class="col">
              <button type="submit" class="btn btn-warning" style="width: 100%;">Mock ข้อมูล</button>
            </div>
          </div>
        </form>
        <form action="bulk_delete.php" method="post">
          <div class="row mt-3">
            <div class="col">
              <input
                type="number"
                name="bulk_delete_count"
                class="form-control"
                placeholder="กรอกจำนวนข้อมูลที่ต้องการลบ"
                aria-label="กรอกจำนวนข้อมูลที่ต้องการลบ"
                min=0
                max=1000
                required />
            </div>
            <div class="col">
              <button type="submit" class="btn btn-danger" style="width: 100%;">ลบข้อมูล</button>
            </div>
          </div>
        </form>

        <!-- ข้อมูลตาราง -->
        <div class="mt-5">
          <p>มีรายชื่อทั้งหมด <?= $studentUsecase->getAllStudentCount() ?> คน</p>
          <div class="overflow-x-scroll">
            <table id="student-table" class="table table-striped">
              <thead>
                <tr>
                  <th>รหัสนิสิต</th>
                  <th>คำนำหน้า</th>
                  <th>ชื่อ</th>
                  <th>นามสกุล</th>
                  <th>ชั้นปี</th>
                  <th>เกรดเฉลี่ย</th>
                  <th>วันเกิด</th>
                  <th>จัดการข้อมูล</th>
                </tr>
              </thead>

              <tbody>
                <!-- ข้อมูลตารางจะแสดงตรงนี้ -->
              </tbody>
            </table>
            <div class="d-flex justify-content-center">
              <div id="loading-student" class="spinner-border text-primary" role="status" style="width: 100px; height: 100px; display:none;">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
            <?php if ($studentUsecase->getAllStudentCount() <= 0): ?>
              <h1 class="text-center">ไม่มีข้อมูลนักเรียน</h1>
              <?php endif ?>
          </div>
        </div>

        <!-- Pagination -->
        <div class="mt-5">
          <nav aria-label="Page navigation example">
            <ul id="pagination" class="pagination justify-content-center flex-wrap">
              <!-- ปุ่มเปลี่ยนหน้าจะอยู่ตรงนี้ -->
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="js/js.js"></script>
</html>