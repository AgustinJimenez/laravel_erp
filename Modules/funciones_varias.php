<?php
  	function remove_dots($number)
    {
        return str_replace('.', '', $number);
    }

    function thousands_separator_dots($number)
    {
        return number_format($number, 0, '', '.');
    }

    function date_to_server($date)
    {
    	return date("Y-m-d", strtotime( str_replace('/', '-', $date) ));
    }
    function date_to_server2($date)
    {   //no anda bien en todos los casos
        return date_create_from_format('d/m/Y', $date);
    }

    function date_from_server($date)
    {
        return date("d/m/Y", strtotime($date));
    }

    function get_iva($iva)
    {
    	if($iva == '0')
    		return 0;
    	else if($iva == '21')
    		return 5;
    	else
    		return 10;
    }

    function get_actual_date()
    {
        date_default_timezone_set('America/Asuncion');
        
        return date('d/m/Y', time());
    }

    function get_actual_date_server()
    {
        date_default_timezone_set('America/Asuncion');
        
        return date('Y-m-d', time());
    }

    function get_actual_date_time_server()
    {
        date_default_timezone_set('America/Asuncion');
        
        return date('Y-m-d H:i:s', time());
    }










?>