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
    return round($nilai1 * 100 / $nilai2, 1);
}

function tostring($text)
{
	return preg_replace('/\s+/', '-',strtolower($text));
}
