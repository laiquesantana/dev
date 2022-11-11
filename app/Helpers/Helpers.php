<?php
function remove_special_char($text)
{

    $t = $text;

    $specChars = array(
        ' ' => '-',    '!' => '',    '"' => '',
        '#' => '',    '$' => '',    '%' => '',
        '&amp;' => '',    '\'' => '',   '(' => '',
        ')' => '',    '*' => '',    '+' => '',
        ',' => '',    '₹' => '',    '.' => '',
        '/-' => '',    ':' => '',    ';' => '',
        '<' => '',    '=' => '',    '>' => '',
        '?' => '',    '@' => '',    '[' => '',
        '\\' => '',   ']' => '',    '^' => '',
        '_' => '',    '`' => '',    '{' => '',
        '|' => '',    '}' => '',    '~' => '',
        '-----' => '-',    '----' => '-',    '---' => '-',
        '/' => '',    '--' => '-',   '/_' => '-',
        '-' => '',

    );

    foreach ($specChars as $k => $v) {
        $t = str_replace($k, $v, $t);
    }

    return $t;
}


function isArrayEmptyOrNull($array) {
    foreach($array as $key => $val) {
        if ($val === '' || $val === null)
            return true;
    }
    return false;
}

function isArrayNotEmpty($array) {
    foreach($array as $key => $val) {
        if ($val != '' || $val != null)
            return true;
    }
    return false;
}
