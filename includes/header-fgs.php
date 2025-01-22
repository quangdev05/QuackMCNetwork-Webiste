<header>

  <?php
  require_once(__DIR__ . "/../config/db.php");
  require_once(__DIR__ . "/../libs/rcon.php");
  require_once(__DIR__ . "/../includes/helpers.php");
  ?>

  <div id="menu-btn">
    <button type="button" class="content">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"></path>
      </svg>
      <span class="ml-2">MENU</span>
    </button>

    <button type="button" class="content opacity-0">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
      <span class="ml-2">ĐÓNG</span>
    </button>
  </div>

  <nav id="menu-main" aria-label="Mobile Navigation" class="opacity-0">
    <ul class="content">
      <li><a href="/">Trang chủ</a></li>
      <li><a href="/free-gems/">Free Gems</a></li>
      <li><a href="/free-gems?action=vong_quay">Vòng Quay</a></li>
      <li><a href="/profile"><?= $_SESSION['username'] ?></a></li>
      <li><a href="/logout">Đăng xuất</a></li>
    </ul>
  </nav>


  <nav class="top-menu basis-3/5 hidden xl:block" aria-label="Main Navigation Left">
    <ul>
      <li><a href="/">Trang chủ</a></li>
      <li><a href="/free-gems/">Free Gems</a></li>
      <li><a href="/free-gems?action=vong_quay">Vòng Quay</a></li>
    </ul>
  </nav>

  <a class="logo basis-1/5" href="/">
    <img src="https://www.playst.click/assets/images/logo-chu.png" alt="QuackMC Network">
  </a>

  <nav class="top-menu basis-3/5 hidden xl:block" aria-label="Main Navigation Right">
    <ul class="justify-end">
      <li><a href="/profile"><?= $_SESSION['username'] ?></a></li>
      <li><a href="/logout">Đăng xuất</a></li>
    </ul>
  </nav>
</header>
