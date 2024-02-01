-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2024 at 07:42 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `visitors`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','security','warden') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `role`) VALUES
(1, 'adminuser', 'adminpassword', 'admin'),
(2, 'securityuser', 'securitypassword', 'security'),
(3, 'wardenuser', 'wardenpassword', 'warden');

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--

CREATE TABLE `contact_form` (
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` int(10) NOT NULL,
  `communication` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_form`
--

INSERT INTO `contact_form` (`name`, `email`, `number`, `communication`) VALUES
('Vusi', 'Vusi@gmail.com', 34414290, 'wev'),
('David', 'lazer7545@gmail.com', 34414290, 'How does it work'),
('David', 'lazer7545@gmail.com', 12345, 'Hhow you doin'),
('Vusi', 'lazer7545@gmail.com', 34414290, 'I hope This system works');

-- --------------------------------------------------------

--
-- Table structure for table `invites`
--

CREATE TABLE `invites` (
  `invite_id` int(3) UNSIGNED ZEROFILL NOT NULL,
  `username` varchar(45) NOT NULL,
  `invite_date` date NOT NULL,
  `visitor_name` varchar(125) NOT NULL,
  `visitor_email` varchar(125) NOT NULL,
  `visitor_phone` varchar(10) NOT NULL,
  `visitor_id` varchar(13) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `parking_reserved` varchar(3) NOT NULL,
  `qrcode` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invites`
--

INSERT INTO `invites` (`invite_id`, `username`, `invite_date`, `visitor_name`, `visitor_email`, `visitor_phone`, `visitor_id`, `reason`, `parking_reserved`, `qrcode`) VALUES
(000, 'kingdavid', '2023-11-16', 'Lazer 234', 'lazer7545@gmail.com', '0731155454', '9609236045083', '', 'No', 0x89504e470d0a1a0a0000000d49484452000000cd000000cd01030000002172662a00000006504c5445ffffff00000055c2d37e000000097048597300000ec400000ec401952b0e1b000001b7494441545885ed973d8e85300c84fd44919223e42670312490b818dc2447a0a488f0ce38ecbed5feb476430a10f91acb638f8dc8739ef3efe955f5ea97acbbae256dfd8a6f5dfc115e83cc255d2299a8b43b6fb4ea394857ce17e242ac6b61c04148785bc3d19465844e290e995e48140aa824d55f523a21abdeb59cc3fdf859d83ee8335b28dc259fe3f75b4fd4d70cbd66d5fd80684cd93b519e0875b26b15e4488bbc8e59d9d5ee086ea2977410e980afe8015ff9d2cb134d627141aa8a4e0292310035238168e66c38347b7f646d6c61f21eb52327c2f447b3ca800813479fb076be958d1f6207bf8eaecd1c4855250471e45e4c149d8dbdaca8a200042341c564dd6cd2e0025dbd44a0c49a655c588b68295b00425c89de4a5fe1e8b37dc41f895919a56243b3b5adabbd912d8408ce5c16ce3681dfc717d1e227815430fb1d1f6f83f545b6233347d9fae70c418a49c3b2e12ad216a4fdee654f74f336fead7091377f64fb214a18af9aa52d891280166ecb53f333932a06f1dfc15462b1f00742af30049fe7e66e1b916e51087a61e654fa7c575aacde887a710161ebb495798c40ed4f4a397cd57ce56db08ee839cff9f37c004d07b5b89468315d0000000049454e44ae426082),
(000, 'vusimuzi', '2023-11-17', 'Mavis Mutsvene', 'lazer7545@gmail.com', '0731155454', '0111115541083', 'study', 'No', 0x89504e470d0a1a0a0000000d49484452000000e1000000e10103000000047d403900000006504c5445ffffff00000055c2d37e000000097048597300000ec400000ec401952b0e1b00000217494441545885ed98318e84301004071110f204ff043e8604121f5b7ee2271012a09beb6eef2eec5d7aa721c001c22e079667dcd3b6d9ddeef62fad75f72fabb3753624f77574eb31b405d3c908ac79600a8667df3a0c475376db2959b5d6197f3356df7abe02c59afd812918abfd6214fbe8eb45a8e25bfbd63bfe9870f62bfa01946701515568cbe7e74909a0cf8533eb86d42ceb98cf208a229658e284adc37211e43937929158ca5856be275f20193c10e8aeeff886d19a2760488c2a973be2d31ef18da28caa631331961bf7fd33f241b4dd8df58855085316d2aedd5330558661ebac5f2d4946fc61e3b1cf417430686c9d1b261c4aa529eb523445ab5cba313a126ea7adf888711045ae41599fbab11ba64cd1145dc96b4938252184f65d1782a89c203d57af316aec15e8c8aef1984241e85429b9164e656c74422519a67a144ce50459bb7b0419a702a9e747018fa2b483ecca4c38eb9175c5b3865202641d7f13d40cf5b23a15a5208a806e7db11035ed20d5ccdf6b8ea25cb30cfdb2bebc05532f982296487e4b72f5bca119edb40753a61903ea9c02a17516a5f34e86d056c66ba6784c940c1e8dd34d2488beb693eecbb17a8253f48368b997415965e8a9b6bc9c79349d5ed694fe59ba6127471145f536029fa3b7112bcf369eaf40790d5a44f500c1a27901aaa816f1984b81dc82a9e23ba954f24d70a09a1df7a328aab32047811b90f694d7b42d96deed6e7fdebe015ecd65f7bbeb721d0000000049454e44ae426082),
(000, 'vusimuzi', '2023-11-30', 'Vusimozi Solani', 'lazer7545@gmail.com', '0731155454', '0111115541083', 'social', 'No', 0x89504e470d0a1a0a0000000d49484452000000e1000000e10103000000047d403900000006504c5445ffffff00000055c2d37e000000097048597300000ec400000ec401952b0e1b00000210494441545885ed98318e84300c458d282839426eb273312490e662c34d7284942910deff3fb0c34ebd3ba69814087814969dffed60f6599ff52fab77f7d5da6c5f66c9bdb46e37bcaac1743280c1ba072fb32f89df5934bd7bfdeaa7644d19f04e1ff79eaf4011ae3f9049bb15e6f44ab45facf332fa25a8eadb7a45b8d86dae8f5faa1f40a985fe9e51e4e3f2aa9400ba07beed3a6ac1ce208aa2960871a20c74b7a4cd4662e911b3cf8ec059eeda14b31a4d53b7f64bc2ae1b332cadcd783cd5378ce26eccc8df90ba07d2d9ade73406d1510a701919cce39e7137a4608a24fa5c767b45cca8f4c3c61ffd0651c4dc41011027ec150e427bc527d154f535a66e74383f8a4cc15a3435c8409254261743e0f114bb0ef6ba17b961b84d39d737860eb00ca76f0070acd81a7830d5e647eae01ba8afccc39f4d298e22482c63dbf6f9e847d1744912a73cac6a5c650f08a6ecd3b7a2a99eef18f87af28d283ae82aab4f4c69862016b3600aa081b9d140bfedbab3c7c650764474496d3884ab71f5391806518e5b8cb43270f523aac283a9f18cc81390c3fe7590d5e1319862f3cbc33451287a6e3d0fa67b3a415de2440fb0fee5c0f17e7a9ccb3478b129a57aae7e149d4cdb8cf71a07f3f62b22986eff4674ee49acb46d967601ca70671cf539e26465f70a94979bcb32765083a9ea3b997e02a28b43a11484055369810a2d9aef5bfdaefcad94f7d3cffaac3f5fdf9b3cf441072181fd0000000049454e44ae426082),
(000, 'vusimuzi', '2023-11-22', 'Vusimozi Solani', 'lazer7545@gmail.com', '0731155454', '0111115541083', 'social', 'No', 0x89504e470d0a1a0a0000000d49484452000000e1000000e10103000000047d403900000006504c5445ffffff00000055c2d37e000000097048597300000ec400000ec401952b0e1b00000215494441545885ed983d8e84300c858d282839426e325c0c89485c6cb80947484911e17dcf8181a5de1d539002317c19c9f8e7d941e459cffa97d5aaea2af52c2f91a09a6a950e8f16671a05a097e6cdcba439709f78d35197571b8354a9c733dbdcea7c070a73f50d4f4a97e8d33bd1364ba369d05b508b6fad0bcc45b6a96dbe44df81b216da714690f7cbb5521ce86678c93ad6829c8117452c61626419d85d0e4546dc6933a53ee8a4309ce15eaa748aaf0f15263f2ec8ba6186a4d573b3b6477cbd681f4c5ee13fdef115d653801de9ba0b19c463a49a41fedd29134e8dc2e618b0e5ec49170a8d6d580b48bd810a0279ad907fce148bfe53cb3f287f71ec6939d1cf08619eccc83f76035fca34a3eb744ad8873b81da0e477c7d288a130987d4eb0038569406ee4d51973097ba81f89a78e8a92939d16d524590e1539df67ee44cb9aa646a0677dab8ca1ee04f6ddc82fcf3190d472d04678a9fd6bb791f3814b234f2fe4737aa9c0433e7083b9c59d61d363b514e5a140a4b38983b6e9b7d29fb117bf7c21386f52356853a5316a7e59a262907593b3c3a53e8062ccd65cee109cd524f9de9ee4ee9d48a3373ecb91c38be4fcbb94ccbe0c5a6c4481fd1f7a2d13e3b70ce816e6c92163f2fe345eddb88e98670f0c27c6f9276038af33e7403418682cce6dd3b505e3a35c9d8c0e24c2dbe28537e042ca7d9f53801b951ab8548dd106a586d9f2b7f57caf7e9b39ef5e7eb0714fefc4d297edea50000000049454e44ae426082),
(000, 'vusimuzi', '2023-11-22', 'Lazer 234', 'lazer7545@gmail.com', '0731155454', '0111115541083', 'social', 'No', 0x89504e470d0a1a0a0000000d49484452000000cd000000cd01030000002172662a00000006504c5445ffffff00000055c2d37e000000097048597300000ec400000ec401952b0e1b000001b8494441545885ed97b18dc3300c4529b870e911b489b3980105f062f1261a41a50ac3bc4fd2b924b85c4b3666e1247a2908f2eb9326bae28a7f6362e6830a1e13d7f131adf8cd777f848f9916a2d486ca40d5cebcd1ca7d26cafdd68890dc5a916b10c243d2cc28d91089b8a25085bf65e884ce7ef103c949ae7f5be98244bd38d0532dd9a7b09d9045a9a69d6772ee68da69e4b664bab5857097ef52b210c41b4ed1b4c2a3d42804a13c7ad053d37faee02d0015a624525153c3b7ca1148aeb1b40a8f819126049402100d92e1aefdaae81ce55f4b714510ee3ced1979c1570efc7cf5cb1141bd5d07dec63a780a8720a897e52e8f5bd35c219b0705a05275fc8f32694814d3d3d3603d11fcec104e66f16b557bf346a88ca46416df6fe26c6f77d90de11275d94290170484b528530a40e2a8e2f3a3aea9db87dbb8a28af22036f115323187a07347c6a92e43d847eefe6897a9871ac156b30d9e2300198766d12f360927f647b61fee59278dfacadb407444c846c70dbe654d4e2fb43bb23729ea644bfb59ad18b4c89208979d453bf3b38b21e81cbef5f55ae189b45f2ca743d5ab8de943fec8d42b5767b57de4b5a538a22baef81a3f47abbc2fb5c0966e0000000049454e44ae426082),
(000, 'vusimuzi', '2023-11-22', 'Mavis Mutsvene', 'Khoollou26@gmail.com', '0731155454', '9609236045083', 'social', 'No', 0x89504e470d0a1a0a0000000d49484452000000e1000000e10103000000047d403900000006504c5445ffffff00000055c2d37e000000097048597300000ec400000ec401952b0e1b00000209494441545885ed98318e83400c458d28a6e408dc245c0c09242e466e3247a0a44078ffff939064b7dd5d533005caf0269233b6bfed985deb5a7fb21a77df9bb15d2b9fb2ddacced6e1d51a4c47b35be319473cebd37ac3eb683a39b6b5afb0342758ebe5c829a82ed1d37d19f269289c9c7cb116e74e42e5dfb1b56aa973da1b85de37ef0750e5c284583b1e3f32e5ffe9719d9d8fb4b4fe005114be4c7b79e04e2ba7a71d32124be9cbe25a1b1c92b631f4fa33506480c35c845eb7d40e8d9d7234edcd673cd20cd72a2b201e7d6bc174c8ae755706345b4bff5a307d1648024b77fab77add6414c5254a2d7c47ac51d2dc679c8ba6da523716351354b337ff0652476d7c66281302d7194cd9e2cc5233b3b6f817dfc86b30c5566ac1774a083b0165d4714bb530956dfc8497f20751d46ef5398ec6ab942208ede0d1146a71a4243fb5a5710da6b27933363b6a2ba8b1876e84d18db5bb67e8f5ec28a62cff5a2c65f7c0ae3e95aab4b094bf2b701045f0330da8669257f3cfee2b8416215329eadb0238a10553282bafd3a41bea0ea9fc164c354fab54d2f00ec3190c9f72302d476824ef54865bf3eefd10aab9cc146b1373416dcf9bf783e8c81956433f5a7b6ed5ae5a307dfc0ba18440ae16fffa29287543a5127d0e1e18fa4f400138be66fa97861fd36218957fb7876e7445cd46b3605afe1bf1323272e887fc0f1f991240af75ad5f5f5fd198aa851c53cad20000000049454e44ae426082),
(000, 'vusimuzi', '2023-11-21', 'Maria Sipho', 'lazer7545@gmail.com', '0731155454', '0111115541083', 'family', 'No', 0x89504e470d0a1a0a0000000d49484452000000e1000000e10103000000047d403900000006504c5445ffffff00000055c2d37e000000097048597300000ec400000ec401952b0e1b00000212494441545885ed98318e833014443fa2a0e408dc042e1609242e0637f1115c5244fc9df9261128edee0e455c582ccf05fbc77f3c8ed9777cc79f8cd6dd774c8de7dab7deea64035e6d623a99f5edd45995eb847573b21eafd574e6973eac5930f9d27ada7a4e77a0d66d954f9def36badd85a292a0ce75a37f7cb38286be4e699f56a4fd505f40a31766aafa9a3e3ae5ff6959f28c5dd7a139e70b505114b141113b5f3dca3919be18728b293a60cd0f088aa766cda33bbf5e4da92f2d636757b092187312531b53b3a0920098a235860ca5b5f4f00d6b76ae0b7df7d3ae1351be5bb30575f402375c7ba9a482f2808cd25519eb1c4f38949e76030ad387c8f87afccd4471d25744adf60836f40d2fd982fb4f4c5b3e85a08c606bf1d8faadaf8832e2c054e91bf0580643bb05c5364339e11b5379011b793bbf8cd6d0358fa743691b60ff620a378b901a6ee6a16fcf7f414b2db27cb4e9cc0bc788c9dfbea1a2d86bd10b0d458e0e0d7d4d4cf1c4d2a188d09737342cb978ac82122cd192cc610c13e7f4a5a20c134ccd38b16bb859666bb82731a5aabc92a12f611928a7d1f94d4ce91638b1d9a18fe3ca784e8c225a96a01722e754014e1e2ba2253fbf4ea1c1e7eb7d5f45a77287e5864bf1662be7b9961e56efeb61afa1afdf83b274c8843d8f271c4ae90e347ce3b837966913d3a2af876f20da43df77e211d2f86de46945daf8cd0d39e7d22902fa1ddff1ebe307bfd8b38b1c2565fd0000000049454e44ae426082);

-- --------------------------------------------------------

--
-- Table structure for table `onspot`
--

CREATE TABLE `onspot` (
  `invite_id` int(3) NOT NULL,
  `username` varchar(45) NOT NULL,
  `invite_date` date NOT NULL,
  `visitor_name` varchar(125) NOT NULL,
  `visitor_email` varchar(125) NOT NULL,
  `visitor_phone` varchar(10) NOT NULL,
  `visitor_id` varchar(13) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `parking_reserved` varchar(3) NOT NULL,
  `qrcode` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `onspot`
--

INSERT INTO `onspot` (`invite_id`, `username`, `invite_date`, `visitor_name`, `visitor_email`, `visitor_phone`, `visitor_id`, `reason`, `parking_reserved`, `qrcode`) VALUES
(1, 'adminuser', '2023-11-09', 'vus', 'lazer7545@gmail.com', '0731155454', '234567765690', '', 'No', 0x796f75725f626c6f625f64617461),
(2, 'adminuser', '2023-11-09', 'vus', 'lazer7545@gmail.com', '0731155454', '234567765690', '', 'No', 0x796f75725f626c6f625f64617461),
(3, 'adminuser', '2023-11-09', 'vus', 'lazer7545@gmail.com', '0731155454', '234567765690', '', 'No', ''),
(4, 'adminuser', '2023-11-09', 'vus', 'lazer7545@gmail.com', '0731155454', '234567765690', '', 'No', 0x796f75725f626c6f625f64617461),
(5, 'adminuser', '2023-11-09', 'vus', 'lazer7545@gmail.com', '0731155454', '234567765690', '', 'No', 0x796f75725f626c6f625f64617461),
(6, 'adminuser', '2023-11-23', 'David Nwachukwu', 'lazer7545@gmail.com', '0725643033', '0111183475894', 'social', '1', 0x796f75725f626c6f625f64617461),
(7, 'adminuser', '2023-11-23', 'David Nwachukwu', 'lazer7545@gmail.com', '0725643033', '0111183475894', 'social', '1', 0x796f75725f626c6f625f64617461),
(8, 'adminuser', '2023-11-22', 'Daniels', 'lazer7545@gmail.com', '0725643033', '23456789', 'social', 'No', 0x796f75725f626c6f625f64617461),
(9, 'Vusimozi', '2023-11-21', 'Maria', 'Lazer7545@gmail.com', '0836260282', '0111183475894', 'social', 'Yes', 0x796f75725f626c6f625f64617461);

-- --------------------------------------------------------

--
-- Table structure for table `residence`
--

CREATE TABLE `residence` (
  `Residence_ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Number_of_Blocks` int(11) DEFAULT NULL,
  `Room_Numbers` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residence`
--

INSERT INTO `residence` (`Residence_ID`, `Name`, `Number_of_Blocks`, `Room_Numbers`) VALUES
(1, 'Cluster_12', 2, 6),
(2, 'Lost City', 2, 6),
(3, 'James', 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `Room_ID` int(11) NOT NULL,
  `Residence_ID` int(11) DEFAULT NULL,
  `Block_Number` int(11) DEFAULT NULL,
  `Room_Number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`Room_ID`, `Residence_ID`, `Block_Number`, `Room_Number`) VALUES
(1, 1, 1, 'C1'),
(2, 1, 1, 'C2'),
(3, 1, 1, 'C3'),
(4, 1, 2, 'C4'),
(5, 1, 2, 'C5'),
(6, 1, 2, 'C6'),
(7, 2, 1, 'L1'),
(8, 2, 1, 'L2'),
(9, 2, 1, 'L3'),
(10, 2, 2, 'L4'),
(11, 2, 2, 'L5'),
(12, 2, 2, 'L6'),
(13, 3, 1, 'J1'),
(14, 3, 1, 'J2'),
(15, 3, 1, 'J3'),
(16, 3, 2, 'J4'),
(17, 3, 2, 'J5'),
(18, 3, 2, 'J6');

-- --------------------------------------------------------

--
-- Table structure for table `scanned_qr`
--

CREATE TABLE `scanned_qr` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `invite_date` date DEFAULT NULL,
  `visitor_name` varchar(255) DEFAULT NULL,
  `visitor_email` varchar(255) DEFAULT NULL,
  `visitor_phone` varchar(255) DEFAULT NULL,
  `visitor_id` varchar(255) DEFAULT NULL,
  `parking_reserved` varchar(3) DEFAULT NULL,
  `time_in` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `checkout_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scanned_qr`
--

INSERT INTO `scanned_qr` (`id`, `username`, `invite_date`, `visitor_name`, `visitor_email`, `visitor_phone`, `visitor_id`, `parking_reserved`, `time_in`, `checkout_time`) VALUES
(10, 'kingdavid', '2023-11-16', 'Lazer 234', 'lazer7545@gmail.com', '0731155454', '9609236045083', 'No', '2023-11-21 09:21:53', '2023-11-21 09:21:53'),
(11, 'adminuser', '2023-11-02', 'Daniels', 'lazer7545@gmail.com', '7890', 'undefined', '0', '2023-11-20 22:52:55', '2023-11-20 22:52:55'),
(12, 'vusimuzi', '2023-11-17', 'Mavis Mutsvene', 'lazer7545@gmail.com', '0731155454', '0111115541083', 'stu', '2023-11-21 11:31:59', '2023-11-21 11:31:59'),
(13, 'vusimuzi', '2023-11-22', 'Lazer 234', 'lazer7545@gmail.com', '0731155454', '0111115541083', 'soc', '2023-11-21 11:31:59', '2023-11-21 11:31:59'),
(14, 'vusimuzi', '2023-11-22', 'Mavis Mutsvene', 'Khoollou26@gmail.com', '0731155454', '9609236045083', 'soc', '2023-11-21 09:21:53', '2023-11-21 09:21:53'),
(15, 'vusimuzi', '2023-11-21', 'Maria Sipho', 'lazer7545@gmail.com', '0731155454', '0111115541083', 'fam', '2023-11-21 11:31:59', '2023-11-21 11:31:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `idnumber` varchar(13) NOT NULL,
  `campus` varchar(25) NOT NULL,
  `residence` varchar(25) NOT NULL,
  `block` varchar(3) NOT NULL,
  `room` varchar(3) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `active` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `phone`, `email`, `idnumber`, `campus`, `residence`, `block`, `room`, `password`, `token`, `active`) VALUES
(1, 'kingdavid', 'David Nwachukwu', '0658951169', 'dave4real2020@gmail.com', '', 'Mahikeng', 'Cluster 12', '3', 'G02', '$2y$10$OTExNTNmNmU4OTY1YzExYukHdu1jA4a1K3VTbUYwo2.BwZcmkG9CW', '', 'ON'),
(2, 'vusimuzi', 'Vusi Sola', '087373678', 'lazer7545@gmail.com', '', 'Mahikeng', 'lost city', '1', '2', '$2y$10$OTk3NGRlZDI4YjA2ZTlmOOaXjOD3NNDyWAQs0uywfEZBux92Qcbpe', '8c0d16966dcbf859ed31bc2f7ebce51ae01ba972182849fbff4daa108d058f911a7d4d3b7f353a88', 'ON');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `Visitor_ID` int(11) NOT NULL,
  `Visitor_Name` varchar(255) DEFAULT NULL,
  `Visitor_Surname` varchar(255) DEFAULT NULL,
  `Visitor_ID_Number` varchar(255) DEFAULT NULL,
  `Visitor_Phone` varchar(255) DEFAULT NULL,
  `Visitor_Email` varchar(255) DEFAULT NULL,
  `Date_of_Invite` date DEFAULT NULL,
  `Room_ID` int(11) DEFAULT NULL,
  `qrcode` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`Visitor_ID`, `Visitor_Name`, `Visitor_Surname`, `Visitor_ID_Number`, `Visitor_Phone`, `Visitor_Email`, `Date_of_Invite`, `Room_ID`, `qrcode`) VALUES
(1, 'John', 'Doe', '123456789', '123-456-7890', 'johndoe@example.com', '2023-10-10', 7, ''),
(2, 'Jane', 'Smith', '987654321', '987-654-3210', 'janesmith@example.com', '2023-10-12', 6, ''),
(3, 'Bob', 'Johnson', '456789123', '456-789-1230', 'bobjohnson@example.com', '2023-10-15', 13, ''),
(4, 'Emily', 'Davis', '789123456', '789-123-4560', 'emilydavis@example.com', '2023-10-18', 1, ''),
(5, 'Lisa', 'Wilson', '321654987', '321-654-9870', 'lisawilson@example.com', '2023-10-20', 15, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `onspot`
--
ALTER TABLE `onspot`
  ADD PRIMARY KEY (`invite_id`);

--
-- Indexes for table `residence`
--
ALTER TABLE `residence`
  ADD PRIMARY KEY (`Residence_ID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`Room_ID`);

--
-- Indexes for table `scanned_qr`
--
ALTER TABLE `scanned_qr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`Visitor_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `onspot`
--
ALTER TABLE `onspot`
  MODIFY `invite_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `scanned_qr`
--
ALTER TABLE `scanned_qr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
