<?php
	if(!defined('SECURITY')){
		die('Bạn không có quyền truy cập file này !!!');
	}

	$limit = 5;
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}else{
		$page=1;
	}
	$skip = $page*$limit - $limit;
	$sql="SELECT * FROM category ORDER BY cat_id DESC LIMIT $skip,$limit";
	$query = mysqli_query($conn, $sql);

	$total_cat = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM category"));
	$total_page = ceil($total_cat/$limit);
	$list_page = '';

	if($page>1){
		$page_pre = $page-1;
		$list_page .= '<li class="page-item"><a class="page-link" href="index.php?page_layout=category&page='.$page_pre.'">&laquo;</a></li>';
	}else{
		$list_page .= '<li class="page-item disabled"><a class="page-link">&laquo;</a></li>';
	}

	for($i=1; $i<=$total_page; $i++){
		if($page == $i ){
			$list_page .= '<li class="page-item active"><a class="page-link" href="index.php?page_layout=category&page='.$i.'">'.$i.'</a></li>';
		}else{
			$list_page .= '<li class="page-item"><a class="page-link" href="index.php?page_layout=category&page='.$i.'">'.$i.'</a></li>';
		}
	}

	if($page>=$total_page){
		$list_page .= '<li class="page-item disabled"><a class="page-link">&raquo;</a></li>';
	}else{
		$page_next = $page+1;
		$list_page .= '<li class="page-item"><a class="page-link" href="index.php?page_layout=category&page='.$page_next.'">&raquo;</a></li>';
	}

?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><svg class="glyph stroked home">
						<use xlink:href="#stroked-home"></use>
					</svg></a></li>
			<li class="active">Quản lý danh mục</li>
		</ol>
	</div>
	<!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Quản lý danh mục</h1>
		</div>
	</div>
	<!--/.row-->
	<div id="toolbar" class="btn-group">
		<a href="index.php?page_layout=add_category" class="btn btn-success">
			<i class="glyphicon glyphicon-plus"></i> Thêm danh mục
		</a>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<table data-toolbar="#toolbar" data-toggle="table">

						<thead>
							<tr>
								<th data-field="id" data-sortable="true">ID</th>
								<th>Tên danh mục</th>
								<th>Hành động</th>
							</tr>
						</thead>
						<tbody>
							<?php while($cat = mysqli_fetch_array($query)){ ?>
							<tr>
								<td style=""><?php echo $cat['cat_id']; ?></td>
								<td style=""><?php echo $cat['cat_name']; ?></td>
								<td class="form-group">
									<a href="index.php?page_layout=edit_category&cat_id=<?php echo $cat['cat_id']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
									<a onclick="return delCat('<?php echo $cat['cat_name']; ?>')" href="del_category.php?cat_id=<?php echo $cat['cat_id']; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
					<nav aria-label="Page navigation example">
						<ul class="pagination">
							<?php echo $list_page; ?>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!--/.row-->
</div><!--/.main-->

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-table.js"></script>
<script>
	function delCat(catName){
		return confirm('Bạn có chắc chắn muốn xóa danh mục '+catName+' ?');
	}
</script>