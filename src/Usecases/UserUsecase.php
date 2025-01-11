<?php

namespace Usecases;

use Entities\User;
use Interfaces\Repositories\IUserRepository;

class UserUsecase {
  public function __construct(
    private IUserRepository $userRepository
  ) {}

  public function getAll() {
    return $this->userRepository->getAll();
  }

  public function getById(int $id) {
    return $this->userRepository->getById($id);
  }

  public function getByUsername(string $username) {
    return $this->userRepository->getByUsername($username);
  }

  public function create(User $user) {
    $this->userRepository->create($user);
  }

  public function deleteById(int $id) {
    $this->userRepository->deleteById($id);
  }
}