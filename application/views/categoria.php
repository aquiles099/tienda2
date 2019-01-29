<?php $this->load->view('breadcrumbs', ['pages' => $breadcrumbs]); ?>
<?php if ($lacategoria->header) {
	echo '<img class="header-categoria" src="' . base_url("assets/uploads/files/$lacategoria->header") . '" alt="' . $lacategoria->categoria . '">';
}
if ($categorias && !$productos) { ?>
	<div class="categorias">
		<?php foreach ($categorias as $categoria) {
			if ($categoria->thumb) { ?>
				<div class="thumb">
					<a href="<?php echo base_url("categoria/$categoria->ruta") ?>" style="background-image:url(<?php echo base_url("assets/uploads/files/$categoria->thumb") ?>)"></a>
					<h3 class="titulo">
						<a href="<?php echo base_url("categoria/$categoria->ruta") ?>">
							<?php echo $categoria->categoria ?>
						</a>
					</h3>
				</div>
			<?php }
		} ?>
	</div>
<?php }
if ($destacados) { ?>
	<div class="destacados">
		<div style="color:#ffffff;  font-size:2em; margin:10px 0; font-weight:100;">PRODUCTOS <span style="font-weight:bold">DESTACADOS</span></div>
		<div class="destacado"><img src="<?php echo base_url() ?>assets/uploads/tienda/1.jpg"></div>
		<div class="destacado"><img src="<?php echo base_url() ?>assets/uploads/tienda/2.jpg"></div>
		<div class="destacado"><img src="<?php echo base_url() ?>assets/uploads/tienda/3.jpg"></div>
	</div>
<?php } ?>
<div class="grilla-productos">
	<?php if ($masvendidos) { ?>
		<div class="modulo masvendidos">
			<h3 class="titulo"><strong>Productos</strong> más vendidos</h3>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/1.jpg" width="150px"><br/><span class="nombre">Producto 1</span><br/><span class="valor">20$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/2.jpg" width="150px"><br/><span class="nombre">Producto 2</span><br/><span class="valor">15$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/3.jpg" width="150px"><br/><span class="nombre">Producto 3</span><br/><span class="valor">45$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/1.jpg" width="150px"><br/><span class="nombre">Producto 4</span><br/><span class="valor">30$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/2.jpg" width="150px"><br/><span class="nombre">Producto 5</span><br/><span class="valor">10$</span></div>
			
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/1.jpg" width="150px"><br/><span class="nombre">Producto 6</span><br/><span class="valor">20$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/2.jpg" width="150px"><br/><span class="nombre">Producto 7</span><br/><span class="valor">15$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/3.jpg" width="150px"><br/><span class="nombre">Producto 8</span><br/><span class="valor">45$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/1.jpg" width="150px"><br/><span class="nombre">Producto 9</span><br/><span class="valor">30$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/2.jpg" width="150px"><br/><span class="nombre">Producto 10</span><br/><span class="valor">10$</span></div>
		</div>
	<?php }
	if ($ofertas) { ?>
		<div class="modulo ofertas">
			<h3 class="titulo"><strong>Nuestras</strong> ofertas</h3>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/1.jpg" width="150px"><br/><span class="nombre">Producto 11</span><br/><span class="valor">20$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/2.jpg" width="150px"><br/><span class="nombre">Producto 12</span><br/><span class="valor">15$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/3.jpg" width="150px"><br/><span class="nombre">Producto 13</span><br/><span class="valor">45$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/1.jpg" width="150px"><br/><span class="nombre">Producto 14</span><br/><span class="valor">30$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/2.jpg" width="150px"><br/><span class="nombre">Producto 15</span><br/><span class="valor">10$</span></div>
		</div>
	<?php }
	if (!empty($marcas) && !empty($productos)) { ?>
		<div class="modulo marcas">
			<?php if(!empty($lamarca)){ ?>
			<input type="hidden" name="lamarca" id="lamarca" value="<?php echo $lamarca->id; ?>">
			<input type="hidden" name="lamarca_ruta" id="lamarca_ruta" value="<?php echo $lamarca->ruta; ?>">
			<?php } ?>
			<h3 class="titulo">Marcas</h3>
			<div class="lista">
				<div class="col-xs-12 slick-slider">
				<?php foreach ($marcas as $marca) { ?>
					<article class="marca">
						<a href="<?php echo base_url('categoria/'.$lacategoria->ruta.'/'.$marca->ruta) ?>" class="thumb" style="background-image:url(<?php echo !empty($marca->thumb) ? base_url('assets/uploads/files/' . $marca->thumb) : base_url('assets/img/no-foto.png'); ?>);">
							<span class="detalles">
								<span class="nombre"><?php echo $marca->marca ?></span>
							</span>
						</a>
					</article>
				<?php } ?>
				</div>
			</div>
		</div>
	<?php }

	if ($productos) { ?>
		<div class="modulo productos">
			<h3 class="titulo"><?php echo $lacategoria->categoria ?></h3>
			<div class="lista">
				<?php foreach ($productos as $producto) { ?>
					<article class="producto">
						<a href="<?php echo base_url('producto/' . $producto->ruta()) ?>" class="thumb" style="background-image:url(<?php echo $producto->thumb() ?>)">
							<span class="detalles">
								<span class="nombre"><?php echo $producto->nombre ?></span>
								<?php if ($listadeprecios && !empty($producto->$listadeprecios)) { ?>
									<br/><span class="precio">$ <?php echo $producto->$listadeprecios ?></span>
								<?php } ?>
							</span>
						</a>
					</article>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</div>
