<?php 
if (isset($_SESSION["authen"])) {
  $user = $_SESSION["authen"];
  $username = $user->username;
}
?>

<nav class="navbar sticky-top bg-info">
  <div class="mx-auto d-flex justify-content-between" style="width: 60vw;">
    <div>
      <a class="navbar-brand" href="/">PHP CRUD</a>
    </div>
    <?php if (isset($_SESSION["authen"])): ?>
      <div>
        <span>ผู้ใช้งาน <?= $username ?></span>
        <a href="/logout.php" class="ms-3 btn btn-outline-danger">ออกจากระบบ</a>
      </div>
    <?php endif; ?>
  </div>
</nav>