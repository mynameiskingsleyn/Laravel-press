<?php

function quickRandom($length = 16)
{
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}

function slug($title, $separator = '-', $language = 'en')
{
    $pattern = '/[^0-9 a-z A-z]/';
    $title = preg_replace($pattern, '', $title);
    return strtolower(str_replace(' ', $separator, trim($title)));
    //return trim($title, $separator);
}
