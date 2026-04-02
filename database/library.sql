-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 11, 2026 at 10:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `authorID` int(11) NOT NULL,
  `authorName` varchar(100) NOT NULL,
  `author_external_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`authorID`, `authorName`, `author_external_link`) VALUES
(1, 'Fyodor Dostoevsky', 'https://en.wikipedia.org/wiki/Fyodor_Dostoevsky'),
(2, 'Jane Austen', 'https://en.wikipedia.org/wiki/Jane_Austen'),
(3, 'William Shakespeare', 'https://en.wikipedia.org/wiki/William_Shakespeare'),
(4, 'Victor Hugo', 'https://en.wikipedia.org/wiki/Victor_Hugo'),
(5, 'Ismail Kadare', 'https://en.wikipedia.org/wiki/Ismail_Kadare'),
(6, 'Ernest Hemingway', 'https://en.wikipedia.org/wiki/Ernest_Hemingway'),
(7, 'Leo Tolstoy', 'https://en.wikipedia.org/wiki/Leo_Tolstoy'),
(8, 'Dritëro Agolli', 'https://en.wikipedia.org/wiki/Drit%C3%ABro_Agolli'),
(9, 'Honoré de Balzac', 'https://en.wikipedia.org/wiki/Honor%C3%A9_de_Balzac'),
(10, 'Charlotte Brontë', 'https://en.wikipedia.org/wiki/Charlotte_Bront%C3%AB'),
(11, 'F. Scott Fitzgerald', 'https://en.wikipedia.org/wiki/F._Scott_Fitzgerald'),
(12, 'Petro Marko', 'https://sq.wikipedia.org/wiki/Petro_Marko');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookID` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover_image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bookID`, `title`, `year`, `isbn`, `description`, `cover_image_path`) VALUES
(31, 'Crime and Punishment', 1866, '978-0486415871', 'A troubled student commits a brutal crime and wrestles with guilt and morality. Dostoevsky explores conscience, redemption, and the psychology of punishment. The novel remains a cornerstone of deep character study and philosophical inquiry.', 'images/crime_punishment.jpg'),
(32, 'The Brothers Karamazov', 1880, '978-0374528379', 'A sweeping exploration of faith, doubt, and family conflict. The murder of a father brings spiritual and moral dilemmas to the forefront. Dostoevsky examines the nature of free will and the human soul.', 'images/Brothers_Karamazov.jpg'),
(33, 'The Idiot', 1869, '978-0140449129', 'Prince Myshkin returns to Russia and is seen as an \"idiot\" because of his goodness and naïveté. His innocence complicates the lives of those around him. The novel questions what it means to be truly good in a flawed society.', 'images/The_Idiot.jpg'),
(34, 'Notes from Underground', 1864, '978-0140445123', 'A bitter narrator renounces society and diaries his internal conflicts. The book is an early work of existential thought. It confronts human self-destructiveness and freedom.', 'images/Notes_from_underground.jpg'),
(35, 'Pride and Prejudice', 1813, '978-1503290563', 'A witty romantic story of Elizabeth Bennet and Mr. Darcy’s misunderstandings and eventual love. Austen critiques class and gender norms. The social dance of manners and marriage provides rich humor and insight.', 'images/Pride_and_Prejudice.jpg'),
(36, 'Sense and Sensibility', 1811, '978-0141439662', 'The Dashwood sisters navigate love, loss, and financial insecurity. Austen balances heartfelt emotion with social observation. The contrast between sense and sentiment drives the narrative.', 'images/Sense-and-Sensibility.jpg'),
(37, 'Emma', 1815, '978-0141439587', 'Emma Woodhouse meddles in matchmaking with humorous consequences. Austen explores self-awareness and empathy. The novel is celebrated for its likable, complex heroine.', 'images/Emma.jpg'),
(38, 'Hamlet', 1603, '978-0451526922', 'Prince Hamlet seeks revenge after his father’s murder. The play delves into madness, betrayal, and moral ambiguity. Shakespeare’s enduring masterpiece remains deeply influential.', 'images/Hamlet.jpg'),
(39, 'Macbeth', 1606, '978-0743477109', 'Ambition and prophecy drive Macbeth to murder. Guilt and paranoia consume him and Lady Macbeth. A chilling study of power and downfall.', 'images/Macbeth.jpg'),
(40, 'Romeo and Juliet', 1597, '978-0743477116', 'Star-crossed lovers from feuding families ignite passion and tragedy. The play examines love, fate, and youthful defiance. A timeless tale of devotion and loss.', 'images/Romeo_Juliet.jpg'),
(41, 'Othello', 1604, '978-1981021565', 'Jealousy and manipulation unravel Othello’s life and marriage. Iago’s deceit fuels devastating consequences. Shakespeare probes trust, honor, and vulnerability.', 'images/Othello.jpg'),
(42, 'Les Misérables', 1862, '978-0451419439', 'Jean Valjean seeks redemption amid revolution and social injustice in France. Hugo paints a sweeping tapestry of courage, love, and moral struggle. A searing look at humanity’s capacity for change.', 'images/Les_Miserables.jpg'),
(43, 'The Hunchback of Notre-Dame', 1831, '978-0140444300', 'Quasimodo, the deformed bellringer, loves the beautiful Esmeralda. Hugo blends tragic romance with architectural reverence. The novel champions compassion and complexity.', 'images/Hunchback_of_Notre_Dame.jpg'),
(44, 'The Man Who Laughs', 1869, '978-0140443921', 'A disfigured young man wanders a harsh world full of spectacle and pain. Hugo critiques class inequality and human cruelty. An emotionally charged, darkly poetic tale.', 'images/The_man_who_laughs.jpg'),
(45, 'Chronicle in Stone', 1971, '978-0226021126', 'A child’s memories of wartime Albania reveal political tensions. Kadare mixes myth and realism in vivid prose. A portrait of identity under upheaval.', 'images/Chronicle_in_stone.jpg'),
(46, 'The General of the Dead Army', 1963, '978-0679722987', 'An Italian general returns to Albania after WWII to recover soldiers’ remains. The search becomes surreal and haunting. Kadare explores memory, loss, and reconciliation.', 'images/general_dead_army.jpg'),
(47, 'Agamemnon’s Daughter', 2004, '978-1574981275', 'An Albanian king faces tragic fate in a retelling of Greek legend. Kadare blends history and mythology with political resonance. The novel interrogates destiny, sacrifice, and power.', 'images/Agamemnons_daughter.jpg'),
(48, 'The Old Man and the Sea', 1952, '978-0684801223', 'An aging fisherman battles a marlin far out at sea. Hemingway’s sparse style highlights perseverance and dignity. A poignant meditation on struggle and resilience.', 'images/old_man_and_the_sea.jpg'),
(49, 'A Farewell to Arms', 1929, '978-0684801469', 'An American officer and nurse fall in love in WWI Italy. Love and loss unfold against wartime chaos. Hemingway captures beauty, pain, and inevitability.', 'images/A_Farewell_to_Arms.jpg'),
(50, 'For Whom the Bell Tolls', 1940, '978-0684803357', 'Set during the Spanish Civil War, an American fights with guerrillas. Bonds, fear, and sacrifice drive the narrative. A stirring portrait of purpose and mortality.', 'images/For_whom_the_bell_tolls.jpg'),
(51, 'The Sun Also Rises', 1926, '978-0743297332', 'A group of expatriates cruise France and Spain after WWI. Their restless search for meaning reflects postwar disillusionment. Hemingway’s crisp prose captures longing and camaraderie.', 'images/sun_also_rises.jpg'),
(52, 'War and Peace', 1869, '978-0199232765', 'A vast tapestry of Russian life during the Napoleonic wars. Tolstoy interweaves personal lives with history. Love, honor, and transformation define the epic.', 'images/War_peace.jpg'),
(53, 'Anna Karenina', 1877, '978-0143035008', 'A tragic tale of love, society, and betrayal. Tolstoy contrasts passion with order, devotion with independence. The novel remains a profound psychological study.', 'images/Anna_Karenina.jpg'),
(54, 'The Death of Ivan Ilyich', 1886, '978-0199537320', 'A judge confronts mortality after a painful illness. Tolstoy probes the fear and denial of death. This short classic examines authenticity and spiritual awakening.', 'images/death_of_ivan_ilyich.jpg'),
(55, 'Splendour and Fall of Comrade Zylo', 1970, '978-9995662015', 'A satire of bureaucracy and socialist absurdity in Albania. Agolli crafts humorous yet biting social critique. The novel highlights resilience amid absurd systems.', 'images/Splendour_fall_comrade_zylo.jpg'),
(56, 'Père Goriot', 1835, '978-0140449181', 'An aging father sacrifices everything for his ungrateful daughters. Balzac portrays Parisian ambition and moral decay. A foundational work of French realism.', 'images/Pere_Goriot.jpg'),
(57, 'Eugénie Grandet', 1833, '978-0140448504', 'A young woman suffers under her miserly father. Balzac blends social critique with rich characterization. The novel captures greed, love, and restraint.', 'images/Eugenie_Grandet.jpg'),
(58, 'Lost Illusions', 1837, '978-0140447224', 'A young poet chases fame and fails in Parisian society. Balzac examines ambition and compromise. A vivid study of dreams vs. reality.', 'images/Lost_Illusion.jpg'),
(59, 'Jane Eyre', 1847, '978-0141441146', 'An orphaned governess finds love and independence. Brontë mixes passion with moral strength. Her fiery heroine defies social bounds.', 'images/Jane_Eyre.jpg'),
(60, 'The Great Gatsby', 1925, '978-0743273565', 'A millionaire, Jay Gatsby, obsessively pursues love and the American Dream. Fitzgerald portrays the glamour and emptiness of post-WWI society. The novel explores disillusionment, desire, and identity.', 'images/great_Gatsby.jpg'),
(61, 'Nata e Ustikës', 1989, '978-99956-858-1-2', 'Në romanin “Nata e Ustikës” Petro Markoja rrëfen një fragment nga betejat, burgjet, dramat dhe dashuritë e tij nëpër Evropë giatë viteve ’30 dhe ’40 të shekullit XX – pra para dhe pas Luftës së Dytë Botërore. ', 'images/nataustikes.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `booksAuthors`
--

CREATE TABLE `booksAuthors` (
  `bookID` int(11) NOT NULL,
  `authorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booksAuthors`
--

INSERT INTO `booksAuthors` (`bookID`, `authorID`) VALUES
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 2),
(36, 2),
(37, 2),
(38, 3),
(39, 3),
(40, 3),
(41, 3),
(42, 4),
(43, 4),
(44, 4),
(45, 5),
(46, 5),
(47, 5),
(48, 6),
(49, 6),
(50, 6),
(51, 6),
(52, 7),
(53, 7),
(54, 7),
(55, 8),
(56, 9),
(57, 9),
(58, 9),
(59, 10),
(60, 11),
(61, 12);

-- --------------------------------------------------------

--
-- Table structure for table `booksGenres`
--

CREATE TABLE `booksGenres` (
  `bookID` int(11) NOT NULL,
  `genreID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booksGenres`
--

INSERT INTO `booksGenres` (`bookID`, `genreID`) VALUES
(31, 1),
(31, 2),
(31, 3),
(31, 4),
(32, 2),
(32, 4),
(32, 5),
(32, 6),
(33, 1),
(33, 4),
(33, 7),
(34, 1),
(34, 4),
(34, 22),
(35, 4),
(35, 7),
(35, 8),
(36, 4),
(36, 7),
(37, 4),
(37, 7),
(37, 23),
(38, 9),
(38, 10),
(39, 9),
(39, 10),
(39, 26),
(40, 7),
(40, 9),
(41, 9),
(41, 10),
(42, 2),
(42, 10),
(42, 12),
(43, 11),
(43, 12),
(44, 2),
(44, 11),
(44, 13),
(45, 2),
(45, 12),
(46, 2),
(46, 16),
(47, 2),
(47, 24),
(47, 25),
(48, 2),
(48, 15),
(49, 7),
(49, 16),
(50, 10),
(50, 16),
(51, 2),
(51, 21),
(52, 2),
(52, 12),
(52, 17),
(53, 2),
(53, 18),
(54, 2),
(54, 5),
(55, 2),
(55, 8),
(55, 27),
(56, 13),
(56, 18),
(56, 20),
(57, 2),
(57, 18),
(58, 18),
(58, 19),
(59, 7),
(59, 11),
(60, 2),
(60, 4),
(60, 21),
(61, 12);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genreID` int(11) NOT NULL,
  `genreName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genreID`, `genreName`) VALUES
