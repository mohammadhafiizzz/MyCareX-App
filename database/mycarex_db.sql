-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2025 at 05:56 AM
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
-- Database: `mycarex_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` varchar(7) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `ic_number` varchar(20) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','admin') NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `account_verified_at` timestamp NULL DEFAULT NULL,
  `account_verified_by` varchar(8) DEFAULT NULL,
  `account_rejected_at` timestamp NULL DEFAULT NULL,
  `profile_image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `full_name`, `ic_number`, `phone_number`, `email`, `password`, `role`, `remember_token`, `email_verified_at`, `account_verified_at`, `account_verified_by`, `account_rejected_at`, `profile_image_url`, `created_at`, `updated_at`, `last_login`) VALUES
('MCX0001', 'K\'', '031210-12-1215', '030729-12-0435', 'mohammadhafiz@yahoo.com', '$2y$12$6Q2f1yTz7JXYTnA0kBdoP.SduzFBJPNk0VaP0QGwb4De7.kv7nV1i', 'superadmin', NULL, NULL, '2025-09-20 14:36:27', NULL, NULL, NULL, '2025-09-20 06:12:28', '2025-09-20 06:12:28', NULL),
('MCX0002', 'MOHAMMAD HAFIZ BIN MOHAN', '030729-12-0435', '0146759237', 'hafizmohan73@gmail.com', '$2y$12$BqFVgQi30/n/KN3OXgqkjOTMZ/.EMfnK2vCzPnXkCBpKvOG.Apv4a', 'admin', NULL, NULL, '2025-09-23 21:07:23', 'MCX0001', NULL, NULL, '2025-09-22 08:44:18', '2025-09-23 21:07:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `allergies`
--

CREATE TABLE `allergies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `allergen` varchar(150) NOT NULL,
  `allergy_type` varchar(150) NOT NULL,
  `severity` enum('Mild','Moderate','Severe','Life-threatening') NOT NULL DEFAULT 'Mild',
  `reaction_desc` text DEFAULT NULL,
  `status` enum('Active','Inactive','Resolved','Suspected') NOT NULL DEFAULT 'Active',
  `verification_status` enum('Unverified','Provider Confirmed','Patient Reported') NOT NULL DEFAULT 'Unverified',
  `first_observed_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `allergies`
--

INSERT INTO `allergies` (`id`, `patient_id`, `allergen`, `allergy_type`, `severity`, `reaction_desc`, `status`, `verification_status`, `first_observed_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Peanuts', 'Food', 'Moderate', 'difficulty breathing', 'Active', 'Unverified', '2025-11-01', '2025-11-10 12:59:29', '2025-11-10 12:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `conditions`
--

CREATE TABLE `conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `condition_name` varchar(150) NOT NULL,
  `diagnosis_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `doc_attachments_url` varchar(255) DEFAULT NULL,
  `severity` enum('Mild','Moderate','Severe') NOT NULL DEFAULT 'Mild',
  `status` enum('Active','Resolved','Chronic') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conditions`
--

INSERT INTO `conditions` (`id`, `patient_id`, `condition_name`, `diagnosis_date`, `description`, `doc_attachments_url`, `severity`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Asthma', '2025-11-01', 'Self diagnosed', NULL, 'Mild', 'Active', '2025-11-10 12:58:06', '2025-11-10 12:58:06');

-- --------------------------------------------------------

--
-- Table structure for table `healthcare_providers`
--

CREATE TABLE `healthcare_providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_name` varchar(150) NOT NULL,
  `organisation_type` varchar(100) NOT NULL,
  `registration_number` varchar(100) DEFAULT NULL,
  `license_number` varchar(100) DEFAULT NULL,
  `license_expiry_date` date DEFAULT NULL,
  `establishment_date` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `phone_number` varchar(15) NOT NULL,
  `emergency_contact` varchar(50) NOT NULL,
  `website_url` varchar(100) DEFAULT NULL,
  `contact_person_name` varchar(100) NOT NULL,
  `contact_person_phone_number` varchar(15) NOT NULL,
  `contact_person_designation` varchar(100) NOT NULL,
  `contact_person_ic_number` varchar(20) NOT NULL,
  `address` longtext NOT NULL,
  `postal_code` varchar(5) NOT NULL,
  `state` enum('Johor','Kedah','Kelantan','Malacca','Negeri Sembilan','Pahang','Penang','Perak','Perlis','Sabah','Sarawak','Selangor','Terengganu','Kuala Lumpur','Labuan','Putrajaya') NOT NULL,
  `business_license_document` varchar(255) DEFAULT NULL,
  `medical_license_document` varchar(255) DEFAULT NULL,
  `profile_image_url` varchar(255) DEFAULT NULL,
  `registration_date` date NOT NULL,
  `verification_status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `verified_by` varchar(255) DEFAULT NULL,
  `approved_at` date DEFAULT NULL,
  `rejected_at` date DEFAULT NULL,
  `rejection_reason` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `healthcare_providers`
--

