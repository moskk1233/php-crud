<?php

namespace Interfaces\Repositories;

use Entities\Student;

interface IStudentRepository
{
  public function getAll(): array;
  public function getPaginated(int $offset, int $limit): array;
  public function getCountAll(): int;
  public function getById(string $id): Student | null;
  public function create(Student $student): void;
  public function editById(string $id, Student $student): void;
  public function deleteById(string $id): void;
}