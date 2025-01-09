<?php
include "Student.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["gen_data"])) {
  for ($i = 0; $i < $_POST["gen_data"]; $i++) {
    array_push($_SESSION["students"], genData());
  }
  header("Location: " . $_SERVER["HTTP_REFERER"]);
  exit();
}