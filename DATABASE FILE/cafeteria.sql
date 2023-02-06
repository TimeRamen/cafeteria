-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2022 at 07:30 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cafeteria`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `c_id` varchar(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`c_id`, `food_id`, `quantity`) VALUES
('011221427', 12, 11),
('011221427', 44, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contains`
--

CREATE TABLE `contains` (
  `order_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contains`
--

INSERT INTO `contains` (`order_id`, `food_id`, `quantity`) VALUES
(1, 1, 5),
(1, 2, 2),
(5, 1, 1),
(7, 28, 5),
(9, 15, 2),
(9, 26, 3),
(10, 1, 4),
(11, 7, 2),
(12, 5, 2),
(12, 8, 2),
(13, 1, 4),
(13, 2, 2),
(14, 1, 3),
(15, 1, 3),
(16, 14, 9);

-- --------------------------------------------------------

--
-- Table structure for table `dietary`
--

CREATE TABLE `dietary` (
  `id` int(11) NOT NULL,
  `diet` varchar(10) NOT NULL,
  `free` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dietary`
--

INSERT INTO `dietary` (`id`, `diet`, `free`) VALUES
(1, 'Vegan', 0),
(2, 'Sugar', 1),
(3, 'Peanut', 1),
(4, 'Gluten', 1),
(5, 'Lactose', 1);

-- --------------------------------------------------------

--
-- Table structure for table `food_diet`
--

CREATE TABLE `food_diet` (
  `food_id` int(11) NOT NULL,
  `diet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food_diet`
--

INSERT INTO `food_diet` (`food_id`, `diet_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(6, 3),
(10, 4),
(11, 4),
(12, 4),
(30, 1),
(50, 2),
(50, 5),
(51, 5),
(52, 2),
(52, 4),
(52, 5),
(53, 2),
(53, 5),
(54, 2),
(59, 5),
(60, 5),
(62, 5),
(66, 2),
(66, 4);

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `food_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `name`, `price`, `stock`, `food_type_id`) VALUES
(1, 'Dal', 20, 24, 1),
(2, 'Dal+Vegetable', 25, 16, 1),
(3, 'Vegetable', 25, 20, 1),
(4, 'Ruti', 8, 20, 1),
(5, 'Paratha', 8, 20, 1),
(6, 'Singara', 8, 20, 2),
(7, 'Potato Chop', 12, 20, 2),
(8, 'Egg Potato Cutlet', 30, 20, 2),
(9, 'Chicken Potato Cutlet', 30, 20, 2),
(10, 'Club Sandwich', 45, 20, 2),
(11, 'Chicken Sandwich', 30, 20, 2),
(12, 'Chicken Roll', 35, 20, 2),
(13, 'Vegetable Roll', 25, 20, 2),
(14, 'Irani Roll', 50, 20, 2),
(15, 'Chicken Spring Roll', 25, 20, 2),
(16, 'Chicken Patties', 35, 20, 2),
(17, 'Chicken Sharma', 55, 20, 2),
(18, 'Fried Anthon', 20, 20, 3),
(19, 'Fried Chicken Wings', 40, 20, 3),
(20, 'BBQ Chicken Wings', 50, 20, 3),
(21, 'Chicken Chili Onion', 55, 20, 3),
(22, 'Chicken Fry', 45, 20, 3),
(23, 'Chicken Jhal Fry', 40, 20, 3),
(24, 'Tandoori Chicken', 75, 20, 3),
(25, 'Jali Kabab', 40, 20, 3),
(26, 'Chicken Shashlik', 70, 20, 3),
(27, 'Sweet & Sour Chicken', 60, 20, 3),
(28, 'Egg Fried Rice', 40, 20, 3),
(29, 'Chicken Vegetable', 40, 20, 3),
(30, 'Mixed Vegetable', 30, 20, 3),
(31, 'Masala Chicken', 100, 20, 3),
(32, 'Plain Rice', 25, 20, 4),
(33, 'Polao', 40, 20, 4),
(34, 'Chicken Polao', 130, 20, 4),
(35, 'Chicken Khachi', 110, 20, 4),
(36, 'Beef Tehari', 100, 20, 4),
(37, 'Chicken Khichuri', 65, 20, 4),
(38, 'Chicken Sonali Roast', 100, 20, 4),
(39, 'Chicken Broiler Roast', 65, 20, 4),
(40, 'Egg Korma', 35, 20, 4),
(41, 'Egg Curry', 25, 20, 4),
(42, 'Beef Curry', 120, 20, 4),
(43, 'Rui Fish', 70, 20, 4),
(44, 'Pizza', 40, 20, 5),
(45, 'Mini Pizza', 50, 20, 5),
(46, 'Chicken Tikka Burger', 45, 20, 5),
(47, 'Fried Chicken Burger', 60, 20, 5),
(48, 'Noodles', 35, 20, 5),
(49, 'Meat Loaf', 50, 20, 5),
(50, 'Firni', 40, 20, 6),
(51, 'Plain Cake', 20, 20, 6),
(52, 'Brownie', 40, 20, 6),
(53, 'Pudding', 35, 20, 6),
(54, 'Pastry', 40, 20, 6),
(55, 'Fresh Juice', 45, 20, 7),
(56, 'Lassi', 40, 20, 7),
(57, 'Mineral Water', 20, 20, 7),
(58, 'Raw Tea', 8, 20, 7),
(59, 'Milk Tea', 10, 20, 7),
(60, 'Powder Milk Tea', 12, 20, 7),
(61, 'Coffee', 20, 20, 7),
(62, 'Ice-Cream', 30, 20, 7),
(63, 'Pepsi', 30, 20, 7),
(64, 'Coca-Cola', 30, 20, 7),
(65, 'Mountain Dew', 30, 20, 7),
(66, 'koli', 30, 40, 7);

-- --------------------------------------------------------

--
-- Table structure for table `food_type`
--

CREATE TABLE `food_type` (
  `id` int(11) NOT NULL,
  `food_type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food_type`
--

INSERT INTO `food_type` (`id`, `food_type`) VALUES
(1, 'Breakfast'),
(2, 'Light Snacks'),
(3, 'Thai/Chinese Food'),
(4, 'Lunch'),
(5, 'Fast Food'),
(6, 'Desserts'),
(7, 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `room` varchar(25) DEFAULT NULL,
  `pickup` datetime NOT NULL DEFAULT current_timestamp(),
  `c_id` varchar(11) DEFAULT 'GUEST',
  `paid` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `room`, `pickup`, `c_id`, `paid`) VALUES
(1, '420', '2022-12-30 20:09:48', '011203011', 1),
(5, '420', '2023-01-06 11:29:00', '011203011', 0),
(7, '', '2022-12-31 17:59:59', '011221427', 1),
(9, NULL, '2022-12-31 13:29:21', 'GUEST', 1),
(10, NULL, '2022-12-31 13:35:26', 'GUEST', 1),
(11, NULL, '2022-12-31 13:38:29', 'GUEST', 1),
(12, NULL, '2022-12-31 14:43:17', 'GUEST', 1),
(13, '', '2022-12-31 21:05:41', '011221427', 1),
(14, '', '2022-12-31 21:06:01', '011221427', 1),
(15, '', '2022-12-31 21:06:23', '011221427', 1),
(16, NULL, '2022-12-31 18:07:11', 'GUEST', 1);

-- --------------------------------------------------------

--
-- Table structure for table `preference`
--

CREATE TABLE `preference` (
  `c_id` varchar(11) NOT NULL,
  `room` varchar(30) DEFAULT NULL,
  `budget` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `preference`
--

INSERT INTO `preference` (`c_id`, `room`, `budget`) VALUES
('011203011', '420', 40);

-- --------------------------------------------------------

--
-- Table structure for table `preference_dietary`
--

CREATE TABLE `preference_dietary` (
  `c_id` varchar(11) NOT NULL,
  `allergen_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `preference_dietary`
--

INSERT INTO `preference_dietary` (`c_id`, `allergen_id`) VALUES
('011203011', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `type_id`) VALUES
('011203004', 'Anas Mohammad Ishfaqul Muktadir', '$2y$10$Mvaiq85wRdDldI0ztRB9YeIgdwS6PecQj8Rhs6Ihb5Bz0uMYu.Q3.', 1),
('011203011', 'Al-Momen Reyad', '$2y$10$WPtm0SyXZIRF6lhCF863k.Xh34PrkjvyixwRuRXv.eAuku9m1N/em', 1),
('011221427', 'Taimur Rahman', '$2y$10$1/8xTjrD.JOPVXVYkIpNb.xHuMy5RzgFe6IupoW0mjq2wKNXl5lSC', 1),
('admin', 'Admin', '$2y$10$OeFLKQbem6VFGRV.07Q3eu.CR5lowJgSBpzn1jmlhqjW2QolfFaYu', 3),
('FAH', 'Farhan Anan Himu', '$2y$10$o8QiX.1fXH5Q5bpagfxUke0yZHcieMASp29ooRORLHpngUEZz/Bza', 2),
('GUEST', '', '', 5),
('MAA', 'MD.Ali Asgar', '$2y$10$pgzUaSsTnAv5EXjEQhPtDeEPMmqBdeaZSq.ovq15MJTBvb1nlnmma', 2),
('RRK', 'Ms. Rubaiya Rahtin Khan', '$2y$10$JLJ7N76YsZgHCQfr/mIQ6.3ytLJNzntMuAtEop0zhZtKRZNsQoJCG', 2),
('Seller1', 'Seller1', '$2y$10$/L9LFP6Ve1/p9dEUiqvb9uiJSWnAlhkABkW.0k2FdcyOULLnZPzoC', 4),
('Seller2', 'Seller2', '$2y$10$EwLaaap7.Z.iSQ3isIBpj.HcAflzBJKqfi5V7hQQ3CJPY8mVDtCk.', 4),
('Seller3', 'Seller3', '$2y$10$bDmO.1WchUflYCJayJDdruYhOa57abdTQNA/RWBM1GCKmlRRr84p.', 4),
('Seller4', 'Seller4', '$2y$10$xxiYzXc3ksDFND.Tt2C4veFDvNOln3kVlg1faknxaej7AIJDULO1m', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `name`) VALUES
(1, 'Student'),
(2, 'Faculty'),
(3, 'Admin'),
(4, 'Seller'),
(5, 'Guest');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`c_id`,`food_id`),
  ADD KEY `fk_food_id3` (`food_id`);

--
-- Indexes for table `contains`
--
ALTER TABLE `contains`
  ADD PRIMARY KEY (`order_id`,`food_id`),
  ADD KEY `fk_food_id2` (`food_id`);

--
-- Indexes for table `dietary`
--
ALTER TABLE `dietary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_diet`
--
ALTER TABLE `food_diet`
  ADD PRIMARY KEY (`food_id`,`diet_id`),
  ADD KEY `fk_diet_id` (`diet_id`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_food_type` (`food_type_id`);

--
-- Indexes for table `food_type`
--
ALTER TABLE `food_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_id` (`c_id`);

--
-- Indexes for table `preference`
--
ALTER TABLE `preference`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `preference_dietary`
--
ALTER TABLE `preference_dietary`
  ADD PRIMARY KEY (`c_id`,`allergen_id`),
  ADD KEY `FK_dietary_preference_allergen` (`allergen_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_type_user` (`type_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dietary`
--
ALTER TABLE `dietary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `food_type`
--
ALTER TABLE `food_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_c_id2` FOREIGN KEY (`c_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_food_id3` FOREIGN KEY (`food_id`) REFERENCES `food_items` (`id`);

--
-- Constraints for table `contains`
--
ALTER TABLE `contains`
  ADD CONSTRAINT `fk_food_id2` FOREIGN KEY (`food_id`) REFERENCES `food_items` (`id`),
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `food_diet`
--
ALTER TABLE `food_diet`
  ADD CONSTRAINT `fk_diet_id` FOREIGN KEY (`diet_id`) REFERENCES `dietary` (`id`),
  ADD CONSTRAINT `fk_food_id` FOREIGN KEY (`food_id`) REFERENCES `food_items` (`id`);

--
-- Constraints for table `food_items`
--
ALTER TABLE `food_items`
  ADD CONSTRAINT `fk_food_type` FOREIGN KEY (`food_type_id`) REFERENCES `food_type` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`c_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `preference`
--
ALTER TABLE `preference`
  ADD CONSTRAINT `FK_customer_preference` FOREIGN KEY (`c_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `preference_dietary`
--
ALTER TABLE `preference_dietary`
  ADD CONSTRAINT `FK_dietary_preference_allergen` FOREIGN KEY (`allergen_id`) REFERENCES `dietary` (`id`),
  ADD CONSTRAINT `FK_preference_preference_allergen` FOREIGN KEY (`c_id`) REFERENCES `preference` (`c_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_user_type_user` FOREIGN KEY (`type_id`) REFERENCES `user_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
