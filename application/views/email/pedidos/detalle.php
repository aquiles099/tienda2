<table class="carro">
	<tbody>
		<?php foreach ($carro as $idproducto => $producto) { ?>
			<tr class="producto">
				<td class="thumb">
					<img src="<?php echo $producto->foto ?>">
				</td>
				<td class="detalles">
					<span class="descripcion"><?php echo $producto->descripcion ?></span><br>
					<span class="cantidad">Cantidad <?php echo $producto->cantidad ?></span>
					<?php if (isset($producto->precio)) { ?>
						<br> <span class="precio"><span class="numero">$ <?php echo $producto->precio ?></span> c/u</span>
				<?php } ?>
				</td>
			</tr>
		<?php } ?>
		<?php if (!empty($total)) { ?>
			<tr class="total">
				<td colspan="2">
					Total: <span class="numero">$ <?php echo $total ?></span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>