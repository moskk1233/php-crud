<?php

require_once "autoload.php";

use Entities\Student;
use Framework\Database\PDOConnection;
use Repositories\StudentRepository;
use Usecases\StudentUsecase;

$conn = PDOConnection::getConnection();
$studentRepository = new StudentRepository($conn);
$studentUsecase = new StudentUsecase($studentRepository);

if ($_SERVER["REQUEST_METHOD"] === "GET") {

  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $student = $studentUsecase->getStudentById($id);

    if (!isset($student)) {
      header("Location: /");
      exit();
    }
  }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $student = new Student(
      $_POST["id"],
      $_POST["prefix"],
      $_POST["firstname"],
      $_POST["lastname"],
      $_POST["year"],
      $_POST["gpa"],
      $_POST["birthdate"]
    );

    $studentUsecase->editStudentById($id, $student);
    
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
            <input 
              type="text" 
              name="id" 
              id="id" 
              class="form-control" 
              placeholder="กรอกรหัสนิสิต" 
              required
              value="<?= $student->id ?>"
            >
          </div>
          <div class="mb-3">
            <label class="fs-4" for="prefix">คำนำหน้า</label>
            <select name="prefix" id="prefix" class="form-select" required>
              <option value="นาย" <?= isset($student) && $student->prefix == "นาย" ? 'selected' : '' ?>>นาย</option>
              <option value="นางสาว" <?= isset($student) && $student->prefix == "นางสาว" ? 'selected' : '' ?>>นางสาว</option>
            </select>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label class="fs-4" for="firstname">ชื่อ</label>
              <input 
                type="text" 
                name="firstname" 
                id="firstname" 
                class="form-control" 
                placeholder="กรอกชื่อ" 
                required
                value="<?= $student->first_name ?>"
              >
            </div>

            <div class="col">
              <label class="fs-4" for="lastname">นามสกุล</label>
              <input 
                type="text" 
                name="lastname" 
                id="lastname" 
                class="form-control" 
                placeholder="กรอกนามสกุล" 
                required
                value="<?= $student->last_name ?>"
              >
            </div>
          </div>

          <div class="mb-3">
            <label class="fs-4" for="year">ชั้นปี</label>
            <select name="year" id="year" class="form-select" required>
              <option value="1" <?= isset($student) && $student->year == 1 ? 'selected' : '' ?>>1</option>
              <option value="2" <?= isset($student) && $student->year == 2 ? 'selected' : '' ?>>2</option>
              <option value="3" <?= isset($student) && $student->year == 3 ? 'selected' : '' ?>>3</option>
              <option value="4" <?= isset($student) && $student->year == 4 ? 'selected' : '' ?>>4</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="fs-4" for="gpa">เกรดเฉลี่ย</label>
            <input 
              type="number" 
              name="gpa" 
              id="gpa" 
              class="form-control" 
              placeholder="กรอกเกรดเฉลี่ย" 
              min="0.00" 
              max="4.00" 
              required
              value="<?= $student->gpa ?>"
            >
          </div>

          <div class="mb-3">
            <label class="fs-4" for="birthdate">วันเกิด</label>
            <input 
              type="date" 
              name="birthdate" 
              id="birthdate" 
              class="form-control" 
              required
              value="<?= $student->birthdate ?>"
            >
          </div>

          <div class="mb-3 mt-5">
            <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
            <a class="btn btn-outline-danger" href="/">ยกเลิก</a>
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