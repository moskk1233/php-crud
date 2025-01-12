<?php 
$username = isset($_SESSION["authen"]) ? $_SESSION["authen"]->username : "";
?>

<nav class="navbar sticky-top bg-info">
  <div class="mx-auto d-flex justify-content-between" style="width: 60vw;">
    <div>
      <a class="navbar-brand" href="/">PHP CRUD</a>
    </div>
    <?php if ($username): ?>
      <div>
        <span>ผู้ใช้งาน <?= htmlspecialchars($username) ?></span>
        <a href="/logout.php" class="ms-3 btn btn-outline-danger">ออกจากระบบ</a>
      </div>
    <?php endif; ?>
  </div>
</nav>