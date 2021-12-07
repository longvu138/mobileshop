<?php
    if(isset($_GET['cat_id']) && isset($_GET['cat_name'])){
        $cat_id = $_GET['cat_id'];
        $cat_name = $_GET['cat_name'];
        $total_prd= mysqli_num_rows(mysqli_query($conn, "SELECT * FROM product WHERE cat_id=$cat_id"));

        $sql = "SELECT * FROM product WHERE cat_id=$cat_id ORDER BY prd_id DESC";
        $query = mysqli_query($conn, $sql);
    }else{
        die('404. Not Found!');
    }
?>
<!--	List Product	-->
<div class="products">
    <h3><?php echo $cat_name; ?> (hiện có <?php echo $total_prd; ?> sản phẩm)</h3>
    <div class="row">
        <?php while($prd = mysqli_fetch_array($query)){ ?>
        <div class="col-lg-4 col-md-4 col-sm6 product">
            <div class="product-item card text-center">
                <a href="index.php?page_layout=product&prd_id=<?php echo $prd['prd_id']; ?>"><img src="./admin/img/<?php echo $prd['prd_image']; ?>"></a>
                <h4><a href="index.php?page_layout=product&prd_id=<?php echo $prd['prd_id']; ?>"><?php echo $prd['prd_name']; ?></a></h4>
                <p>Giá Bán: <span><?php echo number_format($prd['prd_price'],0,'','.'); ?>đ</span></p>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<!--	End List Product	-->

<div id="pagination">
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Trang trước</a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Trang sau</a></li>
    </ul>
</div>

