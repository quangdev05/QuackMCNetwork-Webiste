<?php 
    $pageTitle = "Đăng nhập | PlayST Network";
    require_once(__DIR__."/includes/head.php");
    require_once(__DIR__."/includes/header.php");
    require_once(__DIR__."/config/db.php");
    require_once(__DIR__."/includes/helpers.php");
	if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
      header('Location: /');
    }
?>

<body class="bg-global_0">
    <link rel="stylesheet" type="text/css" href="/assets/css/sweetalert.css?v=<?=time()?>">
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="/assets/js/sweetalert.min.js?v=<?=time()?>"></script>
  
  <section class="main">
    <h1 class="title">Đăng nhập</h1>
    </div>
<form action="free-gems" method="POST" class="form-wrapper" id="login">
  <input type='hidden' name='_csrf' value='aj7qJI83-pTU6Iu-37O4TxMtst1WKXwcLnck'>

  
  <input type="text" name="user" id="user" required placeholder="Tên nhân vật hoặc Email"
    value="" @endif />

  <input type="password" name="pass" id="password" required placeholder="Mật khẩu" />
  
  <button type="submit" id="btn-submit" class="btn-submit">Đăng nhập</button>
</form>
<div class="text-center leading-7">
<a href="/reset-password" class="font-medium">Quên mật khẩu?</a>
<div class="sub-form">
  <a href="/register" class="primary">Đăng ký tài khoản</a> 
</div>
</div>
  </section>
  
    <script src="/assets/js/post.js?v=<?=time()?>"></script>
    <script src="https://code.jquery.com/jquery.min.js "></script>
    <script src="/libs/popper.js/dist/umd/popper.min.js?v=<?=time()?> "></script>
    <script src="/libs/bootstrap/dist/js/bootstrap.min.js?v=<?=time()?> "></script>
  
<?php 
    require_once(__DIR__."/includes/footer.php");
?>
