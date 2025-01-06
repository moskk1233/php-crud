<?php
include "Student.php";
session_start();

if (!isset($_SESSION["students"])) {
  $_SESSION["students"] = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP CRUD</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
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

        <!-- รายชื่อ -->
        <div class="mt-5">
          <p>มีรายชื่อทั้งหมด <?= count($_SESSION["students"]) ?> คน</p>
          <div>
            <table class="table table-striped">
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

              <?php foreach ($_SESSION["students"] as $index => $student): ?>
                <tr>
                  <td><?= htmlspecialchars($student->id) ?></td>
                  <td><?= htmlspecialchars($student->prefix) ?></td>
                  <td><?= htmlspecialchars($student->first_name) ?></td>
                  <td><?= htmlspecialchars($student->last_name) ?></td>
                  <td><?= htmlspecialchars($student->year) ?></td>
                  <td><?= htmlspecialchars($student->gpa) ?></td>
                  <td><?= htmlspecialchars($student->birthdate) ?></td>
                  <td>
                    <a 
                      href="edit.php?idx=<?= $index ?>"
                      class="btn btn-primary"
                    >
                      แก้ไข
                    </a>
                    <a 
                      href="delete.php?idx=<?= $index ?>"
                      class="btn btn-outline-danger"
                    >
                      ลบ
                    </a>
                  </td>
                </tr>
              <?php endforeach ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>