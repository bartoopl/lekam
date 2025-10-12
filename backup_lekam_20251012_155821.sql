-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: localhost    Database: farmaceutyczna_platforma
-- ------------------------------------------------------
-- Server version	8.0.43-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certificates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `quiz_attempt_id` bigint unsigned DEFAULT NULL,
  `certificate_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issued_at` timestamp NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `certificates_certificate_number_unique` (`certificate_number`),
  KEY `certificates_user_id_foreign` (`user_id`),
  KEY `certificates_course_id_foreign` (`course_id`),
  KEY `certificates_quiz_attempt_id_foreign` (`quiz_attempt_id`),
  CONSTRAINT `certificates_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `certificates_quiz_attempt_id_foreign` FOREIGN KEY (`quiz_attempt_id`) REFERENCES `quiz_attempts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `certificates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificates`
--

LOCK TABLES `certificates` WRITE;
/*!40000 ALTER TABLE `certificates` DISABLE KEYS */;
/*!40000 ALTER TABLE `certificates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chapters`
--

DROP TABLE IF EXISTS `chapters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chapters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chapters_course_id_foreign` (`course_id`),
  CONSTRAINT `chapters_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chapters`
--

LOCK TABLES `chapters` WRITE;
/*!40000 ALTER TABLE `chapters` DISABLE KEYS */;
INSERT INTO `chapters` VALUES (9,5,'Tematy',NULL,1,'2025-09-23 09:32:37','2025-09-23 09:32:37'),(10,6,'Rola potasu i magnezu',NULL,1,'2025-10-10 08:34:32','2025-10-10 08:38:35');
/*!40000 ALTER TABLE `chapters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contents`
--

DROP TABLE IF EXISTS `contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `page` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contents_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contents`
--

LOCK TABLES `contents` WRITE;
/*!40000 ALTER TABLE `contents` DISABLE KEYS */;
INSERT INTO `contents` VALUES (1,'home.hero.title.desktop','Główny tytuł na desktop','Akademia LEK-AM<br>Lepsza strona farmacji','html','home','hero',1,'2025-09-25 12:00:19','2025-10-09 13:05:43'),(2,'home.hero.title.mobile','Główny tytuł na mobile','Akademia<br>LEK-AM<br>Lepsza strona farmacji','html','home','hero',1,'2025-09-25 12:00:19','2025-10-09 13:05:43'),(3,'home.hero.description','Opis w sekcji hero','<b>Witaj w serwisie dla Farmaceutów i Techników farmacji.</b> <br>Potrzeba stałego rozwoju wpisana jest w codzienną pracy w aptece. Akademia LEK-AM będzie wspierać Cię w tym procesie. Wszystko w dogodnym dla Ciebie czasie i bez wychodzenia z domu. Zarejestruj się już teraz, aby zyskać dostęp do bezpłatnych szkoleń, zdobywać punkty edukacyjne i poszerzać swoją wiedzę.','html','home','hero',1,'2025-09-25 12:00:19','2025-10-09 13:19:49'),(4,'home.about.title','Tytuł sekcji O Akademii','Wiedza i rozwój w Farmacji dostępna dla Ciebie w wygodnej formule. Zapisz się już dziś do Akademii LEK-AM','html','home','about',1,'2025-09-25 12:00:19','2025-10-09 12:55:43'),(5,'home.features.title','Tytuł sekcji Nasza idea','Nowoczesna formuła nauki','text','home','features',1,'2025-09-25 12:00:19','2025-10-09 12:55:43'),(6,'home.features.description','Opis naszej idei','Wspólnota nauki i myśli dostępna jest dziś w nowoczesnej formule. Chcemy aby Akademia LEK-AM była przestrzenią dla wszystkich, którzy chcą uczyć się w odpowiednim dla siebie czasie, miejscu i formie. W naszych szkoleniach znajdziesz wiedzę odpowiadającą wymaganiom współczesnej farmacji.','text','home','features',1,'2025-09-25 12:00:19','2025-10-09 13:03:54'),(7,'home.trainings.title','Tytuł sekcji Szkolenia','Edukacja online dla profesjonalnej opieki farmaceutycznej','html','home','trainings',1,'2025-09-25 12:00:20','2025-10-09 13:27:13'),(8,'home.trainings.description','Opis sekcji Szkolenia','W Akademii LEK-AM uczysz się wtedy, kiedy masz na to czas – bez stresujących dojazdów czy sztywnego grafiku. Wybierasz kurs, który Cię interesuje, oglądasz wykłady prowadzone przez ekspertów. Na koniec rozwiązujesz test na podstawie którego otrzymujesz certyfikat. Nasze kursy są zgodne z najnowszymi standardami i wymaganiami branży farmaceutycznej. Materiały przygotowane są przez uznanych specjalistów gwarantując wysoką wartość merytoryczną. Rozwijaj swoje kompetencje z nami i zdobywaj punkty edukacyjne.','html','home','trainings',1,'2025-09-25 12:00:20','2025-10-09 13:35:05'),(9,'courses.hero.title','Tytuł strony Szkolenia','Szkolenia','html','courses','hero',1,'2025-09-25 12:00:20','2025-10-06 16:35:16'),(10,'courses.hero.description','Opis strony Szkolenia','Akademia LEK‑AM jest przygotowana z dbałością o wartość merytoryczną. Materiały są zgodne z aktualnymi standardami i wymaganiami współczesnej farmacji. Prowadzą je renomowani wykładowcy i eksperci z wieloletnim doświadczeniem. Znajdziesz tu starannie opracowane kursy, które wspierają rozwój zawodowy Farmaceutów i Techników farmacji, łącząc rzetelną wiedzę z praktycznym podejściem do codziennej pracy.','html','courses','hero',1,'2025-09-25 12:00:20','2025-10-09 13:45:48'),(11,'contact.intro.text1','Pierwszy akapit na stronie kontakt','Masz pytania dotyczące naszych kursów? Skontaktuj się z nami, aby uzyskać szczegółowe informacje o szkoleniach, zapisach i punktach edukacyjnych.','html','contact','intro',1,'2025-09-25 12:00:20','2025-10-06 16:35:16'),(12,'contact.intro.text2','Drugi akapit na stronie kontakt','Napisz do nas jeśli chcesz, aby Twój przedstawiciel LEK-AM udzielił Ci potrzebnych informacji i wsparcia w korzystaniu z serwisu.','html','contact','intro',1,'2025-09-25 12:00:20','2025-10-09 13:50:00'),(13,'contact.lekam.title','Tytuł sekcji kontakt LEK-AM','Kontakt z LEK-AM','html','contact','lekam',1,'2025-09-25 12:00:20','2025-10-09 13:50:00'),(14,'contact.lekam.phone','Telefon LEK-AM','+48 22 635-82-17','html','contact','lekam',1,'2025-09-25 12:00:20','2025-10-09 13:50:01'),(15,'contact.lekam.email','Email LEK-AM','akademia@lekam.pl','html','contact','lekam',1,'2025-09-25 12:00:20','2025-10-09 13:50:01'),(16,'contact.support.title','Tytuł sekcji wsparcia technicznego','Wsparcie techniczne serwisu','html','contact','support',1,'2025-09-25 12:00:21','2025-10-06 16:35:16'),(17,'contact.support.email','Email wsparcia technicznego','office@creativetrust.pl','html','contact','support',1,'2025-09-25 12:00:21','2025-10-06 16:35:16'),(18,'emails.verification.subject','Temat emaila weryfikacyjnego','Potwierdź swój adres email - Akademia LEK-AM','text','emails','verification',1,'2025-09-25 13:42:37','2025-10-06 10:20:11'),(19,'emails.verification.greeting','Powitanie w emailu weryfikacyjnym','Cześć!','text','emails','verification',1,'2025-09-25 13:42:37','2025-09-25 13:42:37'),(20,'emails.verification.intro','Treść wprowadzająca email weryfikacyjny','Dziękujemy za rejestrację w Akademii LEK-AM! Aby rozpocząć naukę i zdobywać punkty edukacyjne, potwierdź swój adres email klikając poniższy przycisk.','text','emails','verification',1,'2025-09-25 13:42:37','2025-10-06 10:20:11'),(21,'emails.verification.button_text','Tekst przycisku weryfikacji','Potwierdź adres email','text','emails','verification',1,'2025-09-25 13:42:38','2025-09-25 13:42:38'),(22,'emails.verification.footer','Stopka emaila weryfikacyjnego','Jeśli nie zarejestrowałeś się w naszej akademii, zignoruj tę wiadomość.','text','emails','verification',1,'2025-09-25 13:42:38','2025-09-25 13:42:38'),(23,'emails.verification.signature','Podpis emaila weryfikacyjnego','Zespół Akademii LEK-AM','text','emails','verification',1,'2025-09-25 13:42:38','2025-10-06 10:20:11'),(24,'emails.reset_password.subject','Temat emaila resetowania hasła','Resetowanie hasła - Akademia LEK-AM','text','emails','reset_password',1,'2025-09-25 13:42:38','2025-10-06 10:20:10'),(25,'emails.reset_password.greeting','Powitanie w emailu resetowania hasła','Cześć!','text','emails','reset_password',1,'2025-09-25 13:42:38','2025-09-25 13:42:38'),(26,'emails.reset_password.intro','Treść wprowadzająca email resetowania hasła','Otrzymujesz ten email, ponieważ otrzymaliśmy prośbę o zresetowanie hasła dla Twojego konta w Akademii LEK-AM.','text','emails','reset_password',1,'2025-09-25 13:42:38','2025-10-06 10:20:10'),(27,'emails.reset_password.button_text','Tekst przycisku resetowania','Resetuj hasło','text','emails','reset_password',1,'2025-09-25 13:42:38','2025-09-25 13:42:38'),(28,'emails.reset_password.expiry_info','Informacja o wygaśnięciu linku','Ten link wygaśnie za :count minut.','text','emails','reset_password',1,'2025-09-25 13:42:38','2025-09-25 13:42:38'),(29,'emails.reset_password.footer','Stopka emaila resetowania hasła','Jeśli nie prosiłeś o zresetowanie hasła, zignoruj tę wiadomość.','text','emails','reset_password',1,'2025-09-25 13:42:38','2025-09-25 13:42:38'),(30,'emails.reset_password.signature','Podpis emaila resetowania hasła','Zespół Akademii LEK-AM','text','emails','reset_password',1,'2025-09-25 13:42:38','2025-10-06 10:20:11'),(31,'home.features.feature1.title','Tytuł pierwszej cechy (Z potrzeby)','Wiedza praktyczna dla Ciebie','html','home','features',1,'2025-10-06 16:35:15','2025-10-09 12:49:07'),(32,'home.features.feature1.description','Opis pierwszej cechy','<b>Akademia LEK-AM</b> powstałą z myślą o dostrzeganych potrzebach codziennej pracy Farmaceutów i Techników farmacji. Pragniemy odpowiedzieć na wyzwania zawodowe, które wymagają nieustannego rozwoju oraz dostępu do najnowszej wiedzy praktycznej .','html','home','features',1,'2025-10-06 16:35:15','2025-10-09 12:49:51'),(33,'home.features.feature2.title','Tytuł drugiej cechy (Wiedza)','Wsparcie Twojego rozwoju','html','home','features',1,'2025-10-06 16:35:15','2025-10-09 12:53:56'),(34,'home.features.feature2.description','Opis drugiej cechy','LEK-AM od lat wspiera środowisko medyczne, dostarczając rzetelną wiedzę oraz praktyczne narzędzia do rozwoju. Akademia to przestrzeń stworzona przez ekspertów z myślą o zawodowym kształceniu na najwyższym poziomie. Dołącz do nas i przekonaj się, że warto razem z nami inwestować w swój rozwój.','html','home','features',1,'2025-10-06 16:35:15','2025-10-09 12:53:56'),(35,'home.features.feature3.title','Tytuł trzeciej cechy (Nasza idea)','Nowoczesna formuła nauki','html','home','features',1,'2025-10-06 16:35:15','2025-10-09 13:06:30'),(36,'home.features.feature3.description','Opis trzeciej cechy (Nasza idea)','Wspólnota nauki i myśli dostępna jest dziś w nowoczesnej formule. Chcemy aby Akademia LEK-AM była przestrzenią dla wszystkich, którzy chcą uczyć się w odpowiednim dla siebie czasie, miejscu i formie. W naszych szkoleniach znajdziesz wiedzę odpowiadającą wymaganiom współczesnej farmacji.','html','home','features',1,'2025-10-06 16:35:15','2025-10-09 13:06:30');
/*!40000 ALTER TABLE `contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `difficulty` enum('podstawowy','średni','zaawansowany') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'podstawowy',
  `duration_minutes` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `requires_sequential_lessons` tinyint(1) NOT NULL DEFAULT '0',
  `pharmacist_points` int NOT NULL DEFAULT '0',
  `technician_points` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `certificate_header` text COLLATE utf8mb4_unicode_ci,
  `certificate_footer` text COLLATE utf8mb4_unicode_ci,
  `instructor_id` bigint unsigned DEFAULT NULL,
  `has_instruction` tinyint(1) NOT NULL DEFAULT '0',
  `instruction_content` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `courses_instructor_id_foreign` (`instructor_id`),
  CONSTRAINT `courses_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (5,'Komunikacja i informacja o leku w pracy Aptekarza - wybrane aspekty teoretyczne i praktyczne','Skuteczna komunikacja i rzetelna informacja o leku to podstawa profesjonalnej obsługi pacjenta. Szkolenie łączy najważniejsze założenia teoretyczne z praktyką, pokazując, jak mówić merytorycznie, ale w sposób zrozumiały dla pacjenta. Kurs uczy jak w sposób precyzyjny, spójny i zrozumiały informować o lekach, jak unikać nieporozumień i poprawić jakość kontaktu z pacjentem. \r\nPunkty twarde  za skończony kurs przyznaje Studium Kształcenia Podyplomowego Wydziału Farmaceutycznego Gdańskiego Uniwersytetu Medycznego.','courses/thumbnails/HdDAh6aEsHLdhQ5u7QsW2dgPQd7sbhiSbFkXsyqs.png','podstawowy',120,1,0,18,9,'2025-09-23 09:32:18','2025-10-10 09:10:42',NULL,NULL,NULL,1,'Kurs składa się z kilku lekcji, każda lekcja to oddzielny wykład.\r\n1. Rozpocznij kurs od Wykładu pierwszego\r\n2. Lekcje pomiędzy pierwszym a ostatnim wykładem możesz oglądać w dowolnej kolejności\r\n3. Zakończ część wideo, oglądając ostatni wykład\r\n4. Warunek zaliczenia części wideo: obejrzenie wszystkich lekcji\r\n5. Po obejrzeniu materiału wideo przystąp do testu wiedzy\r\n6. System wylosuje 18 pytań, aby zaliczyć test musisz odpowiedzieć na co najmniej 14 z nich\r\n7. W przypadku niezaliczenia testu za pierwszym razem, wylosuj ponownie zestaw pytań\r\n8. Po zaliczeniu testu kurs zostaje zakończony\r\n9. Pobierz certyfikat uczestnictwa potwierdzający zdobycie punktów edukacyjnych'),(6,'Rola suplementacji potasu i magnezu w prewencji rozwoju chorób cywilizacyjnych','Ze względu na uniwersalność swoich funkcji i udział w wielu przemianach metabolicznych magnez można uznać za główny kation w organizmie człowieka. Równie istotna jest rola głównego jonu wewnątrz komórkowego – potasu, który działa synergistycznie z magnezem, szczególnie wpływając na funkcjonowanie układu sercowo-naczyniowego.\r\nNa świecie notuje się niedostateczne spożycie magnezu i potasu przez populację. W związku z tym obok optymalizacji diety zalecane jest wzbogacanie jej magnezem i potasem za pomocą specjalistycznych produktów spożywczych i suplementów diety.','courses/thumbnails/LIMtHrSmvea2BfMVkRXr9mhVq1AJVv2doqZ272Fq.jpg','podstawowy',60,1,1,0,0,'2025-10-10 08:33:06','2025-10-10 08:52:36',NULL,NULL,NULL,0,NULL);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructors`
--

DROP TABLE IF EXISTS `instructors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `instructors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `specialization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `instructors_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructors`
--

LOCK TABLES `instructors` WRITE;
/*!40000 ALTER TABLE `instructors` DISABLE KEYS */;
INSERT INTO `instructors` VALUES (1,'Robert Słowik','robert@test.pl','Biografia Roberta','Specjalista farmacji',NULL,1,'2025-08-12 21:39:06','2025-08-12 21:39:06'),(3,'Alicja Telecka',NULL,NULL,'Senior Brand Manager & Innovation - LEK-AM',NULL,1,'2025-09-02 09:07:56','2025-09-24 10:45:31'),(4,'LEKAM',NULL,NULL,'LEKAM',NULL,1,'2025-09-02 09:30:05','2025-09-24 09:21:39'),(5,'Magdalena Stolarczyk',NULL,NULL,NULL,NULL,1,'2025-09-02 09:31:49','2025-09-02 09:31:49'),(6,'Artur Mamcarz',NULL,NULL,'Prof. dr hab. n. med. - Kierownik III Kliniki Chorób Wewnętrznych i Kardiologii Wydziału Lekarskiego WUM',NULL,1,'2025-09-02 09:32:50','2025-09-24 11:06:52'),(7,'Michał Rabijewski',NULL,NULL,NULL,NULL,1,'2025-09-02 09:35:29','2025-09-02 09:35:29'),(8,'Waldemar Misiorowski',NULL,NULL,NULL,NULL,1,'2025-09-24 08:53:51','2025-09-24 08:53:51'),(9,'Joanna Misiorowska- Witwicka',NULL,NULL,'Dr n. med.',NULL,1,'2025-09-24 08:57:47','2025-09-24 11:02:34'),(10,'Marcin Grabowski',NULL,NULL,NULL,NULL,1,'2025-09-24 09:00:29','2025-09-24 09:00:29'),(11,'Adam Wichniak',NULL,NULL,'Dr hab. med. - Profesor w Klinice Endokrynologii CMPK',NULL,1,'2025-09-24 09:03:20','2025-09-24 10:48:12'),(12,'Dr. n. med. Joanna Stanisz-Kempa',NULL,NULL,NULL,NULL,1,'2025-10-10 08:39:46','2025-10-10 08:39:46');
/*!40000 ALTER TABLE `instructors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lessons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_required` tinyint(1) NOT NULL DEFAULT '1',
  `requires_file_download` tinyint(1) NOT NULL DEFAULT '0',
  `download_wait_minutes` int NOT NULL DEFAULT '0',
  `is_first_lesson` tinyint(1) NOT NULL DEFAULT '0',
  `is_last_lesson` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `instructor_id` bigint unsigned DEFAULT NULL,
  `downloadable_materials` json DEFAULT NULL,
  `download_timer_minutes` int NOT NULL DEFAULT '0',
  `requires_download_completion` tinyint(1) NOT NULL DEFAULT '0',
  `chapter_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lessons_course_id_foreign` (`course_id`),
  KEY `lessons_instructor_id_foreign` (`instructor_id`),
  KEY `lessons_chapter_id_foreign` (`chapter_id`),
  CONSTRAINT `lessons_chapter_id_foreign` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lessons_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lessons_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES (30,5,'Adherencja a pacjent czyli o współpracy','Opis','https://lekam.grupaneoart.pl/Video/LEKAM01/05_Lekam_Komunikacja_Artur_Mamcarz.mp4',NULL,NULL,2,1,0,0,1,0,'2025-09-23 09:37:26','2025-10-10 08:45:45',6,'[]',0,0,9),(31,5,'Przewaga terapii skojarzonej magnezu z witaminą B6 nad suplementacją samym magnezem','Opis','https://lekam.grupaneoart.pl/Video/LEKAM01/06_Lekam_Magnez_Artur_Mamcarz.mp4',NULL,NULL,3,1,0,0,0,0,'2025-09-23 09:39:39','2025-09-23 09:39:39',6,'[]',0,0,9),(32,5,'Wsparcie hormonalne w okresie okołomenopauzalnym i andropauzalnym - rola DHEA w organizmie i możliwości suplementacji','Opis','https://lekam.grupaneoart.pl/Video/LEKAM01/08_Lekam_DHEA_Michal_Rabijewski.mp4',NULL,NULL,4,1,0,0,0,0,'2025-09-24 08:51:24','2025-09-24 08:51:24',7,'[]',0,0,9),(33,5,'Biosteron','.','https://lekam.grupaneoart.pl/Video/LEKAM01/03_Lekam_Biosteron.mp4',NULL,NULL,5,1,0,0,0,0,'2025-09-24 08:52:32','2025-09-24 08:52:32',4,'[]',0,0,9),(34,5,'Suplementacja witaminy D w prewencji i leczeniu osteoporozy','.','https://lekam.grupaneoart.pl/Video/LEKAM01/WYKLAD1.mp4',NULL,NULL,6,1,0,0,0,0,'2025-09-24 08:56:39','2025-09-24 08:56:39',8,'[]',0,0,9),(35,5,'Rola farmaceuty w uświadamianiu pacjentów o przyczynach i skutkach niedoboru żelaza','.','https://lekam.grupaneoart.pl/Video/LEKAM01/WYKLAD2.mp4',NULL,NULL,7,1,0,0,0,0,'2025-09-24 08:58:54','2025-09-24 08:58:54',9,'[]',0,0,9),(36,5,'Znaczenie suplementacji potasu dla organizmu człowieka','.','https://lekam.grupaneoart.pl/Video/LEKAM01/video1201523540.mp4',NULL,NULL,8,1,0,0,0,0,'2025-09-24 09:01:59','2025-09-24 09:01:59',10,'[]',0,0,9),(37,5,'Zastosowanie melatoniny egzogennej w leczeniu zaburzeń snu','.','https://lekam.grupaneoart.pl/Video/LEKAM01/video1201523540.mp4',NULL,NULL,9,1,0,0,0,0,'2025-09-24 09:04:19','2025-09-24 09:04:19',11,'[]',0,0,9),(38,5,'Postępowanie z pacjentem po 55 roku życia zgłaszającym bezsenność','.','https://lekam.grupaneoart.pl/Video/LEKAM01/Melatonina_e_learning_cz_1.mp4',NULL,NULL,10,1,0,0,0,0,'2025-09-24 09:05:52','2025-09-24 10:36:51',11,'[]',0,0,9),(40,5,'Zakończenie kursu','.','https://lekam.grupaneoart.pl/Video/LEKAM01/07_Lekam_Magnez_Artur_Mamcarz_Podsumowanie.mp4',NULL,NULL,11,1,0,0,0,1,'2025-09-25 08:33:54','2025-09-25 08:33:54',6,'[]',0,0,9),(41,5,'Komunikacja na linii lekarz-farmaceuta-pacjent','opis','https://lekam.grupaneoart.pl/Video/LEKAM01/10_Lekam_Komunikacja_Magdalena_Stolarczyk.mp4',NULL,NULL,10,1,0,0,0,0,'2025-10-07 07:38:06','2025-10-07 07:44:19',5,'[]',0,0,9),(42,6,'e-Reprint','Ze względu na uniwersalność swoich funkcji i udział w wielu przemianach metabolicznych magnez można uznać za główny kation w organizmie człowieka.\r\nRównie istotna jest rola głównego jonu wewnątrz komórkowego – potasu, który działa synergistycznie z magnezem, szczególnie wpływając na funkcjonowanie układu sercowo-naczyniowego.\r\nNa świecie notuje się niedostateczne spożycie magnezu i potasu przez populację. W związku z tym obok optymalizacji diety zalecane jest wzbogacanie jej magnezem i potasem za pomocą specjalistycznych produktów spożywczych i suplementów diety.',NULL,NULL,NULL,1,1,0,0,0,0,'2025-10-10 08:36:37','2025-10-10 08:41:04',12,'[{\"file\": \"lessons/materials/1760085397_68e8c595cc740.pdf\", \"name\": \"eReprint\", \"size\": 4538471, \"type\": \"application/pdf\", \"extension\": \"pdf\", \"original_name\": \"ePRINT_POTAS-MAGNEZ_STANISZ-KEMPA.pdf\"}]',0,1,10);
/*!40000 ALTER TABLE `lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_08_08_134102_add_user_type_to_users_table',1),(5,'2025_08_08_134116_create_courses_table',1),(6,'2025_08_08_134129_create_lessons_table',1),(7,'2025_08_08_134141_create_user_progress_table',1),(8,'2025_08_08_134155_create_quizzes_table',1),(9,'2025_08_08_134207_create_quiz_questions_table',1),(10,'2025_08_08_134219_create_quiz_attempts_table',1),(11,'2025_08_08_134232_create_certificates_table',1),(12,'2025_08_08_140733_create_personal_access_tokens_table',1),(13,'2025_08_08_155315_add_video_file_to_lessons_table',1),(14,'2025_08_08_170000_create_instructors_table',1),(15,'2025_08_08_170100_add_instructor_id_to_lessons_table',1),(16,'2025_08_08_170200_add_downloadable_materials_to_lessons_table',1),(17,'2025_08_08_173000_add_points_to_courses_table',1),(18,'2025_08_08_173100_add_earned_points_to_quiz_attempts_table',1),(19,'2025_08_08_185412_add_video_position_to_user_progress_table',1),(20,'2025_08_08_205156_add_pharmacy_fields_to_users_table',1),(21,'2025_08_08_211746_create_chapters_table',1),(22,'2025_08_08_211821_add_chapter_id_to_lessons_table',1),(23,'2025_08_10_194216_add_certificate_fields_to_courses_table',1),(24,'2025_08_12_073212_fix_courses_difficulty_column',1),(25,'2025_08_12_213525_add_instructor_id_to_courses_table',2),(26,'2025_08_14_112924_create_representatives_table',3),(27,'2025_08_14_112939_add_representative_id_to_users_table',3),(28,'2025_08_20_205236_fix_download_timer_for_download_lessons',3),(29,'2025_09_02_110311_make_email_nullable_in_instructors_table',4),(30,'2025_09_17_000000_add_is_admin_to_users_table',5),(31,'2025_09_24_124659_add_instruction_fields_to_courses_table',6),(32,'2025_09_25_133320_create_contents_table',7),(33,'2025_10_07_000000_add_consent_fields_to_users_table',8),(34,'2025_10_08_101758_add_questions_to_draw_to_quizzes_table',9),(35,'2025_10_08_102027_add_selected_questions_to_quiz_attempts_table',9),(36,'2025_10_08_102351_add_correct_answers_count_to_quiz_attempts_table',10),(37,'2025_10_08_112340_make_description_nullable_in_quizzes_table',11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('bartosz.lysniewski@gmail.com','$2y$12$QaTVkNMqXRSr2Kd9e2Zz/eaXntgTL3nZ/tmvIrP0dF33X2cUum47a','2025-09-16 17:53:36'),('bartosz@creativetrust.pl','$2y$12$/KC7hau.TODHVHNPHaHWGOB9GMhs5FDSFC42rkbszkSnU.mc1zcDC','2025-09-24 18:42:50');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_attempts`
--

DROP TABLE IF EXISTS `quiz_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz_attempts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `quiz_id` bigint unsigned NOT NULL,
  `score` int NOT NULL DEFAULT '0',
  `correct_answers_count` int DEFAULT NULL,
  `max_score` int NOT NULL DEFAULT '0',
  `percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `passed` tinyint(1) NOT NULL DEFAULT '0',
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `answers` json DEFAULT NULL,
  `selected_question_ids` json DEFAULT NULL,
  `earned_points` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_attempts_user_id_foreign` (`user_id`),
  KEY `quiz_attempts_quiz_id_foreign` (`quiz_id`),
  CONSTRAINT `quiz_attempts_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quiz_attempts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_attempts`
--

LOCK TABLES `quiz_attempts` WRITE;
/*!40000 ALTER TABLE `quiz_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_questions`
--

DROP TABLE IF EXISTS `quiz_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz_questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` bigint unsigned NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('single_choice','multiple_choice','true_false') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'single_choice',
  `options` json NOT NULL,
  `correct_answers` json NOT NULL,
  `points` int NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_questions_quiz_id_foreign` (`quiz_id`),
  CONSTRAINT `quiz_questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_questions`
--

LOCK TABLES `quiz_questions` WRITE;
/*!40000 ALTER TABLE `quiz_questions` DISABLE KEYS */;
INSERT INTO `quiz_questions` VALUES (6,4,'Adherencja terapeutyczna','single_choice','[\"Ułatwia osiąganie celów terapeutycznych\", \"Opisuje zakres zalecanych badań diagnostycznych\", \"Odnosi się wyłącznie do postępowania niefarmakologicznego\", \"Wszystkie prawidłowe\"]','[\"0\"]',1,1,'2025-10-08 09:26:15','2025-10-08 09:26:15'),(7,4,'Ograniczenia dotyczące  przewlekłej farmakoterapii są związane z:','single_choice','[\"Skomplikowanym sposobem dawkowania\", \"Kosztem leczenia\", \"Działaniami niepożądanymi\", \"Wszystkie prawidłowe\"]','[\"3\"]',1,2,'2025-10-08 09:34:07','2025-10-08 09:34:07'),(8,4,'Które z chorób przewlekłych wymagają rozmowy z pacjentem na temat farmakoterapii  zarówno w gabinecie lekarskim, jak i w aptece:','single_choice','[\"Nadciśnienie tętnicze\", \"Hipercholesterolemia\", \"Przewlekła niewydolność serca\", \"Wszystkie powyższe\"]','[\"3\"]',1,3,'2025-10-08 09:35:02','2025-10-08 09:35:02'),(9,4,'Zakres współpracy pacjenta z lekarzem i farmaceutą najlepiej opisuje określenie:','single_choice','[\"Compliance\", \"Adherence\", \"Concordance\", \"Persistance\"]','[\"2\"]',1,4,'2025-10-08 09:36:33','2025-10-08 09:36:33'),(10,4,'Prawdziwe stwierdzenia dotyczące magnezu to:','single_choice','[\"Jest najważniejszym katalizatorem w wytwarzaniu ATP (energii komórkowej)\", \"Łagodzi stres psychologiczny działając jako antagonista wapnia oraz przez blokowanie receptora beta-adrenergicznego\", \"Jest modulatorem pompy sodowej - zapobiega zatrzymywaniu wody w organizmie\", \"Wszystkie prawdziwe\"]','[\"3\"]',1,5,'2025-10-08 09:37:24','2025-10-08 09:37:24'),(11,4,'Magnez łagodzi stres poprzez:','single_choice','[\"Zapobieganie kumulacji metali ciężkich\", \"Zapobieganie granulacji mastocytów, procesowi, w którym pośredniczy również̇ wapń́ (działanie przeciwhistaminowe),\", \"Regulację aktywności limfocytowej (działanie „przeciwzapalne”)\", \"Wszystkie te mechanizmy\"]','[\"3\"]',1,6,'2025-10-08 09:38:25','2025-10-08 09:38:25'),(12,4,'Magnez w połączeniu z witaminą B6:','single_choice','[\"wchłania się lepiej\", \"wchłania się gorzej\", \"nie ma to znaczenia\", \"to zależy od dodatku żelaza\"]','[\"0\"]',1,7,'2025-10-08 09:39:05','2025-10-08 09:39:05'),(13,4,'Dobowe zapotrzebowanie na magnez to:','single_choice','[\"około 50 mg\", \"około200 mg\", \"około 400 mg\", \"około 1000 mg\"]','[\"2\"]',1,8,'2025-10-08 09:39:53','2025-10-08 09:39:53'),(14,4,'Melatonina:','single_choice','[\"jest lekiem bezpiecznym, nie obserwuje się w praktyce istotnych klinicznie interakcji melatoniny z innymi lekami\", \"powoduje uzależnienie organizmu\", \"wykazuje działanie sedatywne\", \"wykazuje działanie cholinolityczne\"]','[\"0\"]',1,9,'2025-10-08 09:41:04','2025-10-08 09:41:04'),(15,4,'Kiedy stosować 5 mg melatoniny w przypadku problemów z zasypianiem u pacjentów po 55 r.ż.?','single_choice','[\"na 2 h przed planowanym snem\", \"na 1 h przed planowanym snem\", \"w momencie planowanego zasypiania\", \"na 3 godziny przez planowanym snem\"]','[\"1\"]',1,10,'2025-10-08 09:42:43','2025-10-08 09:42:43'),(16,4,'Kiedy stosować 5 mg melatoniny w przypadku problemów ze złą jakością snu u pacjentów po 55 r.ż.?','single_choice','[\"na 2 h przed planowanym snem\", \"na 1 h przed planowanym snem\", \"w momencie planowanego zasypiania\", \"na 3 godziny przez planowanym snem\"]','[\"2\"]',1,11,'2025-10-08 09:44:35','2025-10-08 09:44:35'),(17,4,'Jak kształtowany jest silny rytm okołodobowy?','single_choice','[\"Regularne pory wstawania i pory snu\", \"Przebywanie w ciągu dnia w świetle słonecznym\", \"Unikanie światła wieczorem\", \"Wszystkie odpowiedzi są prawidłowe\"]','[\"3\"]',1,12,'2025-10-08 09:46:49','2025-10-08 09:46:49'),(18,4,'Schorzenie, których dotyczy tzw. „epidemia Niedoboru Witaminy D3 (NWD)” to','single_choice','[\"Stwardnienie rozsiane MS\", \"Krzywica u dzieci oraz osteoporoza po menopauzie\", \"Niski wzrost u dzieci\", \"Hipercholesterolemia\"]','[\"1\"]',1,13,'2025-10-08 09:57:27','2025-10-08 09:57:27'),(19,4,'Jakie dawki witaminy D3 są rekomendowane profilaktycznie wszystkim osobom dorosłym z niewystarczającą ekspozycją na słońce ?','single_choice','[\"14 000 j.m. w ciągu tygodnia kuracji\", \"3000 j.m. w ciągu tygodnia kuracji\", \"3000 j.m. raz na 2 tygodnie\", \"200 j.m. codziennie\"]','[\"0\"]',1,14,'2025-10-08 09:58:27','2025-10-08 09:58:27'),(20,4,'15.	Jaką dawkę profilaktyczną witaminy D3rekomenduje się osobom z otyłością ?','single_choice','[\"400 – 600 j.m. codziennie\", \"30 000 j.m. raz na 2 tygodnie kuracji\", \"30 000 j.m. w ciągu tygodnia kuracji\", \"4 000- 6 000j.m. raz na 2 tygodnie\"]','[\"2\"]',1,15,'2025-10-08 09:59:18','2025-10-08 09:59:18'),(21,4,'Do plejotropowych działań witaminy D3 nie należy','single_choice','[\"Wpływ na układ odpornościowy\", \"Wpływ na metabolizm glukozy\", \"Działanie nefroprotekcyjne\", \"Działanie tyreotropowe\"]','[\"3\"]',1,16,'2025-10-08 10:00:17','2025-10-08 10:00:17'),(22,4,'18.	Jakie białko oznacza się w kierunku diagnozy niedoboru żelaza ?','single_choice','[\"CRP\", \"Hepcydyna\", \"Albumina\", \"Ferrytyna\"]','[\"3\"]',1,17,'2025-10-08 10:01:40','2025-10-08 10:01:40'),(23,4,'19.	Jakie zalety wykazuje związek  chelatu żelaza w porównaniu z solami żelaza dwuwartościowego ?','single_choice','[\"Wyższa biodostępność, lepsza tolerancja organizmu\", \"Nie ma zalet\", \"Można je przyjmować raz w tygodniu\", \"Można je podawać także niemowlętom.\"]','[\"0\"]',1,18,'2025-10-08 10:02:35','2025-10-08 10:02:35'),(24,4,'Jakim pacjentom szczególnie można rekomendować podawanie formy chelatu żelaza ?','single_choice','[\"Nie przyjmującym IPP\", \"U osób z wrażliwym przewodem pokarmowym po epizodach złej tolerancji np. soli żelaza\", \"U osób z dietą ubogą w błonnik i inne związki roślinne (fityniany, polifenole)\", \"U osób, które dodatkowo suplementują magnez.\"]','[\"1\"]',1,19,'2025-10-08 10:03:54','2025-10-08 10:03:54');
/*!40000 ALTER TABLE `quiz_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quizzes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `time_limit_minutes` int DEFAULT NULL,
  `passing_score` int NOT NULL DEFAULT '70',
  `questions_to_draw` int DEFAULT NULL,
  `min_correct_answers` int DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quizzes_course_id_foreign` (`course_id`),
  CONSTRAINT `quizzes_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quizzes`
--

LOCK TABLES `quizzes` WRITE;
/*!40000 ALTER TABLE `quizzes` DISABLE KEYS */;
INSERT INTO `quizzes` VALUES (4,5,'Test końcowy',NULL,120,70,18,13,1,'2025-10-08 09:24:42','2025-10-08 09:24:42');
/*!40000 ALTER TABLE `quizzes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `representatives`
--

DROP TABLE IF EXISTS `representatives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `representatives` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `representatives_email_unique` (`email`),
  UNIQUE KEY `representatives_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `representatives`
--

LOCK TABLES `representatives` WRITE;
/*!40000 ALTER TABLE `representatives` DISABLE KEYS */;
INSERT INTO `representatives` VALUES (4,'Stanisław Bot','stanislawbot@lekam.pl','+48664788690','0Ru0EBV8',1,'2025-10-07 13:05:45','2025-10-07 13:05:45'),(5,'Radosław Cyranek','radoslawcyranek@lekam.pl','+48664788674','SQ4v3Ssh',1,'2025-10-07 13:08:54','2025-10-07 13:08:54'),(6,'Łukasz Czyżewski','lukaszczyzewski@lekam.pl','+48662066739','u3lxlbB7',1,'2025-10-07 13:40:56','2025-10-07 13:40:56'),(7,'Waldemar Kida','waldemarkida@lekam.pl','+48694445587','lIEgzwnS',1,'2025-10-07 13:41:51','2025-10-07 13:41:51'),(8,'Krzysztof Woźniak','krzysztofwozniak@lekam.pl','+48604119796','xmHtMjB1',1,'2025-10-07 13:42:46','2025-10-07 13:42:46'),(9,'Artur Zachar','arturzachar@lekam.pl','+48664788652','YmZ13ALz',1,'2025-10-07 13:43:39','2025-10-07 13:43:39'),(10,'Maciej Podejko','maciejpodejko@lekam.pl','+48664788680','iGqkSthI',1,'2025-10-07 13:44:27','2025-10-07 13:44:27'),(11,'Daniel Lemański','daniellemanski@lekam.pl','+48662049453','av0S7Mj1',1,'2025-10-07 13:45:34','2025-10-07 13:45:34'),(12,'Agnieszka Marchwińska','agnieszkamarchwinska@lekam.pl','+48662049457','unlw1oUJ',1,'2025-10-07 13:46:41','2025-10-07 13:46:41'),(13,'Marcin Domagała','marcindomagala@lekam.pl','+48662155301','l0IBE66Z',1,'2025-10-07 13:47:29','2025-10-07 13:47:29');
/*!40000 ALTER TABLE `representatives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('8JUEP9yU1o1pJBCMGvygRq9VhwBMQHgNgt0eA1Eq',NULL,'206.189.44.16','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTVlFWVdPeGdzNjY0QWt2anlJemk4YnE1N1ZxeGRWUlJTbFJtb1JsWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9ha2FkZW1pYWxla2FtLnBsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760196816),('9IYGIVL1G0nFr8SDO02Sd66vSZEMEIJvjGkt7iMz',NULL,'93.159.230.85','Mozilla/5.0 (Linux; arm_64; Android 12; CPH2205) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 YaBrowser/23.3.3.86.00 SA/3 Mobile Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiY2R5S2tUQ1p5RFR1SzlGQk5DVm51YXI0Wnd6NWF3bkxoc2tnVFl6YSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWthZGVtaWFsZWthbS5wbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760189666),('APgAREW4oENNXQmC2JWUIb0TIU1HJ3XxTHFd6lDA',NULL,'46.205.195.4','Mozilla/5.0 (iPhone; CPU iPhone OS 18_6_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/140.0.7339.101 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoia2t1VnozdUQxbncxTkM2ZHM0a0lYdndnZlY2UVFMYWdldUs3TERzUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWthZGVtaWFsZWthbS5wbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760219198),('FeYbQVlRZb7uxsGJtYEdi19QmPzz8w5VWhd5dtfg',NULL,'74.125.216.1','Mozilla/5.0 (compatible; Google-Test;)','YTozOntzOjY6Il90b2tlbiI7czo0MDoic0J0UjZ6amZLb29QeGROZXdxeWo1aG9sdzNUNmlJa1dRRGZZTFZXOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9ha2FkZW1pYWxla2FtLnBsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760227205),('FwYFlR9ZpckAictmTOlf5vRwWKdmEoqBmm8SvHye',NULL,'188.33.42.70','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_1) AppleWebKit/601.2.4 (KHTML, like Gecko) Version/9.0.1 Safari/601.2.4 facebookexternalhit/1.1 Facebot Twitterbot/1.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidURDVmhXWm5rM3dTM3c3TFFJSEZSTWRNQzdIc0M4MGdxWkxaZmNRSiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NzoiaHR0cDovL2xla2FtLnRvamVzdC5kZXYvYWRtaW4vcmVwcmVzZW50YXRpdmVzLzEiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyOToiaHR0cDovL2xla2FtLnRvamVzdC5kZXYvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1760172006),('I1xnJ6U4EB2ps4hLFih14p54rQLhxQtvEUFZgRy4',NULL,'35.195.101.71','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSTRnQjJBczllRjZYbWVDVXQ1cDJGZ1JTZ1ZKSTcwdmYybVFWcDRYSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9ha2FkZW1pYWxla2FtLnBsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760250157),('j6BPMhUU97rDOqxoJ9eU9FjuvaPGMpuBqvb0nRNC',NULL,'95.160.157.153','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_1) AppleWebKit/601.2.4 (KHTML, like Gecko) Version/9.0.1 Safari/601.2.4 facebookexternalhit/1.1 Facebot Twitterbot/1.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOTRYVUVnbkx5MzNGcTZMdmlNS0cxMllhSUZmZG84aHlFb1NJV2EyMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWthZGVtaWFsZWthbS5wbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760191779),('JK59O7pSp65EYC9WEpfMlDllymZUthnRJzGkA2KR',NULL,'35.189.196.16','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXpNa3ViOGtCbUhEZ3l6QzJrQjFrZkR1bTY4NDA2UTJOZGRqWUc2aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWthZGVtaWFsZWthbS5wbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760250158),('Mg50hyQThTklMzU8AdyGynfgOOglkuz0iEcbDnTp',NULL,'206.168.34.217','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXhiUFZEZWl0OEhsMjhGa1B6TUYwYlREbklKYk1hRjlmN056WFVCdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9ha2FkZW1pYWxla2FtLnBsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760193934),('MlQq0zmLGxLROmMSblSfGoqwebbjjASb5l7ElJjl',NULL,'198.235.24.128','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUxqbk55SlBXN0RNclEzbE5DSkFteFJHNGFiQnpUOThueUVoRzI4eSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWthZGVtaWFsZWthbS5wbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760234326),('TnscezK3qtSRrTvZ1wLwaYO7AydplrmEoP7HJnG1',NULL,'169.150.203.245','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVFVDV2JFOEQ5YmRadFNuY2U2bnp5ZWZyVGhHTTZlYVZOamtFQ3J6dSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9ha2FkZW1pYWxla2FtLnBsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760260713),('tPJHzGOI5jYMYCAlYvgFhi3mupsBV8Fly0Ci1wE6',NULL,'34.38.132.164','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaHNJZWVpN084b290ME5qSE5RZGdWdEQ4azNVVm96RkkyaVVBUVdSTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWthZGVtaWFsZWthbS5wbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760250158),('uKioJ33WeDL1Eal7Ni2XhitA0qkijtroWsIzPl21',NULL,'2a01:4f8:c012:8ba::1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGJnSnIwaVF2VzJ5aHZFZG5rc0dPakRtcTByRm90bDUxd3RKdm13RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9sZWthbS50b2plc3QuZGV2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760237129),('uSl8cgucqiOZMSKFvdFyrsZDl5KHzhut4KZh6rNI',NULL,'209.38.140.63','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUkZ3MXFFYk5kSkx0eVlvUlAzQ01JNXFGYTh5dHNNOXhiRTl4Q042aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9ha2FkZW1pYWxla2FtLnBsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760172890),('VKHBgbWzWEMIp0bsdAaqSBUZfyerhL8xE1SErtvg',NULL,'199.244.88.222','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQjRhMDNFWmJCSXBvekFDQ1l4S3hRTUdpOHhGb0txQk1DcmNWNExNZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9ha2FkZW1pYWxla2FtLnBsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760251470),('VWvUjjlYh3pT3icAxB2BvHF4DbTvbCbZciXNoBbe',NULL,'199.45.155.77','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTzFrSXhMZ3h3ZkNtMm91SWtHQmczeDlsRFM4NGxyYjd5cW94aWw2ZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWthZGVtaWFsZWthbS5wbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760194154),('wUTzh1WkUtBARPXXJZaXlnpKekyvn0rZhNdvlEyp',NULL,'45.149.173.195','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoicEpQSnZ3SWpVNTRIbkhsbGxodG5PNXR0TWZEVzJzWFEzcmhrUUhFeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9ha2FkZW1pYWxla2FtLnBsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760178840),('Xoa9wq4UNa9x88hgetTaTdVTjpzR4otduu5Qaqy9',NULL,'2a01:4f8:c012:8ba::1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ1pyY2xaWDN5allXdjZkTHRuMVhrU3V3bkQ1QmRCN055TVZpdHNlaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9sZWthbS50b2plc3QuZGV2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760150717),('xq37wpVFrkZL1cZ8j44jMQeS4BrJtUcPekd8vvzF',NULL,'198.235.24.41','','YTozOntzOjY6Il90b2tlbiI7czo0MDoidmR4U0dwM1pISk5hd3FHeFd2N1llMXVycEF3Q2piSmFuUVZjRlRDbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWthZGVtaWFsZWthbS5wbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760152347),('xXNyaKYl9MftbgONGEZPKRcbSJmS31oEvA6lFaEf',NULL,'35.195.101.71','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoibnFybVlZWTR3Sk5yYnpVbHR4eFlsdzltZ3BVZmh1cm1rbHpkbDRBRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWthZGVtaWFsZWthbS5wbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760250157),('zDlOsSs8qUpTDLozhGw4cprXngdzp7VJzRkm8wzP',NULL,'209.38.140.63','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWkN0dmplTWE0R3c0WG1mRXM0cjFoa3ZnSWZIT1ZVc0ltdElaSEc1ZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWthZGVtaWFsZWthbS5wbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760172891),('zFh5FolwOrRfY8uIr55TdJGD2ct8lwTrTASO4b4q',NULL,'35.195.35.214','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVBxd0FVaURLV1A3QkN1Wm8yd0h5SkE5ZU42VWoxcGxaamVlZkl0aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9ha2FkZW1pYWxla2FtLnBsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1760250158);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_progress`
--

DROP TABLE IF EXISTS `user_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_progress` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `lesson_id` bigint unsigned NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `video_position` int DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_downloaded_at` timestamp NULL DEFAULT NULL,
  `can_proceed_after` timestamp NULL DEFAULT NULL,
  `time_spent_seconds` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_progress_user_id_course_id_lesson_id_unique` (`user_id`,`course_id`,`lesson_id`),
  KEY `user_progress_course_id_foreign` (`course_id`),
  KEY `user_progress_lesson_id_foreign` (`lesson_id`),
  CONSTRAINT `user_progress_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_progress_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=260 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_progress`
--

LOCK TABLES `user_progress` WRITE;
/*!40000 ALTER TABLE `user_progress` DISABLE KEYS */;
INSERT INTO `user_progress` VALUES (251,1,5,30,0,25,NULL,NULL,NULL,0,'2025-09-23 15:43:20','2025-09-23 15:43:20'),(255,6,5,30,0,2028,NULL,NULL,NULL,0,'2025-09-25 09:00:32','2025-09-26 09:21:46'),(256,2,5,30,0,5,NULL,NULL,NULL,0,'2025-09-25 09:01:22','2025-09-25 09:01:22'),(257,4,5,30,0,20,NULL,NULL,NULL,0,'2025-09-25 12:15:25','2025-09-25 20:49:16'),(258,9,5,30,0,476,NULL,NULL,NULL,0,'2025-10-06 11:41:55','2025-10-06 11:51:27');
/*!40000 ALTER TABLE `user_progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pwz_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pharmacy_address` text COLLATE utf8mb4_unicode_ci,
  `pharmacy_postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pharmacy_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `license_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `representative_id` bigint unsigned DEFAULT NULL,
  `consent_1` tinyint(1) NOT NULL DEFAULT '0',
  `consent_2` tinyint(1) NOT NULL DEFAULT '0',
  `consent_3` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_representative_id_foreign` (`representative_id`),
  CONSTRAINT `users_representative_id_foreign` FOREIGN KEY (`representative_id`) REFERENCES `representatives` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Bartosz Łyśniewski','bartosz.lysniewski@gmail.com','510842280','1111111','DDD','66-400','Gorzów Wielkopolski',NULL,NULL,'$2y$12$yS3KDQE0/N2DuFH1lDTCG.RmAVKd65RxsMbnrjZERSLfxTswTYBDy',NULL,'2025-08-12 21:04:12','2025-08-12 21:06:04','admin',0,NULL,NULL,NULL,0,0,0),(2,'Krzysztof Breja','prslobert@gmail.com','698567876','123456','pulawska','02-819','warszawa',NULL,'2025-09-25 08:36:47','$2y$12$3THN0slW/BBbE/mcIpPk0ufLDdK5ql/gSo6VIxDBb29sLkBy87KoK',NULL,'2025-08-13 09:52:54','2025-09-25 08:36:47','farmaceuta',1,NULL,NULL,NULL,0,0,0),(3,'Maria Krześniak','mariakrzesniak@lekam.pl','11111111111','444','masło','05-462','dupa',NULL,NULL,'$2y$12$7CT9EjxCE/joltpMl/sYvOHozxDURgsLwD6gsVMzlvPmHqDZKDdYC',NULL,'2025-08-18 14:31:02','2025-09-25 08:38:28','farmaceuta',1,NULL,NULL,NULL,0,0,0),(4,'Bartosz Łyśniewski','bartosz@creativetrust.pl','444444444','1111111','DDD','56-550','GGG',NULL,'2025-09-24 19:38:44','$2y$12$zdaWX00phBKu6ztbKjev.uetiUdGFJz6kHGp0Z29Glj8eWHQJOrea',NULL,'2025-08-20 09:59:42','2025-09-24 19:38:44','technik_farmacji',1,NULL,NULL,NULL,0,0,0),(5,'Test Test','test@test.pl','555555555','1234567','ASD','66-400','Gorzów',NULL,NULL,'$2y$12$K1nto9OFAFZlxvMYJJlCV.Fpvzm69r7E72X.wAG3/2aGcd9Z9si0y',NULL,'2025-08-26 20:59:42','2025-08-26 20:59:42','farmaceuta',0,NULL,NULL,NULL,0,0,0),(6,'Filip Kopijer','filipkopijer@lekam.pl','728432939','1234567','ul. Przyokopowa 31','02-105','Warszawa',NULL,'2025-09-25 08:37:06','$2y$12$dG9lkCs2wGpgN2O3cvUjMOLgeJLzaj1eyUjBKfkutX8kjVzX6cDWS',NULL,'2025-09-16 14:29:36','2025-09-25 08:37:06','farmaceuta',1,NULL,NULL,NULL,0,0,0),(7,'ALICJA TELECKA','alicjatelecka@lekam.pl','693032012','82838282','Przyokopowa 31','01-208','Warszawa',NULL,NULL,'$2y$12$fcsSCKVzyRzwHbwsHauP7.z6F/3H5dkXMaSKbXVgpsp./DyEwDe9K',NULL,'2025-09-19 12:46:58','2025-09-19 12:46:58','technik_farmacji',0,NULL,NULL,NULL,0,0,0),(8,'Adam Jan','blysniewski@51015kids.eu','444444444','123456','AAA','66-400','Gorzów Wielkopolski',NULL,'2025-09-25 07:40:23','$2y$12$KmX0q8R.XEuzPTIQKXtOu.SDDwnPVpxiC2pchxtthKgrRNmE62hOK',NULL,'2025-09-25 07:38:51','2025-09-25 07:40:23','farmaceuta',0,NULL,NULL,NULL,0,0,0),(9,'Filip Kopijer','filip.kopijer@gmail.com','666111222','12345678910','ul. Apteki 1/U2','00-000ddd','Apteki Wielkie',NULL,'2025-10-06 10:47:30','$2y$12$/9STbwzTqPdH8I9NgSYDKeI9IXudTFp0fcGrgyX/droJp0sKAwmQW',NULL,'2025-10-06 10:44:58','2025-10-06 10:47:30','farmaceuta',0,NULL,NULL,NULL,0,0,0),(10,'Bartosz Lysniewski','bart@ibabart.pl','555555555','1234567','ada','66-400','Gorzow',NULL,NULL,'$2y$12$vxKmI8ECaaGGhNUFa60RG.KQm2IUnASwcLkun16etngzYXz1aUGGC',NULL,'2025-10-06 15:54:47','2025-10-06 15:54:47','farmaceuta',0,NULL,NULL,NULL,0,0,0),(11,'Bartosz Nowak','bnow@bnow.pl','555555555','1234567','Asd','66-400','Gorzów Wielkopolski',NULL,NULL,'$2y$12$nU55a5TIr75Pa9MpTuHhE.7prFnW4l/.Shtci9qX6EI3z1ff3VxdC',NULL,'2025-10-07 10:33:46','2025-10-07 10:33:46','technik_farmacji',0,NULL,NULL,NULL,0,0,0),(12,'Bartosz Łyśniewski','bbb@basdg.pl','510842280','1234567','Czartoryskiego 17/7','66-400','Gorzów Wielkopolski','VxqHtLVP',NULL,'$2y$12$R6iod7v8ny8apfF5bz9iEuGXoGh/0GxrAvXoLjQz1rVe5KsU0M6m2',NULL,'2025-10-07 10:39:35','2025-10-07 10:39:35','farmaceuta',0,NULL,NULL,NULL,0,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-12 15:58:22
