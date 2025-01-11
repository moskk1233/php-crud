<?php


use Framework\Database\PDOConnection;
use Repositories\StudentRepository;
use Usecases\StudentUsecase;

require_once "autoload.php";

session_start();
if (!isset($_SESSION["authen"])) {
  header("Location: /");
  exit();
}

$conn = PDOConnection::getConnection();
$studentRepository = new StudentRepository($conn);
$studentUsecase = new StudentUsecase($studentRepository);


if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $studentUsecase->deleteStudentById($id);
  
  header("Location: " . $_SERVER["HTTP_REFERER"]);
  exit();
} else {
  header("Location: " . $_SERVER["HTTP_REFERER"]);
  exit();
}