(15, 'Adventure'),
(25, 'Allegory'),
(4, 'Classic'),
(14, 'Coming-of-Age'),
(3, 'Crime'),
(10, 'Drama'),
(17, 'Epic'),
(22, 'Existential'),
(6, 'Family'),
(2, 'Fiction'),
(11, 'Gothic'),
(12, 'Historical'),
(23, 'Humor'),
(19, 'Literary'),
(21, 'Lost Generation'),
(24, 'Mythic'),
(13, 'Novel'),
(5, 'Philosophical'),
(27, 'Political'),
(1, 'Psychological'),
(18, 'Realism'),
(7, 'Romance'),
(8, 'Satire'),
(28, 'Sci-Fi'),
(20, 'Social'),
(26, 'Supernatural'),
(9, 'Tragedy'),
(16, 'War');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `bookID` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `review_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewID`, `userID`, `bookID`, `review_text`, `review_created_at`) VALUES
(1, 1, 43, 'The Hunchback of Notre Dame is a timeless masterpiece that weaves together rich, vibrant characters and breathtaking descriptions of Paris. Victor Hugo\'s storytelling is both poetic and powerful, drawing readers deep into the heart of a tragic yet beautiful tale. The characters, especially Quasimodo and Esmeralda, are unforgettable, evoking both sympathy and admiration. With its mix of romance, mystery, and social commentary, this novel is a truly captivating experience that resonates long after the final page.', '2026-01-24 23:52:07'),
(2, 2, 45, 'This novel is, at the very least, a beautiful and unusual portrayal of modern war through the eyes of a child. It contains deeper meanings and messages, most of which would not have been lost on his Albanian readers who were living under the heel of a repressive dictatorship. There is much to recommend this unusually constructed fictional history of an ancient city during times of war. It is an interesting, enjoyable, at times humorous, novel or fictionalised memoir, maybe. I have enjoyed reading it, and encourage everyone to experience it. Get the Canongate edition, if you can; the additional material that it contains is well worth reading.', '2026-01-24 23:52:07'),
(3, 3, 35, 'My first Jane Austen, and goodness gracious me! It was so delightful, my only regret is I waited so long to read it. If ever there was a book that could be a gateway drug to anything, it would be this book to Jane Austen for me. I feel like the floodgates have opened, the dam burst, the Pandora\'s box unsealed. And the only way forward is to read more Jane Austen.', '2026-01-24 23:52:07'),
(4, 1, 38, 'The first time I read this book I was in highschool. It was an 80-page book. The story was so short and simple, so I wondered \"Why so many people say this is such a complex play/book?\". A couple of years later, I bought a special edition of 592 pages: Too much? No! Why not? Because the play was written in Shakespearean English. I feel Shakespeare wanted to express himself on Hamlet. His multiple personalities during the play reminded me of Shakespeare\'s life a bit. On the other hand, I really LOVED how this play ends... What a bloody and violent ending, Terrific! Recommended? Absolutely, but a simple version, because the original might be too difficult and slow to read.', '2026-01-24 23:52:07'),
(5, 2, 57, 'Classic English literature has seen some memorable stone-hearted misers in it\'s time, but they pale in comparison to Balzac\'s provincial Midas, Monsieur Grandet, father of the long-suffering Eugénie. Money is a vast topic in literature, probably second only to love. Perhaps Balzac manages to combine both in a remarkably incisive tale pitted with tragedy. Eugénie Grandet ultimately is about unscrupulous people, and while Balzac has prepared us for Charles’s dastardly behaviour toward the fluttering Eugénie, it still comes as a shock to learn that this sweet-faced dandy, who wept over his father’s demise, makes his fortune in the slave trade. Even in 1833, decades before the American Civil War, Balzac’s damning portrait of Charles’s descent into unscrupulous selfishness is unequivocal.', '2026-01-24 23:52:07'),
(7, 22, 31, 'My favourite book! An absolute gem!', '2026-02-07 12:39:25');

