<?php
ob_start();
if (isset($_SESSION['cart'])) {
    if (isset($_POST['sbm'])) {
        foreach ($_POST['qty'] as $prd_id => $qty) {
            $_SESSION['cart'][$prd_id] = $qty;
        }
    }
    //tạo mảng rỗng chứa các id của giỏ hàng
    $arr_id = array();
    foreach ($_SESSION['cart'] as $prd_id => $qty) {
        $arr_id[] = $prd_id; // push id vừa duyệt vào mảng
    }
    $list_id = implode(', ', $arr_id); // tạo dãy cách nhau dấu ,  vd: 1,2,3
    $sql = "SELECT * FROM product WHERE prd_id IN($list_id)"; // sql where in
    $query = mysqli_query($conn, $sql);

?>
    <!--	Cart	-->
    <div id="my-cart">
        <div class="row">
            <div class="cart-nav-item col-lg-7 col-md-7 col-sm-12">Thông tin sản phẩm</div>
            <div class="cart-nav-item col-lg-2 col-md-2 col-sm-12">Tùy chọn</div>
            <div class="cart-nav-item col-lg-3 col-md-3 col-sm-12">Giá</div>
        </div>
        <form method="post">
            <?php
            $total_price = 0;
            $total_price_all = 0;
            while ($prd = mysqli_fetch_array($query)) {
                $total_price = $prd['prd_price'] * $_SESSION['cart'][$prd['prd_id']];
                $total_price_all += $total_price;
            ?>
                <div class="cart-item row">
                    <div class="cart-thumb col-lg-7 col-md-7 col-sm-12">
                        <img src="./admin/img/<?php echo $prd['prd_image']; ?>">
                        <h4><?php echo $prd['prd_name']; ?></h4>
                    </div>
                      
                    <div class="cart-quantity col-lg-2 col-md-2 col-sm-12">
                        <input type="number" id="quantity" class="form-control form-blue quantity" name="qty[<?php echo $prd['prd_id']; ?>]" value="<?php echo $_SESSION['cart'][$prd['prd_id']]; ?>" min="1">
                    </div>
                    <div class="cart-price col-lg-3 col-md-3 col-sm-12"><b><?php echo number_format($total_price, 0, '', '.') ?>đ</b><a href="./modules/cart/del_cart.php?prd_id=<?php echo $prd['prd_id']; ?>">Xóa</a></div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="cart-thumb col-lg-7 col-md-7 col-sm-12">
                    <button id="update-cart" class="btn btn-success" type="submit" name="sbm">Cập nhật giỏ hàng</button>
                </div>
                <div class="cart-total col-lg-2 col-md-2 col-sm-12"><b>Tổng cộng:</b></div>
                <div class="cart-price col-lg-3 col-md-3 col-sm-12"><b><?php echo number_format($total_price_all, 0, '', '.') ?>đ</b></div>
            </div>
        </form>

    </div>
    <!--	End Cart	-->

<?php } else { ?>
    <div class="alert alert-danger">Hiện tại giỏ hàng của bạn chưa có sản phẩm nào!</div>
<?php } ?>

<!--	Customer Info	-->
<?php
require 'SendMail/src/Exception.php';
require 'SendMail/src/PHPMailer.php';
require 'SendMail/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if (isset($_POST['email'])) {
    if ($_POST['email'] != '') {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $html = '
            
        <div style="border: 1px dotted forestgreen;">
        <h3 align="center">Thông tin khách hàng</h3>
        Họ tên:' . $name . ' <br>
        Sđt:' . $phone . ' <br>
        email: ' . $email . ' <br>
        địa chỉ : ' . $address . '
        </div>
        <table style="width: 100%;" >
        <thead style="background-color: cornflowerblue;">
            <tr>
            <th>Mã Sản phẩm</th>
            <th>Tên Sản Phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
            </tr>
    </thead>
    <tbody>
            ';

        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($query)) {
            $html .= '
    <tr>
            <td>#' . $row['prd_id'] . '</td>
            <td>' . $row['prd_name'] . '</td>
            <td>' . $_SESSION['cart'][$row['prd_id']] . '</td>
            <td>' . number_format($row['prd_price'], 0, '', '.') . 'đ</td>
            <td>' . number_format($_SESSION['cart'][$row['prd_id']] * $row['prd_price'], 0, '', '.') . 'đ</td>
        </tr>
    ';
        }



        $html .= '
    <tr style="font-size: 30px; font-weight: bold; color: red;">
            <td >Tổng tiền</td>
            <td  colspan="4" align="right">' . number_format($total_price_all, 0, '', '.') . 'đ</td>
        </tr>
      
    </tbody>
    </table>
    <p align="center" style="font-weight: bold;">Cảm ơn bạn đã mua hàng bên MOBILE SHOP</p>
    ';

        // Gửi mail

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'tranlongvu1382000@gmail.com';                     // SMTP username
            $mail->Password   = 'vu1382000';                               // SMTP password
            $mail->SMTPSecure = 'TLS';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //fix loi font tiếng việt
            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom('tranlongvu1382000@gmail.com', 'MOBILE SHOP');
            $mail->addAddress($email, $name);     // Add a recipient


            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'XÁC NHẬN ĐƠN HÀNG từ MOBILE SHOP';
            $mail->Body    = $html;

            $mail->send();
            session_destroy();
            header('location: index.php?page_layout=success');
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<div id="customer">
    <form id="frm" method="post">
        <div class="row">

            <div id="customer-name" class="col-lg-4 col-md-4 col-sm-12">
                <input placeholder="Họ và tên (bắt buộc)" type="text" name="name" class="form-control" required>
            </div>
            <div id="customer-phone" class="col-lg-4 col-md-4 col-sm-12">
                <input placeholder="Số điện thoại (bắt buộc)" type="text" name="phone" class="form-control" required>
            </div>
            <div id="customer-mail" class="col-lg-4 col-md-4 col-sm-12">
                <input placeholder="Email (bắt buộc)" type="text" name="email" class="form-control" required>
            </div>
            <div id="customer-add" class="col-lg-12 col-md-12 col-sm-12">
                <input placeholder="Địa chỉ nhà riêng hoặc cơ quan (bắt buộc)" type="text" name="address" class="form-control" required>
            </div>

        </div>
    </form>
    <div class="row">
        <div class="by-now col-lg-6 col-md-6 col-sm-12">
            <a onclick="buyNow()">
                <b>Mua ngay</b>
                <span>Giao hàng tận nơi siêu tốc</span>
            </a>
        </div>
        <div class="by-now col-lg-6 col-md-6 col-sm-12">
            <a href="#">
                <b>Trả góp Online</b>
                <span>Vui lòng call (+84) 0988 550 553</span>
            </a>
        </div>
    </div>
</div>
<!--	End Customer Info	-->

<script>
    function buyNow() {
        document.getElementById('frm').submit();
    }
</script>