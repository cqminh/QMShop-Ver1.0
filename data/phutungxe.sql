-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 12, 2022 lúc 05:52 AM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `phutungxe`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `top3BanChay` ()  BEGIN
	SELECT * FROM chitiethoadon c
    JOIN sanpham s ON s.idSp = c.idSp
    GROUP BY c.idSp
    ORDER BY SUM(soluong) DESC
    LIMIT 3;
END$$

--
-- Các hàm
--
CREATE DEFINER=`root`@`localhost` FUNCTION `tinhDoanhThu` (`fromDate` TIMESTAMP, `toDate` TIMESTAMP) RETURNS FLOAT BEGIN
	DECLARE doanhThu float;
    IF EXISTS (SELECT * FROM hoadon h WHERE created_at BETWEEN fromDate AND toDate)
    THEN
    	SELECT SUM(priceSp*soluong) INTO doanhThu
        FROM sanpham s INNER JOIN chitiethoadon c ON s.idSp = c.idSp
        INNER JOIN hoadon h ON c.idHd = h.idHd
        WHERE created_at BETWEEN fromDate AND toDate;
     ELSE
     	SET doanhThu = -1;
	END IF;
    RETURN doanhThu;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `tinhTongHoaDon` (`idHd` INT(10)) RETURNS FLOAT begin
	declare tong float;
    if exists (select idHd from chitiethoadon c where c.idHd = idHd)
    then
		select sum(priceSp*soluong) into tong
		from sanpham s inner join chitiethoadon c on s.idSp = c.idSp
			where c.idHd = idHd;
	else
		set tong=-1;
    end if;
    RETURN tong;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `unAd` varchar(50) NOT NULL,
  `pwAd` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`unAd`, `pwAd`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `idCthd` int(10) NOT NULL,
  `idHd` int(10) NOT NULL,
  `idSp` int(10) NOT NULL,
  `soluong` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`idCthd`, `idHd`, `idSp`, `soluong`) VALUES
