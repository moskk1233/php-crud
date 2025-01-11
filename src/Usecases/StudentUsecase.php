<?php

namespace Usecases;

use Entities\Student;
use Interfaces\Repositories\IStudentRepository;

class StudentUsecase
{
  public function __construct(
    private IStudentRepository $studentRepository
  ) {}

  public function getAllStudent(): array
  {
    return $this->studentRepository->getAll();
  }

  public function createStudent(Student $student): void
  {
    $this->studentRepository->create($student);
  }

  public function getStudentPaginated(int $page, int $limit): array
  {
    $offset = ($page - 1) * $limit;
    return $this->studentRepository->getPaginated($offset, $limit);
  }

  public function getAllStudentCount()
  {
    return $this->studentRepository->getCountAll();
  }

  public function getStudentById(string $id)
  {
    return $this->studentRepository->getById($id);
  }

  public function editStudentById(string $id, Student $student)
  {
    $this->studentRepository->editById($id, $student);
  }

  public function deleteStudentById(string $id) {
    $this->studentRepository->deleteById($id);
  }
}
