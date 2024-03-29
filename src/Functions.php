<?php

namespace LandKit\Functions;

use DateTime;
use Exception;


/* *** *** *** *** *** *** *** *** *** ***
 * Array
 * *** *** *** *** *** *** *** *** *** ***/

/**
 * @param float|int|string $value
 * @param array $data
 * @param int $size
 * @return bool
 */
function binarySearch($value, array $data, int $size): bool
{
    $left = 0;
    $right = $size - 1;

    while ($left <= $right) {
        $middle = floor(($left + $right) / 2);

        if ($value == $data[$middle]) {
            return true;
        }

        if ($value < $data[$middle]) {
            $right = $middle - 1;
        } else {
            $left = $middle + 1;
        }
    }

    return false;
}

/**
 * @param mixed $needle
 * @param array $haystack
 * @param bool $strict
 * @return bool
 */
function inMultidimensionalArray($needle, array $haystack, bool $strict = false): bool
{
    foreach ($haystack as $item) {
        if (
            ($strict ? $item === $needle : $item == $needle)
            || is_array($item)
            && inMultidimensionalArray($needle, $item, $strict)
        ) {
            return true;
        }
    }

    return false;
}

/**
 * @param mixed $data
 * @param array|int $filter
 * @return array|string
 */
function filterData($data, $filter = FILTER_DEFAULT)
{
    if (is_array($data)) {
        return array_map('trim', filter_var_array($data, $filter));
    }

    return trim(filter_var($data, $filter));
}

/**
 * @param array $files
 * @return array
 */
function normalizeFileArray(array $files): array
{
    $array = [];

    for ($i = 0; $i < count($files['type']); $i++) {
        foreach (array_keys($files) as $keys) {
            $array[$i][$keys] = $files[$keys][$i];
        }
    }

    return $array;
}


/* *** *** *** *** *** *** *** *** *** ***
 * Assets
 * *** *** *** *** *** *** *** *** *** ***/

/**
 * @param mixed ...$params
 * @return void
 */
function varDump(...$params)
{
    echo '<pre>';

    foreach ($params as $param) {
        var_dump($param);
    }

    echo '</pre>';
}

/**
 * @param mixed ...$params
 * @return void
 */
function debug(...$params)
{
    echo '<pre>';

    foreach ($params as $param) {
        var_dump($param);
    }

    echo '</pre>';
    exit;
}


/* *** *** *** *** *** *** *** *** *** ***
 * Date
 * *** *** *** *** *** *** *** *** *** ***/

/**
 * @param string $time
 * @param string $format
 * @return string
 */
