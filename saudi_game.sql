-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 22 أبريل 2026 الساعة 16:36
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saudi_game`
--

-- --------------------------------------------------------

--
-- بنية الجدول `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `x_position` int(11) NOT NULL,
  `y_position` int(11) NOT NULL,
  `level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`, `x_position`, `y_position`, `level`) VALUES
(1, 'الرياض', 568, 333, 1),
(2, 'جده', 438, 408, 2),
(3, 'مكه المكرمه', 472, 389, 3),
(4, 'المدينه المنوره', 452, 308, 4),
(5, 'الدمام', 758, 251, 5),
(6, 'الطائف', 486, 417, 6),
(7, 'ابها', 531, 485, 7),
(8, 'تبوك', 352, 202, 8),
(9, 'حائل', 513, 209, 9),
(10, 'القصيم', 571, 272, 10),
(11, 'نجران', 590, 504, 11),
(12, 'جازان', 546, 525, 12),
(13, 'الباحه', 529, 443, 13),
(14, 'ينبع', 412, 320, 14),
(15, 'الجوف', 470, 142, 15),
(16, 'الخفجي', 680, 212, 16),
(17, 'الخرج', 613, 350, 17),
(18, 'الهفوف', 764, 311, 18),
(19, 'العلا', 374, 254, 19),
(20, 'الأحساء', 727, 347, 20);

-- --------------------------------------------------------

--
-- بنية الجدول `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `game_name` varchar(50) NOT NULL,
  `city_game` varchar(50) NOT NULL,
  `difficulty` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `question_text` varchar(255) NOT NULL,
  `option1` varchar(100) NOT NULL,
  `option2` varchar(100) NOT NULL,
  `option3` varchar(100) NOT NULL,
  `correct_answer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `questions`
--

INSERT INTO `questions` (`question_id`, `city_id`, `question_text`, `option1`, `option2`, `option3`, `correct_answer`) VALUES
(4, 1, 'بمَ شبّه الأمير محمد بن سلمان \"همة السعوديين\" في مقولته الشهيرة التي تعبر عن الصلابة والطموح؟', 'جبل طويق', 'جبل احد', 'جبل السودة', '1'),
(5, 2, 'نافورة الملك فهد في جدة  تعد من ابرز معالم المدينة وش الي يميزها عالمياً؟', 'تُضاء بألوان متغيرة طوال اليوم', 'انها اعلى نافورة في العالم', 'انها اقدم نافورة في العالم', '2'),
(6, 19, 'وش الصخره الشهيرة في العلا؟', 'جبل الفيل', 'جبل احد', 'جبل النور', '1'),
(7, 15, 'وش النباتات البرية العطرية اللي مشهوره بالجوف؟', 'النعناع', 'الزعتر', 'الديدحان', '3'),
(8, 8, 'وش المعلم الديني المعروف في تبوك؟', 'مسجد التوبة', 'المسجد الحرام', 'مسجد قباء', '1'),
(9, 9, 'وش الجبال اللي تزين مدينة حائل؟', 'أجا وسلمى', 'حسمى واللوز', 'طويق والأحمر', '1'),
(10, 14, 'وش أبرز دور اقتصادي لمدينة ينبع؟', 'صيد الأسماك', 'تصدير النفط الخام', 'المنتجات الزراعية', '2'),
(11, 13, 'تُلقب منطقة الباحة بـ\"حديقة الحجاز\" وش السبب الرئيسي لهذا اللقب؟', 'وجود اكبر ميناء بحري', 'كثرة الصحارى الرملية', 'انتشار المساحات الخضراء واعتدال مناخها', '3'),
(12, 12, 'تضم منطقة جازان ارخبيلاً يعد من اشهر الوجهات الطبيعية في المملكة,وش اسمه؟', 'جزر ام القماري', 'جزر فرسان', 'جزر ابو علي', '2'),
(13, 16, 'وش لقب مدينة الخفجي؟', 'بوابة الشرق', 'منارة الحدود', 'مدينة الزهور', '3'),
(14, 18, 'وش اقدم واشهر سوق شعبي في الهفوف؟', 'سوق الزل', 'سوق القيصرية', 'سوق الثلاثاء', '2'),
(15, 20, 'وش الي يصف الميزة الي خلت الأحساء تُدرج ضمن قائمة التراث العالمي لليونسكو؟', 'واحة طبيعية شاسعة تضم اعداد هائلة من النخل', 'اشتهارها بالمناخ الصحراوي الجاف', 'اعلى منطقة جبلية بالمملكة', '1'),
(16, 17, 'تحتضن الخرج واحدة من اشهر القواعد العسكرية الجوية في المملكة, وش اسمها؟', 'قاعدة الملك خالد الجوية', 'قاعدة الأمير سلطان الجوية', 'قاعدة الملك فيصل الجوية', '2'),
(17, 6, 'ليش الطائف تُسمى بمدينة الورد؟', 'بسبب زراعة الورد الطائفي ', 'بسبب لون جبالها', 'لأن فيها حدائق', '1'),
(18, 7, 'تشتهر مدينة ابها بوجود منتزه جبلي يعد من اعلى المناطق السياحية في المملكة,وش اسمه؟', 'منتزه الثمامة', 'منتزه الردف', 'منتزه السودة', '3'),
(19, 10, 'القصيم تعد ابرز منطقة بالمملكة في انتاج التمور, وش اسم المهرجان السنوي الكبير الذي يقام فيها؟', 'مهرجان الجنادرية', 'مهرجان بريدة', 'مهرجان الورد', '2'),
(20, 11, 'وش نوع البيوت الي تشتهر فيه نجران؟', 'بيوت خشبية', 'بيوت طينية مزخرفة', 'بيوت زجاجية', '2'),
(21, 4, 'وش اسم المشروع الكبير اللي يهدف لتحويل المدينة المنورة الى وجهة سياحية وثقافية عالمية؟', 'مشروع ذا لاين', 'مشروع روئ المدينة', 'مشروع المربع الجديد', '2'),
(22, 3, 'وش اطول برج في مكة المكرمة ؟', 'برج الساعة', 'برج جبل عمر', 'برج رافلز', '1'),
(23, 5, 'تصف العبارة مدينة الدمام بأنها \"مهد النفط السعودي\" وش السبب؟', 'لأنها المدينة الوحيدة التي يتواجد فيها النفط في المملكة', 'لأنها تضم اكبر مصفاة نفط في العالم حالياً\r\n', 'لأنها المكان الذي بدأت منه اول عمليات تصدير النفط تاريخياً', '3');

