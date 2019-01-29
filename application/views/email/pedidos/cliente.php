<h1>Detalle de su compra en <?php echo $nombresitio ?></h1>
<?php $this->load->view('email/pedidos/detalle') ?>
<p>Será contactado a la brevedad para coordinar la entrega.</p>
<p>Muchas gracias por su compra.</p>
<br>
<p><?php echo $nombresitio ?></p>
<hr>
<p style="font-size:10px; vertical-align: middle">
    <span style="display: inline-block; vertical-align: middle">Comprobante emitido desde</span>
    <a title="http://nube360plus.com" style="text-decoration: none; display: inline-block; vertical-align: middle;" href="http://nube360plus.com">
        <img alt="http://nube360plus.com" style="height: 30px" height="30" src="<?php echo site_url('branding/img/logo.png') ?>">
    </a>
</p>