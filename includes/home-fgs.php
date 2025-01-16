<?php
$user_id = $_SESSION['user_id'];
$skin_url = getSkinURL($_SESSION['username']);
?>

<section class="main">
    <div class="text-center leading-7">
        <p>Vượt link sau để nhận lượt <a style="text-decoration:none;color:red;" href="/free-gems?action=vong_quay">vòng
                quay</a> (10 link -> 1 lượt): </p>
        <div id="linkContainer">
        </div>
        <p>Tổng link đã vượt: <?= freegemsUser($user_id, 'total') ?></p>
</section>


<script>
    function renderLink() {
        $.ajax({
            type: 'POST',
            url: '/api/api-megaurl.php',
            data: {
                id: <?= $_SESSION['user_id']; ?>
            },
            success: function (response) {
                $("#linkContainer").html(response);
            },
        });
    };
    renderLink();
</script>