-- --------------------------------------------------------

--
-- بنية الجدول `results`
--

CREATE TABLE `results` (
  `result_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT 0,
  `date_played` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `solved_questions`
--

CREATE TABLE `solved_questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `total_score` int(11) DEFAULT 0,
  `level` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `total_score`, `level`, `email`) VALUES
(3, 'sara11', 'SARA10100', 200, 20, 'saracc379@gmail.com'),
(6, 'ahmed', 'A12345', 0, 0, 'aa98@gmail.com'),
(7, 'abu bndr', 'abu1155', 20, 2, 'abuuu43@gmail.com'),
(9, 'Dana', 'DNO12', 10, 1, 'dno1@gmail.com'),
(10, 'reem', 'A123', 0, 0, 're1@gmail.com'),
(11, 'mohamed', 'sa1', 0, 0, 'm1@gmail.com');

-- --------------------------------------------------------

--
-- بنية الجدول `user_progress`
--

CREATE TABLE `user_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `user_progress`
--

INSERT INTO `user_progress` (`id`, `user_id`, `city_id`) VALUES
(97, 5, 1),
(98, 5, 2),
(99, 5, 3),
(120, 7, 1),
(121, 5, 4),
(122, 5, 5),
(123, 5, 6),
(124, 5, 7),
(125, 5, 8),
(126, 5, 9),
(127, 5, 10),
(128, 5, 11),
(129, 5, 12),
(130, 5, 13),
(131, 5, 14),
(132, 5, 15),
(133, 5, 16),
(134, 5, 17),
(135, 5, 18),
(136, 5, 19),
(137, 5, 20),
(181, 7, 2),
(203, 3, 1),
(204, 3, 2),
(205, 3, 3),
(207, 9, 1),
(209, 3, 4),
(210, 3, 5),
(211, 3, 6),
(212, 3, 7),
(213, 3, 8),
(214, 3, 9),
(215, 3, 10),
(216, 3, 11),
(217, 3, 12),
(218, 3, 13),
(219, 3, 14),
(220, 3, 15),
(221, 3, 16),
(222, 3, 17),
(223, 3, 18),
(224, 3, 19),
(227, 3, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `solved_questions`
--
ALTER TABLE `solved_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `solved_questions`
--
ALTER TABLE `solved_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=413;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
