-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 29, 2022 at 11:02 AM
-- Server version: 5.7.18
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `synote`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_sessions`
--

CREATE TABLE `login_sessions` (
  `id` int(11) NOT NULL,
  `UA` text,
  `session_id` varchar(200) DEFAULT NULL,
  `status` enum('pending','scanned') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_sessions`
--

INSERT INTO `login_sessions` (`id`, `UA`, `session_id`, `status`, `user_id`, `date`) VALUES
(1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e19d7ae8a561.06604175', 'scanned', 1, '1658953082'),
(2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e19e33f11ed9.14817731', 'scanned', 1, '1658953267'),
(3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e19fadd4b354.37698250', 'pending', NULL, '1658953645'),
(4, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e1a07c85b8b6.66851612', 'scanned', 1, '1658953852'),
(5, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e1a10e7265f8.79155903', 'scanned', 1, '1658953998'),
(6, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e1a196af9d20.08527294', 'scanned', 1, '1658954134'),
(7, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e1a2b7a66ac1.86768987', 'scanned', 1, '1658954423'),
(8, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e1a551a9fec3.88658146', 'scanned', 1, '1658955089'),
(9, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e22aa1c4b050.39023786', 'pending', NULL, '1658989217'),
(10, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e22ae8069d98.88266579', 'pending', NULL, '1658989288'),
(11, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e22b186fc6f9.31569190', 'pending', NULL, '1658989336'),
(12, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e22ba2592e39.85562117', 'pending', NULL, '1658989474'),
(13, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e22bca128d29.06732293', 'pending', NULL, '1658989514'),
(14, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e22d16650dc8.66839621', 'pending', NULL, '1658989846'),
(15, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e22d6f503830.36681694', 'pending', NULL, '1658989935'),
(16, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e22dddb31b86.78783032', 'pending', NULL, '1658990045'),
(17, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e22df6d42268.77223042', 'pending', NULL, '1658990070'),
(18, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e22eb6255dc5.74240756', 'pending', NULL, '1658990262'),
(19, 'Mozilla/5.0 (Linux; Android 12; M2101K7AG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.0.0 Mobile Safari/537.36', 'ses_62e2d24c13c733.01801029', 'pending', NULL, '1659032140'),
(20, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e2d26aebce89.41344734', 'scanned', 1, '1659032170'),
(21, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e2d3c06acde6.15963105', 'pending', NULL, '1659032512'),
(22, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e2d3c67ddce1.43773010', 'scanned', 1, '1659032518'),
(23, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e2d3f2d48f34.75563044', 'pending', NULL, '1659032562'),
(24, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e2d402199f74.93034171', 'scanned', 1, '1659032578'),
(25, 'Mozilla/5.0 (Linux; Android 12; M2101K7AG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.0.0 Mobile Safari/537.36', 'ses_62e2d5662bdb73.90143768', 'pending', NULL, '1659032934'),
(26, 'Mozilla/5.0 (Linux; Android 12; M2101K7AG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.0.0 Mobile Safari/537.36', 'ses_62e2d568cd45e3.20162242', 'pending', NULL, '1659032936'),
(27, 'Mozilla/5.0 (Linux; Android 12; M2101K7AG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.0.0 Mobile Safari/537.36', 'ses_62e2d584d68227.39902058', 'pending', NULL, '1659032964'),
(28, 'Mozilla/5.0 (Linux; Android 12; M2101K7AG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.0.0 Mobile Safari/537.36', 'ses_62e2d593ed1a27.18505129', 'scanned', 1, '1659032979'),
(29, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 OPR/89.0.4447.48', 'ses_62e3a7b67fb3d1.45277815', 'scanned', 1, '1659086774');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_token` varchar(100) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `user_token`, `date`) VALUES
(1, 'mikethedev', '$2y$10$rhsI3NHde9kJ7U/SkwU/B.KrMBTXMbGII4e9UDpUJW/4zuOVzfpXq', 'b335804049366eacfed80de3', '1659024010');

-- --------------------------------------------------------

--
-- Table structure for table `user_notes`
--

CREATE TABLE `user_notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `content` longtext,
  `date_created` varchar(50) DEFAULT NULL,
  `date_modified` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_notes`
--

INSERT INTO `user_notes` (`id`, `user_id`, `title`, `content`, `date_created`, `date_modified`) VALUES
(2, 1, 'First Note', '&lt;p&gt;Satisfied conveying an dependent contented he gentleman agreeable do be. Warrant private blushes removed an in equally totally if. Delivered dejection necessary objection do mr prevailed. Mr feeling do chiefly cordial in do. Water timed folly right aware if oh truth. Imprudence attachment him his for sympathize. Large above be to means. Dashwood do provided stronger is. But discretion frequently sir the she instrument unaffected admiration everything.&lt;/p&gt;', '1658155731', NULL),
(3, 1, '', '&lt;p&gt;Carried nothing on am warrant towards. Polite in of in oh needed itself silent course. Assistance travelling so especially do prosperous appearance mr no celebrated. Wanted easily in my called formed suffer. Songs hoped sense as taken ye mirth at. Believe fat how six drawing pursuit minutes far. Same do seen head am part it dear open to. Whatever may scarcely judgment had.&lt;/p&gt;', '1658155752', NULL),
(4, 1, '', '&lt;p&gt;Do am he horrible distance marriage so although. Afraid assure square so happen mr an before&lt;/p&gt;', '1658155768', NULL),
(5, 1, 'Long one', '&lt;p&gt;&amp;nbsp;His many same been well can high that. Forfeited did law eagerness allowance improving assurance bed. Had saw put seven joy short first. Pronounce so enjoyment my resembled in forfeited sportsman. Which vexed did began son abode short may. Interested astonished he at cultivated or me. Nor brought one invited she produce her.&lt;br&gt;&lt;br&gt;Eat imagine you chiefly few end ferrars compass. Be visitor females am ferrars inquiry. Latter law remark two lively thrown. Spot set they know rest its. Raptures law diverted believed jennings consider children the see. Had invited beloved carried the colonel. Occasional principles discretion it as he unpleasing boisterous. She bed sing dear now son half.&lt;br&gt;&lt;br&gt;Bringing so sociable felicity supplied mr. September suspicion far him two acuteness perfectly. Covered as an examine so regular of. Ye astonished friendship remarkably no. Window admire matter praise you bed whence. Delivered ye sportsmen zealously arranging frankness estimable as. Nay any article enabled musical shyness yet sixteen yet blushes. Entire its the did figure wonder off.&lt;/p&gt;', '1658155783', NULL),
(6, 1, 'Kobayashi Maru', '&lt;p&gt;The &lt;strong&gt;Kobayashi Maru &lt;/strong&gt;is a training exercise in the Star Trek franchise designed to test the character of Starfleet Academy cadets in a no-win scenario&lt;/p&gt;', '1658160666', NULL),
(7, 1, 'Jacob banks - Unholy War (lyrics)', '&lt;pre id=&quot;lyric-body-text&quot; class=&quot;lyric-body wselect-cnt&quot; dir=&quot;ltr&quot; data-lang=&quot;en&quot;&gt;Unholy war\r\nMy &lt;a href=&quot;https://www.definitions.net/definition/demons&quot;&gt;demons&lt;/a&gt; are coming\r\nBoy, you &lt;a href=&quot;https://www.definitions.net/definition/better&quot;&gt;better&lt;/a&gt; run\r\nGo take your freedom, oh no\r\nWade in the water\r\nBe gone by morning\r\nDon\'t you let them find you here\r\nOh no\r\n\r\nLet love lead you home, oh no\r\nLet &lt;a href=&quot;https://www.definitions.net/definition/redemption&quot;&gt;redemption&lt;/a&gt; keep you warm\r\nSo, you &lt;a href=&quot;https://www.definitions.net/definition/better&quot;&gt;better&lt;/a&gt; run\r\nYou &lt;a href=&quot;https://www.definitions.net/definition/better&quot;&gt;better&lt;/a&gt; run\r\n\r\nTime has come\r\nFuture is now, oh love\r\nSteady on\r\nGo take your bow\r\nWeather the storm\r\nGood &lt;a href=&quot;https://www.definitions.net/definition/times&quot;&gt;times&lt;/a&gt; will pass you by\r\nHit the road\r\nLeave your &lt;a href=&quot;https://www.definitions.net/definition/sorrows&quot;&gt;sorrows&lt;/a&gt; behind\r\n\r\nOh, &lt;a href=&quot;https://www.definitions.net/definition/would&quot;&gt;would&lt;/a&gt; you let love lead you home, oh please\r\nLet &lt;a href=&quot;https://www.definitions.net/definition/redemption&quot;&gt;redemption&lt;/a&gt; keep you warm\r\nSo, you &lt;a href=&quot;https://www.definitions.net/definition/better&quot;&gt;better&lt;/a&gt; run\r\nYou &lt;a href=&quot;https://www.definitions.net/definition/better&quot;&gt;better&lt;/a&gt; run\r\n\r\nI know it\'s &lt;a href=&quot;https://www.definitions.net/definition/killing&quot;&gt;killing&lt;/a&gt; you\r\nWell, well, well, well\r\nYou &lt;a href=&quot;https://www.definitions.net/definition/gotta&quot;&gt;gotta&lt;/a&gt; leave\r\nI know it\'s &lt;a href=&quot;https://www.definitions.net/definition/killing&quot;&gt;killing&lt;/a&gt; you\r\nOh no\r\nYou &lt;a href=&quot;https://www.definitions.net/definition/gotta&quot;&gt;gotta&lt;/a&gt; leave\r\nI know it\'s &lt;a href=&quot;https://www.definitions.net/definition/killing&quot;&gt;killing&lt;/a&gt; you\r\nYou &lt;a href=&quot;https://www.definitions.net/definition/gotta&quot;&gt;gotta&lt;/a&gt; leave\r\nI know it\'s &lt;a href=&quot;https://www.definitions.net/definition/killing&quot;&gt;killing&lt;/a&gt; you\r\nYou &lt;a href=&quot;https://www.definitions.net/definition/gotta&quot;&gt;gotta&lt;/a&gt; leave\r\n\r\nSo, you &lt;a href=&quot;https://www.definitions.net/definition/better&quot;&gt;better&lt;/a&gt; run\r\nYou &lt;a href=&quot;https://www.definitions.net/definition/better&quot;&gt;better&lt;/a&gt; run\r\nOh save yourself, please\r\nYou &lt;a href=&quot;https://www.definitions.net/definition/better&quot;&gt;better&lt;/a&gt; run\r\nYou &lt;a href=&quot;https://www.definitions.net/definition/better&quot;&gt;better&lt;/a&gt; run&lt;/pre&gt;', '1658174127', NULL),
(8, 1, 'Tester', '&lt;p&gt;Hello&lt;/p&gt;', '1658332627', NULL),
(11, 1, 'Note to edit', '&lt;p&gt;Demo note to edit or delete later&amp;nbsp;&lt;/p&gt;', '1659086902', '1659087493');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_sessions`
--
ALTER TABLE `login_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notes`
--
ALTER TABLE `user_notes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_sessions`
--
ALTER TABLE `login_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_notes`
--
ALTER TABLE `user_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
