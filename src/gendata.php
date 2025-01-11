<?php

require_once "autoload.php";

use Entities\Student;
use Framework\Database\PDOConnection;
use Repositories\StudentRepository;
use Usecases\StudentUsecase;

function generateFirstName()
{
  $firstNames = ['John', 'Jane', 'Alex', 'Emily', 'Chris', 'Katie', 'Michael', 'Sarah', 'Daniel', 'Laura'];
  $firstName = $firstNames[array_rand($firstNames)];

  return $firstName;
}

function generateLastName()
{
  $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];
  $lastName = $lastNames[array_rand($lastNames)];

  return $lastName;
}

function randomNumber(int $min, int $max)
{
  return rand($min, $max);
}

function randomPrefix()
{
  $prefixs = ['นาย', 'นางสาว'];
  $prefix = $prefixs[array_rand($prefixs)];

  return $prefix;
}

function genData(int $id)
{
  return new Student(
    $id,
    randomPrefix(),
    generateFirstName(),
    generateLastName(),
    randomNumber(1, 4),
    randomNumber(1, 4),
    "2024-01-25"
  );
}

$conn = PDOConnection::getConnection();
$studentRepository = new StudentRepository($conn);
$studentUsecase = new StudentUsecase($studentRepository);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["gen_data"])) {
  for ($i = 1; $i <= min($_POST["gen_data"], 1000); $i++) {
    $studentUsecase->createStudent(genData($i));
  }
  header("Location: " . $_SERVER["HTTP_REFERER"]);
  exit();
}
