<?php

function therealpath($mypath){

	$pprj = explode("/",$_SERVER['PHP_SELF']);
	$the_path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR.$pprj[1].DIRECTORY_SEPARATOR.$mypath;
	$the_path = str_replace("/",DIRECTORY_SEPARATOR,$the_path);
	$the_path = str_replace("\\",DIRECTORY_SEPARATOR,$the_path);
	$the_path = str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR,DIRECTORY_SEPARATOR,$the_path);
	return $the_path;
}

function strsanitize($input, $sanitizeKey=false) {

    if(isjson($input)){
        $input = json_decode($input, true);
    }

    if (is_array($input)) {
        $sanitizedArray = [];
        foreach ($input as $key => $value) {
            if($sanitizeKey){
                //$sanitizedKey = htmlspecialchars($key, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $sanitizedKey = ltrim(trim(stripslashes(htmlspecialchars(mb_convert_encoding($key, 'UTF-8', 'UTF-8'), ENT_QUOTES | ENT_HTML5, 'UTF-8'))));
            } else {
                $sanitizedKey = $key;
            }
            //$sanitizedValue = htmlspecialchars(mb_convert_encoding($sanitizedValue, 'UTF-8', 'UTF-8'), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $sanitizedValue = ltrim(trim(stripslashes(htmlspecialchars(mb_convert_encoding($value, 'UTF-8', 'UTF-8'), ENT_QUOTES | ENT_HTML5, 'UTF-8'))));
            $sanitizedArray[$sanitizedKey] = $sanitizedValue;
        }
        return $sanitizedArray;
    }
    
    if (is_string($input)) {
        //$input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        $input = ltrim(trim(stripslashes(htmlspecialchars(mb_convert_encoding($input, 'UTF-8', 'UTF-8'), ENT_QUOTES | ENT_HTML5, 'UTF-8'))));
    }
    
    return $input;
}


function __isset($variavel, $valordefault){
    if(!isset($variavel)){
        return strsanitize($valordefault);
    } else {
        return strsanitize($variavel);
    }
}

function isjson($input) {
    // Verifica se o input é uma string
    if (!is_string($input)) {
        return false;
    }

    // Tenta decodificar o JSON
    $decoded = json_decode($input);

    // Verifica se houve erros na decodificação
    if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
        return false;
    }

    // Verifica se o resultado da decodificação é um array ou um objeto
    if (!is_array($decoded) && !is_object($decoded)) {
        return false;
    }

    // O input é um JSON válido
    return true;
}

function isempty($variable) {
    if (is_null($variable)) {
        return true;
    }

    if (is_string($variable)) {
        return empty($variable);
    }

    if (is_array($variable) || is_object($variable)) {
        return count((array) $variable) === 0;
    }

    if (is_bool($variable)) {
        return false;
    }

    if (is_numeric($variable)) {
        return false;
    }

    if ($variable instanceof JsonSerializable) {
        return $variable->jsonSerialize() === [];
    }

    return false;
}

