<?php

namespace Repositories;

use Entities\User;
use Interfaces\Repositories\IUserRepository;
use PDO;

class UserRepository implements IUserRepository {
  public function __construct(
    private PDO $pdo
  ) {}

  public function getAll(): array
  {
    $stmt = $this->pdo->prepare("
      SELECT * FROM User
    ");
    $stmt->execute();

    $result = $stmt->fetchAll();
    $result = array_map(function($row) {
      return new User(
        $row["id"],
        $row["username"],
        $row["password"],
        $row["created_at"],
        $row["updated_at"]
      );
    }, $result);

    return $result;
  }

  public function getById(int $id): ?User
  {
    $stmt = $this->pdo->prepare("
      SELECT * FROM User
      WHERE id = :id
    ");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch();
    if ($result) {
      return new User(
        $result["id"],
        $result["username"],
        $result["password"],
        $result["created_at"],
        $result["updated_at"]
      );
    } else {
      return null;
    }
  }

  public function getByUsername(string $username): ?User
  {
    $stmt = $this->pdo->prepare("
      SELECT * FROM User
      WHERE username = :username
    ");
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch();
    if ($result) {
      return new User(
        $result["id"],
        $result["username"],
        $result["password"],
        $result["created_at"],
        $result["updated_at"]
      );
    } else {
      return null;
    }
  }

  public function create(User $user): void
  {
    $stmt = $this->pdo->prepare("
      INSERT INTO User (username, password)
      VALUES (:username, :password)
    ");
    $stmt->bindParam(":username", $user->username);
    $stmt->bindParam(":password", $user->password);
    $stmt->execute();
  }

  public function deleteById(int $id): void
  {
    $stmt = $this->pdo->prepare("
      DELETE FROM User
      WHERE id = :id
    ");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }
}