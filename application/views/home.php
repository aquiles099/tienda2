<?php if ($categorias) { ?>
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
			<div class="titulo"><strong>Productos</strong> más vendidos</div>
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
			<div class="titulo"><strong>Nuestras</strong> ofertas</div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/1.jpg" width="150px"><br/><span class="nombre">Producto 11</span><br/><span class="valor">20$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/2.jpg" width="150px"><br/><span class="nombre">Producto 12</span><br/><span class="valor">15$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/3.jpg" width="150px"><br/><span class="nombre">Producto 13</span><br/><span class="valor">45$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/1.jpg" width="150px"><br/><span class="nombre">Producto 14</span><br/><span class="valor">30$</span></div>
			<div class="lista"><img src="<?php echo base_url() ?>assets/uploads/tienda/2.jpg" width="150px"><br/><span class="nombre">Producto 15</span><br/><span class="valor">10$</span></div>
		</div>
	<?php } ?>
</div>
