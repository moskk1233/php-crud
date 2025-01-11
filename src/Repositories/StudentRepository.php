<?php

namespace Repositories;

use Entities\Student;
use Interfaces\Repositories\IStudentRepository;
use PDO;

class StudentRepository implements IStudentRepository
{
  public function __construct(
    private PDO $pdo
  ) {}

  public function getAll(): array
  {
    $stmt = $this->pdo->prepare("SELECT * FROM Student");
    $stmt->execute();

    $result = $stmt->fetchAll();
    $result = array_map(function ($row) {
      return new Student(
        $row["id"],
        $row["prefix"],
        $row["first_name"],
        $row["last_name"],
        $row["grade_year"],
        $row["gpa"],
        $row["birthdate"]
      );
    }, $result);

    return $result;
  }

  public function create(Student $student): void
  {
    $stmt = $this->pdo->prepare("
      INSERT INTO Student (id, prefix, first_name, last_name, grade_year, gpa, birthdate)
      VALUES (:id, :prefix, :first_name, :last_name, :grade_year, :gpa, :birthdate)
    ");
    $stmt->bindParam(":id", $student->id);
    $stmt->bindParam(":prefix", $student->prefix);
    $stmt->bindParam(":first_name", $student->first_name);
    $stmt->bindParam(":last_name", $student->last_name);
    $stmt->bindParam(":grade_year", $student->year);
    $stmt->bindParam(":gpa", $student->gpa);
    $stmt->bindParam(":birthdate", $student->birthdate);
    $stmt->execute();
  }

  public function getPaginated(int $offset, int $limit): array
  {
    $stmt = $this->pdo->prepare("
      SELECT * FROM Student LIMIT :limit OFFSET :offset
    ");
    $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
    $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll();

    $result = array_map(function ($row) {
      return new Student(
        $row["id"],
        $row["prefix"],
        $row["first_name"],
        $row["last_name"],
        $row["grade_year"],
        $row["gpa"],
        $row["birthdate"]
      );
    }, $result);

    return $result;
  }

  public function getCountAll(): int
  {
    $stmt = $this->pdo->prepare("
      SELECT COUNT(*) FROM Student
    ");
    $stmt->execute();

    $count = $stmt->fetchColumn();
    return $count;
  }

  public function getById(string $id): Student | null
  {
    $stmt = $this->pdo->prepare("
      SELECT * FROM Student
      WHERE id = :id
    ");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $result = $stmt->fetch();

    if ($result) {
      return new Student(
        $result["id"],
        $result["prefix"],
        $result["first_name"],
        $result["last_name"],
        $result["grade_year"],
        $result["gpa"],
        $result["birthdate"],
      );
    } else {
      return null;
    }
  }

  public function editById(string $id, Student $student): void
  {
    $stmt = $this->pdo->prepare("
      UPDATE Student
      SET id = :id,
          prefix = :prefix,
          first_name = :first_name,
          last_name = :last_name,
          grade_year = :grade_year,
          gpa = :gpa,
          birthdate = :birthdate
      WHERE id = :input_id
    ");
    $stmt->bindParam(":id", $student->id);
    $stmt->bindParam(":prefix", $student->prefix);
    $stmt->bindParam(":first_name", $student->first_name);
    $stmt->bindParam(":last_name", $student->last_name);
    $stmt->bindParam(":grade_year", $student->year);
    $stmt->bindParam(":gpa", $student->gpa);
    $stmt->bindParam(":birthdate", $student->birthdate);
    $stmt->bindParam(":input_id", $id);
    $stmt->execute();
  }

  public function deleteById(string $id): void
  {
    $stmt = $this->pdo->prepare("
      DELETE FROM Student
      WHERE id = :id
    ");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
  }
}