-- --------------------------------------------------------

--
-- Table structure for table `userLibrary`
--

CREATE TABLE `userLibrary` (
  `user_libraryID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `bookID` int(11) NOT NULL,
  `reading_status` enum('TBR','READING','READ') NOT NULL,
  `reading_start_date` date DEFAULT NULL,
  `reading_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userLibrary`
--

INSERT INTO `userLibrary` (`user_libraryID`, `userID`, `bookID`, `reading_status`, `reading_start_date`, `reading_end_date`) VALUES
(5, 22, 31, 'READ', '2025-12-15', '2026-01-14'),
(6, 22, 53, 'TBR', NULL, NULL),
(7, 22, 58, 'READING', NULL, NULL),
(8, 4, 50, 'READING', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `fullName`, `email`, `password`, `role`) VALUES
(1, 'Jane Doe', 'janedoe@email.com', '$2y$10$5VGkvRwzvV4UFsUE3MSoOuV/jNH15PRbmtr79rjrPX0L3/PsVkaGi', 'user'),
(2, 'Alan Smith', 'alansmith@email.com', '$2y$10$94SJBk0fEFWIT0pE9LSTYeseWykQ8pey/YTAwWeVZl2LjPBgRamYu', 'user'),
(3, 'Tommy Atkins', 'tommyatkins@email.com', '$2y$10$c1gJ5Lr/4vPCiXoVgdHJwu5VFi.5ka2bfBE/8WS9LfDToQg.aBn.q', 'user'),
(4, 'Alice Evans', 'aliceevans@email.com', '$2y$10$BTuBlzKXJLe40Fhl2Ry6veZBVxyOUYWAh7F7JZwnsk2au3AJxlqCe', 'admin'),
(22, 'Joe Bloggs', 'joebloggs@email.com', '$2y$10$rdnK/nMZ2fm/1EeJpb.KxOdRs37S9krzZGa0XHquJU6ngrkUvf8vG', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`authorID`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookID`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indexes for table `booksAuthors`
--
ALTER TABLE `booksAuthors`
  ADD PRIMARY KEY (`bookID`,`authorID`),
  ADD KEY `booksAuthors_ibfk_2` (`authorID`);

--
-- Indexes for table `booksGenres`
--
ALTER TABLE `booksGenres`
  ADD PRIMARY KEY (`bookID`,`genreID`),
  ADD KEY `booksGenres_ibfk_2` (`genreID`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genreID`),
  ADD UNIQUE KEY `genreName` (`genreName`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewID`),
  ADD UNIQUE KEY `userID` (`userID`,`bookID`),
  ADD KEY `reviews_ibfk_2` (`bookID`);

--
-- Indexes for table `userLibrary`
--
ALTER TABLE `userLibrary`
  ADD PRIMARY KEY (`user_libraryID`),
  ADD UNIQUE KEY `userID` (`userID`,`bookID`),
  ADD KEY `userLibrary_ibfk_2` (`bookID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `authorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `userLibrary`
--
ALTER TABLE `userLibrary`
  MODIFY `user_libraryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booksAuthors`
--
ALTER TABLE `booksAuthors`
  ADD CONSTRAINT `booksAuthors_ibfk_1` FOREIGN KEY (`bookID`) REFERENCES `books` (`bookID`) ON DELETE CASCADE,
  ADD CONSTRAINT `booksAuthors_ibfk_2` FOREIGN KEY (`authorID`) REFERENCES `authors` (`authorID`) ON DELETE CASCADE;

--
-- Constraints for table `booksGenres`
--
ALTER TABLE `booksGenres`
  ADD CONSTRAINT `booksGenres_ibfk_1` FOREIGN KEY (`bookID`) REFERENCES `books` (`bookID`) ON DELETE CASCADE,
  ADD CONSTRAINT `booksGenres_ibfk_2` FOREIGN KEY (`genreID`) REFERENCES `genres` (`genreID`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`bookID`) REFERENCES `books` (`bookID`) ON DELETE CASCADE;

--
-- Constraints for table `userLibrary`
--
ALTER TABLE `userLibrary`
  ADD CONSTRAINT `userLibrary_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `userLibrary_ibfk_2` FOREIGN KEY (`bookID`) REFERENCES `books` (`bookID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
