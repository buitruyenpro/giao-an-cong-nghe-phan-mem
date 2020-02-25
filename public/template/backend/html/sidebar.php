<?php 
	// <small class="badge pull-right bg-red">3</small>
	$arrMenus	= array(
		array('class' => 'group'	, 'name' => 'Chức vụ'		, 'icon' => 'group'			, 'link' => $this->basePath('admin/group/index')),
		array('class' => 'user'		, 'name' => 'Người dùng'			, 'icon' => 'user'			, 'link' => $this->basePath('admin/user/index')),
		array('class' => 'category'	, 'name' => 'Danh mục'		, 'icon' => 'suitcase'		, 'link' => $this->basePath('admin/category/index')),
		array('class' => 'book'		, 'name' => 'Giáo án'			, 'icon' => 'book'			, 'link' => $this->basePath('admin/book/index')),
	);
	
	$xhtmlMenu = '';
	foreach ($arrMenus as $menu){
		if(!empty($menu['children'])){
			$xhtmlChildMenu		= '';
			foreach ($menu['children'] as $menuChild){
				$xhtmlChildMenu .= sprintf('<li class="admin-%s">
												<a href="%s" style="margin-left: 10px;">
													<i class="fa fa-%s"></i> %s
												</a>
											</li>',$menuChild['class'], $menuChild['link'], $menuChild['icon'], $menuChild['name']);
			}
			$xhtmlMenu .= sprintf('<li class="treeview admin-%s">
										<a href="%s"> 
											<i class="fa fa-%s"></i> <span>%s</span><i class="fa fa-angle-left pull-right"></i>
										</a>
										<ul class="treeview-menu">
											%s
										</ul>
									</li>',$menu['class'], $menu['link'], $menu['icon'], $menu['name'], $xhtmlChildMenu);
		}else{
			$xhtmlMenu .= sprintf('<li class="admin-%s">
									<a href="%s"> 
										<i class="fa fa-%s"></i><span>%s</span>
									</a>
								</li>',$menu['class'], $menu['link'], $menu['icon'], $menu['name']);
		}
	}

?>


<section class="sidebar">

	<!-- Sidebar user panel -->
	<div class="user-panel">
		<div class="pull-left image">
			<img src="<?php echo $urlImage;?>/avatar3.png" class="img-circle" alt="User Image">
		</div>
		<div class="pull-left info">
			<p>Hello, Jane</p>
			<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
		</div>
	</div>

	<!-- sidebar menu: : style can be found in sidebar.less -->
	<ul class="sidebar-menu">
		<?php echo $xhtmlMenu;?>
	</ul>
</section>