<div class="checkout">
	<div class="row">
		<div class="col-sm-8">
			<h1>Finalizar pedido</h1>
			<div class="steps">
				<?php foreach ($steps as $i => $step) {
					$classes = ['step'];
					$stepnumber = $i + 1;
					if ($stepnumber <= $checkout['step']) $classes[] = 'enabled';
					if ($stepnumber < $checkout['step']) $classes[] = 'completed'; ?>
					<div class=" <?php echo implode(' ', $classes) ?>">
						<h2 class="step-title">
							<span class="number"><?php echo $stepnumber ?></span>
							<span class="title"><?php echo $step[1] ?></span>
						</h2>
						<div class="step-body" data-step="<?php echo $stepnumber ?>">
							<?php $this->load->view('checkout/' . $step[0]) ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="col-sm-4">
			<p class="productosencarro"><span class="numero"><?php echo $productosencarro ?></span> artículo(s)</p>
			<?php if (isset($total)) { ?>
				<p class="total">Total $ <span class="numero"><?php echo $total ?></span></p>
			<?php } ?>
			<a href="<?php echo base_url('carro') ?>" class="btn btn-default">Modificar pedido</a>
			<a href="<?php echo base_url('checkout/mercadopago') ?>" class="btn btn-default">Pagar</a>
		</div>
	</div>
</div>