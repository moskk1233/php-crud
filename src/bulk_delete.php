<?php

require_once "autoload.php";

use Framework\Database\PDOConnection;

$conn = PDOConnection::getConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["bulk_delete_count"])) {
  $count = min($_POST["bulk_delete_count"], 500);
  
  $stmt = $conn->prepare("
    DELETE FROM Student
    LIMIT :count
  ");
  $stmt->bindParam(":count", $count, PDO::PARAM_INT);
  $stmt->execute();

  header("Location: /");
  exit();
}
