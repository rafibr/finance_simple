-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2022 at 12:27 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasi_ta`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_barang`
--

CREATE TABLE `data_barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `stok` varchar(100) NOT NULL,
  `kode_supplier` varchar(100) NOT NULL,
  `harga_beli` int(100) NOT NULL,
  `harga_jual` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_barang`
--

INSERT INTO `data_barang` (`id`, `kode_barang`, `nama_barang`, `stok`, `kode_supplier`, `harga_beli`, `harga_jual`) VALUES
(13, 'BR-08224', 'water', '397', 'SP-08225', 2222, 50000),
(14, 'BR-082214', 'Water Pumps', '446', 'SP-08226', 10000, 10000),
(15, 'BR-082215', 'Wortel', '146', 'SP-08226', 6000, 12000);

-- --------------------------------------------------------

--
-- Table structure for table `data_pelanggan`
--

CREATE TABLE `data_pelanggan` (
  `id` int(11) NOT NULL,
  `kode_pelanggan` varchar(100) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat_pelanggan` varchar(100) NOT NULL,
  `telp_pelanggan` varchar(100) NOT NULL,
  `npwp_pelanggan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_pelanggan`
--

INSERT INTO `data_pelanggan` (`id`, `kode_pelanggan`, `nama_pelanggan`, `alamat_pelanggan`, `telp_pelanggan`, `npwp_pelanggan`) VALUES
(2, 'PL-08221', 'aa', 'v', '1', 'c3234.23 234.2.'),
(4, 'PL-08224', 'rafi', 'banjarmasin', '082222', 'cas0/3232/234/qsa');

-- --------------------------------------------------------

--
-- Table structure for table `data_supplier`
--

CREATE TABLE `data_supplier` (
  `id` int(11) NOT NULL,
  `kode_supplier` varchar(100) DEFAULT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `alamat_supplier` varchar(100) NOT NULL,
  `telp_supplier` varchar(100) NOT NULL,
  `npwp_supplier` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_supplier`
--

INSERT INTO `data_supplier` (`id`, `kode_supplier`, `nama_supplier`, `alamat_supplier`, `telp_supplier`, `npwp_supplier`) VALUES
(5, 'SP-08225', 'aaaac', 'aaaa', '13123', '123213'),
(6, 'SP-08226', 'tokopedia', 'jakarta', '08222', '234324.234.');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id` int(11) NOT NULL,
  `kode_pembelian` varchar(10) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `kode_supplier` varchar(100) NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `jumlah_pembelian` int(100) NOT NULL,
  `harga_beli_pembelian` int(100) NOT NULL,
  `sub_total_pembelian` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id`, `kode_pembelian`, `tanggal_pembelian`, `kode_supplier`, `kode_barang`, `jumlah_pembelian`, `harga_beli_pembelian`, `sub_total_pembelian`) VALUES
(61, 'PL-08221', '2022-08-09', 'SP-08226', 'BR-082214', 21, 10000, 210000),
(62, 'PL-08221', '2022-08-09', 'SP-08226', 'BR-082215', 3, 6000, 18000);

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan`
--

CREATE TABLE `penerimaan` (
  `id` int(11) NOT NULL,
  `kode_penerimaan` varchar(100) NOT NULL,
  `tanggal_penerimaan` date NOT NULL,
  `keterangan_penerimaan` text NOT NULL,
  `total_penerimaan` int(100) NOT NULL,
  `kode_penjualan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penerimaan`
--

INSERT INTO `penerimaan` (`id`, `kode_penerimaan`, `tanggal_penerimaan`, `keterangan_penerimaan`, `total_penerimaan`, `kode_penjualan`) VALUES
(50, 'PNK-08221', '2022-08-09', 'Penjualan barang kepada rafi', 410000, 'PJ-08221'),
(51, 'PNK-082251', '2022-08-01', 'Terima donasi', 20000, NULL),
(53, 'PNK-082252', '2022-08-01', 'investor', 20000000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `kode_pengeluaran` varchar(100) NOT NULL,
  `tanggal_pengeluaran` date NOT NULL,
  `keterangan_pengeluaran` text NOT NULL,
  `total_pengeluaran` int(100) NOT NULL,
  `kode_pembelian` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `kode_pengeluaran`, `tanggal_pengeluaran`, `keterangan_pengeluaran`, `total_pengeluaran`, `kode_pembelian`) VALUES
(50, 'PLK-08221', '2022-08-09', 'Pembelian barang dari tokopedia', 228000, 'PL-08221'),
(51, 'PLK-082251', '2022-08-09', 'bayar listrik', 10000000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(11) NOT NULL,
  `kode_penjualan` varchar(10) NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `kode_pelanggan` varchar(100) NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `harga_jual_penjualan` int(100) NOT NULL,
  `jumlah_penjualan` int(100) NOT NULL,
  `sub_total_penjualan` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `kode_penjualan`, `tanggal_penjualan`, `kode_pelanggan`, `kode_barang`, `harga_jual_penjualan`, `jumlah_penjualan`, `sub_total_penjualan`) VALUES
(66, 'PJ-08221', '2022-08-09', 'PL-08224', 'BR-082214', 10000, 21, 210000),
(67, 'PJ-08221', '2022-08-09', 'PL-08224', 'BR-08224', 50000, 4, 200000);

-- --------------------------------------------------------

--
-- Table structure for table `saldo`
--

CREATE TABLE `saldo` (
  `id` int(11) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `saldo`
--

INSERT INTO `saldo` (`id`, `saldo`) VALUES
(1, 11162002);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(15) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama_user`, `email`, `password`, `level`) VALUES
(10, 'admin', 'admin@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin'),
(12, 'Gandi', 'gandi@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'gandi'),
(13, 'Dea', 'dea@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'dea'),
(14, 'Rasel', 'rasel@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'rasel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_barang`
--
ALTER TABLE `data_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_supplier`
--
ALTER TABLE `data_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penerimaan`
--
ALTER TABLE `penerimaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_barang`
--
ALTER TABLE `data_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_supplier`
--
ALTER TABLE `data_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `penerimaan`
--
ALTER TABLE `penerimaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
