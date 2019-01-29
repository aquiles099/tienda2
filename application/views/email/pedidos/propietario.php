<h1>Ha recibido un nuevo pedido de presupuesto a través de su tienda online</h1>
<?php if( isset($cliente) ){ ?>
    <strong>Nombres y Apellidos:</strong>
    <span><?php echo $cliente['guest']['nombre']." ".$cliente['guest']['apellido']; ?></span>
    <br>

    <strong>Teléfono:</strong>
    <span><?php echo $cliente['guest']['telefonocontacto']; ?></span>
    <br>

    <strong>Correo:</strong>
    <span><?php echo $cliente['guest']['email']; ?></span>
    <br><br>

<?php } ?>
<?php $this->load->view('email/pedidos/detalle') ?>
<p>Acceda a su <a href="<?php echo admin_url('presupuestos/presupuestos/consultapresupuesto/' . $idpresupuesto) ?>">administrador Nube360</a> y podrá visualizar el pedido en la sección Presupuestos.</p>
<br><hr>
<p class="saludo">Atte.: El equipo de Nube360</p>
