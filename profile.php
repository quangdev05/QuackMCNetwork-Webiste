<?php
$pageTitle = "Profile | PlayST Network";
require_once(__DIR__."/includes/head.php");
require_once(__DIR__."/includes/header.php");
require_once(__DIR__."/config/db.php");
require_once(__DIR__."/includes/helpers.php");

session_start();
checklogin();
$skin_url = getSkinURL($_SESSION['username']);

$PTDUNG = new PTDUNG();
$tongnap_data = $PTDUNG->get_row("SELECT tongnap FROM tong_nap WHERE user_id = '" . $_SESSION['user_id'] . "'");
$tongnap_text = isset($tongnap_data['tongnap']) && $tongnap_data['tongnap'] !== null ? $tongnap_data['tongnap'] . '₫' : '0₫';
?>

<body class="bg-global_0">
  <section class="main">
<div class="home">
<style>
  @font-face {
    font-family: 'Minecraft';
    src: url('/assets/fonts/Minecraft.woff2') format('woff2'),
</style>


<div class="basis-1/4">
  <div class="flex justify-center">
    <input type="hidden" id="name" value="<?= $_SESSION['username'] ?>">
    <input type="hidden" id="skin_url" value="<?= $skin_url ?>">
    <canvas id="skin_container"></canvas>
  </div>
  <div class="flex flex-row gap-2 user-info">
    <div class="font-medium">ID:</div>
    <div><?= "#" . $_SESSION['user_id'] ?></div>
  </div>
  <div class="flex flex-row gap-2 user-info">
    <div class="font-medium">Email:</div>
    <div><?= $_SESSION['email'] ?></div>
  </div>
  <div class="flex flex-row gap-2">
    <div class="basis-1/2 user-info flex flex-col">
      <span class="font-medium">Trạng thái ID:</span>
      <span>🟢 Đã định danh</span>
    </div>
    <div class="basis-1/2 user-info flex flex-col">
      <span class="font-medium">Tổng nạp (Card):</span>
      <span>💲 <?= $tongnap_text ?></span>
    </div>
  </div>
  <div class="sub-form !max-w-full">
    <a href="/logout.php" class="primary">Đăng Xuất</a>
    <a href="/topup-card" class="primary">Nạp Gems</a>
  </div>
  <h2 class="heading-0 flex-grow">Đổi mật khẩu</h2>
  <form id="changepass" class="form-wrapper">
    <input type="hidden" name="username" value="<?= $_SESSION['username'] ?>" />
    <input type="password" name="old_pass" placeholder="Mật khẩu hiện tại" required />
    <input type="password" name="new_pass" placeholder="Mật khẩu mới" required />
    <input type="password" name="retype_pass" placeholder="Nhập lại mật khẩu mới" required />
    <button type="submit" id="btn-submit" class="btn-submit">Đổi mật khẩu</button>
  </form>
</div>
<div class="basis-3/4">
  <div class="flex flex-row">
    <h2 class="heading-0 flex-grow">Lịch sử đăng nhập</h2>
    <button class="text-right" id="login-log-btn">[ Hiện ]</button>
  </div>
  <div class="mb-8 scrollable-container" id="login-log-content" style="display: none;">
    <div class="log-heading xl:text-base">
      <div class="basis-1/4">Thời gian</div>
      <div class="basis-1/4">IP</div>
      <div class="basis-1/4">Quốc gia</div>
      <div class="basis-1/4">Nguồn</div>
    </div>

    <?php
    $data = $PTDUNG->get_list("SELECT * FROM `login_logs` WHERE `user_id`='" . $_SESSION['user_id'] . "' ORDER BY `id` DESC");

    if (empty($data)): ?>
      <div class="log-row justify-center">
        Không có dữ liệu
      </div>
    <?php else: ?>
      <?php foreach ($data as $row): ?>
        <div class="flex flex-row gap-2 user-info log-row">
          <div class="basis-1/4"><?= $row['create_time'] ?></div>
          <div class="basis-1/4"><?= $row['ip'] ?></div>
          <div class="basis-1/4"><?= $row['nation'] ?></div>
          <div class="basis-1/4"><?= $row['source'] ?></div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <div class="flex flex-row">
    <h2 class="heading-0 flex-grow">Lịch sử nạp Gems</h2>
    <button class="text-right" id="donate-log-btn">[ Ẩn ]</button>
  </div>
  <div class="mb-8" id="recharge-log-content">
    <div class="log-heading xl:text-base">
      <div class="basis-1/5">Thời gian</div>
      <div class="basis-1/5">Số tiền</div>
      <div class="basis-1/5">Số gems</div>
      <div class="basis-1/5">Phương thức</div>
      <div class="basis-1/5">Trạng thái</div>
    </div>

    <?php
    $data = $PTDUNG->get_list("SELECT * FROM `recharge_logs` WHERE `user_id`='" . $_SESSION['user_id'] . "' ORDER BY `id` DESC");

    if (empty($data)): ?>
      <div class="log-row justify-center">
        Không có dữ liệu
      </div>
    <?php else: ?>
      <?php foreach ($data as $row): ?>
        <div class="flex flex-row gap-2 user-info log-row">
          <div class="basis-1/5"><?= $row['create_time'] ?></div>
          <div class="basis-1/5">
            <?php
            if ($row['amount'] == 10000) {
              echo '10.000₫';
            } elseif ($row['amount'] == 20000) {
              echo '20.000₫';
            } elseif ($row['amount'] == 30000) {
              echo '30.000₫';
            } else if ($row['amount'] == 50000) {
              echo '50.000₫';
            } else if ($row['amount'] == 100000) {
              echo '100.000₫';
            } else if ($row['amount'] == 200000) {
              echo '200.000₫';
            } else if ($row['amount'] == 300000) {
              echo '300.000₫';
            } else if ($row['amount'] == 500000) {
              echo '500.000₫';
            } else if ($row['amount'] == 1000000) {
              echo '1.000.000₫';
            }
            ?>
          </div>
          <div class="basis-1/5"><?= $row['gems'] ?></div>
          <div class="basis-1/5"><?= $row['method'] ?></div>
          <div class="basis-1/5">
            <?php
            if ($row['status'] == 0) {
              echo 'Đang xử lí';
            } elseif ($row['status'] == 1) {
              echo 'Thành công';
            } elseif ($row['status'] == 2) {
              echo 'Thất bại';
            }
            ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
</div>
<style>
  .scrollable-container {
    overflow-x: auto;
    white-space: nowrap;
  }
</style>
<script>
  document.getElementById('login-log-btn').addEventListener('click', function () {
    var logContent = document.getElementById('login-log-content');
    if (logContent.style.display === 'none' || logContent.style.display === '') {
      logContent.style.display = 'block';
      this.textContent = '[ Ẩn ]';
    } else {
      logContent.style.display = 'none';
      this.textContent = '[ Hiện ]';
    }
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var logContent = document.getElementById('recharge-log-content');
    logContent.style.display = 'block';
    document.getElementById('donate-log-btn').textContent = '[ Ẩn ]';
  });

  document.getElementById('donate-log-btn').addEventListener('click', function () {
    var logContent = document.getElementById('recharge-log-content');
    if (logContent.style.display === 'none' || logContent.style.display === '') {
      logContent.style.display = 'block';
      this.textContent = '[ Ẩn ]';
    } else {
      logContent.style.display = 'none';
      this.textContent = '[ Hiện ]';
    }
  });
</script>
<link rel="stylesheet" type="text/css" href="/assets/css/sweetalert.css?v=<?= time() ?>">
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="/assets/js/sweetalert.min.js?v=<?= time() ?>"></script>
<script src="/assets/js/post.js?v=<?= time() ?>"></script>
<script src="/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/assets/js/bundle.js"></script>

<?php
require_once(__DIR__ . "/includes/footer.php");
?>
