<?php
if(!function_exists('amino_get_option')) {
	function amino_get_option($key , $default_value = ''){
		
		if( !empty($options) && array_key_exists($key , $options)) {
			$kirki_option = $options[$key];
		}else{
			$kirki_option = get_theme_mod($key, $default_value);
		}
		return $kirki_option;
	}
}
