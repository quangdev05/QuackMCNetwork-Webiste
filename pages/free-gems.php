<html>
<?php
$pageTitle = "Free Gems | QuackMC Network";
require_once(__DIR__ . "/../includes/head.php");
require_once(__DIR__ . "/../includes/header-fgs.php");
require_once(__DIR__ . "/../config/db.php");
require_once(__DIR__ . "/../libs/rcon.php");
require_once(__DIR__ . "/../includes/helpers.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
  header('Location: /login');
  $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}
?>

<body class="bg-global_0">
  <section class="main">
    <div class="home">
      <link rel="stylesheet" type="text/css" href="/assets/css/sweetalert.css?v=<?= time() ?>">
      <script src="/libs/jquery/dist/jquery-1.11.2.min.js?v=<?= time() ?>"></script>
      <script src="/assets/js/sweetalert.min.js?v=<?= time() ?>"></script>
      <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

      <?php
      $action = !empty($_GET['action']) ? xss($_GET['action']) : '';
      switch ($action) {
        case "vong_quay":
          include "../includes/spin-fgs.php";
          break;
        default:
        case "":
          include "../includes/home-fgs.php";
          break;
      }
      ?>
      <script src="/assets/js/post.js?v=<?= time() ?>"></script>
    </div>
    <?php
    require_once(__DIR__ . "/../includes/footer.php");
    ?>
</body>

</html>