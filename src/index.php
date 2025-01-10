<?php
include "Student.php";
include "test_input.php";

session_start();

if (!isset($_SESSION["students"])) {
  $_SESSION["students"] = [];
}

$page = isset($_GET["page"]) ? (int)test_input($_GET["page"]) : 1;
$page = $page > 0 ? $page : 1;
$limit = 10;

?>

<?php
function pagination(int $page, int $perPage)
{
  $startIndex = ($page - 1) * $perPage;

  $pages = $_SESSION["students"];
  return array_slice($pages, $startIndex, $perPage, true);
}

function getTotalPage($limit)
{
  $size = count($_SESSION["students"]);

  return ceil($size / $limit);
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

        <?php if (count($_SESSION["students"]) <= 0): ?>
          <h1 class="text-center mt-5">ยังไม่มีข้อมูลนักเรียนกรุณากดเพิ่มที่ปุ่มสีเขียวหรือสีเหลืองก่อน</h1>
        <?php else: ?>
          <!-- รายชื่อ -->
          <div class="mt-5">
            <p>มีรายชื่อทั้งหมด <?= count($_SESSION["students"]) ?> คน</p>
            <div class="overflow-x-scroll">
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

                <?php foreach (pagination($page, $limit) as $index => $student): ?>
                  <tr>
                    <td><?= test_input($student->id) ?></td>
                    <td><?= test_input($student->prefix) ?></td>
                    <td><?= test_input($student->first_name) ?></td>
                    <td><?= test_input($student->last_name) ?></td>
                    <td><?= test_input($student->year) ?></td>
                    <td><?= test_input($student->gpa) ?></td>
                    <td><?= test_input($student->birthdate) ?></td>
                    <td>
                      <a
                        href="edit.php?idx=<?= $index ?>"
                        class="btn btn-primary">
                        แก้ไข
                      </a>
                      <a
                        href="delete.php?idx=<?= $index ?>"
                        class="btn btn-outline-danger">
                        ลบ
                      </a>
                    </td>
                  </tr>
                <?php endforeach ?>
              </table>
            </div>
          </div>
        <?php endif ?>

        <!-- Paginator -->
        <?php if (count($_SESSION["students"]) > 0): ?>
          <div class="mt-5">
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center flex-wrap">
                <li class="page-item <?= $page <= 1 ? "disabled" : "" ?>">
                  <a class="page-link" href="<?= $page != 1 ? "?page=" . $page - 1 : "" ?>">Previous</a>
                </li>

                <?php for ($i = 1; $i <= getTotalPage($limit); $i++): ?>
                  <li class="page-item <?= $i == $page ? "active" : "" ?>">
                    <a class="page-link" href="?page=<?= $i ?>">
                      <?= $i ?>
                    </a>
                  </li>
                <?php endfor ?>

                <li class="page-item <?= $page >= getTotalPage($limit) ? "disabled" : "" ?>">
                  <a class="page-link" href="<?= $page != getTotalPage($limit) ? "?page=" . $page + 1 : "" ?>">Next</a>
                </li>
              </ul>
            </nav>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>