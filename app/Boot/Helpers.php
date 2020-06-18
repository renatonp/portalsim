<?php

/**
 * Converte problemas de acentuação
 *
 * @param string $string
 * @return string
 */
function convert_accentuation(string $string): string
{
    return utf8_encode(urldecode($string));
}


/**
 * Remove os caracteres especiais do CPF e CNPJ
 *
 * @param string $document
 * @return string
 */
function remove_character_document(string $document): string
{
    return str_replace(['.', '-', '/', ' '], '', $document);
}


/**
 * Converte a data america em brasileira
 *
 * @param string $date
 * @return string
 */
function convert_date_br(string $date)
{
    return date('d/m/Y', strtotime($date));
}

/**
 * Retorna a guia dos serviços que o usuário pertence
 *
 * @return string
 */
function get_guia_services()
{
    $type = session('tipoUsuario');
    
    if ($type == "CIDADÃO") {
        return 1;
    } else if ($type == "EMPRESA" || $type == "EMPRESA NÃO ESTABELECIDA") {
        return 2;
    } else if ($type == "SERVIDOR") {
        return 5;
    }
}