(1, 2, 12, 1),
(2, 3, 11, 1),
(3, 5, 12, 1),
(4, 6, 10, 3),
(5, 8, 10, 3),
(6, 8, 11, 2),
(7, 9, 11, 4),
(8, 10, 18, 1),
(9, 10, 22, 2),
(10, 11, 15, 2),
(11, 12, 14, 5),
(12, 12, 24, 1),
(13, 12, 13, 3),
(14, 13, 16, 2),
(15, 13, 13, 3),
(16, 13, 17, 1),
(17, 14, 20, 3),
(18, 14, 23, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

CREATE TABLE `danhgia` (
  `idDg` int(10) NOT NULL,
  `idKh` int(10) NOT NULL,
  `idSp` int(10) NOT NULL,
  `content` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `danhgia`
--

INSERT INTO `danhgia` (`idDg`, `idKh`, `idSp`, `content`) VALUES
(9, 3, 12, 'Sản phẩm rất tốt'),
(16, 4, 12, 'Nhân viên giao hàng nhiệt tình'),
(17, 4, 10, 'Sản phẩm chất lượng tôi sẽ ủng hộ thêm'),
(18, 5, 18, 'Sản phẩm rất tốt'),
(19, 6, 14, 'Cũng ổn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `idHd` int(10) NOT NULL,
  `idKh` int(10) NOT NULL,
  `addressKh` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`idHd`, `idKh`, `addressKh`, `created_at`) VALUES
(2, 3, 'Ninh Kiều, Cần Thơ', '2022-11-04 07:43:30'),
(3, 4, 'Quận 1, TP.HCM', '2022-11-04 07:46:36'),
(5, 4, 'Quận 1, TP.HCM', '2022-11-04 07:51:09'),
(6, 4, 'Ninh Kiều, Cần Thơ', '2022-11-04 08:14:08'),
(8, 3, 'Ninh Kiều, Cần Thơ', '2022-11-05 10:08:12'),
(9, 3, 'Ninh Kiều, Cần Thơ', '2022-11-06 03:56:59'),
(10, 5, 'Ô Môn, Cần Thơ', '2022-11-08 10:46:04'),
(11, 6, 'Ô Môn, Cần Thơ', '2022-11-08 10:59:04'),
(12, 6, 'Ô Môn, Cần Thơ', '2022-11-08 10:59:38'),
(13, 6, 'Ô Môn, Cần Thơ', '2022-11-10 10:52:37'),
(14, 3, 'Ninh Kiều, Cần Thơ', '2022-11-11 16:22:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `idKh` int(10) NOT NULL,
  `emailKh` varchar(50) NOT NULL,
  `pwKh` varchar(50) NOT NULL,
  `nameKh` varchar(50) NOT NULL,
  `pnKh` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`idKh`, `emailKh`, `pwKh`, `nameKh`, `pnKh`) VALUES
(3, 'cqm@gmail.com', '123456', 'Châu Quang Minh', '0123456789'),
(4, 'stmtp@gmail.com', '123456', 'Sơn Tùng M-TP', '0123456789'),
(5, 'b@gmail.com', '123456', 'Trần Thị B', '0987654321'),
(6, 'tl@gmail.com', '123456', 'Thúy Loan', '0136294728');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `idL` int(10) NOT NULL,
  `nameL` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`idL`, `nameL`) VALUES
(1, 'Dầu nhớt'),
(3, 'Trang trí'),
(4, 'Kính'),
(5, 'Bộ tải'),
(6, 'Bộ nhún'),
(7, 'Bộ phanh'),
(8, 'Vỏ ruột');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phanhoi`
--

CREATE TABLE `phanhoi` (
  `idPh` int(10) NOT NULL,
  `emailKh` varchar(50) NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `phanhoi`
--

INSERT INTO `phanhoi` (`idPh`, `emailKh`, `content`) VALUES
(1, 'cqm@gmail.com', 'Dịch vụ rất tốt! Nên phát huy thêm.'),
(2, 'sqmtp@gmail.com', 'Hàng đóng gói không kỹ'),
(3, 'minhb1910257@student.ctu.edu.vn', 'Sản phẩm chính hãng rất hài lòng'),
(4, 'me@example.com', 'Cũng tạm'),
(5, 'tl@gmail.com', 'sản phẩm ok');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `idSp` int(10) NOT NULL,
  `nameSp` varchar(50) NOT NULL,
  `idL` int(10) NOT NULL,
  `idXs` int(10) NOT NULL,
  `imageSp` varchar(100) DEFAULT NULL,
  `priceSp` float NOT NULL,
  `amountSp` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`idSp`, `nameSp`, `idL`, `idXs`, `imageSp`, `priceSp`, `amountSp`) VALUES
(10, 'Nhớt Castrol', 1, 1, 'Sp548.jpg', 100000, 94),
(11, 'Nhớt Motul', 1, 2, 'Sp796.jpg', 110000, 48),
(12, 'Kính Airblade', 4, 3, 'Sp244.webp', 130000, 100),
(13, 'Kính hậu có gù', 4, 1, 'Sp436.jpg', 80000, 44),
(14, 'Kiếng hậu tròn', 4, 1, 'Sp111.jpg', 60000, 95),
(15, 'Bộ áo Wave (đỏ)', 3, 1, 'Sp962.jpg', 1000000, 8),
(16, 'Bộ ốc nồi Exciter', 3, 4, 'Sp881.jpg', 430000, 48),
(17, 'Xích D.I.D 10 ly', 5, 3, 'Sp172.jpg', 650000, 39),
(18, 'Phuộc RCB VD', 6, 5, 'Sp476.jpg', 5500000, 19),
(19, 'Bao tay Barracuda', 3, 4, 'Sp670.jpg', 400000, 50),
(20, 'Bố thắng đĩa Elig', 7, 6, 'Sp615.png', 100000, 97),
(21, 'Phuộc RCB E2', 6, 2, 'Sp586.jpg', 1800000, 50),
(22, 'Nhớt Motul tay ga', 1, 1, 'Sp207.jpg', 120000, 98),
(23, 'Vỏ Champion SHR79', 8, 5, 'Sp662.jpg', 445000, 99),
(24, 'Vỏ Dunlop', 8, 5, 'Sp904.jpg', 1109000, 19);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `xuatsusanpham`
--

CREATE TABLE `xuatsusanpham` (
  `idXs` int(10) NOT NULL,
  `nameXs` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `xuatsusanpham`
--

INSERT INTO `xuatsusanpham` (`idXs`, `nameXs`) VALUES
(1, 'Việt Nam'),
(2, 'Mỹ'),
(3, 'Nhật Bản'),
(4, 'Thái Lan'),
(5, 'Đài Loan'),
(6, 'Trung Quốc');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`idCthd`),
  ADD KEY `idSp` (`idSp`),
  ADD KEY `idHd` (`idHd`,`idSp`) USING BTREE;

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`idDg`),
  ADD KEY `idSp` (`idSp`),
  ADD KEY `idKh` (`idKh`,`idSp`) USING BTREE;

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`idHd`),
  ADD KEY `idKh` (`idKh`) USING BTREE;

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`idKh`);

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`idL`);

--
-- Chỉ mục cho bảng `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD PRIMARY KEY (`idPh`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`idSp`),
  ADD KEY `idXs` (`idXs`),
  ADD KEY `idL` (`idL`) USING BTREE;

--
-- Chỉ mục cho bảng `xuatsusanpham`
--
ALTER TABLE `xuatsusanpham`
  ADD PRIMARY KEY (`idXs`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  MODIFY `idCthd` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  MODIFY `idDg` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `idHd` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `idKh` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `idL` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `phanhoi`
--
ALTER TABLE `phanhoi`
  MODIFY `idPh` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `idSp` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `xuatsusanpham`
--
ALTER TABLE `xuatsusanpham`
  MODIFY `idXs` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`idSp`) REFERENCES `sanpham` (`idSp`),
  ADD CONSTRAINT `chitiethoadon_ibfk_3` FOREIGN KEY (`idHd`) REFERENCES `hoadon` (`idHd`);

--
-- Các ràng buộc cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `danhgia_ibfk_1` FOREIGN KEY (`idKh`) REFERENCES `khachhang` (`idKh`),
  ADD CONSTRAINT `danhgia_ibfk_2` FOREIGN KEY (`idSp`) REFERENCES `sanpham` (`idSp`);

--
-- Các ràng buộc cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`idKh`) REFERENCES `khachhang` (`idKh`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`idL`) REFERENCES `loaisanpham` (`idL`),
  ADD CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`idXs`) REFERENCES `xuatsusanpham` (`idXs`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
