-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2021 at 11:32 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog-cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `no_of_post` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `no_of_post`) VALUES
(12, 'web Hosting', 0),
(13, 'web development', 3),
(14, 'Tech Tips and Tricks', 1),
(15, 'Wordpress Development', 0),
(17, 'css tips and tricks', 1),
(18, 'Wordpress Tutorials', 0),
(19, 'JQuery Plugins', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `post_title` varchar(100) NOT NULL,
  `post_img` varchar(100) NOT NULL,
  `post_description` text NOT NULL,
  `post_category` int(11) NOT NULL,
  `post_author` int(11) NOT NULL,
  `post_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_title`, `post_img`, `post_description`, `post_category`, `post_author`, `post_date`) VALUES
(4, 'CSS Moving Car Animation Website 🔥 | Pure HTML &amp; CSS Only | CSS Running Animations', 'CSS Moving Car Animation Website Pure HTML and CSS Only CSS Animations.jpg', 'Quicquam animal. Dedit manebat locis aethera partim nitidis poena. Fulminibus fecit aestu! Tractu piscibus. Pro terris litora recepta surgere fulminibus recens satus. Nam mixta cum tempora inmensa norant. Manebat ripis tractu nullaque pronaque. Scythiam illic possedit astra scythiam tuti nitidis aetas inposuit formaeque!\r\n\r\nPendebat aliud circumfuso altae summaque aethere coegit silvas. Colebat mollia septemque coegit addidit matutinis sponte imagine chaos:. Discordia effigiem habentem. Temperiemque quem derecti fulgura fixo. Fuerant grandia rapidisque humanas moderantum plagae. Pondus nunc fuerat cetera locis animalia. Hunc videre caelum fuerant caelumque campoque.\r\n\r\nPeregrinum coeptis! Media mutastis aquae lumina primaque. Congestaque terram otia. Secant ponderibus ulla mollia iuga formas habitabilis. Tenent frigida tumescere iuga dixere in fuit aera! Tellus dextra flamina mutatas? Erat facientes illic librata metusque melior metusque. Circumdare aeris longo facientes moles abscidit hanc.', 13, 16, '18 Dec, 2020'),
(9, 'CMD : Find All Wifi Passwords With Only 1 Command - Windows 10/8/8.1/7', 'CMD-Find-All-Wifi-Passwords-With-Only-1-Command-Windows-10-8-8.1-7.jpg', 'Liquidum corpore iussit ille cingebant. Partim aer lanient. Capacius eurus stagna nubes ardentior posset: quicquam colebat freta. Usu capacius ab neu principio membra horrifer gentes. Spectent quae dissociata madescit ignea eodem poena silvas membra. Fuit flamma diremit iudicis.\r\n\r\nAnimal ensis piscibus solum innabilis otia. Titan egens septemque fratrum securae. Peragebant homini melior quicquam proxima figuras. Ventis secant undas discordia madescit. Aberant lacusque zonae haec quem. Indigestaque secuit supplex inposuit circumdare. Alto illas principio pluvialibus mortales pontus.\r\n\r\nMutastis deus radiis orbem caelo bene mollia cornua. Ambitae diversa emicuit lege porrexerat umor ad. Diremit diverso lapidosos crescendo mea. Dispositam dedit orbis nullo. Librata onus spectent. Plagae limitibus sua pronaque orbe animalia os non tegit. Qui nitidis!\r\n\r\nAnimalibus illis prima vindice pro circumfluus satus haec. Congestaque vesper legebantur. Quanto tumescere diversa retinebat. Caelo habentia frigore. Haec subsidere ut densior iussit nova rapidisque. Possedit haec derecti gentes rapidisque. Nubibus septemque galeae solum pace videre figuras animalibus.', 14, 16, '19 Dec, 2020'),
(10, 'Pure CSS Button With Sliding Background Hover Effect - Animated Hover Button', 'pure-css-button-with-sliding-background-hover-effect.jpg', 'Liquidum corpore iussit ille cingebant. Partim aer lanient. Capacius eurus stagna nubes ardentior posset: quicquam colebat freta. Usu capacius ab neu principio membra horrifer gentes. Spectent quae dissociata madescit ignea eodem poena silvas membra. Fuit flamma diremit iudicis.\r\n\r\nAnimal ensis piscibus solum innabilis otia. Titan egens septemque fratrum securae. Peragebant homini melior quicquam proxima figuras. Ventis secant undas discordia madescit. Aberant lacusque zonae haec quem. Indigestaque secuit supplex inposuit circumdare. Alto illas principio pluvialibus mortales pontus.\r\n\r\nMutastis deus radiis orbem caelo bene mollia cornua. Ambitae diversa emicuit lege porrexerat umor ad. Diremit diverso lapidosos crescendo mea. Dispositam dedit orbis nullo. Librata onus spectent. Plagae limitibus sua pronaque orbe animalia os non tegit. Qui nitidis!\r\n\r\nAnimalibus illis prima vindice pro circumfluus satus haec. Congestaque vesper legebantur. Quanto tumescere diversa retinebat. Caelo habentia frigore. Haec subsidere ut densior iussit nova rapidisque. Possedit haec derecti gentes rapidisque. Nubibus septemque galeae solum pace videre figuras animalibus.', 17, 16, '19 Dec, 2020'),
(11, 'How to Copy or Clone Any Website - Download Complete Website Code', 'how-to-copy-or-clone-any-website.jpg', 'Liquidum corpore iussit ille cingebant. Partim aer lanient. Capacius eurus stagna nubes ardentior posset: quicquam colebat freta. Usu capacius ab neu principio membra horrifer gentes. Spectent quae dissociata madescit ignea eodem poena silvas membra. Fuit flamma diremit iudicis.\r\n\r\nAnimal ensis piscibus solum innabilis otia. Titan egens septemque fratrum securae. Peragebant homini melior quicquam proxima figuras. Ventis secant undas discordia madescit. Aberant lacusque zonae haec quem. Indigestaque secuit supplex inposuit circumdare. Alto illas principio pluvialibus mortales pontus.\r\n\r\nMutastis deus radiis orbem caelo bene mollia cornua. Ambitae diversa emicuit lege porrexerat umor ad. Diremit diverso lapidosos crescendo mea. Dispositam dedit orbis nullo. Librata onus spectent. Plagae limitibus sua pronaque orbe animalia os non tegit. Qui nitidis!\r\n\r\nAnimalibus illis prima vindice pro circumfluus satus haec. Congestaque vesper legebantur. Quanto tumescere diversa retinebat. Caelo habentia frigore. Haec subsidere ut densior iussit nova rapidisque. Possedit haec derecti gentes rapidisque. Nubibus septemque galeae solum pace videre figuras animalibus.', 13, 16, '19 Dec, 2020'),
(12, 'Responsive Filterable image gallery with image lightbox 🔥 | Magnific Popup', 'Responsive Filterable image gallery with image lightbox  Magnific Popup  HTML CSS JQuery.jpg', 'Liquidum corpore iussit ille cingebant. Partim aer lanient. Capacius eurus stagna nubes ardentior posset: quicquam colebat freta. Usu capacius ab neu principio membra horrifer gentes. Spectent quae dissociata madescit ignea eodem poena silvas membra. Fuit flamma diremit iudicis.\r\n\r\nAnimal ensis piscibus solum innabilis otia. Titan egens septemque fratrum securae. Peragebant homini melior quicquam proxima figuras. Ventis secant undas discordia madescit. Aberant lacusque zonae haec quem. Indigestaque secuit supplex inposuit circumdare. Alto illas principio pluvialibus mortales pontus.\r\n\r\nMutastis deus radiis orbem caelo bene mollia cornua. Ambitae diversa emicuit lege porrexerat umor ad. Diremit diverso lapidosos crescendo mea. Dispositam dedit orbis nullo. Librata onus spectent. Plagae limitibus sua pronaque orbe animalia os non tegit. Qui nitidis!\r\n\r\nAnimalibus illis prima vindice pro circumfluus satus haec. Congestaque vesper legebantur. Quanto tumescere diversa retinebat. Caelo habentia frigore. Haec subsidere ut densior iussit nova rapidisque. Possedit haec derecti gentes rapidisque. Nubibus septemque galeae solum pace videre figuras animalibus.', 19, 17, '19 Dec, 2020'),
(13, 'Quick Web Tips: Responsive Website using HTML CSS', 'Responsive-Websiite-without-coding-copy-paste-1608413203.jpg', 'Liquidum corpore iussit ille cingebant. Partim aer lanient. Capacius eurus stagna nubes ardentior posset: quicquam colebat freta. Usu capacius ab neu principio membra horrifer gentes. Spectent quae dissociata madescit ignea eodem poena silvas membra. Fuit flamma diremit iudicis.\r\n\r\nAnimal ensis piscibus solum innabilis otia. Titan egens septemque fratrum securae. Peragebant homini melior quicquam proxima figuras. Ventis secant undas discordia madescit. Aberant lacusque zonae haec quem. Indigestaque secuit supplex inposuit circumdare. Alto illas principio pluvialibus mortales pontus.\r\n\r\nMutastis deus radiis orbem caelo bene mollia cornua. Ambitae diversa emicuit lege porrexerat umor ad. Diremit diverso lapidosos crescendo mea. Dispositam dedit orbis nullo. Librata onus spectent. Plagae limitibus sua pronaque orbe animalia os non tegit. Qui nitidis!\r\n\r\nAnimalibus illis prima vindice pro circumfluus satus haec. Congestaque vesper legebantur. Quanto tumescere diversa retinebat. Caelo habentia frigore. Haec subsidere ut densior iussit nova rapidisque. Possedit haec derecti gentes rapidisque. Nubibus septemque galeae solum pace videre figuras animalibus.', 13, 18, '19 Dec, 2020');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `user_role` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `email`, `user_role`, `password`, `token`, `status`) VALUES
(14, 'Hanzala', 'Ali', 'hanzala', 'abc123@gmail.com', 'admin', '$2y$10$SP7RE0GV3To4XSySRSnZL.nxej4gCnmpamR5vIT/26Mz6n6rhhQ.i', 'bc2d6e4f98793efe6bd52703d811ff', 'verified'),
(16, 'Muhammad', 'Abubakar', 'abubakar', 'abc124@gmail.com', 'admin', '$2y$10$SP7RE0GV3To4XSySRSnZL.nxej4gCnmpamR5vIT/26Mz6n6rhhQ.i', 'd1c44980d5cbebb8851eb5de834df3', 'verified'),
(17, 'Hassan', 'Ali', 'hassan', 'abc125@gmail.com', 'subscriber', '$2y$10$SP7RE0GV3To4XSySRSnZL.nxej4gCnmpamR5vIT/26Mz6n6rhhQ.i', '3bddc7ca70f4cb3caab53fe7cc054b', 'verified'),
(18, 'Huzaifa', 'Ali', 'huzaifa', 'abc126@gmail.com', 'subscriber', '$2y$10$SP7RE0GV3To4XSySRSnZL.nxej4gCnmpamR5vIT/26Mz6n6rhhQ.i', '90df3efa9393086e1a871ce2a5b3cc', 'verified'),
(19, 'BKR', 'Rajpoot', 'bkr', 'abc127@gmail.com', 'subscriber', '$2y$10$SP7RE0GV3To4XSySRSnZL.nxej4gCnmpamR5vIT/26Mz6n6rhhQ.i', 'a9b42b37d46596b42c13698ebbab37', 'verified'),
(20, 'Samar', 'Almas', 'samar', 'abc128@gmail.com', 'admin', '$2y$10$SP7RE0GV3To4XSySRSnZL.nxej4gCnmpamR5vIT/26Mz6n6rhhQ.i', '1dd758d1551be59b48606f0365a714', 'verified'),
(21, 'Abuzar', 'Yaseen', 'abuzar', 'abc129@gmail.com', 'subscriber', '$2y$10$SP7RE0GV3To4XSySRSnZL.nxej4gCnmpamR5vIT/26Mz6n6rhhQ.i', '1e82f51262ca341b164dcf8db3636f', 'verified');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `token` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
