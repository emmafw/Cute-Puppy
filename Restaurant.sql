-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 09, 2018 at 02:58 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `Restaurant`
--

CREATE TABLE `Restaurant` (
  `ID` int(4) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Zipcode` int(5) NOT NULL,
  `Hours` text NOT NULL,
  `Tags` text NOT NULL,
  `Allergens` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Restaurant`
--

INSERT INTO `Restaurant` (`ID`, `Name`, `Phone`, `Address`, `City`, `State`, `Zipcode`, `Hours`, `Tags`, `Allergens`) VALUES
(1, 'Wagamama', '6177782344', '800 Boylston St', 'Boston', 'MA', 0, 'Sunday 11AM-10PM Monday 11AM-10PM Tuesday 11AM-10PM Wednesday 11AM-10PM Thursday 11AM-10PM Friday 11AM-11PM Saturday 11AM-11PM', 'Japanese ', 'wheat, dairy'),
(2, 'Sweet Green', '6179363464', '659 Boylston St', 'Boston', 'MA', 2116, 'Sunday 10:30AM-10:30PM Monday 10:30AM-10:30PM Tuesday 10:30AM-10:30PM Wednesday 10:30AM-10:30PM Thursday 10:30AM-10:30PM Friday 10:30AM-10:30PM Saturday 10:30AM-10:30PM Sunday 10:30AM-10:30PM', 'Salad, fresh, organic', 'gluten, dairy, peanuts, tree nuts, fish'),
(3, 'Native Foods', '', '', 'Chicago', 'IL', 0, '', 'vegan', ''),
(4, 'Flattop Grill', '', '', 'Chicago', 'IL', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Review`
--

CREATE TABLE `Review` (
  `ReviewID` int(10) NOT NULL,
  `RestaurantID` int(4) NOT NULL,
  `UserID` int(4) NOT NULL,
  `MainStars` int(1) NOT NULL,
  `AllergyStars` int(1) NOT NULL,
  `Review` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Review`
--

INSERT INTO `Review` (`ReviewID`, `RestaurantID`, `UserID`, `MainStars`, `AllergyStars`, `Review`) VALUES
(1, 1, 2, 5, 5, 'Wagamama has great service and a really cool environment. The Chicken Katsu Curry is delicious. They have an extensive allergen menu online that is easy to follow for both their standalone restaurants and their locations in airports. The staff is also super accommodating. Most of their menu items contain no milk so there is a wide selection of meals to choose from. I’d highly recommend.'),
(2, 2, 2, 4, 3, 'Sweet Green is great for a quick healthy meal. Every time I’ve been, their ingredients have been super fresh and their staff extremely pleasant. They label their vegan items on their menu. I usually stick to those although I believe most of the meat is diary free. I’d highly recommend the pesto dressing. It is delicious and very rare to find dairy free pesto. Overall, the food and experiences were great.'),
(3, 3, 2, 5, 5, 'Native Foods is a completely Vegan restaurant. They offer a lot of delicious comfort food that is all dairy-free. Usually I am skeptical about Vegan cheese but their Mac and Cheese and Nachos are the best dairy-free alternatives I’ve had. They also have extremely delicious dessert. For people who have other allergies besides dairy, they have an extensive allergen and ingredient list online. Definitely, a place worth checking out.'),
(4, 4, 2, 3, 4, 'A great stir fry place with multiple locations in the Chicago area. They have a great variety of build your own options. They are definitely allergy conscious. They have a color-coordinated stick system to let the preparers know you have an allergy. Online they have a list of a wide range of allergies and which ingredients people with the allergies can eat or the few that they can’t eat.'),
(5, 1, 1, 5, 5, 'I really like Wagamama. They have a separate gluten free menu and all the staff is really knowledgable about what is gluten free and what isn\'t. The food is really good as well and there are options for all different kinds of diets. ');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `UserID` int(4) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Zipcode` varchar(5) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Allergy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserID`, `FirstName`, `LastName`, `Email`, `Zipcode`, `Password`, `Allergy`) VALUES
(1, 'Emma', 'Findlay-Walters', 'efindlaywalters@gmail.com', '02131', 'cc03e747a6afbbcbf8be7668acfebee5', 'gluten'),
(2, 'Katie', 'Canavan', 'kcanavan@luc.edu', '02492', 'cc03e747a6afbbcbf8be7668acfebee5', 'dairy'),
(3, 'John', 'Smith', 'jsmith@test.com', '02115', '5a105e8b9d40e1329780d62ea2265d8a', 'Tree Nuts, Peanuts'),
(4, 'Jane', 'Doe', 'jdoe@test.com', '90210', '098f6bcd4621d373cade4e832627b4f6', 'Shellfish');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Restaurant`
--
ALTER TABLE `Restaurant`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Review`
--
ALTER TABLE `Review`
  ADD PRIMARY KEY (`ReviewID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
