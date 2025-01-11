<?php

namespace Interfaces\Repositories;

use Entities\User;

interface IUserRepository {
  public function getAll(): array;
  public function getById(int $id): ?User;
  public function getByUsername(string $username): ?User;
  public function create(User $user): void;
  public function deleteById(int $id): void;
}