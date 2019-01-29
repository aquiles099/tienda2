<div class="carro">
	<div class="row">
		<div class="col-sm-8">
			<h1>Carro de compras</h1>
			<?php if ($productosencarro) {
				foreach ($carro as $idproducto => $producto) { ?>
					<div class="producto" data-id="<?php echo $idproducto ?>">
						<div class="row">
							<div class="thumb col-sm-2">
								<img src="<?php echo $producto->foto ?>">
							</div>
							<div class="info col-sm-6">
								<p class="descripcion"><a href="<?php echo base_url('producto/' . $producto->ruta) ?>"><?php echo $producto->descripcion ?></a></p>
								<?php if (isset($producto->precio)) { ?>
									<p class="precio unitario">$ <span class="numero"><?php echo $producto->precio ?></span></p>
								<?php } ?>
							</div>
							<div class="opciones col-sm-4">
								<input class="form-control cantidad" type="number" value="<?php echo $producto->cantidad ?>">
								<?php if (isset($producto->precio)) { ?>
									<p class="precio subtotal">$ <span class="numero"><?php echo $producto->precio * $producto->cantidad ?></span></p>
								<?php } ?>
								<a class="eliminar-producto-btn"><span class="fa fa-trash"></span></a>
							</div>
						</div>
					</div>
				<?php }
			} else { ?>
				<p>No tiene productos en el carro.</p>
				<p><a href="<?php echo base_url() ?>">Continuar comprando.</a></p>
			<?php } ?>
		</div>
		<div class="col-sm-4">
			<p class="productosencarro"><span class="numero"><?php echo $productosencarro ?></span> artículo(s)</p>
			<?php if (isset($total)) { ?>
				<p class="total">Total $ <span class="numero"><?php echo $total ?></span></p>
			<?php } ?>
			<a href="<?php echo base_url('checkout') ?>" class="btn btn-primary <?php if (!$productosencarro) echo 'disabled'; ?>">Finalizar pedido</a>
		</div>
	</div>
</div>