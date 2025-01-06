<?php
include "Student.php";
session_start();

if (isset($_GET["idx"])) {
  $idx = $_GET["idx"];
  if (isset($_SESSION["students"], $_SESSION["students"][$idx])) {
    array_splice($_SESSION["students"], $idx, 1);
  }

  header("Location: /");
  exit();
} else {
  header("Location: /");
  exit();
}