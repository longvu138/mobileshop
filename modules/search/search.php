<?php
    if(isset($_POST['key'])){
        $keyword = $_POST['key'];

        $arr_keyword = explode(' ', $keyword);
        $key= '%'.implode('%', $arr_keyword).'%';
        $sql = "SELECT * FROM product WHERE prd_name LIKE '$key'";
        $query= mysqli_query($conn, $sql);
    }else{
        die('404 NOT FOUND');
    }
?>

<!--	List Product	-->
<div class="products">
    <div id="search-result">Kết quả tìm kiếm với sản phẩm:  <span><?php echo $keyword; ?></span></div>
    <div class="row">
        <?php while($prd=mysqli_fetch_array($query)){ ?>
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