function dateFormat(string $time, string $format = 'd/m/Y H\hi'): string
{
    try {
        return (new DateTime($time))->format($format);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

/**
 * @param string $time
 * @param bool $complete
 * @return string
 */
function dateFormatBr(string $time, bool $complete = true): string
{
    try {
        return (new DateTime($time))->format(!$complete ? 'd/m/Y' : 'd/m/Y H:i:s');
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

/**
 * @param string $time
 * @param bool $complete
 * @return string
 */
function dateFormatApp(string $time, bool $complete = true): string
{
    try {
        return (new DateTime(($time)))->format(!$complete ? 'Y-m-d' : 'Y-m-d H:i:s');
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

/**
 * @param string $dateBr
 * @return string
 */
function dateBrToApp(string $dateBr): string
{
    if (strpos($dateBr, ' ') != false) {
        list($date, $hour) = explode(' ', $dateBr);

        return implode('-', array_reverse(explode('/', $date))) . ' ' . $hour;
    }

    return implode('-', array_reverse(explode('/', $dateBr)));
}

/**
 * @param int|string $monthOrDate
 * @return string
 */
function monthInPtBr($monthOrDate): string
{
    $month = $monthOrDate;

    if (is_string($monthOrDate)) {
        if (strpos($month, '/') != false) {
            $monthOrDate = dateBrToApp($monthOrDate);
        }

        if (strpos($monthOrDate, '-') != false) {
            $month = (int) dateFormat($monthOrDate, 'm');
        }
    }

    switch ($month) {
        case 1:
            return 'Janeiro';
        case 2:
            return 'Fevereiro';
        case 3:
            return 'Março';
        case 4:
            return 'Abril';
        case 5:
            return 'Maio';
        case 6:
            return 'Junho';
        case 7:
            return 'Julho';
        case 8:
            return 'Agosto';
        case 9:
            return 'Setembro';
        case 10:
            return 'Outubro';
        case 11:
            return 'Novembro';
        case 12:
            return 'Dezembro';
        default:
            return 'Mês inválido';
    }
}


/* *** *** *** *** *** *** *** *** *** ***
 * Form
 * *** *** *** *** *** *** *** *** *** ***/

/**
 * @param string $selectedUf
 * @return string
 */
function stateOptionsBr(string $selectedUf = ''): string
{
    $options = [];
    $states = [
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins'
    ];

    foreach ($states as $uf => $name) {
        $selectedAttribute = !$selectedUf || $selectedUf != $uf ? '' : ' selected';
        $options[] = "<option value='{$uf}'{$selectedAttribute}>{$name}</option>";
    }

    return implode('', $options);
}


/* *** *** *** *** *** *** *** *** *** ***
 * Password
 * *** *** *** *** *** *** *** *** *** ***/

/**
 * @param string $value
 * @param bool $renew
 * @param string $algorithm
 * @param array $options
 * @return string
 */
function password(
    string $value,
    bool $renew = false,
    string $algorithm = PASSWORD_DEFAULT,
    array $options = ['cost' => 10]
): string {
    if (!$renew && !empty(password_get_info($value)['algo'])) {
        return $value;
    }

    return password_hash($value, $algorithm, $options);
}

/**
 * @param string $hash
 * @param string $algorithm
 * @param array $options
 * @return bool
 */
function passwordRehash(string $hash, string $algorithm = PASSWORD_DEFAULT, array $options = ['cost' => 10]): bool
{
    return password_needs_rehash($hash, $algorithm, $options);
}

/**
 * @param int $length
 * @param bool $upper
 * @param bool $lower
 * @param bool $number
 * @param bool $symbol
 * @return string
 */
function passwordGenerator(int $length, bool $upper, bool $lower, bool $number, bool $symbol): string
{
    $u = 'ABCDEFGHIJKLMNOPQRSTUVYXWZ';
    $l = 'abcdefghijklmnopqrstuvyxwz';
    $n = '0123456789';
    $s = '!@#$%&*()_+=';
    $password = '';

    if ($upper) {
        $password .= str_shuffle($u);
    }

    if ($lower) {
        $password .= str_shuffle($l);
    }

    if ($number) {
        $password .= str_shuffle($n);
    }

    if ($symbol) {
        $password .= str_shuffle($s);
    }

    return substr(str_shuffle($password), 0, $length);
}


/* *** *** *** *** *** *** *** *** *** ***
 * String
 * *** *** *** *** *** *** *** *** *** ***/

/**
 * @param string $value
 * @return string
 */
function strSlug(string $value): string
{
    $from = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $to = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

    $value = filter_var(mb_strtolower($value), FILTER_SANITIZE_STRIPPED);
    $value = trim(strtr(utf8_decode($value), utf8_decode($from), $to));
    $value = str_replace(' ', '-', $value);

    return str_replace(['-----', '----', '---', '--'], '-', $value);
}

/**
 * @param string $value
 * @return string
 */
function strStudlyCase(string $value): string
{
    $value = str_replace('-', ' ', strSlug($value));
    return str_replace(' ', '', mb_convert_case($value, MB_CASE_TITLE));
}

/**
 * @param string $value
 * @return string
 */
function strCamelCase(string $value): string
{
    return lcfirst(strStudlyCase($value));
}

/**
 * @param string $value
 * @return string
 */
function strTitle(string $value): string
{
    $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    return mb_convert_case($value, MB_CASE_TITLE);
}

/**
 * @param string $value
 * @return string
 */
function strTextarea(string $value): string
{
    $value = filter_var($value, FILTER_SANITIZE_STRIPPED);
    $replace = [
        '&#10;',
        '&#10;&#10;',
        '&#10;&#10;&#10;',
        '&#10;&#10;&#10;&#10;',
        '&#10;&#10;&#10;&#10;&#10;'
    ];

    return '<p>' . str_replace($replace, '</p><p>', $value) . '</p>';
}

/**
 * @param string $value
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function strLimitChars(string $value, int $limit, string $pointer = '...'): string
{
    $value = trim(filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    if (mb_strlen($value) <= $limit) {
        return $value;
    }

    $length = mb_strrpos(mb_substr($value, 0, $limit), ' ');
    return mb_substr($value, 0, $length) . $pointer;
}

/**
 * @param string $value
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function strLimitWords(string $value, int $limit, string $pointer = '...'): string
{
    $value = trim(filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $arrWords = explode(' ', $value);

    if (count($arrWords) < $limit) {
        return $value;
    }

    return implode(' ', array_slice($arrWords, 0, $limit)) . $pointer;
}

/**
 * @param float|int|string $value
 * @return string
 */
function strPrice($value): string
{
    $value = str_replace(',', '.', str_replace('.', '', $value));
    return number_format($value ?: 0, 2, ',', '.');
}

/**
 * @param string $value
 * @return string
 */
function strSearch(string $value): string
{
    if (!$value) {
        return 'all';
    }

    return preg_replace('/[^a-z0-9A-Z@ ]/', '', $value) ?: 'all';
}

/**
 * @param string $value
 * @param string $format
 * @return string
 */
function strMask(string $value, string $format): string
{
    $masked = '';
    $j = 0;

    for ($i = 0; $i <= (strlen($format) - 1); ++$i) {
        if ($format[$i] == '#') {
            if (isset($value[$j])) {
                $masked .= $value[$j++];
            }
        } elseif (isset($format[$i])) {
            $masked .= $format[$i];
        }
    }

    return $masked;
}


/* *** *** *** *** *** *** *** *** *** ***
 * Url
 * *** *** *** *** *** *** *** *** *** ***/

/**
 * @return string
 */
function urlBack(): string
{
    return $_SERVER['HTTP_REFERER'] ?? '';
}

/**
 * @param string $url
 * @return void
 */
function redirect(string $url)
{
    header('HTTP/1.1 302 Redirect');

    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header('Location: ' . $url);
    } elseif (function_exists('url')) {
        header('Location: ' . url($url));
    } else {
        header('Location: ' . $url);
    }

    exit;
}


/* *** *** *** *** *** *** *** *** *** ***
 * Validation
 * *** *** *** *** *** *** *** *** *** ***/

/**
 * @param string $value
 * @return bool
 */
function isFullName(string $value): bool
{
    return strpos($value, ' ') != false;
}

/**
 * @param string $value
 * @return bool
 */
function isEmail(string $value): bool
{
    return filter_var($value, FILTER_VALIDATE_EMAIL) != false;
}

/**
 * @param string $value
 * @param int $minLength
 * @param int $maxLength
 * @return bool
 */
function isPassword(string $value, int $minLength = 8, int $maxLength = 40): bool
{
    if (password_get_info($value)['algo'] || mb_strlen($value) >= $minLength && mb_strlen($value) <= $maxLength) {
        return true;
    }

    return false;
}

/**
 * @param string $value
 * @return bool
 */
function isCpf(string $value): bool
{
    if (strlen($value) != 11) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $value[$c] * ($t + 1 - $c);
        }

        $d = ((10 * $d) % 11) % 10;

        if ($value[$c] != $d) {
            return false;
        }
    }

    return true;
}

/**
 * @param string $value
 * @return bool
 */
function isCnpj(string $value): bool
{
    if (strlen($value) != 14) {
        return false;
    }

    for ($t = 12; $t < 14; $t++) {
        for ($d = 0, $m = ($t - 7), $i = 0; $i < $t; $i++) {
            $d += $value[$i] * $m;
            $m = $m == 2 ? 9 : --$m;
        }

        $d = ((10 * $d) % 11) % 10;

        if ($value[$i] != $d) {
            return false;
        }
    }

    return true;
}

/**
 * @param string $value
 * @param bool $validateAreaCode
 * @return bool
 */
function isCellPhone(string $value, bool $validateAreaCode = true): bool
{
    return strlen($value) == ($validateAreaCode ? 11 : 9);
}

/**
 * @param string $value
 * @param string $format
 * @return bool
 */
function isDate(string $value, string $format = 'Y-m-d'): bool
{
    $dateTime = DateTime::createFromFormat($format, $value);
    return $dateTime && $dateTime->format($format) == $value;
}

/**
 * @param string $value
 * @return bool
 */
function isZipCodeBr(string $value): bool
{
    return strlen($value) == 8;
}