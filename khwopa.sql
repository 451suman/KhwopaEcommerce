-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 05:55 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `khwopa`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorys`
--

CREATE TABLE `categorys` (
  `cid` int(11) NOT NULL,
  `c_name` varchar(500) NOT NULL,
  `c_img` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorys`
--

INSERT INTO `categorys` (`cid`, `c_name`, `c_img`) VALUES
(1, 'Tshirt', 'category_image_1726598880.jpg'),
(2, 'Men pants', 'category_image_1726590682.jpg'),
(3, 'Men Jacket', 'category_image_1726591005.jpg'),
(4, 'Nigel Fuentes', 'category_image_1731467239.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `oid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `o_totalAmount` int(11) NOT NULL,
  `o_shippingAddress` varchar(500) NOT NULL,
  `o_orderStatus` varchar(500) NOT NULL DEFAULT 'pending',
  `o_quantity` int(11) NOT NULL,
  `o_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`oid`, `uid`, `pid`, `o_totalAmount`, `o_shippingAddress`, `o_orderStatus`, `o_quantity`, `o_date`) VALUES
(1, 2, 2, 703, ' Est vel voluptatem , Molestiae harum tene', 'completed', 1, '2024-09-13 19:08:13'),
(2, 3, 2, 703, ' Ut suscipit numquam , Esse vitae incidunt', 'completed', 1, '2024-09-13 19:09:11'),
(3, 4, 2, 703, ' Tempore sit commod, Nesciunt ex aperiam', 'completed', 1, '2024-09-13 19:10:37'),
(4, 5, 2, 703, ' Delectus sunt a adi, Non fugiat optio u', 'completed', 1, '2024-09-13 19:31:15'),
(5, 6, 2, 703, ' Commodi commodo rem , Anim dolore in fugit', 'completed', 1, '2024-09-13 19:32:12'),
(6, 7, 2, 703, ' Ut enim reiciendis s, Fuga Aut atque blan', 'completed', 1, '2024-09-13 19:33:13'),
(7, 8, 2, 703, ' Culpa eu nemo et al, Autem aut reiciendis', 'completed', 1, '2024-09-13 19:34:05'),
(8, 9, 2, 703, ' Dicta omnis ut cum e, Voluptatem numquam a', 'completed', 1, '2024-09-13 19:35:54'),
(9, 10, 2, 703, ' Blanditiis vel conse, Nihil ea accusantium', 'completed', 1, '2024-09-13 19:36:38'),
(10, 11, 2, 703, ' Quaerat consequatur , Voluptatem nihil ip', 'completed', 1, '2024-09-13 19:37:24'),
(11, 12, 2, 703, ' Et sed asperiores ut, Repudiandae excepteu', 'completed', 1, '2024-09-13 19:38:04'),
(12, 13, 2, 703, ' Eligendi veniam dol, Nihil dolorum veniam', 'completed', 1, '2024-09-13 19:38:47'),
(14, 14, 2, 703, ' Vel inventore vel qu, Fuga Autem dolores ', 'completed', 1, '2024-09-13 19:46:41'),
(15, 10, 2, 703, ' Blanditiis vel conse, Nihil ea accusantium', 'completed', 1, '2024-09-13 20:55:11'),
(16, 2, 18, 215, ' Est vel voluptatem , Molestiae harum tene', 'completed', 1, '2024-09-17 22:55:22'),
(17, 2, 26, 875, ' Est vel voluptatem , Molestiae harum tene', 'completed', 1, '2024-09-17 22:57:57'),
(18, 2, 16, 79, ' Est vel voluptatem , Molestiae harum tene', 'completed', 1, '2024-09-22 09:28:33'),
(19, 2, 15, 864, ' Est vel voluptatem , Molestiae harum tene', 'completed', 1, '2024-09-22 10:37:51'),
(20, 2, 15, 864, ' Est vel voluptatem , Molestiae harum tene', 'completed', 1, '2024-09-22 10:45:31'),
(21, 2, 2, 703, ' Est vel voluptatem , Molestiae harum tene', 'completed', 1, '2024-11-07 20:44:58'),
(22, 2, 38, 152, ' Est vel voluptatem , Molestiae harum tene', 'completed', 1, '2024-11-07 20:47:55'),
(24, 2, 2, 703, ' Est vel voluptatem , Molestiae harum tene', 'completed', 1, '2024-11-12 12:35:22'),
(25, 2, 21, 273, ' Est vel voluptatem , Molestiae harum tene', 'completed', 1, '2024-11-13 08:34:07'),
(26, 22, 15, 4320, ' Laboriosam nulla qu, Eaque voluptatem cil', 'completed', 5, '2024-11-13 13:29:09'),
(27, 2, 19, 404, ' Est vel voluptatem , Molestiae harum tene', 'completed', 1, '2024-11-14 14:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `p_name` varchar(500) NOT NULL,
  `p_model` varchar(500) NOT NULL,
  `p_brand` varchar(500) NOT NULL,
  `p_description` text NOT NULL,
  `p_price` int(11) NOT NULL,
  `p_stocksQuantity` int(11) NOT NULL DEFAULT 0,
  `p_dateAndTime` datetime NOT NULL DEFAULT current_timestamp(),
  `p_image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `cid`, `p_name`, `p_model`, `p_brand`, `p_description`, `p_price`, `p_stocksQuantity`, `p_dateAndTime`, `p_image`) VALUES