INSERT INTO `healthcare_providers` (`id`, `organisation_name`, `organisation_type`, `registration_number`, `license_number`, `license_expiry_date`, `establishment_date`, `email`, `password`, `remember_token`, `phone_number`, `emergency_contact`, `website_url`, `contact_person_name`, `contact_person_phone_number`, `contact_person_designation`, `contact_person_ic_number`, `address`, `postal_code`, `state`, `business_license_document`, `medical_license_document`, `profile_image_url`, `registration_date`, `verification_status`, `verified_by`, `approved_at`, `rejected_at`, `rejection_reason`, `email_verified_at`, `last_login`, `created_at`, `updated_at`) VALUES
(3, 'K\' PHARMA SDN BHD', 'Pharmacy', '123456789', '123456789', '2025-09-01', '2025-09-30', 'kpharma@email.com', '$2y$12$JyZ/19WGdtx.pOnWBgpPKOjTxDD7aNkyM7rFQywG1/.szeCrr7Jfu', NULL, '014-675 9237', '014-675 9237', 'https://kpharma.com', 'MOHAMMAD HAFIZ BIN MOHAN', '014-675 9237', 'Chief Medical Officer', '030729-12-0435', 'Kampung Laut Kinarut Papar', '89500', 'Sabah', NULL, NULL, NULL, '2025-09-27', 'Approved', 'MCX0001', '2025-09-27', NULL, NULL, '2025-09-27 04:48:18', '2025-11-17 02:27:20', '2025-09-27 04:47:21', '2025-11-17 02:27:20'),
(4, 'NEURALINK SDN BHD', 'Laboratory', '987654321', '987654321', '2025-10-31', '2025-09-01', 'neuralink@neuralink.com', '$2y$12$ZuFEHvUcPpqH2RbODzo00.0a4M7zbTNpbUdRSdMQreabeRKlMD6gC', NULL, '012-312 3123', '012-312 3123', 'https://neuralink.com', 'AHMAD NUR BAZLI BIN BALI', '013-828 6121', 'Administrator', '030909-12-0486', 'Kampung Somboi Kinarut Papar', '89500', 'Sabah', NULL, NULL, NULL, '2025-09-28', 'Pending', NULL, NULL, NULL, NULL, '2025-11-16 03:41:46', '2025-11-16 03:42:13', '2025-09-27 19:28:56', '2025-11-16 03:42:13');

-- --------------------------------------------------------

--
-- Table structure for table `immunisations`
--

CREATE TABLE `immunisations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `vaccine_name` varchar(255) NOT NULL,
  `dose_details` varchar(100) DEFAULT NULL,
  `vaccination_date` date NOT NULL,
  `administered_by` varchar(255) DEFAULT NULL,
  `vaccine_lot_number` varchar(100) DEFAULT NULL,
  `verification_status` enum('Unverified','Provider Confirmed','Patient Reported') NOT NULL DEFAULT 'Unverified',
  `certificate_url` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `immunisations`
--

INSERT INTO `immunisations` (`id`, `patient_id`, `vaccine_name`, `dose_details`, `vaccination_date`, `administered_by`, `vaccine_lot_number`, `verification_status`, `certificate_url`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'COVID-19', '2nd Dose', '2025-11-08', 'HQE 2', NULL, 'Unverified', NULL, NULL, '2025-11-10 13:00:04', '2025-11-10 13:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE `labs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `test_name` varchar(150) NOT NULL,
  `test_date` date NOT NULL,
  `file_attachment_url` varchar(255) NOT NULL,
  `test_category` varchar(100) NOT NULL,
  `facility_name` varchar(255) DEFAULT NULL,
  `verification_status` enum('Unverified','Provider Confirmed','Patient Reported') NOT NULL DEFAULT 'Unverified',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` (`id`, `patient_id`, `test_name`, `test_date`, `file_attachment_url`, `test_category`, `facility_name`, `verification_status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'Complete Blood Count', '2025-11-08', 'http://localhost:8000/files/lab/LabTest_1_Attachment.pdf', 'Hermatology', 'HQE 2', 'Unverified', 'test results', '2025-11-10 13:01:06', '2025-11-10 13:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `medications`
--

CREATE TABLE `medications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `medication_name` varchar(150) NOT NULL,
  `dosage` int(10) UNSIGNED NOT NULL,
  `frequency` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('Active','On Hold','Completed','Discontinued') NOT NULL DEFAULT 'Active',
  `med_image_url` varchar(255) DEFAULT NULL,
  `reason_for_med` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medications`
--

