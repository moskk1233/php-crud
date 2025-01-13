<?php

use Framework\Database\PDOConnection;
use Repositories\StudentRepository;
use Usecases\StudentUsecase;

require_once "../autoload.php";
require_once "../test_input.php";

$conn = PDOConnection::getConnection();
$studentRepository = new StudentRepository($conn);
$studentUsecase = new StudentUsecase($studentRepository);

header("Content-Type: application/json");
session_start();

if (!isset($_SESSION["authen"])) {
  http_response_code(401);
  exit();
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  
  $page = $_GET["page"] ?? 1;
  $limit = 20;
  $students = $studentUsecase->getStudentPaginated($page, $limit);
  $studentCount = $studentUsecase->getAllStudentCount();
  $total_page = ceil($studentCount / $limit);

  echo json_encode([
    "students" => $students,
    "total_page" => $total_page
  ]);
} else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $studentUsecase->deleteStudentById($id);

    http_response_code(204);
  } else {
    http_response_code(404);
  }
}