<?php
$user_id = $_SESSION['user_id'];
?>
<link rel="stylesheet" href="/assets/css/wheel.css?v=<?=time()?>">
<section class="main">
    <div class="text-center leading-7">
<main>
	<section class="main">
		<span class="wheel-span">
			<ul class="wheel"></ul>
		</span>
		<button class="btn--wheel">Quay</button>
		<p class="msg">Còn Lại <span id="luot_quay"><?= freegemsUser($user_id, 'turns') ?></span> Lượt (<a style="text-decoration:none;color:red" href="https://www.playst.click/free-gems/">Kiếm Lượt</a>)</p>
		<input type="hidden" id="user_id" value="<?= $_SESSION['user_id'] ?>">
	</section>
</main>
<script src="/assets/js/vong_quay.js?v=<?= time() ?>"></script>    
</div>
