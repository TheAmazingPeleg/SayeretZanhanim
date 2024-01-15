-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: אפריל 06, 2022 בזמן 08:27 AM
-- גרסת שרת: 5.6.41-84.1
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sayernim_system`
--

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `letter`
--

CREATE TABLE `letter` (
  `id` int(11) NOT NULL,
  `rule` varchar(30) NOT NULL,
  `sender` varchar(30) NOT NULL,
  `message` longtext NOT NULL,
  `img` longtext NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- הוצאת מידע עבור טבלה `letter`
--

INSERT INTO `letter` (`id`, `rule`, `sender`, `message`, `img`, `status`) VALUES
(1, 'מפקד היחידה', 'נועם מיכאל', '!מפקדים, לוחמים וחיילים יקרים<br />.מצורפת איגרת \"מעודכנים בסיירת צנחנים\" לשבוע 7<br /><br />!השבוע, התקיים תרגיל חטיבתי- ישר כוח לכל המשתתפים<br />.רגילה מהנה לכולם! שמרו על עצמכם, משפחת סיירת צנחנים', 'assets/img/client-img-03.jpg', 1);

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `ranks`
--

CREATE TABLE `ranks` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `color` varchar(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- הוצאת מידע עבור טבלה `ranks`
--

INSERT INTO `ranks` (`id`, `name`, `color`) VALUES
(1, 'צופה', '#b3b3b3'),
(2, 'משתמש', '#ffffff'),
(3, 'עורך', '#cc66ff'),
(4, 'מפקד', '#0066ff'),
(5, 'מנהל', '#ff6600');

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `rides`
--

CREATE TABLE `rides` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `driver` varchar(50) NOT NULL,
  `com` varchar(50) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `exitLocation` longtext NOT NULL,
  `stops` longtext NOT NULL,
  `destination` longtext NOT NULL,
  `seatRemaining` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `authorisedBY` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- הוצאת מידע עבור טבלה `rides`
--

INSERT INTO `rides` (`id`, `user`, `driver`, `com`, `start`, `end`, `exitLocation`, `stops`, `destination`, `seatRemaining`, `status`, `authorisedBY`) VALUES
(1, 1, 'פלג', 'פלג', 1655790400, 1655797600, 'מוצב עופר', 'כוכב יעקוב, רמה', 'מוצב עופר', 3, 1, 1),
(2, 1, 'פלג רובין', 'פלג רובין', 1645824420, 1645825380, 'מחנה עופר', 'בורגר סאלון', 'מחנה בית ליד', 2, 1, 1),
(3, 1, 'פלג רובין', 'פלג רובין', 1645826580, 1645909380, 'מחנה עופר', 'דלק פרדסיה', 'מחנה בית ליד', 2, 2, 1),
(4, 1, 'פלג רובין', 'פלג רובין', 1655790400, 1655837680, 'מחנה עופר', 'חוף פולג', 'מחנה בית ליד', 1, 1, 1),
(5, 1, 'פלג רובין', 'פלג רובין', 1647011700, 1647022500, 'מחנה עופר', 'בורגר סאלון', 'מחנה בית ליד', 2, 1, 1);

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` longtext NOT NULL,
  `password` longtext NOT NULL,
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `rank` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- הוצאת מידע עבור טבלה `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `firstName`, `lastName`, `rank`, `status`) VALUES
(1, 'pelegrubin', 'peleg.rubin@gmail.com', '7f3adb25c63138bc179458092d806a6e', 'פלג', 'רובין', 5, 1),
(2, 'shaked', 'shakedh999@gmail.com', '94ce51a8d84f6b2961f1b2bbd89e1f42', 'שקד', 'הרמתי', 4, 0);

--
-- Indexes for dumped tables
--

--
-- אינדקסים לטבלה `letter`
--
ALTER TABLE `letter`
  ADD PRIMARY KEY (`id`);

--
-- אינדקסים לטבלה `ranks`
--
ALTER TABLE `ranks`
  ADD PRIMARY KEY (`id`);

--
-- אינדקסים לטבלה `rides`
--
ALTER TABLE `rides`
  ADD PRIMARY KEY (`id`);

--
-- אינדקסים לטבלה `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `letter`
--
ALTER TABLE `letter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ranks`
--
ALTER TABLE `ranks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rides`
--
ALTER TABLE `rides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
