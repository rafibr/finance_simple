<?php
require_once 'config.php';
include_once 'orm/DataBarangORM.php';
include_once 'orm/DataPelangganORM.php';

class DataPembelianORM extends Model
{
	//nama tabel di database
	public static $_table = 'pembelian';

}
