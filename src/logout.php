<?php

session_start();

if (isset($_SESSION["authen"])) {
  unset($_SESSION["authen"]);
}

header("Location: /");
exit();