INSERT INTO `medications` (`id`, `patient_id`, `medication_name`, `dosage`, `frequency`, `start_date`, `end_date`, `notes`, `status`, `med_image_url`, `reason_for_med`, `created_at`, `updated_at`, `provider_id`) VALUES
(1, 1, 'Metformin', 500, '3 times daily', '2025-11-06', '2025-11-25', 'Take with food', 'Active', NULL, 'Type 2 Diabetes', '2025-11-10 12:58:46', '2025-11-12 08:19:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `ic_number` varchar(20) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `blood_type` varchar(10) NOT NULL,
  `race` varchar(20) NOT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `address` longtext NOT NULL,
  `postal_code` varchar(5) NOT NULL,
  `state` enum('Johor','Kedah','Kelantan','Malacca','Negeri Sembilan','Pahang','Penang','Perak','Perlis','Sabah','Sarawak','Selangor','Terengganu','Kuala Lumpur','Labuan','Putrajaya') NOT NULL,
  `emergency_contact_number` varchar(15) NOT NULL,
  `emergency_contact_name` varchar(100) NOT NULL,
  `emergency_contact_ic_number` varchar(20) NOT NULL,
  `emergency_contact_relationship` varchar(30) NOT NULL,
  `profile_image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `full_name`, `ic_number`, `phone_number`, `email`, `password`, `remember_token`, `date_of_birth`, `gender`, `blood_type`, `race`, `height`, `weight`, `address`, `postal_code`, `state`, `emergency_contact_number`, `emergency_contact_name`, `emergency_contact_ic_number`, `emergency_contact_relationship`, `profile_image_url`, `created_at`, `updated_at`, `last_login`, `email_verified_at`) VALUES
(1, 'MOHAMMAD HAFIZ BIN MOHAN', '030729-12-0435', '014-675 9237', 'mohammadhafiizzzz@gmail.com', '$2y$12$5BnJHbJSEJvfJfiCC9smeuvxCM05I7GONeBFwNVUjiMZll3tNKF/m', 'rfeQlTJi7Rv9JWfMeLA9KDruoMOiykg6IxdgOvc6F5xInPMqMmg5lndbzCiY', '2003-07-29', 'Male', 'O+', 'Bajau', NULL, NULL, 'Kampung Laut Kinarut Papar', '89500', 'Sabah', '03-0729 1204', 'SITI NOOR AMIRA BINTI MOHAN', '030729-12-0435', 'Sibling', 'http://localhost:8000/images/userProfile/_Profile_Picture.jpg', '2025-09-18 23:22:09', '2025-11-17 02:30:34', '2025-11-17 02:30:34', '2025-09-18 23:24:24'),
(2, 'AHMAD NUR BAZLI BIN BALI', '030909-12-0376', '013-828 6121', 'ahmadnurbazli@yahoo.com', '$2y$12$yC0JWBIwyaY0.9xfGd571umfklgH.rmeBv7DgaRkSIVESugP59CXK', NULL, '2003-09-09', 'Male', 'B+', 'Bajau', NULL, NULL, 'Kampung Somboi Kinarut Papar', '89500', 'Sabah', '014-675 9237', 'MOHAMMAD HAFIZ BIN MOHAN', '030729-12-0435', 'Friend', NULL, '2025-09-22 20:08:53', '2025-09-22 20:10:08', NULL, '2025-09-22 20:10:08');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `requested_at` date NOT NULL,
  `granted_at` date DEFAULT NULL,
  `status` enum('Pending','Active','Denied','Revoked','Expired') NOT NULL DEFAULT 'Pending',
  `expiry_date` date DEFAULT NULL,
  `permission_scope` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permission_scope`)),
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admins_ic_number_unique` (`ic_number`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `allergies`
--
ALTER TABLE `allergies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `allergies_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `conditions`
--
ALTER TABLE `conditions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conditions_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `healthcare_providers`
--
ALTER TABLE `healthcare_providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `healthcare_providers_email_unique` (`email`),
  ADD UNIQUE KEY `healthcare_providers_contact_person_ic_number_unique` (`contact_person_ic_number`),
  ADD UNIQUE KEY `healthcare_providers_registration_number_unique` (`registration_number`),
  ADD UNIQUE KEY `healthcare_providers_license_number_unique` (`license_number`);

--
-- Indexes for table `immunisations`
--
ALTER TABLE `immunisations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `immunisations_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `labs`
--
ALTER TABLE `labs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `labs_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `medications`
--
ALTER TABLE `medications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medications_patient_id_foreign` (`patient_id`),
  ADD KEY `medications_provider_id_foreign` (`provider_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_ic_number_unique` (`ic_number`),
  ADD UNIQUE KEY `patients_email_unique` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_patient_id_foreign` (`patient_id`),
  ADD KEY `permissions_provider_id_foreign` (`provider_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allergies`
--
ALTER TABLE `allergies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conditions`
--
ALTER TABLE `conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `healthcare_providers`
--
ALTER TABLE `healthcare_providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `immunisations`
--
ALTER TABLE `immunisations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `labs`
--
ALTER TABLE `labs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medications`
--
ALTER TABLE `medications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allergies`
--
ALTER TABLE `allergies`
  ADD CONSTRAINT `allergies_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `conditions`
--
ALTER TABLE `conditions`
  ADD CONSTRAINT `conditions_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `immunisations`
--
ALTER TABLE `immunisations`
  ADD CONSTRAINT `immunisations_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `labs`
--
ALTER TABLE `labs`
  ADD CONSTRAINT `labs_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medications`
--
ALTER TABLE `medications`
  ADD CONSTRAINT `medications_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medications_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `healthcare_providers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permissions_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `healthcare_providers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
