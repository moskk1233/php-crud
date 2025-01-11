<?php
require_once "Student.php";
require_once "test_input.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST['id'], $_POST['prefix'], $_POST['firstname'], $_POST['lastname'], $_POST['year'], $_POST['gpa'], $_POST['birthdate'])) {
    $id = test_input($_POST["id"]);
    $prefix = test_input($_POST["prefix"]);
    $first_name = test_input($_POST["firstname"]);
    $last_name = test_input($_POST["lastname"]);
    $year = test_input($_POST["year"]);
    $gpa = test_input($_POST["gpa"]);
    $birthdate = test_input($_POST["birthdate"]);

    $student = new Student(
      $id,
      $prefix,
      $first_name,
      $last_name,
      $year,
      $gpa,
      $birthdate
    );

    array_push($_SESSION["students"], $student);
    header("Location: /");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>เพิ่มข้อมูล</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div style="width: 50%;" class="mx-auto m-5">
    <div class="card">
      <div class="card-body">
        <div>
          <h1 class="text-center">เพิ่มข้อมูล</h1>
        </div>
        <form action="" method="post">
          <div class="mb-3">
            <label class="fs-4" for="id">รหัสนิสิต</label>
            <input type="text" name="id" id="id" class="form-control" placeholder="กรอกรหัสนิสิต" required>
          </div>
          <div class="mb-3">
            <label class="fs-4" for="prefix">คำนำหน้า</label>
            <select name="prefix" id="prefix" class="form-select" required>
              <option value="นาย">นาย</option>
              <option value="นางสาว">นางสาว</option>
            </select>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label class="fs-4" for="firstname">ชื่อ</label>
              <input type="text" name="firstname" id="firstname" class="form-control" placeholder="กรอกชื่อ" required >
            </div>

            <div class="col">
              <label class="fs-4" for="lastname">นามสกุล</label>
              <input type="text" name="lastname" id="lastname" class="form-control" placeholder="กรอกนามสกุล" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="fs-4" for="year">ชั้นปี</label>
            <select name="year" id="year" class="form-select" required>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="fs-4" for="gpa">เกรดเฉลี่ย</label>
            <input type="number" name="gpa" id="gpa" class="form-control" placeholder="กรอกเกรดเฉลี่ย" min="0.00" max="4.00" required>
          </div>

          <div class="mb-3">
            <label class="fs-4" for="birthdate">วันเกิด</label>
            <input type="date" name="birthdate" id="birthdate" class="form-control" required>
          </div>

          <div class="mb-3 mt-5">
            <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
            <button class="btn btn-outline-danger" onclick="cancelAction()">ยกเลิก</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

<script>
  function cancelAction() {
    window.location.href = "/";
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>