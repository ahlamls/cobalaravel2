-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 14, 2020 at 06:02 PM
-- Server version: 10.5.8-MariaDB-1:10.5.8+maria~focal
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cobalaravel2`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `comment` text NOT NULL,
  `vote` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `post_id`, `time`, `comment`, `vote`) VALUES
(1, 1, 4, '2020-12-14 13:08:59', 'still waiting for it to finish', 0),
(2, 2, 4, '2020-12-14 13:08:59', 'cool project', 0),
(3, 4, 4, '2020-12-14 13:08:59', 'the comment works now! thanks', 0),
(4, 1, 5, '2020-12-14 16:45:39', 'who is lizard?', 0),
(5, 1, 5, '2020-12-14 16:46:57', 'lizard is kadal in indonesia', 0),
(6, 1, 5, '2020-12-14 16:49:40', 'dafadfaf', 0),
(7, 1, 5, '2020-12-14 16:50:41', 'why the 1 minute limit . i want to comment again?', 0),
(8, 1, 5, '2020-12-14 16:51:42', 'sfggfs', 0),
(9, 1, 5, '2020-12-14 17:04:41', 'why the 1 minute limit . i want to comment again?', 0),
(10, 2, 5, '2020-12-14 17:07:29', 'it is to prevent spam', 0),
(11, 2, 5, '2020-12-14 17:13:44', 'wow now the comment is scrolling automatically', 0);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `caption` text NOT NULL,
  `vote` int(11) NOT NULL DEFAULT 0,
  `commentcount` int(11) NOT NULL DEFAULT 0,
  `image_url` text NOT NULL,
  `hidden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `user_id`, `time`, `caption`, `vote`, `commentcount`, `image_url`, `hidden`) VALUES
