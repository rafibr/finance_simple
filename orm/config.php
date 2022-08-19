<?php
//kita akan hilangkan pesan warning di file ini. 
error_reporting(E_ERROR | E_PARSE);

//include_once hanya akan menampilkan warning saja, klo require_once akan menjadi fatal error 
//fatal error menyebabkan halaman tidak bisa dieksekusi / blank putih. 

include '../helper.php';

require_once('vendor/autoload.php');
ORM::configure('mysql:host=localhost;dbname=aplikasi_ta');
ORM::configure('username', 'root');
ORM::configure('password', '');

//nantinya dapat digunakan untuk melihat hasil query
ORM::configure('logging', true);
