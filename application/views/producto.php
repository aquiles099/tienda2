<div class="vista-producto">
	<?php $this->load->view('breadcrumbs', ['pages' => $breadcrumbs]); ?>
	<div class="row">
		<div class="col-md-7 col-md-push-5">
			<h1 class="nombre-producto"><?php echo $elproducto->nombre; ?></h1>
			<?php if (isset($elproducto->descripcion_tipo)) { ?>
				<h2 class="descripcion-producto"><?php echo $elproducto->descripcion_tipo; ?></h2>
			<?php }
			if ($listadeprecios && !empty($elproducto->$listadeprecios)) { ?>
				<p class="precio">$ <?php echo $elproducto->$listadeprecios ?></p>
			<?php } ?>
			<?php if (!empty($productos)) {
				// Variantes
				foreach ($productos as $producto) { ?>
					<div class="datos-producto">
						<?php if ($producto->descripcion) { ?>
							<label class="variante-producto">
								<input type="radio" name="idproducto" value="<?php echo $producto->idproducto ?>">
								<?php echo str_replace(' - ' . $elproducto->descripcion_tipo, '', $producto->descripcion); ?>
							</label>
						<?php } ?>
					</div>
				<?php }
			}?>
			<div class="acciones">
				<div id="cart-feedback"></div>
				<button data-id="<?php echo $elproducto->idproducto ?>" class="btn btn-primary add-product-btn">
					<i class="fa fa-spinner fa-spin fa-fw"></i>
					Agregar al carro
				</button>
				<input type="number" class="form-control quantity" value="1">
			</div>
		</div>
		<div class="col-md-5 col-md-pull-7">
			<div class="preview">
				<?php foreach ($fotos as $i => $foto) { ?>
					<a class="img fancybox" href="<?php echo base_url('assets/uploads/files/' . $foto->src) ?>" data-thumb="<?php echo $i ?>">
						<img src="<?php echo base_url('assets/uploads/files/' . $foto->src) ?>">
					</a>
				<?php } ?>
			</div>
			<div class="thumbs">
				<?php foreach ($fotos as $i => $foto) { ?>
					<a class="thumb" data-thumb="<?php echo $i ?>"
						style="background-image:url(<?php echo base_url('assets/uploads/files/' . $foto->src) ?>)">
						<span class="legend"><?php echo $foto->titulo; ?></span>
					</a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>