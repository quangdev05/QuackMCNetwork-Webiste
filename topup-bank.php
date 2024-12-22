<html>
<?php
$pageTitle = "Nạp Gems (bank) | PlayST Network";
require_once(__DIR__ . "/includes/head.php");
require_once(__DIR__ . "/includes/header.php");
require_once(__DIR__ . "/config/db.php");
require_once(__DIR__ . "/includes/helpers.php");

if (!isset($_SESSION['username'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>

<body class="bg-global_0">
  <section class="main">
<div class="home">
<section class="main">
    <button class="tab rounded-tl-lg" onclick="window.location.href='https://www.playst.click/topup-card'">Nạp
        thẻ</button>
    <button class="tab tab-selected">Ngân hàng</button>
    <button class="tab rounded-tr-lg" onclick="window.location.href='https://thesieuviet.net/recharge/nap-quackmc-network'">Thẻ
        Siêu Việt</button>
    </div>
    <form action="#submit" method="POST" class="form-wrapper" id="napBank"
        onsubmit="return redirectToLoginIfEmpty();">
        <input type='hidden' name='_csrf' value='wvx0B2Ux-0w0D1wzEYH-TZcUbzu7791hSonA'>
        <div
            style="background-color: #CF0A0A; border-radius: 12px; margin-top: 5px; padding: 10px; text-align: center;">
            <div style="color: white; font-weight: bold; font-size: 11px;">
                NGƯỜI CHƠI PHẢI ĐĂNG NHẬP GAME LẦN ĐẦU TRƯỚC KHI NẠP!
            </div>
            <div style="color: white; font-weight: bold; font-size: 11px;">
                NẠP QUA BANK SẼ KHÔNG GHI LỊCH SỬ VÀO PROFILE!
            </div>
        </div>
        <select class="form-control" name="name" id="bankSelect" style="display: none;" required>
            <option value="MB" selected>MBBank</option>

        </select>

        <input type="text" class="form-control" name="MB" value="MBBank" id="MB" required placeholder="Ngân hàng"
            readonly />
        <input type="number" class="form-control" name="stk" id="stkInput" required placeholder="Số tài khoản"
            readonly />

        <input type="text" class="form-control" name="tentk" id="tentkInput" required placeholder="Chủ tài khoản"
            readonly />

        <input type="text" class="form-control" name="username" id="usernameInput" value="<?= $username ?>" required
            placeholder="Tên nhân vật (Vui Lòng Đăng Nhập)" readonly onclick="redirectToLoginIfEmpty()" />

        <input type="number" class="form-control" name="gems" id="gemsInput" required
            placeholder="Gems (1 Gems = 820đ)" />

        <input type=" text" name="money2" id="money2" required placeholder="Tổng thanh toán (VND)"
            value="<?php echo isset($money) ? htmlspecialchars($money) : ''; ?>" readonly />

        <input type=" number" name="money" id="money" required placeholder="Tổng thanh toán (VND)"
            value="<?php echo isset($money) ? htmlspecialchars($money) : ''; ?>" readonly style="display: none;" />

        <input type="text" class="form-control" name="nd" id="ndInput" required placeholder="Nội dung" readonly />

        <input type="hidden" name="temp" value="compact">
        <button type="submit" id="submit" name="submit" class="btn-submit">Tạo QR Code</button>
        </div>
    </form>
    </div>
    <?php
    function check_string($data)
    {
        return trim(htmlspecialchars(addslashes($data)));
    }
    function format_money($value)
    {
        return trim(str_replace('đ', '', $value));
    }

    $fixed_info = array(
        "MB" => array("stk" => "409088888", "tentk" => "PHAM DUY QUANG"),
    );

    $name = isset($_POST['name']) ? $_POST['name'] : ""; 
    
    if (isset($_POST['submit'])) {
        $name = check_string($_POST['name']);
        $stk = isset($fixed_info[$name]) ? $fixed_info[$name]['stk'] : "";
        $money = check_string(format_money($_POST['money']));
        $money2 = check_string(format_money($_POST['money2']));
        $gems = check_string(format_money($_POST['gems']));
        $tentk = urlencode(isset($fixed_info[$name]) ? $fixed_info[$name]['tentk'] : "");
        $nd = urlencode(check_string($_POST['nd']));
        $temp = check_string($_POST['temp']);
        if (!$name) {
            echo 'Bạn chưa chọn ngân hàng';
        } else if (!$stk) {
            echo 'Không có thông tin số tài khoản cho ngân hàng này';
        } else {
            $url = "https://img.vietqr.io/image/$name-$stk-$temp.png?amount=$money&addInfo=$nd&accountName=$tentk";
            $code = rand(100000000, 999999999);
            // $PTDUNG->insert("recharge_logs", array(
            //     'user_id' => $_SESSION['user_id'],
            //     'trans_id' => $code,
            //     'amount2' => $money2,
            //     'gems' => $gems,
            //     'method' => "Bank-" . $name,
            //     'status' => 3,
            //     'create_time' => get_time(),
            // ));
        }
    }
    ?>
    <?php if (isset($url)) { ?>
        <center>
            <div class="col-md-1" style="text-align: center;">
                <img src="<?= $url; ?>" class="centered-image">
            </div>

            <style>
                .centered-image {
                    display: block;
                    margin-left: auto;
                    margin-right: auto;
                    max-width: 20%;
                    height: auto;
                }
            </style>

            <div class="form-group">
            </div>
            </div>
        </center>
    <?php } ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
        integrity="sha384-smHYKdLADwkXOn1EmN1k/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('#bankSelect').change(function () {
                var selectedBank = $(this).val();
                var stk = '<?php echo isset($fixed_info["MB"]) ? $fixed_info["MB"]["stk"] : ""; ?>';
                var tentk = '<?php echo isset($fixed_info["MB"]) ? urldecode($fixed_info["MB"]["tentk"]) : ""; ?>';

                if (selectedBank === "MB") {
                    stk = '<?php echo isset($fixed_info["MB"]) ? $fixed_info["MB"]["stk"] : ""; ?>';
                    tentk = '<?php echo isset($fixed_info["MB"]) ? urldecode($fixed_info["MB"]["tentk"]) : ""; ?>';
                }

                $('#stkInput').val(stk);
                $('#tentkInput').val(tentk);
            });

            $(document).ready(function () {
                var defaultBank = 'MB';
                $('#bankSelect').val(defaultBank).change();
            });

            setInterval(function () {
                var username = $('#usernameInput').val();
                var content = 'PlayST ' + username + 'Player';
                $('#ndInput').val(content);
            }, 100);

            $('#gemsInput').on('input', function () {
                var gems = $(this).val();
                var total = gems * 820;
                $('#money').val(total);
            });

            $('#gemsInput').on('input', function () {
                var gems = $(this).val();
                var total = gems * 820;
                var formattedTotal = formatCurrency(total);
                $('#money2').val(formattedTotal);
            });
            function formatCurrency(value) {
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + "đ";
            }
        });
    </script>

    <script>
        function redirectToLoginIfEmpty() {
            var usernameInput = document.getElementById('usernameInput').value;
            if (!usernameInput || usernameInput.trim() === '') {
                alert('Vui lòng đăng nhập để tiếp tục.');
                window.location.href = '/login';
                return false;
            }
            return true;
        }
    </script>
    </div>

    <?php
    require_once(__DIR__ . "/includes/footer.php");
    ?>
    </body>
</html>
