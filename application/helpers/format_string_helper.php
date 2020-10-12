<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 

function rupiah($harga)
{
    $angka = number_format($harga,0,",",".");
    return "Rp. ".$angka.",-";
}


function rupiah_num($harga)
{
    return number_format($harga,0,",",".");
}

function percent($nilai1, $nilai2)
{
    return $nilai1 * $nilai2 / 100;
}

function percent1($nilai1, $nilai2)
{
    return round($nilai1 / $nilai2 * 100, 1);
}

function percent_price($harga_diskon, $harga_awal)
{
    $selisih = $harga_awal - $harga_diskon;
    return round($selisih / $harga_awal * 100, 1);
}

function tostring($text)
{
	return preg_replace('/\s+/', '-',strtolower($text));
}

function string_type($text)
{
	return ucwords(str_replace("-"," ", $text));
}
