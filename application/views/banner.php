<?php if ($banner) { ?>
	<div class="banner">
		<?php if ($banner->url) {
			$target = $banner->targetblank ? 'target="_blank"' : '';
			echo "<a href=\"$banner->url\" $target>"; 
		} ?>
		<img src="<?php echo base_url($banner->img); ?>">
		<?php if ($banner->url) {
			echo '</a>';
		} ?>
	</div>
<?php }
