<?php

// make function to get the site url
function site_url($page = '')
{
	$url = "http://localhost/prima_kimia/?page=" . $page;
	return $url;
}

function app_url($page = '')
{
	$url = "http://localhost/prima_kimia/";
	return $url;
}


// make function rupiah	
function rupiah($angka)
{
	$hasil_rupiah = "Rp" . number_format($angka, 0, ',', '.');
	return $hasil_rupiah;
}
