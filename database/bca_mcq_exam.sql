-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2025 at 03:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bca_mcq_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'suresh', '$2y$10$MBR.BltfP4J/j3IOXX3F2Ocp7uzevZAqG2NW1LK0s98NyLznL8I5e');

-- --------------------------------------------------------

--
-- Table structure for table `exam_attempts`
--

CREATE TABLE `exam_attempts` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `correct_answers` int(11) NOT NULL,
  `wrong_answers` int(11) NOT NULL,
  `attempted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_status`
--

CREATE TABLE `exam_status` (
  `id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_status`
--

INSERT INTO `exam_status` (`id`, `subject`, `is_enabled`, `updated_at`) VALUES
(1, 'Economics', 0, '2025-05-31 02:05:44'),
(4, 'Mobile Programming', 1, '2025-07-26 06:07:24');

-- --------------------------------------------------------

--
-- Table structure for table `practice_attempts`
--

CREATE TABLE `practice_attempts` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `selected_option` char(1) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `attempted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `practice_attempts`
--

INSERT INTO `practice_attempts` (`id`, `student_id`, `question_id`, `selected_option`, `is_correct`, `attempted_at`) VALUES
(1, 3, 1, 'A', 1, '2025-07-26 13:15:10'),
(2, 3, 1, 'B', 0, '2025-07-26 13:15:34'),
(3, 3, 1, 'D', 0, '2025-07-26 13:15:41'),
(4, 3, 1, 'D', 0, '2025-07-26 13:17:04'),
(5, 3, 1, 'D', 0, '2025-07-26 13:18:44'),
(6, 3, 1, 'D', 0, '2025-07-26 13:18:51'),
(7, 3, 1, 'C', 0, '2025-07-26 13:19:04'),
(8, 3, 4, 'C', 1, '2025-07-26 13:25:22'),
(9, 3, 3, 'A', 0, '2025-07-26 13:25:59'),
(10, 3, 17, 'A', 0, '2025-07-26 13:32:38'),
(11, 3, 124, 'D', 0, '2025-07-26 13:32:52'),
(12, 3, 3, 'D', 0, '2025-07-26 13:37:46'),
(13, 3, 1, 'B', 0, '2025-07-26 13:38:02'),
(14, 3, 7, 'A', 0, '2025-07-26 13:38:13'),
(15, 3, 7, 'A', 0, '2025-07-26 13:38:42'),
(16, 3, 6, 'A', 0, '2025-07-26 13:42:10'),
(17, 3, 6, 'A', 0, '2025-07-26 13:42:26'),
(18, 3, 6, 'C', 0, '2025-07-26 13:42:56'),
(19, 3, 3, 'B', 0, '2025-07-26 13:43:11'),
(20, 3, 4, 'A', 0, '2025-07-26 13:43:29'),
(21, 3, 6, 'D', 0, '2025-07-26 13:43:35'),
(22, 3, 6, 'D', 0, '2025-07-26 13:45:08'),
(23, 3, 2, 'A', 1, '2025-07-26 13:45:21'),
(24, 3, 1, 'D', 0, '2025-07-27 07:34:09'),
(25, 3, 7, 'B', 1, '2025-07-27 07:34:21'),
(26, 3, 3, 'B', 0, '2025-07-27 07:34:46'),
(27, 3, 1, 'B', 0, '2025-07-27 07:41:44'),
(28, 3, 1, 'B', 0, '2025-07-27 07:42:06'),
(29, 3, 1, 'B', 0, '2025-07-27 07:42:22'),
(30, 3, 7, 'C', 0, '2025-07-27 07:42:38'),
(31, 3, 7, 'B', 1, '2025-07-27 08:34:40'),
(32, 3, 2, 'B', 0, '2025-07-27 08:34:57'),
(33, 3, 2, 'B', 0, '2025-07-27 08:35:10'),
(34, 3, 3, 'C', 0, '2025-07-27 08:35:18'),
(35, 3, 2, 'C', 0, '2025-07-27 08:42:14'),
(36, 3, 5, 'A', 0, '2025-07-27 08:42:23'),
(37, 3, 4, 'B', 1, '2025-07-27 08:42:38'),
(38, 3, 4, 'B', 1, '2025-07-27 08:46:33'),
(39, 3, 4, 'A', 0, '2025-07-27 08:46:40'),
(40, 3, 3, 'D', 0, '2025-07-27 08:46:51'),
(41, 3, 7, 'B', 1, '2025-07-27 08:47:00'),
(42, 3, 6, 'B', 1, '2025-07-27 08:47:11'),
(43, 3, 1, 'D', 0, '2025-07-27 08:47:20'),
(44, 3, 4, 'A', 0, '2025-07-27 08:47:26'),
(45, 3, 3, 'D', 0, '2025-07-27 08:47:39'),
(46, 3, 7, 'B', 1, '2025-07-27 08:53:31'),
(47, 3, 3, 'A', 1, '2025-07-27 08:53:44'),
(48, 3, 7, 'B', 1, '2025-07-27 08:53:55'),
(49, 3, 11, 'C', 1, '2025-07-27 09:10:58'),
(50, 3, 15, 'A', 1, '2025-07-27 09:11:10'),
(51, 3, 14, 'C', 1, '2025-07-27 09:11:21'),
(52, 3, 15, 'D', 0, '2025-07-27 09:11:33'),
(53, 3, 12, 'A', 0, '2025-07-27 09:11:45'),
(54, 3, 1, 'D', 0, '2025-07-27 09:11:51'),
(55, 7, 6, 'B', 1, '2025-07-27 10:43:09'),
(56, 7, 12, 'D', 1, '2025-07-27 10:43:19'),
(57, 7, 14, 'A', 0, '2025-07-27 10:43:26'),
(58, 7, 11, 'A', 0, '2025-07-27 10:43:36'),
(59, 7, 5, 'B', 0, '2025-07-27 10:43:44'),
(60, 7, 1, 'D', 0, '2025-07-27 12:29:30'),
(61, 7, 1, 'A', 1, '2025-07-27 12:29:43'),
(62, 7, 13, 'C', 1, '2025-07-27 12:29:57'),
(63, 7, 16, 'A', 0, '2025-07-27 12:30:14'),
(64, 7, 1, 'A', 1, '2025-07-27 14:16:16'),
(65, 7, 13, 'C', 1, '2025-07-27 14:16:30'),
(66, 7, 14, 'D', 0, '2025-07-27 14:16:38');

-- --------------------------------------------------------

--
-- Table structure for table `practice_questions`
--

CREATE TABLE `practice_questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_option` char(1) DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `difficulty` enum('Easy','Medium','Hard') DEFAULT NULL,
  `topic` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `practice_questions`
--

INSERT INTO `practice_questions` (`id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation`, `difficulty`, `topic`) VALUES
(1, 'Which language is used to develop Android apps?', 'Java', 'Python', 'PHP', 'Swift', 'A', 'Java is the official language used by Android for app development.', 'Easy', 'Android Basics'),
(2, 'What does APK stand for in Android?', 'Android Package', 'Application Package', 'Android Phone Kit', 'App Pack', 'A', 'APK stands for Android Package used to install apps.', 'Easy', 'Android Basics'),
(3, 'Which tool is used for building UI in iOS?', 'Xcode', 'Android Studio', 'React Native', 'Flutter', 'A', 'Xcode is the official tool used to develop iOS apps.', 'Easy', 'iOS UI'),
(4, 'What does HTTP stand for?', 'Hyper Transfer Text Protocol', 'HyperText Transfer Protocol', 'Hyper Transfer Type Protocol', 'Hyperlink Text Transfer Protocol', 'B', 'HTTP stands for HyperText Transfer Protocol.', 'Easy', 'HTTP Basics'),
(5, 'Which protocol is used to resolve domain names?', 'HTTP', 'TCP', 'DNS', 'FTP', 'C', 'DNS (Domain Name System) is used to resolve domain names to IP addresses.', 'Easy', 'DNS'),
(6, 'Which SQL clause is used to combine rows from two or more tables?', 'SELECT', 'JOIN', 'WHERE', 'ORDER BY', 'B', 'JOIN is used to combine rows from two or more tables.', 'Easy', 'SQL Joins'),
(7, 'What is the purpose of normalization?', 'To speed up queries', 'To eliminate redundancy', 'To create backups', 'To manage users', 'B', 'Normalization reduces data redundancy and improves data integrity.', 'Easy', 'Normalization'),
(8, 'Which tag is used to insert an image in HTML?', '<image>', '<img>', '<src>', '<pic>', 'B', '<img> tag is used to embed an image in HTML.', 'Easy', 'Web'),
(9, 'Which of the following is a valid variable name in C?', 'int', '123var', 'my_var', 'char', 'C', 'my_var is a valid identifier in C.', 'Easy', 'C Programming'),
(10, 'Which keyword is used to declare a function in JavaScript?', 'define', 'function', 'method', 'declare', 'B', '\"function\" keyword is used to define a function in JavaScript.', 'Easy', 'JavaScript'),
(11, 'Which SQL clause is used to filter records?', 'ORDER BY', 'GROUP BY', 'WHERE', 'HAVING', 'C', 'WHERE clause filters rows before grouping.', 'Medium', 'DBMS'),
(12, 'Which data structure uses LIFO?', 'Queue', 'Array', 'Linked List', 'Stack', 'D', 'Stack follows Last In First Out order.', 'Medium', 'Data Structure'),
(13, 'Which of the following is NOT a loop in Java?', 'for', 'do-while', 'repeat-until', 'while', 'C', 'Java doesn’t support repeat-until loop.', 'Medium', 'Java'),
(14, 'Which normal form removes transitive dependency?', '1NF', '2NF', '3NF', 'BCNF', 'C', '3NF removes transitive dependency.', 'Hard', 'DBMS'),
(15, 'What is the output of 3 + 2 + \"7\" in JavaScript?', '57', '12', '327', 'Error', 'A', '3+2=5, then \"5\"+\"7\" = \"57\" due to string concatenation.', 'Hard', 'JavaScript'),
(16, 'Which algorithm is used for shortest path in graphs?', 'DFS', 'BFS', 'Dijkstra', 'Kruskal', 'C', 'Dijkstra’s algorithm finds the shortest path from a source node.', 'Hard', 'Algorithm');

-- --------------------------------------------------------

--
-- Table structure for table `practice_review`
--

CREATE TABLE `practice_review` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `saved_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `practice_topics`
--

CREATE TABLE `practice_topics` (
  `id` int(11) NOT NULL,
  `topic_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `option1` varchar(255) DEFAULT NULL,
  `option2` varchar(255) DEFAULT NULL,
  `option3` varchar(255) DEFAULT NULL,
  `option4` varchar(255) DEFAULT NULL,
  `correct_option` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `audio_path` varchar(255) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `subject`, `question`, `option1`, `option2`, `option3`, `option4`, `correct_option`, `image_path`, `audio_path`, `video_path`, `created_at`) VALUES
(10, 'sports', 'who is your favourite football player ', 'cristano ronaldo ', 'messi', 'marshello', 'ronaldio', 'option4', 'uploads/cristiano_ronaldo_real_madrid_wallpapers_by_jafarjeef_d7j78t6-fullview.jpg', '', '', '2025-05-24 01:38:46'),
(12, 'Mobile Programming', 'which of the following is not layout used for designing the user interface in android programming', 'Linear Layout', 'Absolute Layout', 'Flow Layout', 'Table Layout', 'option3', '', '', '', '2025-05-27 04:24:12'),
(13, 'Mobile Programming', 'which of the following view display one child at a time and act as dropdown list?', 'EditText', 'CheckBox', 'RadioButton', 'Spinner', 'option4', '', '', '', '2025-05-27 04:25:45'),
(14, 'Mobile Programming', 'which of the following package is used for Button view?', 'android.app.*', 'android.intent.*', 'android.view.*', 'android.widget.*', 'option4', '', '', '', '2025-05-27 04:27:49'),
(15, 'Mobile Programming', 'During activity lifecycle, what is first callback invoked bye the system?', 'onStart()', 'onStop()', 'onCreate()', 'onResume()', 'option3', '', '', '', '2025-05-27 04:29:22'),
(16, 'Mobile Programming', 'if you need to pass data from one activity to another activity, the which of the following method you should use?', 'startActivityForResult()', 'ActivityForResult()', 'setResult()', 'startActivity()', 'option1', '', '', '', '2025-05-27 04:31:20'),
(17, 'Mobile Programming', 'which one is not menu supported in android programming?', 'Dropdowm Menu', 'Context Menu', 'Option Menu', 'Popup Menu', 'option1', '', '', '', '2025-05-27 04:32:50'),
(18, 'Mobile Programming', 'which of the following view supports both vertical and horizontal scrolling?', 'ListView', 'RecyclerView', 'GridView', 'ImageView', 'option2', '', '', '', '2025-05-27 04:34:27'),
(19, 'Mobile Programming', 'which one is not method of SQLiteOpenHelper class?', 'onCreate()', 'Close()', 'onStop()', 'onUpgrade()', 'option3', '', '', '', '2025-05-27 04:35:52'),
(20, 'Mobile Programming', 'which of the following is incorrect data type in swift?', 'UINt', 'Char', 'Double', 'Optional', 'option2', '', '', '', '2025-05-27 04:37:14'),
(21, 'Mobile Programming', 'which permission are required to get location in android programming?', 'ACCES_FINE and ACCESS_COARSE', 'GPRS permission', 'Internet Permission', 'WIFI Permission', 'option1', '', '', '', '2025-05-27 04:38:48'),
(22, 'Economics', 'What is the main economic problem faced by society?', 'Scarcity of resources', ' Unlimited wants', ' Choice', ' Both A and B ', 'option4', '', '', '', '2025-05-30 10:11:21'),
(23, 'Minus iusto delectus', 'Id debitis rerum qui', 'Et accusantium archi', 'Omnis officia laudan', 'Et dolor quis quas o', 'Voluptatem ut et qui', 'option4', 'uploads/431624791_718806897081189_3998471542867090090_n.jpg', '', '', '2025-05-31 11:18:27');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `full_name`, `email`, `password`, `registered_at`) VALUES
(1, 'Ila Fuentes', 'ssdasf@gmail.com', '$2y$10$Qs0dih9e3n2bzDer3NAsnOmEvQnTBTW1HyzXjsJCeIye6bC2e0i2a', '2025-05-25 12:03:39'),
(2, 'Nayda Mcpherson', 'sskfsakfsakfs@gmail.com', '$2y$10$YFcPcX2miuwr7POYdtvkJuFcP1vTRtHbYr45HckhboetEAVe1jKuS', '2025-05-25 12:04:28'),
(4, 'nikhiliya maharjan', 'nikhiliyamaharjan@gmail.com', '$2y$10$hy1J96Ssy3obk5oYgIykbeqjQAAcRk3735FVdGPV3mKMevIZbmh36', '2025-05-27 02:09:03'),
(5, 'suresh shrestha', 'surace9848@gmail.com', '$2y$10$B.BOWfScej7NLgwdbA8rP.hIEJIeRdfINc3jr8lDpMs.hUQmpYoTK', '2025-05-31 11:11:22'),
(6, 'manjila', 'manjeelamaharjan@gmail.com', '$2y$10$pCi8Bw/IEf6y7y74ySuj1OZn31oldg5fwcsbzoEgVFtzPoxoHs9om', '2025-06-10 03:25:41'),
(7, 'suresh shrestha', 'ss4246810@gmail.com', '$2y$10$Zm8zZp6bYJ7V8wexikhAJefhz3yVO1g9UiaJO1NvrkrQgxkkg0hF6', '2025-07-27 04:55:10');

-- --------------------------------------------------------

--
-- Table structure for table `student_answers`
--

CREATE TABLE `student_answers` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_answer` varchar(255) NOT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_answers`
--

INSERT INTO `student_answers` (`id`, `student_id`, `question_id`, `selected_answer`, `subject`, `submitted_at`) VALUES
(11, 4, 12, 'option3', 'Mobile Programming', '2025-05-30 10:15:18'),
(12, 4, 13, 'option3', 'Mobile Programming', '2025-05-30 10:15:23'),
(13, 4, 14, 'option1', 'Mobile Programming', '2025-05-30 10:15:29'),
(14, 4, 15, 'option1', 'Mobile Programming', '2025-05-30 10:15:33'),
(15, 4, 16, 'option1', 'Mobile Programming', '2025-05-30 10:15:37'),
(16, 4, 17, 'option1', 'Mobile Programming', '2025-05-30 10:15:42'),
(17, 4, 18, 'option2', 'Mobile Programming', '2025-05-30 10:15:47'),
(18, 4, 19, 'option3', 'Mobile Programming', '2025-05-30 10:15:51'),
(19, 4, 20, 'option1', 'Mobile Programming', '2025-05-30 10:15:55'),
(20, 4, 21, 'option1', 'Mobile Programming', '2025-05-30 10:16:00'),
(21, 5, 12, 'option2', 'Mobile Programming', '2025-05-31 11:14:21'),
(22, 5, 13, 'option1', 'Mobile Programming', '2025-05-31 11:15:14'),
(23, 5, 14, 'option2', 'Mobile Programming', '2025-05-31 11:15:18'),
(24, 5, 15, 'option1', 'Mobile Programming', '2025-05-31 11:15:22'),
(25, 5, 16, 'option1', 'Mobile Programming', '2025-05-31 11:15:28'),
(26, 5, 17, 'option1', 'Mobile Programming', '2025-05-31 11:15:32'),
(27, 5, 18, 'option1', 'Mobile Programming', '2025-05-31 11:15:36'),
(28, 5, 19, 'option4', 'Mobile Programming', '2025-05-31 11:15:49'),
(29, 5, 20, 'option1', 'Mobile Programming', '2025-05-31 11:15:58'),
(30, 5, 21, 'option1', 'Mobile Programming', '2025-05-31 11:16:56'),
(31, 6, 12, 'option2', 'Mobile Programming', '2025-06-10 04:14:40'),
(32, 6, 13, 'option2', 'Mobile Programming', '2025-06-10 04:14:45'),
(33, 6, 14, 'option2', 'Mobile Programming', '2025-06-10 04:14:51'),
(34, 6, 15, 'option2', 'Mobile Programming', '2025-06-10 04:14:58'),
(35, 6, 16, 'option3', 'Mobile Programming', '2025-06-10 04:15:07'),
(36, 6, 17, 'option3', 'Mobile Programming', '2025-06-10 04:15:12'),
(37, 6, 18, 'option1', 'Mobile Programming', '2025-06-10 04:15:17'),
(38, 6, 19, 'option2', 'Mobile Programming', '2025-06-10 04:15:23'),
(39, 6, 20, 'option2', 'Mobile Programming', '2025-06-10 04:15:28'),
(40, 6, 21, 'option3', 'Mobile Programming', '2025-06-10 04:15:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `exam_attempts`
--
ALTER TABLE `exam_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `exam_status`
--
ALTER TABLE `exam_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subject` (`subject`);

--
-- Indexes for table `practice_attempts`
--
ALTER TABLE `practice_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `practice_questions`
--
ALTER TABLE `practice_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `practice_review`
--
ALTER TABLE `practice_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `practice_topics`
--
ALTER TABLE `practice_topics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `topic_name` (`topic_name`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_attempts`
--
ALTER TABLE `exam_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `exam_status`
--
ALTER TABLE `exam_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `practice_attempts`
--
ALTER TABLE `practice_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `practice_questions`
--
ALTER TABLE `practice_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `practice_review`
--
ALTER TABLE `practice_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `practice_topics`
--
ALTER TABLE `practice_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_answers`
--
ALTER TABLE `student_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam_attempts`
--
ALTER TABLE `exam_attempts`
  ADD CONSTRAINT `exam_attempts_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD CONSTRAINT `student_answers_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