(1, 1, '2020-12-11 13:53:56', 'php artisan serve output', 1, 3, '/image/laravnyut.png', 0),
(2, 1, '2020-12-11 13:53:56', 'succesfully installed phpmyadmin', 10, 20, '/image/pma.png', 0),
(3, 1, '2020-12-11 16:06:25', 'screenfetch output', 1, 0, '/image/e8527724855ab0e88d9ddb841d39ae6014c7acfd1a3e09c40c3a516f1ff7cf7e677c29825446b5c886f3d9939f9b7d5cd44f892a20490540efa24231ef0edb8c.png', 0),
(4, 4, '2020-12-11 17:47:14', 'This project progress', 4, 0, '/image/d2ff307e0641ca78274295f3c93b33f79b7b31361a85db1dabb2eac6c1f028db15559dcdc78c9598d729f405b46018e52a708ea1839b8560e739c1ed68e22cb3.png', 0),
(5, 1, '2020-12-14 11:57:31', 'working on lizard project python', 2, 2, '/image/64164a4b57fb6f0ddcf4c7cbf52003c29929ac309d0462e1e9d28f439b16a84fa9b69cce274c589fe675ceb844979cf37025bb7360a6c47b9a6f7e1c809d5781.png', 0),
(6, 2, '2020-12-14 17:35:25', 'trading using system monitor', 0, 0, '/image/a8f8278048b489c5ac5f5d723547b88b0f9ad526039cc2ab454440d2f28dedf85e1480b8de1c373a7456efca640278029b7230f09ec31f755e2bbe27d8a4d4a8.png', 0),
(7, 2, '2020-12-14 17:36:40', 'trading', 0, 0, '/image/195b14df9bb7d75a655cbbea8efb314c87a3ecb0f88dec998864bf9d0d72d4b29c656641181b99513410f5752b4046ff90cd0814501039d8d612b3f02f9dc0cf.png', 0),
(8, 2, '2020-12-14 17:39:37', 'test', 0, 0, '/image/cc79252927edc49c9e5f4551679ddf0f424c68f19ecdff6c986e27385d1f0f8720ed3f41fbf602f08ddd2b0efec33d7195b8fa5f8922e6dc89fe4a7d096268c1.png', 0),
(9, 2, '2020-12-14 17:41:38', 'screenfetch again', 0, 0, '/image/103b301e7e8967b55ebcfbebaa273a2a0ce4efaf4d4367b27ba6d8178e2b9f09068ea111f2dbb1c9fa1fb17b5b8a0507f215f962c11e599fa1fb8209327e8747.png.jpg', 0),
(10, 2, '2020-12-14 17:44:00', 'egen', 0, 0, '/image/679a53e3cf4047b536e1105e256e30617e66da1baa564ffa4d3227950c1b7e4d1f3edba15f0b03e160ea418bb80359d7513416d839441fd20f0d86e2910b7c8e.png.jpg', 0),
(11, 2, '2020-12-14 17:46:01', 'adfadfad', 0, 0, '/image/0f766b365384c25712415f68fb0ad18c0887a83213b1fdd03acf1505ed640a6da92630a3346aa131d9d1154a3fbbe3736327f50e890f898ea1d80b67798b15d4.png.jpg', 0),
(12, 2, '2020-12-14 17:50:37', 'dafdafdafdafafa', 0, 0, '/image/09c89c9d392e63b0e8e5f4a2c5724d7861ede73be1e795527bf5607c7ce0eaf142aea9ac854ce41f3893044ad25b13915d07e5b91d56fe2f53369a9e314ec92f.png.jpg', 0),
(13, 2, '2020-12-14 17:51:10', 'adfadfad', 0, 0, '/image/ad9285c062962166ec532d5551b29ce7eeba0eae47b9fa5eddee092d7ae7adfa75d4887edadb611f389358cf205105ef1693ca9582335adaf3293d5f0035b212.png.jpg', 0),
(14, 2, '2020-12-14 17:51:27', 'adfafadf', 0, 0, '/image/e2a833b860a25e6e31f720ae26fdecf5dc4c5d82f9f395065dbdeb5d9710251bf42434192abf243355e845399ec620a1e9c154c2e66a410df5d086e8c0cb8b0c.png.jpg', 0),
(15, 2, '2020-12-14 17:52:39', 'afdafad', 0, 0, '/image/1dfdba14b297eb94efba469b88b0a651162ca1bf185ed807257142506b42c68c1cdfd5fe8100e6c7e513dd6b16f4816c8fcd5f8f1c36e8edc71f5947404af984.png.jpg', 0),
(16, 2, '2020-12-14 17:53:54', 'adfafadf', 0, 0, '/image/447a233c8e0fe2ae18453c6a96b0780c8434605d48c17b1ebc3854581f0bb05206398ae9499874a2685f8d443b0216c3f9a3cb1ed231ecf084c49d06f345ded8.png.jpg', 0),
(17, 2, '2020-12-14 17:54:12', 'adfadfa', 0, 0, '/image/32de4462bdf349b0f1a789531d54449ffb287f7aa9386c4c8706ab1bb66d544d1ec15db53395194cbe99cda4ce1c12fd6224f2a31096be21efb8ae3cccf85072.png.jpg', 0),
(18, 2, '2020-12-14 17:54:32', 'adfafadfadfa', 0, 0, '/image/993b67e6aa4960aad0674de8357622e894885d293532acf22c8c41cb1cc88f86b37ed091dd16fe38b46375aa91d37ea7540aacf6b073a8e1c72275876f058cf4.png.jpg', 0),
(19, 2, '2020-12-14 17:58:01', 'afdfaf', 0, 0, '/image/aa586c58cee9ece2ccd5fb7b023d180873e3565dd624bc73f8de7017e635ced43c4d75f464461e3b38b216c2b6b53ec18d3bbe74995e580588ccebc377f6874b.png.jpg', 0),
(20, 2, '2020-12-14 17:58:51', 'adfadfafdaf', 0, 0, '/image/241587e41088346d75d4b479441679eac4a9e2cccf3f1b0e5489261c0df14d5dc434dd7c1f8f849df3ae31a365298d259d88b939e60e82a0ee6436f02bc4598f.png.jpg', 0),
(21, 2, '2020-12-14 17:59:41', 'dafadfadf', 0, 0, '/image/d3f7bfa6b670f8437b51bdf6f64c65b83341b9df2369b9178af93678200728d11937cd9b9f81a65da7e2984e7e44505568cb26642c102530a328171f25aa86b1.png.jpg', 0),
(22, 2, '2020-12-14 18:00:15', 'adfadfadfadfad', 0, 0, '/image/14c297b0477173f4da286af6b461a3b4abe58daa3c3395615a8daab8879dbf7dd1695bae705877bbe2e377cfeacf76f65d7db67224b7fa28ecab7933bfaae4e2.png.jpg', 0),
(23, 2, '2020-12-14 18:01:01', 'adfdfadfafadf', 0, 0, '/image/1774f0d7c177b769b3f3872ccf4fea3dd52bf88f2e839880b843c72013d7de20a5f7543e9b95ec79ab2c4027580f630b1b93499a1aea1e8235a7c4991fea4774.png.jpg', 0),
(24, 2, '2020-12-14 18:01:14', 'adfadfadfad', 0, 0, '/image/402f74ad881e2825cd30d1293e5dc06082ffb7e9ccc8bed834dd2ceeca66409772006c2ad6616ebc90a5b6fba9867ed6fdb399e35f9c58afc0c5df5259870242.png.jpg', 0),
(25, 2, '2020-12-14 18:01:27', 'adfadfadfadf', 0, 0, '/image/61833db61526a4a939c933c7c1e235d26674f9241e3b8d133a10cbd7c1568ee9ca0957a940494a7fc9fa5550b0095f7fbd059147ccb211d790196f291faefdc7.png.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `bio` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `time`, `username`, `password`, `email`, `bio`) VALUES
(1, '2020-12-11 13:52:19', 'test', 'daef4953b9783365cad6615223720506cc46c5167cd16ab500fa597aa08ff964eb24fb19687f34d7665f778fcb6c5358fc0a5b81e1662cf90f73a2671c53f991', 'user@mail.domain', 'just a test user'),
(2, '2020-12-11 17:38:21', 'test2', 'daef4953b9783365cad6615223720506cc46c5167cd16ab500fa597aa08ff964eb24fb19687f34d7665f778fcb6c5358fc0a5b81e1662cf90f73a2671c53f991', 'user2@mail.domain', 'just a test user 2'),
(4, '2020-12-11 17:45:52', 'test3', '922facc3f4e6ca73c7d36ad7640bef968e3692864531b1fa2b3adb234667afa7f3f47c42b2bcdb84472ec99a86e8a48e25d0acbe7c13f76e5d3dee0dd926360d', 'test3@mail.domain', 'this user still use default bio');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`id`, `post_id`, `user_id`, `type`) VALUES
(40, 1, 1, 0),
(42, 3, 1, 1),
(44, 4, 1, 1),
(48, 2, 1, 0),
(50, 5, 1, 1),
(51, 5, 2, 1),
(52, 4, 2, 1),
(53, 3, 2, 1),
(54, 2, 2, 1),
(55, 1, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `image` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `image` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
