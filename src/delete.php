<?php
require_once "Student.php";
session_start();

if (isset($_GET["idx"])) {
  $idx = $_GET["idx"];
  if (isset($_SESSION["students"], $_SESSION["students"][$idx])) {
    array_splice($_SESSION["students"], $idx, 1);
  }

  header("Location: " . $_SERVER["HTTP_REFERER"]);
  exit();
} else {
  header("Location: " . $_SERVER["HTTP_REFERER"]);
  exit();
}