(2, 1, 'Giacomo Powers', 'Ipsum nostrum quo i', 'Dolores non id volup', 'Eius repudiandae qui', 703, 5, '2024-09-13 19:08:01', 'product_image_1726233781.jpg'),
(14, 2, 'Neville Diaz', 'Quis id dicta eos d', 'Nemo dolores deserun', 'Summer Thin Soft Lyocell Fabric Jeans Men Casual Elastic Waist Fashion Denim Trousers Male Brand Loose Straight Armygreen Pants', 882, 854, '2024-09-17 22:16:41', 'product_image_1726590701.jpg'),
(15, 2, 'Davis Spence', 'Officiis adipisci vo', 'Amet ducimus aut s', 'Summer Thin Soft Lyocell Fabric Jeans Men Casual Elastic Waist Fashion Denim Trousers Male Brand Loose Straight Armygreen Pants', 864, 46, '2024-09-17 22:18:07', 'product_image_1726590787.jpg'),
(16, 2, 'Jackson Clay', 'Laboris ut consectet', 'Voluptatem iste sed ', 'Summer Thin Soft Lyocell Fabric Jeans Men Casual Elastic Waist Fashion Denim Trousers Male Brand Loose Straight Armygreen Pants', 79, 202, '2024-09-17 22:18:18', 'product_image_1726590798.jpg'),
(17, 2, 'Kieran Walters', 'Reprehenderit dicta', 'Enim enim nisi quia ', 'Product details of Men Soft Cotton Round Neck Summer T-Shirt\r\nColor: Multicolor\r\nStyle: Casual\r\nPattern Type: Plain\r\nNeckline: Round Neck\r\nSleeve Length: Short Sleeve\r\nSleeve Type: Regular Sleeve\r\nLength: Regular\r\nFit Type: Regular Fit\r\nFabric: Slight Stretch Cotton\r\nMaterial: Cotton\r\nComposition: 100% Cotton\r\nCare Instructions: Machine wash or professional dry clean\r\nSheer: No\r\nMade with Ever Soft ring spun cotton for premium softness wash after wash. This great fleece collection offers a variety of great benefits to keep you feeling comfortable and confident. The wicking and odor protection benefits will help keep you feeling fresh. Stay confident knowing that the Tee is working to keep you feeling comfortable and looking great all day.', 599, 818, '2024-09-17 22:18:28', 'product_image_1726590808.jpg'),
(18, 2, 'Asher Justice', 'Accusamus ex molesti', 'Porro autem doloremq', 'Summer Thin Soft Lyocell Fabric Jeans Men Casual Elastic Waist Fashion Denim Trousers Male Brand Loose Straight Armygreen Pants', 215, 404, '2024-09-17 22:19:39', 'product_image_1726590879.jpg'),
(19, 2, 'Patricia May', 'Qui occaecat cum ips', 'Sit consequatur min', 'Product details of Men Soft Cotton Round Neck Summer T-Shirt\r\nColor: Multicolor\r\nStyle: Casual\r\nPattern Type: Plain\r\nNeckline: Round Neck\r\nSleeve Length: Short Sleeve\r\nSleeve Type: Regular Sleeve\r\nLength: Regular\r\nFit Type: Regular Fit\r\nFabric: Slight Stretch Cotton\r\nMaterial: Cotton\r\nComposition: 100% Cotton\r\nCare Instructions: Machine wash or professional dry clean\r\nSheer: No\r\nMade with Ever Soft ring spun cotton for premium softness wash after wash. This great fleece collection offers a variety of great benefits to keep you feeling comfortable and confident. The wicking and odor protection benefits will help keep you feeling fresh. Stay confident knowing that the Tee is working to keep you feeling comfortable and looking great all day.', 404, 283, '2024-09-17 22:19:49', 'product_image_1726590889.jpg'),
(20, 2, 'India Hewitt', 'Vitae qui commodi qu', 'Ad eaque et aliquip ', 'Summer Thin Soft Lyocell Fabric Jeans Men Casual Elastic Waist Fashion Denim Trousers Male Brand Loose Straight Armygreen Pants', 659, 189, '2024-09-17 22:20:01', 'product_image_1726590901.jpg'),
(21, 2, 'Indigo Reid', 'Placeat rerum quos ', 'Enim sit veritatis e', 'Summer Thin Soft Lyocell Fabric Jeans Men Casual Elastic Waist Fashion Denim Trousers Male Brand Loose Straight Armygreen Pants', 273, 638, '2024-09-17 22:20:45', 'product_image_1726590945.jpg'),
(23, 2, 'Jada Bolton', 'Aut non velit unde ', 'Ut quos dignissimos ', 'Magna nulla voluptat', 336, 826, '2024-09-17 22:34:01', 'product_image_1726591741.jpg'),
(24, 2, 'Coby Edwards', 'Ut qui cum proident', 'Et sit doloremque p', 'Iusto officia tempor', 805, 761, '2024-09-17 22:34:09', 'product_image_1726591749.jpg'),
(26, 3, 'Davis Rios', 'Sit et dolor consequ', 'Do perspiciatis rem', 'Product details of Summer Thin Sunblock And Dustproof Windcheater Jacket For Men - Fashion | Jackets For Men | Windcheater For Men\r\npre { white-space: pre-wrap; }• Summer Thin Sunblock And Dustproof Windcheater Jacket for Men• Fashionable Stripe Pattern with Hooded Collar• Zipper Closure for Easy Wear• Lightweight Jacket Ideal for Summer• Provides Sunblock and Dustproof Protection• Perfect for Outdoor Activities and Sports\r\nThis Summer Thin Sunblock and Dustproof Windcheater Jacket for Men is the perfect addition to any fashion-forward wardrobe. The jacket features a stylish stripe pattern and a hooded collar for added protection against the elements. The jacket closure type is a zipper, making it easy to put on and take off. This lightweight jacket is perfect for those warm summer days when you need protection from the sun and dust. It is made with high-quality materials to ensure durability and long-lasting wear. Whether you\'re out for a walk or running errands, this jacket is sure to keep you comfortable and stylish.\r\nSpecifications of Summer Thin Sunblock And Dustproof Windcheater Jacket For Men - Fashion | Jackets For Men | Windcheater For Men\r\nBrand: No Brand\r\nSKU: 105571444_NP-1037213278\r\nPattern: Stripe\r\nJacket Closure Type: Zipper\r\nCollar Type: Hooded\r\nClothing Style: Fashion', 875, 19, '2024-09-17 22:34:27', 'product_image_1726591767.jpg'),
(27, 3, 'Flynn Baker', 'Unde voluptatem non ', 'Facilis voluptas off', 'Product details of Summer Thin Sunblock And Dustproof Windcheater Jacket For Men - Fashion | Jackets For Men | Windcheater For Men\r\npre { white-space: pre-wrap; }• Summer Thin Sunblock And Dustproof Windcheater Jacket for Men• Fashionable Stripe Pattern with Hooded Collar• Zipper Closure for Easy Wear• Lightweight Jacket Ideal for Summer• Provides Sunblock and Dustproof Protection• Perfect for Outdoor Activities and Sports\r\nThis Summer Thin Sunblock and Dustproof Windcheater Jacket for Men is the perfect addition to any fashion-forward wardrobe. The jacket features a stylish stripe pattern and a hooded collar for added protection against the elements. The jacket closure type is a zipper, making it easy to put on and take off. This lightweight jacket is perfect for those warm summer days when you need protection from the sun and dust. It is made with high-quality materials to ensure durability and long-lasting wear. Whether you\'re out for a walk or running errands, this jacket is sure to keep you comfortable and stylish.\r\nSpecifications of Summer Thin Sunblock And Dustproof Windcheater Jacket For Men - Fashion | Jackets For Men | Windcheater For Men\r\nBrand: No Brand\r\nSKU: 105571444_NP-1037213278\r\nPattern: Stripe\r\nJacket Closure Type: Zipper\r\nCollar Type: Hooded\r\nClothing Style: Fashion', 262, 20, '2024-09-17 22:34:35', 'product_image_1726591775.jpg'),
(29, 2, 'Barrett Hewitt', 'Veniam incididunt a', 'Non enim sit perfere', 'Officia enim nulla p', 42, 324, '2024-09-17 22:34:53', 'product_image_1726591793.jpg'),
(30, 3, 'Salvador Patton', 'Nostrud unde non eos', 'Voluptatibus incidun', 'Product details of Summer Thin Sunblock And Dustproof Windcheater Jacket For Men - Fashion | Jackets For Men | Windcheater For Men\r\npre { white-space: pre-wrap; }• Summer Thin Sunblock And Dustproof Windcheater Jacket for Men• Fashionable Stripe Pattern with Hooded Collar• Zipper Closure for Easy Wear• Lightweight Jacket Ideal for Summer• Provides Sunblock and Dustproof Protection• Perfect for Outdoor Activities and Sports\r\nThis Summer Thin Sunblock and Dustproof Windcheater Jacket for Men is the perfect addition to any fashion-forward wardrobe. The jacket features a stylish stripe pattern and a hooded collar for added protection against the elements. The jacket closure type is a zipper, making it easy to put on and take off. This lightweight jacket is perfect for those warm summer days when you need protection from the sun and dust. It is made with high-quality materials to ensure durability and long-lasting wear. Whether you\'re out for a walk or running errands, this jacket is sure to keep you comfortable and stylish.\r\nSpecifications of Summer Thin Sunblock And Dustproof Windcheater Jacket For Men - Fashion | Jackets For Men | Windcheater For Men\r\nBrand: No Brand\r\nSKU: 105571444_NP-1037213278\r\nPattern: Stripe\r\nJacket Closure Type: Zipper\r\nCollar Type: Hooded\r\nClothing Style: Fashion', 716, 30, '2024-09-17 22:35:02', 'product_image_1726591802.jpg'),
(31, 3, 'Salvador Patton', 'Nostrud unde non eos', 'Voluptatibus incidun', 'Impedit fuga Volup', 716, 21, '2024-09-17 22:36:36', 'product_image_1726591896.jpg'),
(32, 3, 'Salvador Patton', 'Nostrud unde non eos', 'Voluptatibus incidun', 'Impedit fuga Volup', 716, 771, '2024-09-17 22:37:17', 'product_image_1726591937.jpg'),
(38, 3, 'Raven Ewing', 'Fuga Id voluptas si', 'Ullamco qui esse lab', 'Magnam facilis volup', 152, 4, '2024-11-07 20:45:26', 'product_image_1730991626.png');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `rid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `r_ratingValue` int(11) NOT NULL,
  `r_comment` varchar(500) NOT NULL,
  `r_dateAndTime` datetime NOT NULL DEFAULT current_timestamp(),
  `r_revievStatus` int(11) NOT NULL DEFAULT 0 COMMENT '0 = not verified\r\n1= verified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`rid`, `uid`, `pid`, `r_ratingValue`, `r_comment`, `r_dateAndTime`, `r_revievStatus`) VALUES
(1, 2, 2, 4, 'nice products ', '2024-09-13 19:08:40', 0),
(2, 3, 2, 2, 'Pariatur Deserunt e', '2024-09-13 19:09:30', 0),
(3, 4, 2, 5, 'dalskjjbd;kasdbf;baskd;ffasdgsfasdads', '2024-09-13 19:11:08', 0),
(4, 5, 2, 5, 'good product', '2024-09-13 19:31:50', 0),
(5, 6, 2, 5, 'good', '2024-09-13 19:32:46', 0),
(6, 7, 2, 5, 'good', '2024-09-13 19:33:35', 0),
(8, 8, 2, 4, 'good ', '2024-09-13 19:35:32', 0),
(9, 9, 2, 4, 'wdadsasda', '2024-09-13 19:36:08', 0),
(10, 10, 2, 4, 'dalskjjbd;kasdbf;baskd;ffasdgsfasdads', '2024-09-13 19:36:53', 0),
(11, 11, 2, 4, 'dalskjjbd;kasdbf;baskd;ffasdgsfasdads', '2024-09-13 19:37:44', 0),
(12, 12, 2, 3, 'dalskjjbd;kasdbf;baskd;ffasdgsfasdads', '2024-09-13 19:38:16', 0),
(13, 13, 2, 1, 'bad', '2024-09-13 19:39:06', 0),
(14, 2, 16, 5, 'nice products', '2024-09-22 09:29:33', 0),
(15, 2, 15, 4, 'Molestiae omnis vita', '2024-09-22 10:45:19', 0),
(17, 2, 38, 3, 'sad', '2024-11-07 20:48:17', 0),
(19, 2, 18, 3, 'sa', '2024-11-07 20:58:09', 0),
(20, 2, 18, 3, 'asd', '2024-11-07 20:58:17', 0),
(21, 2, 26, 2, 'asdasd', '2024-11-07 20:58:33', 0),
(23, 2, 21, 2, 'nice product', '2024-11-13 08:35:32', 0),
(24, 22, 15, 3, 'noce', '2024-11-13 13:29:39', 0),
(25, 2, 19, 4, 'nice', '2024-11-14 14:07:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `sid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `s_quantity` int(11) NOT NULL,
  `s_in_out` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=in 1=out',
  `s_entryDate` datetime NOT NULL DEFAULT current_timestamp(),
  `s_productPrice` int(11) NOT NULL COMMENT 'total priice of ordered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`sid`, `pid`, `s_quantity`, `s_in_out`, `s_entryDate`, `s_productPrice`) VALUES
