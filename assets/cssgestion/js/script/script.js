function getQS() {
	var i, qsvar, qsvars, qs = {};
	if (location.search) {
		qsvars = location.search.substr(1).split('&');
		for (i = 0; i < qsvars.length; i++) {
			qsvar = qsvars[i].split('=');
			qs[qsvar.shift()] = qsvar.pop();
		}
	}
	return qs;
}
function addParams(params) {
	var qs = getQS();
	for (var i = 0; i < params.length; i++) {
		qs[params[i][0]] = params[i][1];
	}
	window.location.search = '?' + $.param(qs);
}

(function($) {
	// Campos de fecha
	 $.fn.datepicker.dates['es'] = {
		days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		daysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
		daysMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
		months: ['Enero', 'Febrero', 'Mazo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		today: 'Hoy',
		clear: 'Limpiar',
		format: 'yyyy-mm-dd',
		titleFormat: 'MM yyyy', /* Leverages same syntax as 'format' */
		weekStart: 0
	};
	$( '.datepicker-input' ).datepicker({
	    language: 'es'
	});

	// Sidebar
    $('li.nav-parent').click(function() {
    	if ($('#active-circle').hasClass('selected-ul-menu-sidebar')) {
			$('.selected-ul-menu-sidebar').remove();
    	}
		$('<i id="active-circle" class="fa fa-circle text-default selected-ul-menu-sidebar" aria-hidden="true"></i>').insertAfter($(this).find('span'));
    });

    // Administración de usuarios
    function checkModulos() {
    	var checks = [1, 2];
    	for (var i = 0; i < checks.length; i++) {
    		var c = checks[i],
    			d = c + 1;
    		;
	    	$('.checkbox-tab-' + c).each(function() {
	    		var label = $(this),
	    			check = label.find('input[type=checkbox]'),
	    			checked = check.prop('checked'),
	    			next = label.parent().next().find('.checkbox-tab-' + d + ', .checkbox-tab-' + (d + 1));
	    		while (next.length > 0) {
	    			if (checked) {
	    				next.find('input[type=checkbox]').prop('checked', check.prop('checked'));
	    			}
	    			next = next.parent().next();
	    			if (next.length > 0) {
	    				next = next.find('.checkbox-tab-' + d + ', .checkbox-tab-' + (d + 1));
	    			}
	    		}
	    	});
    	}
    }
    function uncheckModulos() {
    	var checks = [3, 2];
    	for (var i = 0; i < checks.length; i++) {
    		var c = checks[i],
    			d = c - 1;
    		;
	    	$('.checkbox-tab-' + c).each(function() {
	    		var label = $(this),
	    			check = label.find('input[type=checkbox]'),
	    			checked = check.prop('checked'),
	    			current = label.parent().find('.checkbox-tab-' + c),
	    			next = label.parent().prev().find('.checkbox-tab-' + c);
	    		while (next.length > 0) {
	    			current = next;
	    			next = next.parent().prev().find('.checkbox-tab-' + c);
	    		}
	    		next = current.parent().prev().find('.checkbox-tab-' + d);
	    		if (next.length && !checked) {
	    			next.find('input[type=checkbox]').prop('checked', false);
	    		}
	    	});
    	}
    }
    checkModulos();
    $('.checkbox-tab-1 input[type=checkbox], ' +
      '.checkbox-tab-2 input[type=checkbox]').change(function() {
    	if ($(this).prop('checked')) {
    		checkModulos();
    	}
    });
    $('.checkbox-tab-2 input[type=checkbox], ' +
      '.checkbox-tab-3 input[type=checkbox]').change(function() {
    	if (!$(this).prop('checked')) {
    		uncheckModulos();
    	}
    });

})(jQuery);
