-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 03, 2022 at 10:37 AM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bathhack`
--

-- --------------------------------------------------------

--
-- Table structure for table `charities`
--

CREATE TABLE `charities` (
  `charityNumber` int(8) NOT NULL,
  `charityName` text NOT NULL,
  `address` text NOT NULL,
  `postcode` text NOT NULL,
  `phoneNumber` int(11) DEFAULT NULL,
  `charityType` text NOT NULL,
  `task` text NOT NULL,
  `minimumAge` int(11) DEFAULT NULL,
  `carRequired` text,
  `DBSRequired` text,
  `charityEmail` text,
  `charityPassword` text,
  `charityLat` double NOT NULL,
  `charityLng` double NOT NULL,
  `charityImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `charities`
--

INSERT INTO `charities` (`charityNumber`, `charityName`, `address`, `postcode`, `phoneNumber`, `charityType`, `task`, `minimumAge`, `carRequired`, `DBSRequired`, `charityEmail`, `charityPassword`, `charityLat`, `charityLng`, `charityImage`) VALUES
(205594, 'Bath Cats & Dogs Home', 'The Avenue, Claverton Down, Bath\r\n', 'BA2 7AZ', 1225787321, 'animals', 'Work in feeding the species hosted by us.', NULL, NULL, 'Yes', 'catsanddogshome@gmail.com', '$2y$10$zQTl4p/0sySYTIi6UtXub.4XdcsMrRJwV58xuoD7S4hYJxy.W51AC', 51.37548903025406, -2.321647931200209, 'BathCatsandDogsHomeLogo.jpg'),
(1154251, 'Bath Foodbank', 'The Gateway Centre, Snow Hill, London Road,Bath\r\n', 'BA1 6DH', 1225463549, 'homelessness', 'Help organize the queue at our centre.', NULL, NULL, NULL, 'info@bath.foodbank.org.uk', '$2y$10$zQTl4p/0sySYTIi6UtXub.4XdcsMrRJwV58xuoD7S4hYJxy.W51AC', 51.38009687485119, -2.3569211674749395, 'BathFoodbankLogo.webp'),
(1154253, 'Genesis Trust Bath', 'Snow Hill, London Road, Bath\r\n', 'BA1 6DH', 1225463549, 'homelessness', 'Offer digital training services to homeless people.', NULL, 'Yes', NULL, 'office@genesistrust.org.uk', '$2y$10$zQTl4p/0sySYTIi6UtXub.4XdcsMrRJwV58xuoD7S4hYJxy.W51AC', 51.39187232324945, -2.3544251045261153, 'GenesisTrustBathLogo.png'),
(1183751, 'Julian House Homeless Hostel', '55 New King Street, Bath', 'BA1 2BN', 1225354650, 'homelessness', 'Serve food to homeless people.', 14, NULL, 'Yes', 'admin@julianhouse.org.uk', '$2y$10$zQTl4p/0sySYTIi6UtXub.4XdcsMrRJwV58xuoD7S4hYJxy.W51AC', 51.37926749049669, -2.356914185682831, 'JulianHouseHomelessShelterLogo.png');

-- --------------------------------------------------------

--
-- Table structure for table `UserCharities`
--

CREATE TABLE `UserCharities` (
  `UserCharitiesID` int(11) NOT NULL,
  `userEmail` varchar(400) NOT NULL,
  `charityNumber` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `UserCharities`
--

INSERT INTO `UserCharities` (`UserCharitiesID`, `userEmail`, `charityNumber`) VALUES
(19, 'ns2227@bath.ac.uk', 205594),
(21, 'ns2227@bath.ac.uk', 1183751),
(22, 'ns2227@bath.ac.uk', 1154253);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userEmail` varchar(400) NOT NULL,
  `userName` text NOT NULL,
  `DOB` date NOT NULL,
  `contactNumber` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `DBS` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userEmail`, `userName`, `DOB`, `contactNumber`, `password`, `DBS`) VALUES
('ns2227@bath.ac.uk', 'Niccolò', '2002-11-16', 0, '$2y$10$eQsdn8YNXo63RoAD5UoJweJ45Kc8Q.OUObCPj.jk7qqVKxBCelgI.', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `charities`
--
ALTER TABLE `charities`
  ADD PRIMARY KEY (`charityNumber`);

--
-- Indexes for table `UserCharities`
--
ALTER TABLE `UserCharities`
  ADD PRIMARY KEY (`UserCharitiesID`),
  ADD UNIQUE KEY `CharityNumber` (`charityNumber`),
  ADD KEY `UserEmail` (`userEmail`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `UserCharities`
--
ALTER TABLE `UserCharities`
  MODIFY `UserCharitiesID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