(1, 2, 5, 0, '2024-09-13 19:08:06', 703),
(2, 2, 1, 1, '2024-09-13 19:08:20', 703),
(3, 2, 1, 1, '2024-09-13 19:09:18', 703),
(4, 2, 1, 1, '2024-09-13 19:10:57', 703),
(5, 2, 20, 0, '2024-09-13 19:31:05', 703),
(6, 2, 1, 1, '2024-09-13 19:31:21', 703),
(7, 2, 1, 1, '2024-09-13 19:32:37', 703),
(8, 2, 1, 1, '2024-09-13 19:33:20', 703),
(9, 2, 1, 1, '2024-09-13 19:34:11', 703),
(10, 2, 1, 1, '2024-09-13 19:36:01', 703),
(11, 2, 1, 1, '2024-09-13 19:36:46', 703),
(12, 2, 1, 1, '2024-09-13 19:37:30', 703),
(13, 2, 1, 1, '2024-09-13 19:38:10', 703),
(14, 2, 1, 1, '2024-09-13 19:38:54', 703),
(15, 2, 1, 1, '2024-09-13 19:46:29', 703),
(16, 2, 1, 1, '2024-09-13 19:46:47', 703),
(28, 17, 818, 0, '2024-09-17 22:20:11', 599),
(29, 19, 284, 0, '2024-09-17 22:20:16', 404),
(30, 14, 854, 0, '2024-09-17 22:20:19', 882),
(31, 15, 53, 0, '2024-09-17 22:20:23', 864),
(32, 16, 203, 0, '2024-09-17 22:20:27', 79),
(33, 18, 405, 0, '2024-09-17 22:20:30', 215),
(34, 20, 189, 0, '2024-09-17 22:20:34', 659),
(35, 21, 639, 0, '2024-09-17 22:20:53', 273),
(37, 23, 826, 0, '2024-09-17 22:37:32', 336),
(38, 24, 761, 0, '2024-09-17 22:37:35', 805),
(39, 29, 324, 0, '2024-09-17 22:37:40', 42),
(40, 32, 771, 0, '2024-09-17 22:37:44', 716),
(41, 18, 1, 1, '2024-09-17 22:55:32', 215),
(42, 26, 1, 1, '2024-09-17 22:58:05', 875),
(43, 27, 0, 0, '2024-09-18 01:14:05', 262),
(44, 30, 10, 0, '2024-09-18 01:14:34', 716),
(45, 31, 1, 0, '2024-09-18 01:15:46', 716),
(46, 2, 1, 1, '2024-09-18 01:17:07', 703),
(47, 16, 1, 1, '2024-09-22 09:29:04', 79),
(48, 15, 1, 1, '2024-09-22 10:38:31', 864),
(49, 2, 1, 1, '2024-11-07 20:45:07', 703),
(50, 38, 5, 0, '2024-11-07 20:45:38', 152),
(51, 38, 1, 1, '2024-11-07 20:48:08', 152),
(52, 15, 1, 1, '2024-11-07 20:52:23', 864),
(55, 21, 1, 1, '2024-11-13 08:34:34', 273),
(56, 15, 5, 1, '2024-11-13 13:29:28', 4320),
(57, 19, 1, 1, '2024-11-14 14:07:00', 404),
(60, 2, 1, 1, '2024-11-15 20:37:49', 703);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `first_name` varchar(500) NOT NULL,
  `last_name` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(5000) NOT NULL,
  `phone` int(11) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=admin, 1=Customer',
  `district` varchar(500) NOT NULL,
  `city` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `first_name`, `last_name`, `email`, `password`, `phone`, `role`, `district`, `city`) VALUES
