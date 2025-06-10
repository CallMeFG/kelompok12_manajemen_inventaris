-- -- Membuat Database
-- CREATE DATABASE IF NOT EXISTS inventaris_db;
-- USE inventaris_db;

-- -- --------------------------------------------------------

-- --
-- -- Struktur dari Tabel `kategori`
-- --
-- CREATE TABLE `kategori` (
--   `id_kategori` INT(11) NOT NULL AUTO_INCREMENT,
--   `nama_kategori` VARCHAR(100) NOT NULL,
--   PRIMARY KEY (`id_kategori`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --
-- -- Sample data untuk tabel `kategori`
-- --
-- INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
-- (1, 'Alat Tulis Kantor'),
-- (2, 'Buku & Referensi'),
-- (3, 'Elektronik');

-- -- --------------------------------------------------------

-- --
-- -- Struktur dari Tabel `produk`
-- --
-- CREATE TABLE `produk` (
--   `id_produk` INT(11) NOT NULL AUTO_INCREMENT,
--   `id_kategori` INT(11) NOT NULL,
--   `nama_produk` VARCHAR(150) NOT NULL,
--   `harga` DECIMAL(10,2) NOT NULL,
--   `stok` INT(11) NOT NULL DEFAULT 0,
--   PRIMARY KEY (`id_produk`),
--   KEY `id_kategori` (`id_kategori`),
--   CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --
-- -- Sample data untuk tabel `produk`
-- --
-- INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `harga`, `stok`) VALUES
-- (1, 1, 'Pensil 2B Faber-Castell', 2500.00, 50),
-- (2, 2, 'Buku Tulis Sinar Dunia 58 Lbr', 4000.00, 120),
-- (3, 3, 'Mouse Logitech M170', 150000.00, 15),
-- (4, 1, 'Penghapus Joyko', 1500.00, 75);

-- -- --------------------------------------------------------

-- --
-- -- Struktur dari Tabel `log_stok`
-- --
-- CREATE TABLE `log_stok` (
--   `id_log` INT(11) NOT NULL AUTO_INCREMENT,
--   `id_produk` INT(11) NOT NULL,
--   `stok_lama` INT(11) NOT NULL,
--   `stok_baru` INT(11) NOT NULL,
--   `waktu_ubah` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
--   PRIMARY KEY (`id_log`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -- --------------------------------------------------------

-- --
-- -- Objek Database: VIEW `v_produk_lengkap`
-- --
-- CREATE OR REPLACE VIEW `v_produk_lengkap` AS
-- SELECT
--     p.id_produk,
--     p.nama_produk,
--     p.harga,
--     p.stok,
--     k.id_kategori,
--     k.nama_kategori
-- FROM produk p
-- JOIN kategori k ON p.id_kategori = k.id_kategori;

-- -- --------------------------------------------------------

-- --
-- -- Objek Database: FUNCTION `fn_status_stok`
-- --
-- DELIMITER $$
-- CREATE FUNCTION `fn_status_stok` (`jumlah_stok` INT)
-- RETURNS VARCHAR(20)
-- DETERMINISTIC
-- BEGIN
--     DECLARE status_text VARCHAR(20);
--     IF jumlah_stok > 10 THEN
--         SET status_text = 'Tersedia';
--     ELSEIF jumlah_stok > 0 AND jumlah_stok <= 10 THEN
--         SET status_text = 'Stok Menipis';
--     ELSE
--         SET status_text = 'Habis';
--     END IF;
--     RETURN status_text;
-- END$$
-- DELIMITER ;

-- -- --------------------------------------------------------

-- --
-- -- Objek Database: TRIGGER `trg_catat_perubahan_stok`
-- --
-- DELIMITER $$
-- CREATE TRIGGER `trg_catat_perubahan_stok`
-- AFTER UPDATE ON `produk`
-- FOR EACH ROW
-- BEGIN
--     IF OLD.stok <> NEW.stok THEN
--         INSERT INTO log_stok(id_produk, stok_lama, stok_baru)
--         VALUES(OLD.id_produk, OLD.stok, NEW.stok);
--     END IF;
-- END$$
-- DELIMITER ;