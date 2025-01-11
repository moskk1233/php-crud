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
  $values = [];
  
  for ($i = 1; $i <= min($_POST["gen_data"], 1000); $i++) {
    $student = genData($i);
    $values[] = "('$student->id', '$student->prefix', '$student->first_name', '$student->last_name', '$student->year', '$student->gpa', '$student->birthdate')";
  }
  
  $sql = "
    INSERT INTO Student (id, prefix, first_name, last_name, grade_year, gpa, birthdate)
    VALUES 
  " . implode(", ", $values);

  $stmt = $conn->prepare($sql);
  $stmt->execute();
  
  header("Location: " . $_SERVER["HTTP_REFERER"]);
  exit();
}
