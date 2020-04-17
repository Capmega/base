<?php
namespace Capmega\Base\Helpers;

/**
 *
 */
class Helpers
{
    /**
     * Convierte una cadena a su version SEO
     * @param  string $string    [description]
     * @param  string $separator [description]
     * @return string            [description]
     */
    public static function toSeo($string, $separator = '-' ){
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array( '&' => 'and', "'" => '');
        $string        = mb_strtolower( trim( $string ), 'UTF-8' );
        $string        = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
        $string        = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
        $string        = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string        = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;
    }

    /**
     * trunca un numero flotante para solo tener un numero especifico
     * @param  string  $number  Numero a truncar
     * @param  int     $decimal Numero de digitos despues del punto
     * @param  boolean $force   Determina si se deben completar los 0
     * @return double           Numero formateado
     */
    public static function truncate($number, int $decimal, $force = false){
        $number = explode('.', $number);
        if (isset($number[1])) {
            $number[1] = substr($number[1], 0, $decimal);
        }else{
            $number[1] = '';
        }

        $result = $number[0] . '.' . $number[1];
        if (is_numeric($result)) {

            return str_replace('E', '0', $result);
        }
        return 0;
    }
}
