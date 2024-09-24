<?php

function convertToSlug($text)
{
    $text = strtolower($text);
    $text = str_replace("-", " ", $text);
    $text = preg_replace("/[\s_]/", "_", $text);
    return $text;
}
