<?php 
function form_field($field, $type, $data, $options = null) {
	$message = form_message($field, $data);
	$value = form_value($field, $data);
	$name = preg_replace('#.*/#', '', $field);
	switch ($type) {
		case 'email':
			return '<input class="form-control" type="email" name="' . $name . '" value="' . $value . '">' . $message;
			break;
		case 'select':
			$select = '<select class="form-control" name="' . $name . '">';
			if ($options) {
				foreach ($options as $v => $option) {
					$selected = $v == $value ? 'selected="selected"' : '';
					$select .= '<option value="' . $v . '" ' . $selected . '>' . $option . '</option>';
				}
			}
			$select .= '<select class="form-control" name="' . $name . '">';
			return $select . $message;
		default:
			return '<input class="form-control" type="text" name="' . $name . '" value="' . $value . '">' . $message;
		break;
	}
}

function form_value($field, $data) {
	$fieldPath = explode('/', $field);
	$value = _form_message_fetch_data($fieldPath, $data);
	if ($value) {
		return $value;
	}
	return '';
}

function form_message($field, $data) {
	if (isset($data['error'])) {
		$fieldPath = explode('/', $field);
		$error = _form_message_fetch_data($fieldPath, $data['error']);
		if ($error) {
			return '<div class="alert alert-danger">' . $error . '</div>';
		}
	}
	return '';
}

function _form_message_fetch_data($field, $data) {
	$f = array_shift($field);
	if (isset($data[$f])) {
		if (count($field)) {
			return _form_message_fetch_data($field, $data[$f]);
		}
		return $data[$f];
	}
	return false;
}
