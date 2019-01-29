$(document).ready(function() {

	$('.fancybox').fancybox();
	
	// Product thumb
	$('.vista-producto .thumbs .thumb').bind('mouseover click', function() {
		var thumb = $(this).data('thumb');
		$('.vista-producto .preview .img').hide();
		$('.vista-producto .preview [data-thumb=' + thumb + ']').show();
	}).eq(0).trigger('click');

	// Buscador de productos
	$( '#search' ).autocomplete({
      	source: function( request, response ) {
      		console.log(request);
	        $.ajax( {
		        url: baseurl+'Productos/buscar',
		        dataType: 'json',
		        data: {
		            term: request.term
		        },
	         	success: function( data ) {
	            	response( data );
	            	console.log(data);
	          	},
	          	error: function( result ) {
	          		console.log(result);
	          	}
	        } );
      	},
      	minLength: 2,
      	select: function( event, ui ) {
      		$('#search').val(ui.item.label);
        	$('#id_producto').val(ui.item.idproducto);
        	$('#id_familia').val(ui.item.id_familia);
        	$('#id_categoria').val(ui.item.id_categoria);
        	window.location.href = baseurl + 'producto/'+ui.item.ruta;
      	}
    } )
    .autocomplete( 'instance' )._renderItem = function( ul, item ) {
      	return $( '<li>' )
        .append( '<div>' + item.label + '</div>' )
        .appendTo( ul );
    };

    $( '#search' ).on('focus',function(){
    	$(this).animate({paddingLeft: '10px'},'slow');
    	$('#form-search .input-content button').css('color','#333333');
    });

    $( '#search' ).on('focusout',function(){
    	$(this).animate({paddingLeft: '45px'},'slow');
    	$('#form-search .input-content button').css('color','#ffffff');
    });
	
	// Agregar producto
	$('.add-product-btn').click(function() {
		var btn = $(this),
			id = btn.data('id'),
			variantes = $('.variante-producto')
		;
		if (variantes.length) {
			var selected = variantes.find(':checked');
			if (!selected.length) {
				alert('Por favor, seleccione una variante del producto');
				return;
			}
			id = selected.val();
		}
		btn.prop('disabled', true).addClass('loading');
		$.post(baseurl + 'productos/agregar/' + id, {
			cantidad: $('.quantity').val()
		}, function(data) {
			btn.prop('disabled', false).removeClass('loading');
			$('.topbar .carro .totalproductos').text(data.productosencarro);
			if (data.success) {
				var alert = $('<div class="alert alert-success">' + data.success + '</div>').appendTo('#cart-feedback');
				setTimeout(function() {
					alert.fadeOut(function() {
						$(this).remove();
					});
				}, 3000);
			}
		});
	});

	$('#registerUser').click(function() {
		console.log('injdfoin');
		$('#modalLoginForm').modal('toggle');
		
	});


	// Quitar producto
	$('.eliminar-producto-btn').click(function() {
		var producto = $(this).closest('.producto'),
			id = producto.data('id');
		$.get(baseurl + 'productos/quitar/' + id, function(data) {
			$('.productosencarro .numero').text(data.productosencarro);
			$('.carro .totalproductos').text(data.productosencarro);
			$('.total .numero').text(data.total.toFixed(2));
			producto.remove();
		});
	});

	// Modificar cantidad
	$('.producto .cantidad').change(function() {
		var input = $(this),
			q = input.val(),
			producto = input.closest('.producto'),
			idproducto = producto.data('id'),
			precio = producto.find('.precio.unitario .numero').text();
		$.post(baseurl + 'productos/cantidad/' + idproducto, {
			cantidad: q
		}, function(data) {
			$('.productosencarro .numero').text(data.productosencarro);
			$('.carro .totalproductos').text(data.productosencarro);
			$('.total .numero').text(data.total.toFixed(2));
			producto.find('.subtotal .numero').text((q * precio).toFixed(2));
		});
	});

	// Checkout
	var steps = $('.checkout .step-body');
	if (steps.length) {
		steps.hide();
		$.get(baseurl + 'checkout/step', function(data) {
			$('[data-step=' + data.step + ']').show();
		});
		$('.checkout .enabled .step-title').click(function() {
			steps.hide();
			$(this).next().show();
		});
		// personal
		$('.checkout .guest-btn').click(function() {
			var btn = $(this);
			btn.addClass('active');
			$('.checkout .login-btn').removeClass('active');
			$('#checkout-guest-form').show();
			$('#checkout-login-form').hide();
		}).trigger('click');
		$('.checkout .login-btn').click(function() {
			var btn = $(this);
			btn.addClass('active');
			$('.checkout .guest-btn').removeClass('active');
			$('#checkout-guest-form').hide();
			$('#checkout-login-form').show();
		});
	}

	// Select de provincias
	$.fn.provincia = function(pais) {
		var provincia = this;
		provincia.prop('disabled', true);
		$(pais).on('change', function(e) {
			var idpais = $(this).val(),
				pais = idpais ? true : false,
				html = '<option></option>';

			provincia.prop('disabled', pais).html(html).trigger('liszt:updated');

			$.ajax({
				url: baseurl + 'provincias/getSelect',
				type:'POST',
				data: 'idpais=' + idpais,
				dataType: 'json',
				success: function(output) {
					$.each(output, function(i, v){
						html += '<option value=\'' + i + '\'>' + v + '</option>';
					});
					provincia.html(html).prop('disabled', false).trigger('liszt:updated');
				},
				error: function(data) {
					console.log(data);
				}
			});
		}).trigger('change');
	};
	$('select[name=f_provincia]').provincia('select[name=f_pais]');

	// Formulario de contacto
	$('#contact-form').submit(function() {
		var form = $(this);
		form.addClass('loading');
		form.find('.form-group').removeClass('has-error');
		form.find('.help-block').remove();
		$.post(form.attr('action'), form.serializeArray(), function(data) {
			form.removeClass('loading');
			grecaptcha.reset();
			if (data.success) {
				form.find('.feedback').html('<div class="alert alert-success">' + data.message + '</div>');
				// Reset form
				form.find('.form-control').val('');
			} else {
				$.each(data.errors, function(i, error) {
					form.find('[name=' + error.name + ']')
						.after('<span class="help-block">' + error.message + '</span>')
						.closest('.form-group').addClass('has-error');
				});
				form.find('.feedback').html('<div class="alert alert-danger">' + data.message + '</div>');
			}
		}, 'json');
		return false;
	});

	if ($(".slick-slider").length > 0) {
		$(".slick-slider").slick({
			dots: true,
			infinite: true,
			speed: 300,
			slidesToShow: 4,
			slidesToScroll: 1,
			responsive: [
			{
			  breakpoint: 1024,
			  settings: {
			    slidesToShow: 3,
			    slidesToScroll: 1,
			    infinite: true,
			    dots: true
			  }
			},
			{
			  breakpoint: 600,
			  settings: {
			    slidesToShow: 2,
			    slidesToScroll: 1,
			    dots: true
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
			    slidesToShow: 1,
			    slidesToScroll: 1,
			    dots: true
			  }
			}]
		});
	}

	$(".checkbox .check_atributo").on('change', function(e) {
		var marca = ($("#lamarca_ruta").length > 0)? $("#lamarca_ruta").val() : null,
			categoria = $("#cat_ruta").val(),
			full_url = baseurl + 'categoria/' + categoria,
			url_attr = armarUrlAtributos();

		if (marca != null) 		full_url += "/" + marca;
		if (url_attr != null) 	full_url += "?"+url_attr;
		window.location.href =  full_url;
	});

	function armarUrlAtributos() {
		var url_atributos 	= "",
			url_valores 	= "",
			full_url  		= "",
			checked 		= false,
			armar  			= false;

		$(".atributos").each(function(index, value){
			var form 		= $(this).find(".frm-atributos"),
				idatributo 	= form.find('input[name=idatributo]').val(),
				lista 		= $("#" + form.attr('id') + " ul li");

			lista.each(function(i, v) {
				check = $(this).find('.check_atributo');
				if (check.prop('checked')) {
					if (!armar) armar = true;
					if (!checked) {
						checked = true;
						if (url_valores != "" && url_valores.slice(-1) != '&' && url_valores.length > 4) url_valores += "_";
					}

					if (url_valores == "") {
						url_valores = "vls="+check.val();
					}else if (url_valores.slice(-1) == '_') {
						url_valores += check.val();
					}else{
						url_valores += "-"+check.val();
					}
				}
			});

			if (checked){

				if (url_atributos == "") {
					url_atributos = "attr="+idatributo;
				}else{
					url_atributos += "_"+idatributo;
				}

				checked = false;
			} 
		});

		if (armar) {
			full_url = url_atributos + "&" + url_valores;
			return full_url;
		}else{
			return null;
		}

	}

	$("form[name='login-form']").validate({
	//$('#form-register form#login-form').validate({
		
		rules: {
			usuario: 'required',
			password: 'required'
		},
		messages: {
			usuario: {
				required: 'El campo usuario/email  es requerido'
			},
			password: {
				required: 'El campo contraseña es requerido',
			}
		},
		submitHandler: function (form) {
				//a0lert('wfgsrgs');
				loginUsuario(form);
		}
	});

	$("form[name='register-form']").validate({
	
		rules: {
			nombre: 'required',
			email: 'required',
			apellido: 'required',
			usuario_registro: 'required',
			telephone:'required',
			cuit:'required',
			password_registro: {
				required: true,
				minlength: 8
			},
			password_confirmation_registro: {
				required: true,
				minlength: 8,
				equalTo: '#password_registro'
			}
		},
		messages: {
			nombre: {
				required: 'El campo nombre es requerido'
			},
			apellido: {
				required: 'El campo apellido es requerido'
			},
			email: {
				required: 'El campo email es requerido',
				email: 'Por favor ingresa una dirección de correo electrónico válida'
			},
			telephone:{
				required: 'El campo numero de telefono es requerido',
			},
			cuit:{
				required: 'El campo cuit es requerido',
			},
			usuario_registro: {
				required: 'El campo usuario es requerido'
			},
			password_registro: {
				required: 'El campo contraseña es requerido',
				minlength: 'El campo contraseña debe tener al menos 8 caracteres'
			},
			password_confirmation_registro: {
				required: 'El campo confirmacion de contraseña es requerido',
				minlength: 'El campo confirmar contraseña debe tener al menos 8 caracteres',
				equalTo: 'La contraseña y su confirmación no concuerdan'
			}
		},
		submitHandler: function (form) {
			registrarUsuario(form);
		}
			
	});



	function loginUsuario(form){

		var btnlogin = $("#btnlogin");
  		btnlogin.button('loading');

		var formu = $(this),
			postData = {
				usuario: $('#usuario').val(),
				password: $('#password').val()
			}
		;

		

		$.ajax({
			url: baseurl+"/login/login",
			type: 'POST',
			data: postData,
			dataType: 'json',
			success: function(output_string) {
				if (output_string !=='err') {
					new PNotify({
					title: 'Logeado con Exitos',
					text: 'Bienvenido ',
					type: 'success'
				});
				setTimeout(function(){
					window.location.href=window.location;
				}, 1000);

				} else {

					btnlogin.button('reset');
					new PNotify({
						title: 'AS-GESTION',
						text: 'Error en inicio de sesion, verifique los datos',
						type: 'error'
					});
				}
			}
			// End of success function of ajax form
		}); // End of ajax call
		return false; 
	};




	function registrarUsuario(form){
		var btnregistrar = $("#btnregistrar");
  		btnregistrar.button('loading');

		var formu = $(this),
			postData = {
				usuario: $('#usuario_registro').val(),
				password: $('#password_registro').val(),
				telephone: $('#telephone').val(),
				nombre:$('#nombre').val(),
				apellido:$('#apellido').val(),
				email:$('#email').val(),
				cuit:$('#cuit').val()
			};


		$.ajax({
			url: baseurl+"/login/registrar",
			type: 'POST',
			data: postData,
			dataType: 'json',
			success: function(data) {

				new PNotify({
					title: data.title,
					text: data.text,
					type: data.type
				});

			if( data.type=='success' ){
					setTimeout(function(){
						window.location.href=window.location;
					}, 2000);
				}

				btnregistrar.button('reset');
			
			}
			// End of success function of ajax form
		}); // End of ajax call
		return false; 

	}

	$('#passwordreset').submit(function(e) {

		e.preventDefault();

		var btnforgotpass = $("#btnforgotpass");
  		btnforgotpass.button('loading');

		var form = $(this),
		postData = { usuario: $('#usuario_reset').val() };
						
		$.ajax({
			url: form.attr('action'),
			method: 'POST',
			data: postData,
			dataType: 'json',
			success: function( data ){
				new PNotify({
					title: data.title,
					text: data.text,
					type: data.type
				});
				if( data.type=='success' ){
					setTimeout(function(){
						location.href = window.location;;
					}, 2000);
				}
				btnforgotpass.button('reset');
			},
			error: function( data ){
				new PNotify({
					title: data.title,
					text: data.text,
					type: data.type
				});
				btnforgotpass.button('reset');
			}
		});
	
		return false; 
	});

	



});
