<?php
    $sql="SELECT * FROM product WHERE prd_featured=1 ORDER BY prd_id DESC LIMIT 6";
    $query = mysqli_query($conn, $sql);

?>
<!--	Feature Product	-->
<div class="products">
    <h3>Sản phẩm nổi bật</h3>
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
<!--	End Feature Product	-->