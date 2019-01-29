<ol class="breadcrumb">
	<li><a href="<?php echo base_url('home') ?>">Tienda</a></li>
	<?php foreach ($pages as $page) {
		if (!empty($page['url'])) { ?>
			<li><a href="<?php echo $page['url'] ?>"><?php echo $page['title'] ?></a></li>
		<?php } else { ?>
			<li class="active"><?php echo $page['title'] ?></li>
		<?php }
	} ?>
</ol>