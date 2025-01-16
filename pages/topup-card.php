<html>
<?php
session_start();
$pageTitle = "Nạp Gems (card) | QuackMC Network";
require_once(__DIR__ . "/../includes/head.php");
require_once(__DIR__ . "/../includes/header.php");

if (!isset($_SESSION['username'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>

<body class="bg-global_0">
    <section class="main">
        <div class="home">
            <link rel="stylesheet" type="text/css" href="/assets/css/sweetalert.css?v=<?= time() ?>">
            <script src="/libs/jquery/dist/jquery-1.11.2.min.js?v=<?= time() ?>"></script>
            <script src="/assets/js/sweetalert.min.js?v=<?= time() ?>"></script>
            <section class="main">
                <button class="tab rounded-tl-lg tab-selected">Nạp thẻ</button>
                <button class="tab" onclick="window.location.href='/topup-bank'">Ngân
                    hàng</button>
                <button class="tab rounded-tr-lg"
                    onclick="window.location.href='https://thesieuviet.net/recharge/nap-quackmc-network'">Thẻ
                    Siêu Việt</button>

        </div>
        <form class="form-wrapper" id="napThe">
            <input type='hidden' name='_csrf' value='wvx0B2Ux-0w0D1wzEYH-TZcUbzu7791hSonA'>
            <div
                style="background-color: #CF0A0A; border-radius: 12px; margin-top: 5px; padding: 10px; text-align: center;">
                <div style="color: white; font-weight: bold; font-size: 11px;">
                    NGƯỜI CHƠI PHẢI ĐĂNG NHẬP GAME LẦN ĐẦU TRƯỚC KHI NẠP!
                </div>
            </div>
            <select class="form-control" name="card_type" id="cardSelect">
                <option disabled selected>Chọn loại thẻ</option>
                <option value="VIETTEL">Viettel</option>
                <option value="VINAPHONE">Vinaphone</option>
                <option value="MOBIFONE">Mobifone</option>
            </select>

            <select class="form-control" name="amount" id="amountSelect">
                <option disabled selected>Chọn mệnh giá</option>
                <option value="10000">10.000đ</option>
                <option value="20000">20.000đ </option>
                <option value="30000">30.000đ</option>
                <option value="50000">50.000đ</option>
                <option value="100000">100.000đ</option>
                <option value="200000">200.000đ</option>
                <option value="300000">300.000đ</option>
                <option value="500000">500.000đ</option>
                <option value="1000000">1.000.000đ</option>
            </select>
            <input type="text" class="form-control" name="gems2" id="gems2" required placeholder="Gems nhận được"
                readonly />
            <input type="text" class="form-control" name="gems" id="gems" required placeholder="Gems nhận được" readonly
                style="display: none;" />
            <input type=" text" class="form-control" name="username" id="username" value="<?= $username ?>" required
                placeholder="Tên nhân vật (Vui Lòng Đăng Nhập)" readonly onclick="redirectToLoginIfEmpty()" />
            <input type="number" class="form-control" name="code" id="code" required placeholder="Mã thẻ" />
            <input type="number" class="form-control" name="seri" id="seri" required placeholder="Serial thẻ" />


            <button type="submit" id="btn-submit" class="btn-submit">Nạp Thẻ</button>
        </form>
        <div class="sub-form">
            <a href="/profile" class="primary" style="position: relative; top: -15px;">Lịch sử nạp</a>
        </div>
        <script src="/assets/js/post.js?v=<?= time() ?>"></script>
        <script>
            function redirectToLoginIfEmpty() {
                var usernameInput = document.getElementById('username').value;
                if (!usernameInput || usernameInput.trim() === '') {
                    window.location.href = '/login';
                }
            }
        </script>
        </div>
        <script>
            $(document).ready(function () {
                $('#amountSelect').change(function () {
                    var selectedAmount = $(this).val();
                    var gems = '';
                    var gems2 = '';

                    switch (selectedAmount) {
                        case '10000':
                            gems = '10';
                            gems2 = '10 Gems';
                            break;
                        case '20000':
                            gems = '20';
                            gems2 = '20 Gems';
                            break;
                        case '30000':
                            gems = '30';
                            gems2 = '30 Gems';
                            break;
                        case '50000':
                            gems = '50';
                            gems2 = '50 Gems';
                            break;
                        case '100000':
                            gems = '100';
                            gems2 = '100 Gems';
                            break;
                        case '200000':
                            gems = '200';
                            gems2 = '200 Gems';
                            break;
                        case '300000':
                            gems = '300';
                            gems2 = '300 Gems';
                            break;
                        case '500000':
                            gems = '500';
                            gems2 = '500 Gems';
                            break;
                        case '1000000':
                            gems = '1000';
                            gems2 = '1000 Gems';
                            break;
                        default:
                            break;
                    }

                    $('#gems').val(gems);
                    $('#gems2').val(gems2);
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#napThe').submit(function (e) {
                    e.preventDefault();
                    $('#btn-submit').text('Loading...');
                    $.ajax({
                        type: 'POST',
                        data: $(this).serialize(),
                        complete: function () {
                            $('#btn-submit').text('Nạp Thẻ');
                        }
                    });
                });
            });
        </script>
        <?php
        require_once(__DIR__ . "/../includes/footer.php");
        ?>
</body>
<style>
    .lds-ripple,
    .lds-ripple div {
        box-sizing: border-box;
    }

    .lds-ripple {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .lds-ripple div {
        position: absolute;
        border: 4px solid currentColor;
        opacity: 1;
        border-radius: 50%;
        animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
    }

    .lds-ripple div:nth-child(2) {
        animation-delay: -0.5s;
    }

    @keyframes lds-ripple {
        0% {
            top: 36px;
            left: 36px;
            width: 8px;
            height: 8px;
            opacity: 0;
        }

        4.9% {
            top: 36px;
            left: 36px;
            width: 8px;
            height: 8px;
            opacity: 0;
        }

        5% {
            top: 36px;
            left: 36px;
            width: 8px;
            height: 8px;
            opacity: 1;
        }

        100% {
            top: 0;
            left: 0;
            width: 80px;
            height: 80px;
            opacity: 0;
        }
    }
</style>

</html>