(1, 'Remedios', 'Velez', 'admin@gmail.com', '3a2a5ce900c7489c2112302b646bdef3', 1234567890, 0, 'Aliquid sunt laudan', 'Enim tempora modi la'),
(2, 'suman', 'Cortez', 'suman@gmail.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Est vel voluptatem ', 'Molestiae harum tene'),
(3, 'Xantha', 'Pollard', 'huqyqogin@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Ut suscipit numquam ', 'Esse vitae incidunt'),
(4, 'Eliana', 'Sampson', 'mygyfyxic@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Tempore sit commod', 'Nesciunt ex aperiam'),
(5, 'Keane', 'Ware', 'homejykide@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Delectus sunt a adi', 'Non fugiat optio u'),
(6, 'Isaac', 'Potts', 'lyla@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Commodi commodo rem ', 'Anim dolore in fugit'),
(7, 'Cooper', 'James', 'pogofopyvo@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Ut enim reiciendis s', 'Fuga Aut atque blan'),
(8, 'Drake', 'Blake', 'wexypixe@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Culpa eu nemo et al', 'Autem aut reiciendis'),
(9, 'Tanek', 'Jacobson', 'difojihaf@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Dicta omnis ut cum e', 'Voluptatem numquam a'),
(10, 'Kelsey', 'Parker', 'zuwuhoce@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Blanditiis vel conse', 'Nihil ea accusantium'),
(11, 'Kalia', 'Buck', 'gavidi@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Quaerat consequatur ', 'Voluptatem nihil ip'),
(12, 'Tanisha', 'Stanton', 'zysydi@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Et sed asperiores ut', 'Repudiandae excepteu'),
(13, 'Destiny', 'Tucker', 'fifawuwaf@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Eligendi veniam dol', 'Nihil dolorum veniam'),
(14, 'Ursula', 'Madden', 'ticek@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Vel inventore vel qu', 'Fuga Autem dolores '),
(15, 'Jermaine', 'Padilla', 'higynumusi@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Cupiditate porro fug', 'Sequi magni laboris '),
(16, 'Dawn', 'Ross', 'qizyqoqed@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Aut ipsam dolor a ad', 'Qui expedita dolore '),
(17, 'Ciaran', 'Monroe', 'dokot@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Itaque iste aliqua ', 'Dolorum accusamus id'),
(18, 'Jayme', 'Alvarado', 'rome@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Officia mollitia ad ', 'Debitis quia velit q'),
(19, 'Lyle', 'Curry', 'jarucok@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Dolorem et enim faci', 'Harum incidunt dese'),
(20, 'Stephanie', 'Chambers', 'logilonep@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Porro deleniti molli', 'Qui eos culpa lauda'),
(21, 'Molly', 'Mcfarland', 'gukiranymy@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Reiciendis asperiore', 'Consequatur sunt fu'),
(22, 'Victoria', 'Murphy', 'jebacu@mailinator.com', '3a2a5ce900c7489c2112302b646bdef3', 2147483647, 1, 'Laboriosam nulla qu', 'Eaque voluptatem cil');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorys`
--
ALTER TABLE `categorys`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`oid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`sid`),
  ADD KEY `stocks_ibfk_1` (`pid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorys`
--
ALTER TABLE `categorys`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `products` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `categorys` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `products` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `products` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
