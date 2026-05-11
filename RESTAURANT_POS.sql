-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2026 at 01:46 AM
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
-- Database: `restaurant_pos_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounting_categories`
--

CREATE TABLE `accounting_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `account_code` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounting_categories`
--

INSERT INTO `accounting_categories` (`id`, `category`, `account_code`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(75, 'Assets', '1000', 20, 'active', '2026-02-27 08:36:43', '2026-02-27 08:36:43'),
(76, 'Liabilities', '2000', 20, 'active', '2026-02-27 08:37:42', '2026-02-27 08:37:42'),
(77, 'Equity', '3000', 20, 'active', '2026-02-27 08:39:07', '2026-02-27 08:39:07'),
(78, 'Revenue', '4000', 20, 'active', '2026-03-05 03:30:40', '2026-03-05 03:30:40'),
(79, 'Expenses', '6000', 20, 'active', '2026-03-05 06:41:13', '2026-03-05 06:41:13');

-- --------------------------------------------------------

--
-- Table structure for table `accounting_sub_categories`
--

CREATE TABLE `accounting_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accounting_category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category` varchar(255) NOT NULL,
  `account_code` varchar(255) DEFAULT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounting_sub_categories`
--

INSERT INTO `accounting_sub_categories` (`id`, `accounting_category_id`, `sub_category`, `account_code`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(7, 75, 'Current Assets', '100', 'active', 20, '2026-02-27 08:36:57', '2026-02-27 08:36:57'),
(8, 75, 'Non-Current Assets', '200', 'active', 20, '2026-02-27 08:37:16', '2026-02-27 08:37:16'),
(9, 75, 'Contra Assets', '300', 'active', 20, '2026-02-27 08:37:30', '2026-02-27 08:37:30'),
(10, 76, 'Current Liabilities', '100', 'active', 20, '2026-02-27 08:37:56', '2026-02-27 08:37:56'),
(11, 77, 'Equity', '100', 'active', 20, '2026-02-27 08:39:18', '2026-02-27 08:39:18'),
(12, 78, 'Sales', '100', 'active', 20, '2026-03-05 03:31:20', '2026-03-05 03:31:20'),
(13, 78, 'Contra Revenue', '200', 'active', 20, '2026-03-05 03:31:44', '2026-03-05 03:31:44'),
(14, 79, 'Payroll', '100', 'active', 20, '2026-03-05 06:42:03', '2026-03-05 06:42:03'),
(15, 79, 'Occupancy', '200', 'active', 20, '2026-03-05 06:42:14', '2026-03-05 06:42:14'),
(16, 79, 'Administrative', '300', 'active', 20, '2026-03-05 06:42:30', '2026-03-05 06:42:30'),
(17, 79, 'Marketing', '400', 'active', 20, '2026-03-05 06:42:44', '2026-03-05 06:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `accounts_receivables`
--

CREATE TABLE `accounts_receivables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_datetime` datetime NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `payor_name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `sub_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `amount_due` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_received` decimal(15,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `completed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `disapproved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `archived_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `disapproved_at` timestamp NULL DEFAULT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts_receivables`
--

INSERT INTO `accounts_receivables` (`id`, `user_id`, `branch_id`, `transaction_datetime`, `reference_no`, `payor_name`, `company`, `address`, `mobile_no`, `email`, `tin`, `due_date`, `transaction_type`, `sub_total`, `total_tax`, `total_amount`, `amount_due`, `total_received`, `balance`, `status`, `approved_by`, `completed_by`, `disapproved_by`, `archived_by`, `approved_at`, `completed_at`, `disapproved_at`, `archived_at`, `created_at`, `updated_at`) VALUES
(7, 20, 8, '2026-03-03 14:52:47', 'AR-8-00001', 'Sm', 'sm', 'cebu', '54658976796', 'sm@s.com', '66464', '2026-03-04', 'Account Receivables', 1800.00, 216.00, 2016.00, 2016.00, 0.00, 2016.00, 'approved', 20, NULL, NULL, NULL, '2026-03-06 08:51:05', NULL, NULL, NULL, '2026-03-03 06:56:44', '2026-03-06 08:51:05'),
(8, 20, 8, '2026-03-06 16:45:08', 'AR-8-00002', 'Mr X', 'X Company', 'x', '37373737', 'x@gcom', '222222', '2026-03-07', 'Account Receivables', 12000.00, 1440.00, 13440.00, 13440.00, 10000.00, 3440.00, 'approved', 20, NULL, NULL, NULL, '2026-03-06 08:50:57', NULL, NULL, NULL, '2026-03-06 08:49:43', '2026-03-06 08:51:51');

-- --------------------------------------------------------

--
-- Table structure for table `accounts_receivables_payments`
--

CREATE TABLE `accounts_receivables_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_receivable_id` bigint(20) UNSIGNED NOT NULL,
  `cash_equivalent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `transaction_datetime` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts_receivables_payments`
--

INSERT INTO `accounts_receivables_payments` (`id`, `account_receivable_id`, `cash_equivalent_id`, `payment_method_id`, `amount`, `transaction_datetime`, `created_at`, `updated_at`) VALUES
(10, 8, 5, 9, 10000.00, '2026-03-06 16:49:31', '2026-03-06 08:51:51', '2026-03-06 08:51:51');

-- --------------------------------------------------------

--
-- Table structure for table `accounts_receivable_details`
--

CREATE TABLE `accounts_receivable_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accounts_receivable_id` bigint(20) UNSIGNED NOT NULL,
  `chart_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `unit_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax` varchar(255) NOT NULL DEFAULT 'NON-VAT',
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts_receivable_details`
--

INSERT INTO `accounts_receivable_details` (`id`, `accounts_receivable_id`, `chart_account_id`, `type_id`, `description`, `qty`, `unit_price`, `tax`, `tax_id`, `tax_amount`, `sub_total`, `total_amount`, `attachments`, `created_at`, `updated_at`) VALUES
(15, 7, 2, 10, 'test', 1, 1500.00, 'VAT', NULL, 180.00, 1500.00, 1680.00, NULL, '2026-03-03 06:56:44', '2026-03-03 06:56:44'),
(16, 7, 1, 7, 'cash on hand test', 1, 300.00, 'VAT', NULL, 36.00, 300.00, 336.00, NULL, '2026-03-03 06:56:44', '2026-03-03 06:56:44'),
(17, 8, 16, 12, 'Sales from catering services', 1, 12000.00, 'VAT', NULL, 1440.00, 12000.00, 13440.00, NULL, '2026-03-06 08:49:43', '2026-03-06 08:49:43');

-- --------------------------------------------------------

--
-- Table structure for table `account_payables`
--

CREATE TABLE `account_payables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_number` varchar(255) NOT NULL,
  `payor_details` varchar(255) DEFAULT NULL,
  `payer_name` varchar(255) DEFAULT NULL,
  `payer_company` varchar(255) DEFAULT NULL,
  `payer_address` varchar(255) DEFAULT NULL,
  `payer_mobile_number` varchar(255) DEFAULT NULL,
  `payer_email_address` varchar(255) DEFAULT NULL,
  `payer_tin` varchar(255) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','approved','completed','disapproved','archived') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_payables`
--

INSERT INTO `account_payables` (`id`, `branch_id`, `reference_number`, `payor_details`, `payer_name`, `payer_company`, `payer_address`, `payer_mobile_number`, `payer_email_address`, `payer_tin`, `due_date`, `status`, `created_at`, `updated_at`) VALUES
(32, NULL, 'AP-8-000001', 'Veco', 'Veco', 'Veco', 'cebu', '34353434', 'v@g.com', '435345', '2026-03-18', 'pending', '2026-03-17 09:04:28', '2026-03-17 09:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `account_payable_details`
--

CREATE TABLE `account_payable_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chart_account_id` bigint(20) UNSIGNED NOT NULL,
  `account_payable_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cash_equivalent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `accounting_category_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `amount_per_unit` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `amount_to_pay` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_payable_details`
--

INSERT INTO `account_payable_details` (`id`, `chart_account_id`, `account_payable_id`, `payment_id`, `cash_equivalent_id`, `tax_id`, `accounting_category_id`, `description`, `quantity`, `amount_per_unit`, `total_amount`, `amount_to_pay`, `created_at`, `updated_at`) VALUES
(45, 10, 32, NULL, NULL, NULL, 79, 'electric bill', 1, 1500.00, 1500.00, 0.00, '2026-03-17 09:04:28', '2026-03-17 09:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `asset_categories`
--

CREATE TABLE `asset_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_categories`
--

INSERT INTO `asset_categories` (`id`, `name`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Furnitures and Fixtures', 15, 'active', '2025-11-17 08:40:48', '2025-11-24 04:53:22'),
(3, 'Equipment', 20, 'active', '2025-11-24 04:52:31', '2025-11-24 04:52:31');

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `benefits`
--

CREATE TABLE `benefits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `benefits`
--

INSERT INTO `benefits` (`id`, `name`, `date`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 'Free Lunch', '2025-12-11 00:00:00', 'active', 15, '2025-12-11 06:04:36', '2025-12-11 06:04:36'),
(3, 'Flexible', '2025-12-11 15:09:00', 'active', 15, '2025-12-11 07:09:25', '2025-12-11 07:10:27');

-- --------------------------------------------------------

--
-- Table structure for table `benefit_details`
--

CREATE TABLE `benefit_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `benefit_id` bigint(20) UNSIGNED NOT NULL,
  `salary_rate_from` decimal(15,2) NOT NULL DEFAULT 0.00,
  `salary_rate_to` decimal(15,2) NOT NULL DEFAULT 0.00,
  `employer_share` decimal(15,2) NOT NULL DEFAULT 0.00,
  `employee_share` decimal(15,2) NOT NULL DEFAULT 0.00,
  `employer_share_type` varchar(255) DEFAULT NULL,
  `employee_share_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `benefit_details`
--

INSERT INTO `benefit_details` (`id`, `benefit_id`, `salary_rate_from`, `salary_rate_to`, `employer_share`, `employee_share`, `employer_share_type`, `employee_share_type`, `created_at`, `updated_at`) VALUES
(2, 2, 10000.00, 12000.00, 500.00, 500.00, 'fixed', 'fixed', '2025-12-11 06:04:36', '2025-12-11 06:04:36'),
(4, 3, 5000.00, 8000.00, 2000.00, 2000.00, 'fixed', 'fixed', '2025-12-11 07:09:38', '2025-12-11 07:09:38');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `permit_number` varchar(255) DEFAULT NULL,
  `dti_issued` varchar(255) DEFAULT NULL,
  `pos_sn` varchar(255) DEFAULT NULL,
  `min_number` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `mobile_number`, `phone_number`, `email`, `tin`, `permit_number`, `dti_issued`, `pos_sn`, `min_number`, `address`, `contact_person`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Main Comissary', '09171234567', '028123456', 'main@branch.com', '123-456-789', NULL, NULL, NULL, NULL, '123 Main St, Cityville', NULL, '2025-10-21 18:43:33', '2026-01-30 08:03:52', 'active'),
(4, 'Bantayan', '0915532323', '9023-233', 'bantayan@gmail.com', '2332', '001', '8080', '90876231', '1234567890', 'Bantayan Island Cebu', '09923923', '2025-10-14 19:52:34', '2026-01-30 08:04:39', 'active'),
(6, 'Manila', '09179876543', '028765432', 'north@branch.com', '987-654-321', NULL, NULL, NULL, NULL, '456 North Ave, Uptown', NULL, '2025-10-21 18:43:33', '2026-01-30 08:04:25', 'active'),
(7, 'Davao', '09177654321', '028654321', 'south@branch.com', '654-321-987', NULL, NULL, NULL, NULL, '789 South Rd, Downtown', NULL, '2025-10-21 18:43:33', '2026-01-30 08:04:54', 'active'),
(8, 'Cebu', '999999', '09999999999', 'cebu@gmail.com', '9999999999', 'P999', NULL, 'POSSN99', NULL, 'Cabu City', 'POS Cebu', '2025-10-26 16:54:17', '2025-11-24 03:11:37', 'active'),
(9, 'Bohol', '9838847753', '093988854', 'bohol@email.com', '432432', '9873', '109283', '001234', '20009', 'Ubay Bohol', 'Juan Ponce Enrile', '2026-02-11 06:26:06', '2026-02-11 06:26:06', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `branch_components`
--

CREATE TABLE `branch_components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `component_id` bigint(20) UNSIGNED NOT NULL,
  `onhand` decimal(15,2) NOT NULL,
  `cost` decimal(15,2) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `for_sale` tinyint(1) NOT NULL DEFAULT 1,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_components`
--

INSERT INTO `branch_components` (`id`, `branch_id`, `component_id`, `onhand`, `cost`, `price`, `status`, `for_sale`, `supplier_id`, `created_at`, `updated_at`) VALUES
(350, 1, 366, 0.00, 3200.00, 4320.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(351, 1, 367, 0.00, 4052.00, 5470.20, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(352, 1, 368, 0.00, 3200.00, 4320.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(353, 1, 369, 0.00, 3200.00, 4320.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(354, 1, 370, 0.00, 3200.00, 4320.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(355, 1, 371, 0.00, 3200.00, 4320.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(356, 1, 372, 0.00, 28.92, 39.04, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(357, 1, 373, 0.00, 49.96, 67.45, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(358, 1, 374, 0.00, 65.00, 87.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(359, 1, 375, 0.00, 50.20, 67.77, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(360, 1, 376, 0.00, 44.17, 59.63, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(361, 1, 377, 34.00, 39.38, 53.16, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(362, 1, 378, 0.00, 20.17, 27.23, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(363, 1, 379, 50.00, 35.42, 47.82, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(364, 1, 380, 0.00, 5.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-12 04:20:53'),
(365, 1, 381, 0.00, 1.00, 1.35, 'active', 1, NULL, '2026-03-10 06:34:27', '2026-03-12 04:12:08'),
(366, 1, 382, 0.00, 49.96, 67.45, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(367, 1, 383, 0.00, 35.50, 47.93, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(368, 1, 384, 0.00, 26.17, 35.33, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(369, 1, 385, 0.00, 30.33, 40.95, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(370, 1, 386, 0.00, 28.42, 38.37, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(371, 1, 387, 0.00, 28.75, 38.81, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(372, 1, 388, 0.00, 19.58, 26.43, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(373, 1, 389, 0.00, 75.00, 101.25, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(374, 1, 390, 0.00, 15.83, 21.37, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(375, 1, 391, 42.00, 53.00, 71.55, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(376, 1, 392, 0.00, 19.83, 26.77, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(377, 1, 393, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(378, 1, 394, 12.00, 9.58, 12.93, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(379, 1, 395, 0.00, 8.90, 12.02, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(380, 1, 396, 26.00, 28.92, 39.04, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(381, 1, 397, 27.00, 28.92, 39.04, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(382, 1, 398, 13.00, 28.92, 39.04, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(383, 1, 399, 1.00, 28.92, 39.04, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(384, 1, 400, 0.00, 22.00, 29.70, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(385, 1, 401, 42.00, 29.92, 40.39, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(386, 1, 402, 0.00, 17.00, 22.95, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(387, 1, 403, 0.00, 225.83, 304.87, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(388, 1, 404, 0.00, 9.75, 13.16, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(389, 1, 405, 0.00, 17.06, 23.03, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(390, 1, 406, 0.00, 25.38, 34.26, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(391, 1, 407, 13.00, 161.11, 217.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(392, 1, 408, 1.00, 15.00, 20.25, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(393, 1, 409, 4.00, 15.00, 20.25, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(394, 1, 410, 0.00, 2.01, 2.71, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(395, 1, 411, 0.00, 169.17, 228.38, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(396, 1, 412, 0.00, 6.00, 8.10, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(397, 1, 413, 0.00, 41.30, 55.76, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(398, 1, 414, 0.00, 42.12, 56.86, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(399, 1, 415, 0.00, 26.09, 35.22, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(400, 1, 416, 0.00, 64.35, 86.87, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(401, 1, 417, 0.00, 26.09, 35.22, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(402, 1, 418, 0.00, 17.42, 23.52, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(403, 1, 419, 0.00, 18.26, 24.65, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(404, 1, 420, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(405, 1, 421, 0.00, 84.78, 114.45, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(406, 1, 422, 0.00, 198.00, 267.30, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(407, 1, 423, 0.00, 5.60, 7.56, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(408, 1, 424, 0.00, 280.00, 378.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(409, 1, 425, 0.00, 180.00, 243.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(410, 1, 426, 0.00, 11.40, 15.39, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(411, 1, 427, 0.00, 10.00, 13.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(412, 1, 428, 0.00, 3.52, 4.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(413, 1, 429, 0.00, 23.20, 31.32, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(414, 1, 430, 0.00, 26.00, 35.10, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(415, 1, 431, 0.00, 28.94, 39.07, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(416, 1, 432, 0.00, 5.64, 7.61, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(417, 1, 433, 0.00, 34.60, 46.71, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(418, 1, 434, 0.00, 42.42, 57.27, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(419, 1, 435, 0.00, 44.00, 59.40, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(420, 1, 436, 0.00, 27.80, 37.53, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(421, 1, 437, 0.00, 17.88, 24.14, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(422, 1, 438, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(423, 1, 439, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(424, 1, 440, 0.00, 26.96, 36.40, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(425, 1, 441, 0.00, 30.30, 40.91, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(426, 1, 442, 0.00, 37.83, 51.07, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(427, 1, 443, 0.00, 43.33, 58.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(428, 1, 444, 0.00, 216.00, 291.60, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(429, 1, 445, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(430, 1, 446, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(431, 1, 447, 0.00, 105.20, 142.02, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(432, 1, 448, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(433, 1, 449, 0.00, 34.85, 47.05, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(434, 1, 450, 0.00, 20.87, 28.17, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(435, 1, 451, 0.00, 40.43, 54.58, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(436, 1, 452, 0.00, 43.03, 58.09, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(437, 1, 453, 0.00, 40.43, 54.58, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(438, 1, 454, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(442, 1, 458, 63.00, 54.60, 73.71, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(443, 1, 459, 0.00, 22.08, 29.81, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(444, 1, 460, 0.00, 1.60, 2.16, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(445, 1, 461, 0.00, 0.45, 0.61, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(446, 1, 462, 0.00, 0.09, 0.12, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(447, 1, 463, 0.00, 0.24, 0.32, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(448, 1, 464, 0.00, 0.50, 0.68, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(449, 1, 465, 0.00, 280.00, 378.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(450, 1, 466, 100.00, 0.24, 0.32, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(451, 1, 467, 0.00, 0.41, 0.55, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(452, 1, 468, 0.00, 0.30, 0.41, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(453, 1, 469, 0.00, 0.68, 0.92, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(454, 1, 470, 0.00, 39.00, 52.65, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(455, 1, 471, 0.00, 27.50, 37.13, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(456, 1, 472, 0.00, 0.23, 0.31, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(457, 1, 473, 40.00, 0.50, 0.68, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(458, 1, 474, 0.00, 178.00, 240.30, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(459, 1, 475, 0.00, 3.17, 4.28, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(460, 1, 476, 0.00, 0.09, 0.12, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(461, 1, 477, 0.20, 0.80, 1.08, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(462, 1, 478, 0.00, 0.39, 0.53, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(463, 1, 479, 0.00, 0.28, 0.38, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(464, 1, 480, 0.00, 0.17, 0.23, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(465, 1, 481, 0.00, 2.20, 2.97, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(466, 1, 482, 0.00, 0.67, 0.90, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(467, 1, 483, 0.00, 0.12, 0.16, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(468, 1, 484, 0.00, 0.15, 0.20, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(469, 1, 485, 0.00, 0.28, 0.38, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(470, 1, 486, 0.00, 88.20, 119.07, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(471, 1, 487, 0.00, 0.28, 0.38, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(472, 1, 488, 0.00, 0.15, 0.20, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(473, 1, 489, 0.00, 0.38, 0.51, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(474, 1, 490, 0.15, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(475, 1, 491, 0.00, 173.33, 234.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(476, 1, 492, 0.00, 0.55, 0.74, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(477, 1, 493, 0.00, 0.92, 1.24, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(478, 1, 494, 0.00, 2.08, 2.81, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(479, 1, 495, 0.00, 0.30, 0.41, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(480, 1, 496, 1.00, 200.00, 270.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(481, 1, 497, 0.00, 222.50, 300.38, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(482, 1, 498, 4.70, 57.00, 76.95, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(483, 1, 499, 1.80, 485.50, 655.43, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(484, 1, 500, 1.00, 90.00, 121.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(485, 1, 501, 0.00, 127.50, 172.13, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(486, 1, 502, 2.50, 190.00, 256.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(487, 1, 503, 0.00, 45.00, 60.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(488, 1, 504, 0.00, 301.16, 406.57, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(489, 1, 505, 1.90, 485.50, 655.43, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(490, 1, 506, 0.30, 559.50, 755.33, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(491, 1, 507, 1.60, 119.70, 161.60, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(492, 1, 508, 0.70, 60.00, 81.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(493, 1, 509, 0.00, 583.95, 788.33, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(494, 1, 510, 1.80, 786.41, 1061.65, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(495, 1, 511, 0.00, 111.88, 151.04, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(496, 1, 512, 0.00, 45.00, 60.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(497, 1, 513, 15.00, 52.00, 70.20, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(498, 1, 514, 0.00, 114.50, 154.58, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(499, 1, 515, 0.00, 26.70, 36.05, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(500, 1, 516, 0.00, 446.00, 602.10, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(501, 1, 517, 0.10, 30.00, 40.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(502, 1, 518, 10.00, 28.00, 37.80, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(503, 1, 519, 0.00, 227.21, 306.73, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(504, 1, 520, 0.23, 241.30, 325.76, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(505, 1, 521, 3.50, 75.75, 102.26, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(506, 1, 522, 2.00, 70.00, 94.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(507, 1, 523, 0.00, 325.00, 438.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(508, 1, 524, 0.00, 275.00, 371.25, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(509, 1, 525, 4.20, 156.62, 211.44, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(510, 1, 526, 3.00, 317.38, 428.46, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(511, 1, 527, 0.00, 342.59, 462.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(512, 1, 528, 0.00, 374.47, 505.53, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(513, 1, 529, 0.00, 287.50, 388.13, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(514, 1, 530, 1.00, 20.00, 27.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(515, 1, 531, 0.00, 160.00, 216.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(516, 1, 532, 0.00, 97.39, 131.48, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(517, 1, 533, 0.00, 72.00, 97.20, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(518, 1, 534, 0.00, 48.50, 65.48, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(519, 1, 535, 2.50, 99.00, 133.65, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(520, 1, 536, 1.60, 117.19, 158.21, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(521, 1, 537, 0.00, 146.97, 198.41, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(522, 1, 538, 0.00, 117.19, 158.21, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(523, 1, 539, 5.50, 409.49, 552.81, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(524, 1, 540, 0.00, 275.00, 371.25, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(525, 1, 541, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(526, 1, 542, 1.50, 64.70, 87.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(527, 1, 543, 0.80, 99.44, 134.24, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(528, 1, 544, 0.00, 185.00, 249.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(529, 1, 545, 0.00, 123.75, 167.06, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(530, 1, 546, 40.00, 82.81, 111.79, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(531, 1, 547, 0.00, 178.00, 240.30, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(532, 1, 548, 0.00, 466.60, 629.91, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(533, 1, 549, 1.50, 162.86, 219.86, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(534, 1, 550, 0.00, 49.41, 66.70, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(535, 1, 551, 0.00, 83.77, 113.09, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(536, 1, 552, 0.00, 70.95, 95.78, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(537, 1, 553, 0.00, 91.50, 123.53, 'active', 1, NULL, '2026-03-10 06:34:27', '2026-03-12 04:11:40'),
(538, 1, 554, 0.30, 261.50, 353.03, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(539, 1, 555, 21.00, 234.29, 316.29, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(540, 1, 556, 0.00, 286.70, 387.05, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(541, 1, 557, 3.00, 53.17, 71.78, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(542, 1, 558, 0.00, 236.65, 319.48, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(543, 1, 559, 3.00, 227.50, 307.13, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(544, 1, 560, 0.00, 71.25, 96.19, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(545, 1, 561, 7.00, 47.96, 64.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(546, 1, 562, 2.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(547, 1, 563, 0.00, 93.75, 126.56, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(548, 1, 564, 2.00, 40.50, 54.68, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(549, 1, 565, 1.50, 286.14, 386.29, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(550, 1, 566, 3.60, 241.72, 326.32, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(551, 1, 567, 3.00, 97.66, 131.84, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(552, 1, 568, 0.00, 102.08, 137.81, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(553, 1, 569, 0.00, 0.26, 0.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(554, 1, 570, 0.00, 2.43, 3.28, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(555, 1, 571, 0.00, 0.25, 0.34, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(556, 1, 572, 0.00, 40.00, 54.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(557, 1, 573, 0.00, 17.50, 23.63, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(558, 1, 574, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(559, 1, 575, 0.00, 8.00, 10.80, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(560, 1, 576, 0.00, 7.21, 9.73, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(561, 1, 577, 0.00, 70.00, 94.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(562, 1, 578, 0.00, 25.00, 33.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(563, 1, 579, 0.00, 50.00, 67.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(564, 1, 580, 0.00, 1.69, 2.28, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(565, 1, 581, 13.00, 8.00, 10.80, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(566, 1, 582, 0.00, 4.00, 5.40, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(567, 1, 583, 0.00, 1.76, 2.38, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(568, 1, 584, 0.00, 0.70, 0.95, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(569, 1, 585, 165.00, 1.10, 1.49, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(570, 1, 586, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(571, 1, 587, 0.00, 1.50, 2.03, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(572, 1, 588, 0.00, 3.33, 4.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(573, 1, 589, 0.00, 40.00, 54.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(574, 1, 590, 0.00, 12.00, 16.20, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(575, 1, 591, 0.00, 1.19, 1.61, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(576, 1, 592, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(577, 1, 593, 0.00, 0.22, 0.30, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(578, 1, 594, 0.00, 65.00, 87.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(579, 1, 595, 0.00, 0.30, 0.41, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(580, 1, 596, 16.60, 365.00, 492.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(581, 1, 597, 0.00, 380.00, 513.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(582, 1, 598, 0.00, 187.50, 253.13, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(583, 1, 599, 0.00, 380.00, 513.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(584, 1, 600, 0.00, 260.00, 351.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(585, 1, 601, 0.00, 205.00, 276.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(586, 1, 602, 0.00, 205.20, 277.02, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(587, 1, 603, 2.00, 148.00, 199.80, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(588, 1, 604, 17.00, 265.00, 357.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(589, 1, 605, 0.00, 162.00, 218.70, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(590, 1, 606, 0.00, 120.00, 162.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(591, 1, 607, 0.00, 285.00, 384.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(592, 1, 608, 40.00, 285.00, 384.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(593, 1, 609, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(594, 1, 610, 20.00, 150.00, 202.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(595, 1, 611, 0.00, 80.00, 108.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(596, 1, 612, 0.00, 440.00, 594.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(597, 1, 613, 0.00, 80.00, 108.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(598, 1, 614, 10.70, 262.00, 353.70, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(599, 1, 615, 0.00, 205.00, 276.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(600, 1, 616, 0.00, 190.00, 256.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(601, 1, 617, 0.00, 15.00, 20.25, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(602, 1, 618, 0.00, 150.00, 202.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(603, 1, 619, 0.00, 180.00, 243.00, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(604, 1, 620, 0.00, 145.00, 195.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(605, 1, 621, 0.00, 150.00, 202.50, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(606, 1, 622, 40.00, 135.87, 183.42, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(607, 1, 623, 15.00, 180.15, 243.20, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(608, 1, 624, 22.00, 176.24, 237.92, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(609, 1, 625, 0.00, 311.67, 420.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(610, 1, 626, 0.00, 221.00, 298.35, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(611, 1, 627, 0.00, 234.60, 316.71, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(612, 1, 628, 0.00, 15.50, 20.93, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(613, 1, 629, 30.00, 128.00, 172.80, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(614, 1, 630, 0.00, 115.00, 155.25, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(615, 1, 631, 0.00, 225.00, 303.75, 'active', 0, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(616, 1, 632, 15.00, 180.00, 243.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(617, 1, 633, 0.00, 210.00, 283.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(618, 1, 634, 0.00, 320.00, 432.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(619, 1, 635, 3.00, 70.00, 94.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(620, 1, 636, 0.00, 380.00, 513.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(621, 1, 637, 0.00, 710.00, 958.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(622, 1, 638, 2.50, 496.72, 670.57, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(623, 1, 639, 32.00, 60.00, 81.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(624, 1, 640, 13.00, 1.50, 2.03, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(625, 1, 641, 0.00, 50.00, 67.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(626, 1, 642, 0.00, 40.00, 54.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(627, 1, 643, 0.60, 190.00, 256.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(628, 1, 644, 0.00, 60.00, 81.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(629, 1, 645, 0.00, 120.00, 162.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(630, 1, 646, 5.00, 140.00, 189.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(631, 1, 647, 2.50, 60.00, 81.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(632, 1, 648, 1.00, 180.00, 243.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(633, 1, 649, 0.50, 240.00, 324.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(634, 1, 650, 0.00, 450.00, 607.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(635, 1, 651, 0.00, 1.00, 1.35, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(636, 1, 652, 1.20, 70.00, 94.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(637, 1, 653, 2.00, 100.00, 135.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(638, 1, 654, 0.00, 148.82, 200.91, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(639, 1, 655, 3.00, 80.00, 108.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(640, 1, 656, 4.00, 140.00, 189.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(641, 1, 657, 0.00, 30.00, 40.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(642, 1, 658, 0.40, 140.00, 189.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(643, 1, 659, 0.60, 150.00, 202.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(644, 1, 660, 2.00, 380.00, 513.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(645, 1, 661, 0.00, 140.00, 189.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(646, 1, 662, 1.00, 80.00, 108.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(647, 1, 663, 0.00, 396.00, 534.60, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(648, 1, 664, 0.00, 180.00, 243.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(649, 1, 665, 0.00, 200.00, 270.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(650, 1, 666, 1.00, 20.00, 27.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(651, 1, 667, 0.00, 100.00, 135.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(652, 1, 668, 0.50, 120.00, 162.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(653, 1, 669, 1.00, 80.00, 108.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(654, 1, 670, 0.00, 80.00, 108.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(655, 1, 671, 0.50, 150.00, 202.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(656, 1, 672, 12.00, 87.50, 118.13, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(657, 1, 673, 0.00, 80.00, 108.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(658, 1, 674, 0.00, 54.16, 73.12, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(659, 1, 675, 0.00, 1000.00, 1350.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(660, 1, 676, 1.50, 100.00, 135.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(661, 1, 677, 1.30, 150.00, 202.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(662, 1, 678, 5.00, 60.00, 81.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(663, 1, 679, 1.50, 100.00, 135.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(664, 1, 680, 0.00, 240.00, 324.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(665, 1, 681, 0.50, 380.00, 513.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(666, 1, 682, 0.00, 500.00, 675.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(667, 1, 683, 0.60, 180.00, 243.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(668, 1, 684, 0.00, 197.14, 266.14, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(669, 1, 685, 0.00, 100.00, 135.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(670, 1, 686, 0.00, 196.25, 264.94, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(671, 1, 687, 3.00, 100.00, 135.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(672, 1, 688, 2.00, 140.00, 189.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(673, 1, 689, 0.50, 139.00, 187.65, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(674, 1, 690, 0.00, 120.00, 162.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(675, 1, 691, 0.00, 100.00, 135.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(676, 1, 692, 2.00, 180.00, 243.00, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(677, 1, 693, 0.00, 50.00, 67.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(678, 1, 694, 0.00, 70.00, 94.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(679, 1, 695, 0.00, 50.00, 67.50, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(680, 1, 696, 9.00, 6.90, 9.32, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(681, 1, 697, 70.00, 5.00, 6.75, 'active', 0, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(682, 8, 675, 0.00, 0.00, 0.00, 'active', 0, NULL, '2026-03-10 09:05:10', '2026-03-10 09:05:10');

-- --------------------------------------------------------

--
-- Table structure for table `branch_products`
--

CREATE TABLE `branch_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('simple','bundle') NOT NULL DEFAULT 'simple',
  `price` decimal(12,2) NOT NULL,
  `station_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_products`
--

INSERT INTO `branch_products` (`id`, `branch_id`, `product_id`, `type`, `price`, `station_id`, `unit_id`, `status`, `supplier_id`, `quantity`, `created_at`, `updated_at`) VALUES
(145, 1, 174, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(146, 1, 175, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(147, 1, 176, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(148, 1, 177, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(149, 1, 178, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(150, 1, 179, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(151, 1, 180, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(152, 1, 181, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(153, 1, 182, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(154, 1, 183, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(155, 1, 184, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(156, 1, 185, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(157, 1, 186, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(158, 1, 187, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(159, 1, 188, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(160, 1, 189, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(161, 1, 190, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(162, 1, 191, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(163, 1, 192, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(164, 1, 193, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(165, 1, 194, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(166, 1, 195, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(167, 1, 196, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(168, 1, 197, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(169, 1, 198, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(170, 1, 199, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(171, 1, 200, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(172, 1, 201, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(173, 1, 202, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(174, 1, 203, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(175, 1, 204, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(176, 1, 205, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(177, 1, 206, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(178, 1, 207, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(179, 1, 208, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(180, 1, 209, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(181, 1, 210, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(182, 1, 211, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(183, 1, 212, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(184, 1, 213, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(185, 1, 214, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(186, 1, 215, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(187, 1, 216, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(188, 1, 217, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(189, 1, 218, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(190, 1, 219, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(191, 1, 220, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(192, 1, 221, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(193, 1, 222, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(194, 1, 223, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(195, 1, 224, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(196, 1, 225, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(197, 1, 226, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(198, 1, 227, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(199, 1, 228, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(200, 1, 229, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(201, 1, 230, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(202, 1, 231, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(203, 1, 232, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(204, 1, 233, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(205, 1, 234, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(206, 1, 235, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(207, 1, 236, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(208, 1, 237, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(209, 1, 238, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(210, 1, 239, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(211, 1, 240, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(212, 1, 241, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(213, 1, 242, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(214, 1, 243, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(215, 1, 244, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(216, 1, 245, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(217, 1, 246, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(218, 1, 247, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(219, 1, 248, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(220, 1, 249, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(221, 1, 250, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(222, 1, 251, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(223, 1, 252, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(224, 1, 253, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(225, 1, 254, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(226, 1, 255, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(227, 1, 256, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(228, 1, 257, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(229, 1, 258, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(230, 1, 259, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(231, 1, 260, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(232, 1, 261, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(233, 1, 262, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(234, 1, 263, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(235, 1, 264, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(236, 1, 265, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(237, 1, 266, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(238, 1, 267, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(239, 1, 268, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(240, 1, 269, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(241, 1, 270, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(242, 1, 271, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(243, 1, 272, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(244, 1, 273, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(245, 1, 274, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(246, 1, 275, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(247, 1, 276, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(248, 1, 277, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(249, 1, 278, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(250, 1, 279, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(251, 1, 280, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(252, 1, 281, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(253, 1, 282, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(254, 1, 283, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(255, 1, 284, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(256, 1, 285, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(257, 1, 286, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(258, 1, 287, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(259, 1, 288, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(260, 1, 289, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(261, 1, 290, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(262, 1, 291, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(263, 1, 292, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(264, 1, 293, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(265, 1, 294, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(266, 1, 295, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(267, 1, 296, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(268, 1, 297, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(269, 1, 298, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(270, 1, 299, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(271, 1, 300, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(272, 1, 301, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(273, 1, 302, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(274, 1, 303, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(275, 1, 304, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(276, 1, 305, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(277, 1, 306, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(278, 1, 307, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(279, 1, 308, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(280, 1, 309, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(281, 1, 310, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(282, 1, 311, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(283, 1, 312, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(284, 1, 313, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(285, 1, 314, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(286, 1, 315, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(287, 1, 316, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(288, 1, 317, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(289, 1, 318, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(290, 1, 319, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(291, 1, 320, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(292, 1, 321, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(293, 1, 322, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(294, 1, 323, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(295, 1, 324, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(296, 1, 325, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(297, 1, 326, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(298, 1, 327, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(299, 1, 328, 'simple', 0.00, NULL, 13, 'active', NULL, 0.00, '2026-03-12 03:13:24', '2026-03-12 03:13:24');

-- --------------------------------------------------------

--
-- Table structure for table `branch_role`
--

CREATE TABLE `branch_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_role`
--

INSERT INTO `branch_role` (`id`, `branch_id`, `role_id`, `created_at`, `updated_at`) VALUES
(17, 8, 5, '2026-02-11 02:01:50', '2026-02-11 02:01:50'),
(24, 7, 4, '2026-02-11 02:12:44', '2026-02-11 02:12:44'),
(27, 4, 5, '2026-02-11 02:19:36', '2026-02-11 02:19:36'),
(31, 1, 7, '2026-02-11 02:23:50', '2026-02-11 02:23:50'),
(36, 1, 5, '2026-02-11 06:43:32', '2026-02-11 06:43:32'),
(37, 1, 6, '2026-02-11 06:43:32', '2026-02-11 06:43:32');

-- --------------------------------------------------------

--
-- Table structure for table `branch_user`
--

CREATE TABLE `branch_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_user`
--

INSERT INTO `branch_user` (`id`, `user_id`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 20, 8, NULL, NULL),
(2, 20, 6, NULL, NULL),
(3, 15, 1, NULL, NULL),
(5, 20, 4, NULL, NULL),
(6, 15, 6, NULL, NULL),
(7, 15, 4, NULL, NULL),
(24, 20, 7, NULL, NULL),
(27, 20, 1, NULL, NULL),
(33, 79, 1, NULL, NULL),
(56, 104, 1, NULL, NULL),
(60, 19, 1, NULL, NULL),
(61, 19, 7, NULL, NULL),
(62, 19, 6, NULL, NULL),
(63, 17, 8, NULL, NULL),
(64, 56, 8, NULL, NULL),
(65, 16, 6, NULL, NULL),
(66, 106, 6, NULL, NULL),
(67, 107, 1, NULL, NULL),
(78, 110, 1, NULL, NULL),
(86, 110, 6, NULL, NULL),
(87, 107, 6, NULL, NULL),
(88, 111, 1, NULL, NULL),
(89, 112, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bundle_items`
--

CREATE TABLE `bundle_items` (
  `bundle_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `item_type` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_audits`
--

CREATE TABLE `cash_audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cash_audit_record_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `cashier_id` bigint(20) UNSIGNED NOT NULL,
  `terminal_no` varchar(255) NOT NULL,
  `transaction_datetime` datetime DEFAULT NULL,
  `starting_fund` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_breakdown` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_breakdown`)),
  `total_sales` decimal(12,2) NOT NULL DEFAULT 0.00,
  `receivable` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tip` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shortage` decimal(12,2) NOT NULL DEFAULT 0.00,
  `overage` decimal(12,2) NOT NULL DEFAULT 0.00,
  `transfer_to` varchar(100) DEFAULT NULL,
  `transfer_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `d_1000` int(11) DEFAULT NULL,
  `d_500` int(11) DEFAULT NULL,
  `d_200` int(11) DEFAULT NULL,
  `d_100` int(11) DEFAULT NULL,
  `d_50` int(11) DEFAULT NULL,
  `d_20` int(11) DEFAULT NULL,
  `d_10` int(11) DEFAULT NULL,
  `d_5` int(11) DEFAULT NULL,
  `d_1` int(11) DEFAULT NULL,
  `d_050` int(11) DEFAULT NULL,
  `d_025` int(11) DEFAULT NULL,
  `d_010` int(11) DEFAULT NULL,
  `d_005` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('open','closed','pending','completed') NOT NULL DEFAULT 'open',
  `closed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_audits`
--

INSERT INTO `cash_audits` (`id`, `cash_audit_record_id`, `reference_no`, `branch_id`, `cashier_id`, `terminal_no`, `transaction_datetime`, `starting_fund`, `payment_breakdown`, `total_sales`, `receivable`, `tip`, `shortage`, `overage`, `transfer_to`, `transfer_amount`, `d_1000`, `d_500`, `d_200`, `d_100`, `d_50`, `d_20`, `d_10`, `d_5`, `d_1`, `d_050`, `d_025`, `d_010`, `d_005`, `remarks`, `status`, `closed_at`, `created_at`, `updated_at`) VALUES
(7, NULL, NULL, 1, 20, 'T1', NULL, 2500.00, NULL, 0.00, 0.00, 0.00, 2500.00, 0.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'closed', '2025-11-12 06:53:42', '2025-11-11 21:04:44', '2025-11-11 22:53:42'),
(9, NULL, NULL, 1, 20, 'T1', NULL, 4000.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'closed', NULL, '2025-11-12 17:05:44', '2025-11-12 17:05:44'),
(11, NULL, NULL, 1, 20, 'Windows_NOEL', NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '6', 900.00, NULL, 1, 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'closed', '2025-11-13 08:03:55', '2025-11-12 23:23:24', '2025-11-13 00:03:55'),
(12, NULL, NULL, 1, 20, 'Windows_NOEL', NULL, 2500.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '6', 990.00, 2, 2, 2, NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'closed', '2025-11-24 14:39:14', '2025-11-13 17:31:08', '2025-11-24 06:39:14'),
(13, NULL, NULL, 8, 20, 'Windows_NOEL', '2025-12-11 09:04:00', 3000.00, '[]', 0.00, 0.00, 0.00, 0.00, 0.00, '6', 0.00, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'closed', '2025-12-11 09:07:27', '2025-11-24 06:42:58', '2025-12-11 01:07:27'),
(16, NULL, NULL, 8, 20, 'Windows_NOEL', '2025-12-11 13:19:00', 2000.00, '{\"debit_card\":{\"name\":\"Debit Card\",\"total\":771.43,\"breakdown\":{\"BDO\":771.43}},\"gcash\":{\"name\":\"GCash\",\"total\":1000,\"breakdown\":{\"GCash\":1000}},\"cash\":{\"name\":\"Cash\",\"total\":250,\"breakdown\":{\"Cash On Hand\":250}}}', 0.00, 0.00, 0.00, 0.00, 0.00, '6', 0.00, 2, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'closed', '2025-12-11 13:23:37', '2025-12-11 01:20:50', '2025-12-11 05:23:37'),
(18, NULL, 'TRN-08-00018', 8, 20, 'Windows_NOEL', '2025-12-17 11:38:00', 6000.00, '[]', 0.00, 0.00, 0.00, 0.00, 0.00, '6', 6000.00, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2025-12-17 11:40:05', '2025-12-11 05:24:57', '2025-12-17 03:40:05'),
(22, NULL, 'TRN-08-00022', 8, 20, 'Windows_NOEL', '2026-01-19 10:12:00', 5000.00, '[]', 0.00, 0.00, 0.00, 0.00, 1150.00, '6', 6150.00, 6, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2026-01-19 10:14:37', '2025-12-17 03:43:29', '2026-01-19 02:14:37'),
(24, 2, 'TRN-01-00024', 1, 20, 'Windows_NOEL', '2026-01-21 11:38:00', 3000.00, '{\"gcash\":{\"name\":\"GCash\",\"total\":42.86,\"breakdown\":{\"GCash\":42.86}},\"cash\":{\"name\":\"Cash\",\"total\":900,\"breakdown\":{\"Cash On Hand\":900}}}', 0.00, 0.00, 0.00, 0.00, 0.00, '6', 3900.00, 3, 1, NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'completed', '2026-01-21 11:42:06', '2026-01-21 01:16:03', '2026-01-21 03:46:42'),
(26, NULL, NULL, 8, 20, 'Windows_NOEL', '2026-01-23 10:13:55', 2500.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'open', NULL, '2026-01-23 02:13:55', '2026-01-23 02:13:55'),
(27, NULL, 'TRN-01-00027', 1, 20, 'Windows_NOEL', '2026-03-06 09:11:00', 5000.00, '{\"gcash\":{\"name\":\"GCash\",\"total\":2500,\"breakdown\":{\"GCash\":2500}},\"cash\":{\"name\":\"Cash\",\"total\":9961.84,\"breakdown\":{\"Cash On Hand\":3990.96}}}', 0.00, 0.00, 0.00, 5704.84, 0.00, '16', 9257.00, 9, NULL, NULL, 2, 1, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, 'short of P1', 'pending', '2026-03-06 09:19:42', '2026-01-26 05:26:53', '2026-03-06 01:19:42'),
(30, NULL, NULL, 4, 20, 'Windows_NOEL', '2026-01-29 10:19:28', 6500.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'open', NULL, '2026-01-29 02:19:28', '2026-01-29 02:19:28'),
(31, NULL, NULL, 6, 20, 'Windows_NOEL', '2026-02-02 10:29:22', 3500.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'open', NULL, '2026-02-02 02:29:22', '2026-02-02 02:29:22'),
(33, 3, 'TRN-01-00033', 1, 15, 'Windows_Kyle', '2026-02-11 14:47:00', 3000.00, '[]', 0.00, 0.00, 0.00, 0.00, 0.00, '1', 3000.00, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'completed', '2026-02-11 14:48:51', '2026-02-11 06:05:10', '2026-02-11 07:13:24'),
(34, 3, 'TRN-01-00034', 1, 15, 'Windows_Kyle', '2026-02-11 15:08:00', 2500.00, '{\"cash\":{\"name\":\"Cash\",\"total\":450,\"breakdown\":{\"Cash On Hand\":450}},\"gcash\":{\"name\":\"GCash\",\"total\":500,\"breakdown\":{\"GCash\":500}}}', 0.00, 0.00, 0.00, 0.00, 0.00, '1', 2950.00, 2, 1, NULL, 4, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'completed', '2026-02-11 15:10:50', '2026-02-11 06:49:31', '2026-02-11 07:13:24'),
(35, NULL, 'TRN-01-00035', 1, 15, 'Windows_Kyle', '2026-02-11 15:35:00', 1000.00, '[]', 0.00, 0.00, 0.00, 0.00, 0.00, '1', 1000.00, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2026-02-11 15:35:47', '2026-02-11 07:31:28', '2026-02-11 07:35:47'),
(36, NULL, NULL, 1, 15, 'Windows_Kyle', '2026-02-11 15:37:22', 1000.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'open', NULL, '2026-02-11 07:37:22', '2026-02-11 07:37:22'),
(37, NULL, 'TRN-01-00037', 1, 20, 'Windows_NOEL', '2026-03-06 09:44:00', 1000.00, '{\"cash\":{\"name\":\"Cash\",\"total\":4624.25,\"breakdown\":{\"Cash On Hand\":4624.25}},\"gcash\":{\"name\":\"GCash\",\"total\":500,\"breakdown\":{\"GCash\":500}}}', 0.00, 0.00, 0.00, 0.00, 200.75, '18', 5825.00, 5, NULL, NULL, 8, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, 'over 1.65', 'pending', '2026-03-06 09:51:41', '2026-03-06 01:37:00', '2026-03-06 01:51:41'),
(38, NULL, NULL, 1, 20, 'Windows_NOEL', '2026-03-12 12:02:36', 1000.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'open', NULL, '2026-03-12 04:02:36', '2026-03-12 04:02:36');

-- --------------------------------------------------------

--
-- Table structure for table `cash_audit_records`
--

CREATE TABLE `cash_audit_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entry_datetime` datetime NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `submitted_by` bigint(20) UNSIGNED NOT NULL,
  `total_amount` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`total_amount`)),
  `transfer_to` bigint(20) UNSIGNED DEFAULT NULL,
  `transfer_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','completed') NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_audit_records`
--

INSERT INTO `cash_audit_records` (`id`, `entry_datetime`, `reference_no`, `submitted_by`, `total_amount`, `transfer_to`, `transfer_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, '2025-12-17 11:37:00', 'CAR-01-00001', 15, '{\"total_transferred\":8000}', NULL, 8000.00, 'completed', '2025-12-17 03:37:47', '2025-12-17 03:37:47'),
(2, '2026-01-21 11:46:00', 'CAR-01-00002', 20, '{\"total_transferred\":8400}', NULL, 8400.00, 'completed', '2026-01-21 03:46:42', '2026-01-21 03:46:42'),
(3, '2026-02-11 15:12:00', 'CAR-01-00003', 15, '{\"total_transferred\":5950}', NULL, 5950.00, 'completed', '2026-02-11 07:13:24', '2026-02-11 07:13:24');

-- --------------------------------------------------------

--
-- Table structure for table `cash_equivalents`
--

CREATE TABLE `cash_equivalents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accountable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `type_of_account` varchar(255) DEFAULT NULL,
  `conversion_in_peso` decimal(15,2) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_equivalents`
--

INSERT INTO `cash_equivalents` (`id`, `accountable_id`, `name`, `account_number`, `type_of_account`, `conversion_in_peso`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(2, NULL, 'Petty Cash', '123', 'Dollar Account', NULL, 15, 'archived', '2025-10-12 23:10:30', '2025-10-12 23:20:54'),
(3, NULL, 'Revolving Fund', 'Cheng', 'Peso Account', 2.00, 15, 'active', '2025-10-12 23:41:19', '2026-02-05 03:39:15'),
(4, NULL, 'BDO', 'BDO1111111', 'Peso Account', 1.00, 15, 'active', '2025-10-13 01:05:27', '2025-11-24 05:47:00'),
(5, NULL, 'GCash', '09775688750', 'Peso Account', 1.00, 15, 'active', '2025-10-13 19:41:33', '2025-10-13 19:41:33'),
(7, NULL, 'China Bank', 'CBC11111', 'Peso Account', 1.00, 20, 'active', '2025-11-24 08:30:47', '2025-11-24 08:30:47'),
(10, NULL, 'Change Fund', 'Chain', NULL, NULL, 20, 'active', '2026-02-09 00:43:23', '2026-02-09 00:43:23'),
(11, 15, 'Change Fund', '88900', NULL, NULL, 15, 'active', '2026-02-09 03:59:06', '2026-02-09 03:59:06'),
(12, 112, 'Change Fund', '0992', NULL, NULL, 15, 'active', '2026-02-11 06:45:42', '2026-02-11 06:45:42'),
(13, 104, 'Union Bank', '123456', NULL, NULL, 20, 'active', '2026-02-12 02:03:16', '2026-03-17 09:01:08'),
(16, 15, 'Cash On Hand', '0', NULL, NULL, 15, 'active', '2026-02-12 08:07:55', '2026-02-12 08:07:55'),
(17, 20, 'Cash On Hand', '0', NULL, NULL, 20, 'active', '2026-02-13 02:37:29', '2026-02-13 02:37:29'),
(18, 107, 'Cash On Hand', 'Karen', NULL, NULL, 15, 'active', '2026-03-06 01:25:53', '2026-03-06 01:25:53');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `created_by`) VALUES
(2, 'Groceries', 'Essential food items and pantry staples available for purchase.', 'active', '2025-09-24 18:28:00', '2026-02-09 03:33:53', NULL),
(3, 'Food', 'Hearty dishes served as the centerpiece of the meal.', 'active', '2025-09-24 18:33:00', '2026-02-09 03:33:24', NULL),
(4, 'Drinks', 'Refreshing beverages served hot or cold.', 'active', '2025-09-26 00:11:00', '2026-02-09 03:32:37', NULL),
(14, 'Miscellaneous', 'Miscellaneous', 'active', '2025-10-09 18:36:49', '2025-10-09 18:36:49', 15),
(16, 'Vegetables', 'Freshly prepared vegetable dishes served as sides or light mains.', 'active', '2026-01-23 02:32:00', '2026-02-09 03:31:41', 15),
(19, 'Meat', NULL, 'active', '2026-02-23 05:23:06', '2026-02-23 05:23:06', 20),
(20, 'Seafoods', NULL, 'active', '2026-03-10 03:44:19', '2026-03-10 03:44:19', 20),
(22, 'Foods', NULL, 'active', '2026-03-10 08:57:32', '2026-03-10 08:57:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chart_accounts`
--

CREATE TABLE `chart_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `classification` enum('credit','debit') NOT NULL,
  `tax_mapping` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `accounting_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `accounting_subcategory_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chart_accounts`
--

INSERT INTO `chart_accounts` (`id`, `code`, `name`, `classification`, `tax_mapping`, `created_by`, `status`, `created_at`, `updated_at`, `accounting_category_id`, `accounting_subcategory_id`) VALUES
(1, '2103', 'SSS Payable', 'debit', 'N/A', 20, 'active', '2026-02-27 08:38:42', '2026-03-05 06:35:19', 76, 10),
(2, '2101', 'Accounts Payable - Trade', 'debit', 'N/A', 20, 'active', '2026-02-27 08:40:10', '2026-03-05 06:33:56', 76, 10),
(3, '2106', 'Withholding Tax', 'debit', '1601EQ / 1601C', 20, 'active', '2026-03-05 03:35:45', '2026-03-05 06:33:46', 76, 10),
(4, '2104', 'PhilHealth Payable', 'debit', NULL, 20, 'active', '2026-03-05 06:37:07', '2026-03-05 06:37:07', 76, 10),
(5, '2105', 'Pag-IBIG Payable', 'debit', NULL, 20, 'active', '2026-03-05 06:37:55', '2026-03-05 06:37:55', 76, 10),
(6, '2196', 'Withholding Tax Payable', 'debit', NULL, 20, 'active', '2026-03-05 06:38:32', '2026-03-05 06:38:32', 76, 10),
(7, '2107', 'VAT Payable (Output VAT)', 'debit', NULL, 20, 'active', '2026-03-05 06:39:00', '2026-03-05 06:39:00', 76, 10),
(8, '6101', 'Salaries & Wages', 'debit', NULL, 20, 'active', '2026-03-05 06:43:43', '2026-03-05 06:49:59', 79, 14),
(9, '6102', 'Overtime Pay', 'debit', NULL, 20, 'active', '2026-03-05 06:44:13', '2026-03-05 06:49:49', 79, 14),
(10, '6202', 'Utilities - Electricity', 'debit', NULL, 20, 'active', '2026-03-05 06:44:48', '2026-03-05 06:58:26', 79, 15),
(11, '6203', 'Utilities - Water', 'debit', NULL, 20, 'active', '2026-03-05 06:45:14', '2026-03-05 06:49:22', 79, 15),
(12, '6204', 'Internet Expense', 'debit', NULL, 20, 'active', '2026-03-05 06:45:36', '2026-03-05 06:49:10', 79, 15),
(13, '6301', 'Office Supplies', 'debit', NULL, 20, 'active', '2026-03-05 06:45:59', '2026-03-05 06:48:58', 79, 16),
(14, '6302', 'Repairs & Maintenance', 'debit', NULL, 20, 'active', '2026-03-05 06:46:23', '2026-03-05 06:48:49', 79, 16),
(15, '4101', 'Food Sales', 'credit', NULL, 20, 'active', '2026-03-05 06:51:03', '2026-03-05 06:54:14', 78, 12),
(16, '4102', 'Beverage Sales', 'credit', NULL, 20, 'active', '2026-03-05 06:51:25', '2026-03-05 06:54:05', 78, 12),
(17, '4105', 'Service Charge Income', 'credit', NULL, 20, 'active', '2026-03-05 06:51:55', '2026-03-05 06:53:56', 78, 12),
(18, '1104', 'Petty Cash Fund', 'credit', NULL, 20, 'active', '2026-03-05 06:53:34', '2026-03-05 06:53:34', 75, 7),
(19, '1105', 'Accounts Receivable', 'credit', NULL, 20, 'active', '2026-03-05 06:54:53', '2026-03-05 06:54:53', 75, 7),
(20, '1106', 'Employee Advances', 'credit', NULL, 20, 'active', '2026-03-05 06:55:16', '2026-03-05 06:55:16', 75, 7),
(21, '1110', 'Input VAT', 'credit', NULL, 20, 'active', '2026-03-05 06:55:41', '2026-03-05 06:55:41', 75, 7);

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE `components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `onhand` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `image` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `for_sale` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`id`, `supplier_id`, `name`, `brand_name`, `code`, `cost`, `price`, `unit_id`, `onhand`, `status`, `image`, `remarks`, `for_sale`, `category_id`, `subcategory_id`, `created_at`, `updated_at`) VALUES
(366, NULL, 'BIB 7-Up', NULL, 'D0001', 0.00, 0.00, 7, 0, 'active', NULL, NULL, 1, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(367, NULL, 'BIB Iced Tea', NULL, 'D0002', 0.00, 0.00, 7, 0, 'active', NULL, NULL, 1, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(368, NULL, 'BIB Mirinda', NULL, 'D0003', 0.00, 0.00, 7, 0, 'active', NULL, NULL, 1, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(369, NULL, 'BIB Mountain Dew', NULL, 'D0004', 0.00, 0.00, 7, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(370, NULL, 'BIB Mug', NULL, 'D0005', 0.00, 0.00, 7, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(371, NULL, 'BIB Pepsi', NULL, 'D0006', 0.00, 0.00, 7, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(372, NULL, 'BIB Pepsi Max', NULL, 'D0007', 0.00, 0.00, 7, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(373, NULL, 'Cerveza Negra', NULL, 'D0008', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(374, NULL, 'Corona Beer', NULL, 'D0009', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(375, NULL, 'Heineken Beer', NULL, 'D0010', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(376, NULL, 'Heineken Lager', NULL, 'D0011', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(377, NULL, 'Pale Pilsen', NULL, 'D0012', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(378, NULL, 'Pale Pilsen October', NULL, 'D0013', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(379, NULL, 'Red Horse', NULL, 'D0014', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 1, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(380, NULL, 'Red Horse 1L', NULL, 'D0015', 0.00, 0.00, 5, 0, 'active', 'components/HfA8rwDplkfX9f5hHk2bDTLjnS7PwxF7nmFQ2trM.png', NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-12 04:20:53'),
(381, NULL, 'Red Horse 500ml', NULL, 'D0016', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 1, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(382, NULL, 'Super Dry', NULL, 'D0017', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(383, NULL, 'Tiger Beer', NULL, 'D0018', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(384, NULL, 'Tiger Black', NULL, 'D0019', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(385, NULL, 'Tiger Crystal Light', NULL, 'D0020', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(386, NULL, 'Alcoholic Malt Apple', NULL, 'D0021', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(387, NULL, 'Alcoholic Malt Lemon', NULL, 'D0022', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(388, NULL, 'Tanduay Ice', NULL, 'D0023', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(389, NULL, 'Vodka Ice', NULL, 'D0024', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(390, NULL, '7-UP', NULL, 'D0025', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(391, NULL, 'Pepsi 1.5L', NULL, 'D0026', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(392, NULL, 'Pepsi 500ml', NULL, 'D0027', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(393, NULL, 'Pepsi 850ml', NULL, 'D0028', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(394, NULL, 'Mineral Big', NULL, 'D0029', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(395, NULL, 'Mineral Small', NULL, 'D0030', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(396, NULL, 'Mirinda', NULL, 'D0031', 0.00, 0.00, 8, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(397, NULL, 'Mountain Dew', NULL, 'D0032', 0.00, 0.00, 8, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(398, NULL, 'Mug', NULL, 'D0033', 0.00, 0.00, 8, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(399, NULL, 'Pepsi', NULL, 'D0034', 0.00, 0.00, 8, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(400, NULL, 'Pepsi Light', NULL, 'D0035', 0.00, 0.00, 8, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(401, NULL, 'Pepsi Max', NULL, 'D0036', 0.00, 0.00, 8, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(402, NULL, 'Upgrade Softdrink', NULL, 'D0037', 0.00, 0.00, 8, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(403, NULL, 'Nestle Lemonade 1k', NULL, 'D0038', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(404, NULL, 'Mango Juice', NULL, 'D0039', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(405, NULL, 'Orange Juice', NULL, 'D0040', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(406, NULL, 'Pineapple Juice', NULL, 'D0041', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(407, NULL, 'Lipton Ice tea 1L', NULL, 'D0042', 0.00, 0.00, 11, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(408, NULL, 'Cappuccino', NULL, 'D0043', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(409, NULL, 'Latte', NULL, 'D0044', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(410, NULL, 'Coffee', NULL, 'D0045', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(411, NULL, 'Lipton tea', NULL, 'D0046', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 4, 36, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(412, NULL, 'Apricot Brandy', NULL, 'D0047', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(413, NULL, 'Carlos 1 700ml', NULL, 'D0048', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(414, NULL, 'Carlos 1 Liter', NULL, 'D0049', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(415, NULL, 'Fundador Exclu Liter', NULL, 'D0050', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(416, NULL, 'Fundador Exclu Reg', NULL, 'D0051', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(417, NULL, 'Fundador Gold Reg', NULL, 'D0052', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(418, NULL, 'Fundador Liter', NULL, 'D0053', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(419, NULL, 'Fundador Regular', NULL, 'D0054', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(420, NULL, 'Local Brandy', NULL, 'D0055', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(421, NULL, 'Remy Martin VSOP', NULL, 'D0056', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(422, NULL, 'Remy Martin XO', NULL, 'D0057', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(423, NULL, 'Local Gin', NULL, 'D0058', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(424, NULL, 'Lime Juice', NULL, 'D0059', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(425, NULL, 'Grenadine', NULL, 'D0060', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(426, NULL, 'Bacardi Gold', NULL, 'D0061', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(427, NULL, 'Bacardi Light Rhum', NULL, 'D0062', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(428, NULL, 'Local Rhum', NULL, 'D0063', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(429, NULL, 'Malibu', NULL, 'D0064', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(430, NULL, 'Absolut Vodka Reg.', NULL, 'D0065', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(431, NULL, 'Citron Vodka', NULL, 'D0066', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(432, NULL, 'Local Vodka', NULL, 'D0067', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(433, NULL, 'Ballantines', NULL, 'D0068', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(434, NULL, 'Chivas Regal Liter', NULL, 'D0069', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(435, NULL, 'Chivas Regal Regular', NULL, 'D0070', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(436, NULL, 'Cutty Sark 700ml', NULL, 'D0071', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(437, NULL, 'Cutty Sark Liter', NULL, 'D0072', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(438, NULL, 'Glenffedich', NULL, 'D0073', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(439, NULL, 'J & B Liter', NULL, 'D0074', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(440, NULL, 'J & B Regular', NULL, 'D0075', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(441, NULL, 'J.Walker Black Liter', NULL, 'D0076', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(442, NULL, 'J.Walker Black Reg.', NULL, 'D0077', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(443, NULL, 'J.Walker Blue Liter', NULL, 'D0078', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(444, NULL, 'J.Walker Blue Reg.', NULL, 'D0079', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(445, NULL, 'J.Walker Gold Reg.', NULL, 'D0080', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(446, NULL, 'J.Walker Green Liter', NULL, 'D0081', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(447, NULL, 'J.Walker Green Reg.', NULL, 'D0082', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(448, NULL, 'J.Walker Red 700ml', NULL, 'D0083', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(449, NULL, 'J.Walker Red Liter', NULL, 'D0084', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(450, NULL, 'J.Walker Red Reg.', NULL, 'D0085', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(451, NULL, 'Jack Daniels 700ml', NULL, 'D0086', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(452, NULL, 'Jack Daniels Liter', NULL, 'D0087', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(453, NULL, 'Jack Daniels Regular', NULL, 'D0088', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(454, NULL, 'Local Whisky', NULL, 'D0089', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 4, 23, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(458, NULL, 'Rice', NULL, 'F0001', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 3, 6, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(459, NULL, 'Lemon', NULL, 'G0001', 0.00, 0.00, 5, 0, 'active', NULL, NULL, 0, 2, 39, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(460, NULL, 'Anchovies', NULL, 'G0002', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(461, NULL, 'Bilbao', NULL, 'G0003', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(462, NULL, 'Black Beans', NULL, 'G0004', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(463, NULL, 'Black Olives', NULL, 'G0005', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(464, NULL, 'Black Pepper', NULL, 'G0006', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(465, NULL, 'Bulaklak ng Saging', NULL, 'G0007', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(466, NULL, 'Butter', NULL, 'G0008', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(467, NULL, 'Capers', NULL, 'G0009', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(468, NULL, 'Cheese Whiz', NULL, 'G0010', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(469, NULL, 'Coconut Milk Powder', NULL, 'G0011', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(470, NULL, 'Curry Powder', NULL, 'G0012', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(471, NULL, 'Dried Alamang', NULL, 'G0013', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(472, NULL, 'Graham', NULL, 'G0014', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(473, NULL, 'Ground Pepper', NULL, 'G0015', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(474, NULL, 'Ground Saffron', NULL, 'G0016', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(475, NULL, 'Italian Seasoning', NULL, 'G0017', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(476, NULL, 'Kernel Corn', NULL, 'G0018', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(477, NULL, 'Laurel Leaves', NULL, 'G0019', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(478, NULL, 'Mustard', NULL, 'G0020', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(479, NULL, 'Nata De Coco', NULL, 'G0021', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(480, NULL, 'Orange Marmalade', NULL, 'G0022', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(481, NULL, 'Paprika Ground', NULL, 'G0023', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(482, NULL, 'Parmesan Cheese', NULL, 'G0024', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(483, NULL, 'Pineapple Sliced', NULL, 'G0025', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(484, NULL, 'Pineapple Tidbits', NULL, 'G0026', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(485, NULL, 'Raisins', NULL, 'G0027', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(486, NULL, 'Rosemary Leaves', NULL, 'G0028', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(487, NULL, 'Sesame Seed', NULL, 'G0029', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(488, NULL, 'Sinigang Paste', NULL, 'G0030', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(489, NULL, 'Sour Cream', NULL, 'G0031', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(490, NULL, 'Star Anis', NULL, 'G0032', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(491, NULL, 'Tomato Paste', NULL, 'G0033', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(492, NULL, 'Tumeric Ground', NULL, 'G0034', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(493, NULL, 'Wasabi Powder', NULL, 'G0035', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(494, NULL, 'White Pepper', NULL, 'G0036', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(495, NULL, 'Yeast', NULL, 'G0037', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(496, NULL, 'Azuete', NULL, 'G0038', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(497, NULL, 'Baking Powder', NULL, 'G0039', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(498, NULL, 'Banana Ketchup', NULL, 'G0040', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(499, NULL, 'Beef Broth', NULL, 'G0041', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(500, NULL, 'Bihon', NULL, 'G0042', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(501, NULL, 'Bread Crumbs', NULL, 'G0043', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(502, NULL, 'Canton Noodles', NULL, 'G0044', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(503, NULL, 'Chami Noodles', NULL, 'G0045', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(504, NULL, 'Cheddar Cheese', NULL, 'G0046', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(505, NULL, 'Chicken Broth', NULL, 'G0047', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(506, NULL, 'Chicken Powder', NULL, 'G0048', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(507, NULL, 'Chili Ketchup', NULL, 'G0049', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(508, NULL, 'Cornstarch', NULL, 'G0050', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(509, NULL, 'Cream Cheese', NULL, 'G0051', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(510, NULL, 'Demi Glace', NULL, 'G0052', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(511, NULL, 'Diced Tomato', NULL, 'G0053', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(512, NULL, 'Flat Noodles', NULL, 'G0054', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(513, NULL, 'Flour', NULL, 'G0055', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(514, NULL, 'French Fries', NULL, 'G0056', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(515, NULL, 'Garbanzos', NULL, 'G0057', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(516, NULL, 'Green Gulaman', NULL, 'G0058', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(517, NULL, 'Iodized Salt', NULL, 'G0059', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(518, NULL, 'Kare-Kare Paste', NULL, 'G0060', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(519, NULL, 'Lasagna Noodles', NULL, 'G0061', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(520, NULL, 'Liver Spread', NULL, 'G0062', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(521, NULL, 'Mang Tomas', NULL, 'G0063', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(522, NULL, 'Miki Noodles', NULL, 'G0064', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(523, NULL, 'Mozarella Cheese', NULL, 'G0065', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(524, NULL, 'Nestle Thick Cream', NULL, 'G0066', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(525, NULL, 'Oyster Sauce', NULL, 'G0067', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(526, NULL, 'Peanut Butter', NULL, 'G0068', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(527, NULL, 'Pickles', NULL, 'G0069', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(528, NULL, 'Quick Melt', NULL, 'G0070', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(529, NULL, 'Red Pimiento', NULL, 'G0071', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(530, NULL, 'Rock Salt', NULL, 'G0072', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(531, NULL, 'Sotanghon', NULL, 'G0073', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(532, NULL, 'Spaghetti Noodles', NULL, 'G0074', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(533, NULL, 'Spaghetti Sauce', NULL, 'G0075', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(534, NULL, 'Star Margarine', NULL, 'G0076', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(535, NULL, 'Sugar', NULL, 'G0077', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(536, NULL, 'Sweet Chili Bottle', NULL, 'G0078', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(537, NULL, 'Sweet Chili Sauce', NULL, 'G0079', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(538, NULL, 'Sweet Spicy Sauce', NULL, 'G0080', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(539, NULL, 'Tamarind Soup Base', NULL, 'G0081', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(540, NULL, 'Thick Cream', NULL, 'G0082', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(541, NULL, 'Thousand Island', NULL, 'G0083', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(542, NULL, 'Tomato Catsup', NULL, 'G0084', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(543, NULL, 'Tomato Sauce', NULL, 'G0085', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(544, NULL, 'Tortilla Chips', NULL, 'G0086', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(545, NULL, 'Whole Mushroom', NULL, 'G0087', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(546, NULL, 'Cooking Oil', NULL, 'G0088', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(547, NULL, 'All Purpose Cream', NULL, 'G0089', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(548, NULL, 'Balsamic Vinegar', NULL, 'G0090', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(549, NULL, 'BBQ Marinade', NULL, 'G0091', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(550, NULL, 'Canola Oil', NULL, 'G0092', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(551, NULL, 'Condensed Milk', NULL, 'G0093', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(552, NULL, 'Evaporated Milk', NULL, 'G0094', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(553, NULL, 'Fresh Milk', NULL, 'G0095', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 4, 19, '2026-03-10 06:34:27', '2026-03-12 04:11:40'),
(554, NULL, 'Kikoman', NULL, 'G0096', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(555, NULL, 'Mayonnaise', NULL, 'G0097', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(556, NULL, 'Olive Oil', NULL, 'G0098', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(557, NULL, 'Patis', NULL, 'G0099', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(558, NULL, 'Red Hot Pepper Sauce', NULL, 'G0100', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(559, NULL, 'Sesame Oil', NULL, 'G0101', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(560, NULL, 'Shanghai Soy Sauce', NULL, 'G0102', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(561, NULL, 'Soy Sauce', NULL, 'G0103', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(562, NULL, 'Teriyaki Sauce', NULL, 'G0104', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(563, NULL, 'Vegetable Oil', NULL, 'G0105', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(564, NULL, 'Vinegar', NULL, 'G0106', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(565, NULL, 'Hot Sauce', NULL, 'G0107', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 37, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(566, NULL, 'Seasoning', NULL, 'G0108', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 37, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(567, NULL, 'Coconut Brand SoySos', NULL, 'G0109', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(568, NULL, 'Mushroom Soy Sauce', NULL, 'G0110', 0.00, 0.00, 9, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(569, NULL, 'Honey', NULL, 'G0111', 0.00, 0.00, 10, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(570, NULL, 'Vanilla', NULL, 'G0112', 0.00, 0.00, 10, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(571, NULL, 'Worcestershire Sauce', NULL, 'G0113', 0.00, 0.00, 10, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(572, NULL, 'Mango Float Big', NULL, 'G0114', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(573, NULL, 'Green Mango', NULL, 'G0115', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 39, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(574, NULL, 'Cafe Latte', NULL, 'G0116', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(575, NULL, 'Cheese Sliced', NULL, 'G0117', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(576, NULL, 'Cherry', NULL, 'G0118', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(577, NULL, 'French Bread', NULL, 'G0119', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(578, NULL, 'Pizza Crust', NULL, 'G0120', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(579, NULL, 'Ripe Mango', NULL, 'G0121', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 39, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(580, NULL, 'Creamer', NULL, 'G0122', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(581, NULL, 'Egg', NULL, 'G0123', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(582, NULL, 'Hotdog Buns', NULL, 'G0124', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(583, NULL, 'Lumpia Wrapper', NULL, 'G0125', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(584, NULL, 'Molo Wrapper', NULL, 'G0126', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(585, NULL, 'Paper Bag', NULL, 'G0127', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(586, NULL, 'Paper Plate', NULL, 'G0128', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(587, NULL, 'Quail Egg', NULL, 'G0129', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(588, NULL, 'Sliced Bread', NULL, 'G0130', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(589, NULL, 'Buko', NULL, 'G0131', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 39, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(590, NULL, 'Dayap', NULL, 'G0132', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 39, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(591, NULL, 'Sugar Sachet', NULL, 'G0133', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(592, NULL, 'Sugar Syrup', NULL, 'G0134', 0.00, 0.00, 12, 0, 'active', NULL, NULL, 0, 2, 2, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(593, NULL, 'Fresh Orange', NULL, 'G0135', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 39, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(594, NULL, 'Melon', NULL, 'G0136', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 2, 39, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(595, NULL, 'Ham', NULL, 'M0001', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(596, NULL, 'Beef Shoulder', NULL, 'M0002', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 31, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(597, NULL, 'Camto', NULL, 'M0003', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 31, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(598, NULL, 'Ground Beef', NULL, 'M0004', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 31, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(599, NULL, 'Kalitiran', NULL, 'M0005', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 31, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(600, NULL, 'Top Round', NULL, 'M0006', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 31, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(601, NULL, 'Breast Fillet', NULL, 'M0007', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 32, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(602, NULL, 'Ground Chicken', NULL, 'M0008', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 32, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(603, NULL, 'Leg Quarter', NULL, 'M0009', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 32, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(604, NULL, 'Leg Quarter Fillet', NULL, 'M0010', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 32, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(605, NULL, 'Sliced Chicken', NULL, 'M0011', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 32, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(606, NULL, 'Balat ng Baboy', NULL, 'M0012', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(607, NULL, 'Ground Pork', NULL, 'M0013', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(608, NULL, 'Liempo', NULL, 'M0014', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(609, NULL, 'Liempo (Laga)', NULL, 'M0015', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(610, NULL, 'Mukha', NULL, 'M0016', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(611, NULL, 'Mukha (1st Fry)', NULL, 'M0017', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(612, NULL, 'Mukha (Chicharon)', NULL, 'M0018', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(613, NULL, 'Mukha (Laga)', NULL, 'M0019', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(614, NULL, 'Pigue', NULL, 'M0020', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(615, NULL, 'Pigue (Laga)', NULL, 'M0021', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(616, NULL, 'Pork Belly', NULL, 'M0022', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(617, NULL, 'Pork Blood', NULL, 'M0023', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(618, NULL, 'Pork Casim', NULL, 'M0024', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(619, NULL, 'Pork Loin', NULL, 'M0025', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(620, NULL, 'Pork Ribs', NULL, 'M0026', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(621, NULL, 'Longganisa', NULL, 'M0027', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(622, NULL, 'Bulalo', NULL, 'M0028', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 19, 31, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(623, NULL, 'Whole Chicken', NULL, 'M0029', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 19, 32, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(624, NULL, 'Pata', NULL, 'M0030', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(625, NULL, 'Pata Large', NULL, 'M0031', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(626, NULL, 'Pata Medium', NULL, 'M0032', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(627, NULL, 'Pata Regular', NULL, 'M0033', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(628, NULL, 'Hungarian', NULL, 'M0034', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 19, 30, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(629, NULL, 'Fish Fillet', NULL, 'S0001', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 20, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(630, NULL, 'Lumot', NULL, 'S0002', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 20, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(631, NULL, 'Salmon Belly', NULL, 'S0003', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 20, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(632, NULL, 'Squid Giant', NULL, 'S0004', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 20, NULL, '2026-03-10 06:34:27', '2026-03-10 06:34:27'),
(633, NULL, 'Squid Ring', NULL, 'S0005', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 20, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(634, NULL, 'Tuna Belly', NULL, 'S0006', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 20, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(635, NULL, 'Alamang', NULL, 'S0007', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 20, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(636, NULL, 'Gambas', NULL, 'S0008', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 20, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(637, NULL, 'Prawns', NULL, 'S0009', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 20, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(638, NULL, 'Suahe', NULL, 'S0010', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 20, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(639, NULL, 'Boneless Bangus', NULL, 'S0011', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 20, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(640, NULL, 'Squid Balls', NULL, 'S0012', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 20, NULL, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(641, NULL, 'Basil Leaves', NULL, 'V0001', 0.00, 0.00, 3, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(642, NULL, 'Asparagus', NULL, 'V0002', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(643, NULL, 'Baguio Beans', NULL, 'V0003', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(644, NULL, 'Beans', NULL, 'V0004', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(645, NULL, 'Broccoli', NULL, 'V0005', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(646, NULL, 'Cabbage', NULL, 'V0006', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(647, NULL, 'Calamansi', NULL, 'V0007', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(648, NULL, 'Carrots', NULL, 'V0008', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(649, NULL, 'Cauliflower', NULL, 'V0009', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(650, NULL, 'Celery', NULL, 'V0010', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(651, NULL, 'Cilantro', NULL, 'V0011', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(652, NULL, 'Corn (Fresh)', NULL, 'V0012', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(653, NULL, 'Cucumber', NULL, 'V0013', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(654, NULL, 'Dried Mushroom', NULL, 'V0014', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(655, NULL, 'Eggplant', NULL, 'V0015', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(656, NULL, 'Fresh Peanuts', NULL, 'V0016', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(657, NULL, 'Gabi Leaves', NULL, 'V0017', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(658, NULL, 'Garlic', NULL, 'V0018', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(659, NULL, 'Ginger', NULL, 'V0019', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(660, NULL, 'Green Bell Pepper', NULL, 'V0020', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(661, NULL, 'Hot Pepper Leaves', NULL, 'V0021', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(662, NULL, 'Kangkong', NULL, 'V0022', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(663, NULL, 'Kinchay', NULL, 'V0023', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(664, NULL, 'Lettuce', NULL, 'V0024', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(665, NULL, 'Mint Leaves', NULL, 'V0025', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(666, NULL, 'Miso', NULL, 'V0026', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(667, NULL, 'Monggo', NULL, 'V0027', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(668, NULL, 'Mustasa', NULL, 'V0028', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(669, NULL, 'Okra', NULL, 'V0029', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(670, NULL, 'Onion Leeks', NULL, 'V0030', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(671, NULL, 'Onion Red', NULL, 'V0031', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(672, NULL, 'Onion White', NULL, 'V0032', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(673, NULL, 'Pandan Leaves', NULL, 'V0033', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(674, NULL, 'Papaya', NULL, 'V0034', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(675, NULL, 'Parsley', NULL, 'V0035', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(676, NULL, 'Pechay Tagalog', NULL, 'V0036', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(677, NULL, 'Potato', NULL, 'V0037', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(678, NULL, 'Puso ng Saging', NULL, 'V0038', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(679, NULL, 'Raddish', NULL, 'V0039', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(680, NULL, 'Red Beans', NULL, 'V0040', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(681, NULL, 'Red Bell Pepper', NULL, 'V0041', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(682, NULL, 'Sili Labuyo', NULL, 'V0042', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(683, NULL, 'Sili Sigang', NULL, 'V0043', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(684, NULL, 'Sitsaro', NULL, 'V0044', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(685, NULL, 'Spinach', NULL, 'V0045', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(686, NULL, 'Spring Onion', NULL, 'V0046', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(687, NULL, 'Squash', NULL, 'V0047', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(688, NULL, 'String Beans', NULL, 'V0048', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(689, NULL, 'Sweet Peas', NULL, 'V0049', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(690, NULL, 'Tanglad', NULL, 'V0050', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(691, NULL, 'Toge', NULL, 'V0051', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(692, NULL, 'Tomato', NULL, 'V0052', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(693, NULL, 'Ubod', NULL, 'V0053', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(694, NULL, 'Winged Bean', NULL, 'V0054', 0.00, 0.00, 4, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(695, NULL, 'Niyog', NULL, 'V0055', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(696, NULL, 'Saba', NULL, 'V0056', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28'),
(697, NULL, 'Tokwa', NULL, 'V0057', 0.00, 0.00, 2, 0, 'active', NULL, NULL, 0, 16, 29, '2026-03-10 06:34:28', '2026-03-10 06:34:28');

-- --------------------------------------------------------

--
-- Table structure for table `contact_persons`
--

CREATE TABLE `contact_persons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_persons`
--

INSERT INTO `contact_persons` (`id`, `user_id`, `name`, `contact_number`, `address`, `created_at`, `updated_at`) VALUES
(6, 51, 'michael jordan sr', '88888888', 'kasambagan', '2026-01-09 06:31:33', '2026-01-09 06:31:33'),
(8, 20, 'Aida', '3333333', 'cordova', '2026-01-16 02:25:44', '2026-01-23 01:59:24'),
(10, 17, NULL, NULL, NULL, '2026-01-22 00:45:32', '2026-01-22 00:45:32'),
(11, 16, NULL, NULL, NULL, '2026-01-22 00:58:27', '2026-01-22 00:58:27'),
(12, 15, NULL, NULL, NULL, '2026-01-22 08:04:49', '2026-01-22 08:04:49'),
(13, 79, NULL, NULL, NULL, '2026-01-22 08:05:07', '2026-01-22 08:05:07'),
(26, 19, NULL, NULL, NULL, '2026-02-09 06:54:21', '2026-02-09 06:54:21'),
(27, 56, NULL, NULL, NULL, '2026-02-09 06:59:01', '2026-02-09 06:59:01'),
(28, 107, NULL, NULL, NULL, '2026-02-11 01:28:41', '2026-02-11 01:28:41'),
(29, 110, NULL, NULL, NULL, '2026-02-11 01:42:11', '2026-02-11 01:42:11'),
(30, 111, NULL, NULL, NULL, '2026-02-11 06:02:01', '2026-02-11 06:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_no` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `customer_since` date DEFAULT NULL,
  `landline_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `assigned_personnel` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(255) DEFAULT NULL,
  `credit_limit` decimal(10,2) DEFAULT NULL,
  `payment_terms_days` int(11) DEFAULT NULL,
  `customer_type` varchar(255) DEFAULT NULL,
  `discount_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_no`, `customer_name`, `company_name`, `mobile_no`, `customer_since`, `landline_no`, `email`, `address`, `status`, `assigned_personnel`, `province`, `city_municipality`, `credit_limit`, `payment_terms_days`, `customer_type`, `discount_id`, `created_at`, `updated_at`) VALUES
(1, 'CUS-000001', 'qwer', '12321', '12312', '2025-10-23', '123', 'enforcer1@gmail.com', 'J.M Ceniza St. Looc Mandaue City, Cebu Philippines', 'archived', 'Juan', 'Ilocos Sur', 'Banayoyo', 22.00, NULL, 'individual', 11, '2025-10-22 21:35:48', '2025-10-22 21:42:44'),
(2, 'CUS-000002', 'Gon', 'HxH', '+93922', '2025-10-23', '990-23', 'kill@hxh.com', 'J.M Ceniza St. Looc Mandaue City, Cebu Philippines', 'active', 'Junjun', 'Batanes', 'Itbayat', 9000.00, 15, 'regular_customer', 10, '2025-10-22 21:41:00', '2025-10-22 22:27:10'),
(3, 'CUS-000003', 'Noel', 'Omni System', '09997629273', '2025-10-23', '9900-239-2', 'new@gmail.com', 'New Street', 'active', 'Miguel', 'Cebu', 'Cordova', 10000.00, 30, 'vip_customer', 12, '2025-10-22 22:28:18', '2025-10-22 22:28:18'),
(4, 'CUS-000004', 'Michael Jackson', NULL, '07178785412', NULL, NULL, 'mj@yahoo.com', NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-24 06:36:07', '2026-02-24 06:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `daily_time_records`
--

CREATE TABLE `daily_time_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `salary_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `time_in_reports` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`time_in_reports`)),
  `other_reports` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`other_reports`)),
  `time_out_reports` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`time_out_reports`)),
  `status` enum('rest_day','absent','late','under_time','worked') NOT NULL DEFAULT 'worked',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_time_records`
--

INSERT INTO `daily_time_records` (`id`, `date`, `user_id`, `salary_method_id`, `activity`, `time`, `time_in_reports`, `other_reports`, `time_out_reports`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '2026-01-20', 16, NULL, 'time_in', '15:55:00', NULL, NULL, NULL, 'worked', 15, '2026-01-20 08:29:08', '2026-01-20 08:29:08'),
(2, '2026-01-26', 15, 39, 'time_in', '14:49:00', NULL, NULL, NULL, 'worked', 15, '2026-01-26 07:15:49', '2026-01-26 07:15:49'),
(20, '2026-02-01', 19, 68, 'time_in_reports', '07:00:00', '[\"07:15\"]', '[\"start_overtime: 15:00\"]', '[\"15:15\"]', 'worked', 15, '2026-02-12 06:51:07', '2026-02-16 03:16:09'),
(21, '2026-02-02', 19, 68, NULL, NULL, '[\"06:50\"]', '[\"start_overtime: 16:00\"]', NULL, 'worked', 15, '2026-02-12 08:50:56', '2026-02-12 08:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Sales', 20, 'active', '2025-11-14 06:34:38', '2025-11-14 06:34:38'),
(7, 'Accounting', 20, 'active', '2025-11-14 06:35:17', '2025-11-14 06:35:17'),
(8, 'IT', 20, 'active', '2025-11-14 06:35:26', '2025-11-14 06:35:26'),
(13, 'Water', 15, 'archived', '2025-11-14 06:57:33', '2025-11-27 03:38:44'),
(15, 'Like', 15, 'archived', '2025-11-14 07:10:42', '2025-11-27 03:38:36'),
(17, 'Purchasing', 15, 'active', '2025-11-14 07:22:36', '2025-11-27 03:37:59'),
(19, 'Front of House', 15, 'active', '2025-11-14 07:34:34', '2026-01-30 08:12:05'),
(20, 'Back of House', 20, 'active', '2026-01-30 08:09:55', '2026-01-30 08:12:17'),
(21, 'Admin', 20, 'active', '2026-02-09 03:21:10', '2026-02-09 03:21:10');

-- --------------------------------------------------------

--
-- Table structure for table `dependents`
--

CREATE TABLE `dependents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dependents`
--

INSERT INTO `dependents` (`id`, `user_id`, `name`, `birthdate`, `age`, `gender`, `relationship`, `created_at`, `updated_at`) VALUES
(7, 51, 'michael jordan jr', '2000-02-02', 25, 'Male', 'Son', '2026-01-09 06:34:01', '2026-01-09 06:34:01');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `status`, `created_at`, `updated_at`, `created_by`) VALUES
(2, 'Cashier', 'active', '2025-12-05 08:36:03', '2026-01-30 08:27:39', 20),
(3, 'Cook', 'active', '2025-12-05 08:36:18', '2026-01-30 08:26:16', 20),
(4, 'Sales and Marketing', 'active', '2025-12-05 08:36:34', '2025-12-05 08:36:34', 20),
(5, 'Manager', 'active', '2025-12-05 08:36:44', '2025-12-05 08:36:44', 20),
(6, 'IT Developer', 'active', '2026-01-30 05:12:37', '2026-01-30 05:12:37', 20),
(7, 'Director', 'active', '2026-01-30 05:12:46', '2026-01-30 05:12:46', 20),
(8, 'Waiter', 'active', '2026-01-30 05:12:54', '2026-01-30 08:27:07', 20),
(9, 'Maintenance/Utility', 'active', '2026-01-30 05:13:00', '2026-01-30 08:25:44', 20),
(10, 'Dishwasher', 'active', '2026-01-30 05:13:11', '2026-01-30 08:25:17', 20),
(11, 'Owner', 'active', '2026-01-30 05:40:11', '2026-01-30 08:24:53', 15),
(12, 'Supervisor', 'active', '2026-01-30 08:29:45', '2026-01-30 08:29:45', 15),
(13, 'Bartender', 'active', '2026-02-09 03:24:29', '2026-02-09 03:24:29', 20),
(14, 'Chef', 'active', '2026-02-09 03:25:14', '2026-02-09 03:25:14', 20),
(15, 'Dishwasher/Steward', 'active', '2026-02-09 03:25:36', '2026-02-09 03:25:36', 20);

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `name`, `type`, `value`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(10, 'Senior Citizen', 'percentage', 20.00, 15, 'active', '2025-10-08 19:57:28', '2025-10-08 19:57:28'),
(11, 'PWD', 'percentage', 20.00, 15, 'active', '2025-10-08 19:57:40', '2025-10-08 19:57:40'),
(12, 'VIP', 'percentage', 10.00, 15, 'active', '2025-10-09 22:38:48', '2025-10-09 22:38:48'),
(13, 'Atlhete', 'percentage', 20.00, 15, 'active', '2025-10-09 22:41:51', '2025-10-09 22:41:51'),
(14, 'Single Parents', 'percentage', 10.00, 15, 'active', '2025-10-14 00:24:35', '2025-10-14 00:24:35');

-- --------------------------------------------------------

--
-- Table structure for table `discount_entries`
--

CREATE TABLE `discount_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `discount_id` bigint(20) UNSIGNED NOT NULL,
  `person_name` varchar(255) DEFAULT NULL,
  `person_id_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount_entries`
--

INSERT INTO `discount_entries` (`id`, `order_id`, `discount_id`, `person_name`, `person_id_number`, `created_at`, `updated_at`) VALUES
(46, 92, 11, 'newfield', '32', '2025-10-16 18:55:04', '2025-10-16 18:55:04'),
(100, 184, 10, '184', '184', '2026-01-30 02:00:08', '2026-01-30 02:00:08'),
(101, 186, 10, 'ENGR', 'E123', '2026-01-30 03:26:48', '2026-01-30 03:26:48'),
(102, 186, 10, 'O;I', 'UT', '2026-01-30 04:23:42', '2026-01-30 04:23:42'),
(103, 186, 10, 'O;I', 'UT', '2026-01-30 04:23:43', '2026-01-30 04:23:43'),
(104, 191, 10, 'tee', '231', '2026-02-02 08:32:47', '2026-02-02 08:32:47'),
(105, 194, 10, 'karlos', '123', '2026-02-03 02:28:06', '2026-02-03 02:28:06'),
(106, 194, 11, 'juan', '231', '2026-02-03 02:28:06', '2026-02-03 02:28:06'),
(107, 194, 10, 'karlos', '123', '2026-02-03 02:28:09', '2026-02-03 02:28:09'),
(108, 194, 11, 'juan', '231', '2026-02-03 02:28:09', '2026-02-03 02:28:09'),
(109, 194, 10, 'karlos', '123', '2026-02-03 02:28:09', '2026-02-03 02:28:09'),
(110, 194, 11, 'juan', '231', '2026-02-03 02:28:09', '2026-02-03 02:28:09'),
(111, 194, 10, 'karlos', '123', '2026-02-03 02:28:09', '2026-02-03 02:28:09'),
(112, 194, 11, 'juan', '231', '2026-02-03 02:28:09', '2026-02-03 02:28:09'),
(113, 194, 10, 'karlos', '123', '2026-02-03 02:28:10', '2026-02-03 02:28:10'),
(114, 194, 11, 'juan', '231', '2026-02-03 02:28:10', '2026-02-03 02:28:10'),
(115, 194, 10, 'karlos', '123', '2026-02-03 02:28:10', '2026-02-03 02:28:10'),
(116, 194, 11, 'juan', '231', '2026-02-03 02:28:10', '2026-02-03 02:28:10'),
(117, 194, 10, 'karlos', '123', '2026-02-03 02:28:11', '2026-02-03 02:28:11'),
(118, 194, 11, 'juan', '231', '2026-02-03 02:28:11', '2026-02-03 02:28:11'),
(119, 194, 10, 'karlos', '123', '2026-02-03 02:28:11', '2026-02-03 02:28:11'),
(120, 194, 11, 'juan', '231', '2026-02-03 02:28:11', '2026-02-03 02:28:11'),
(121, 194, 10, 'karlos', '123', '2026-02-03 02:28:11', '2026-02-03 02:28:11'),
(122, 194, 11, 'juan', '231', '2026-02-03 02:28:11', '2026-02-03 02:28:11'),
(123, 194, 10, 'karlos', '123', '2026-02-03 02:28:11', '2026-02-03 02:28:11'),
(124, 194, 11, 'juan', '231', '2026-02-03 02:28:11', '2026-02-03 02:28:11'),
(125, 194, 10, 'karlos', '123', '2026-02-03 02:28:11', '2026-02-03 02:28:11'),
(126, 194, 11, 'juan', '231', '2026-02-03 02:28:11', '2026-02-03 02:28:11'),
(127, 194, 10, 'karlos', '123', '2026-02-03 02:28:12', '2026-02-03 02:28:12'),
(128, 194, 11, 'juan', '231', '2026-02-03 02:28:12', '2026-02-03 02:28:12'),
(129, 194, 10, 'karlos', '123', '2026-02-03 02:28:12', '2026-02-03 02:28:12'),
(130, 194, 11, 'juan', '231', '2026-02-03 02:28:12', '2026-02-03 02:28:12'),
(131, 194, 10, 'karlos', '123', '2026-02-03 02:28:12', '2026-02-03 02:28:12'),
(132, 194, 11, 'juan', '231', '2026-02-03 02:28:12', '2026-02-03 02:28:12'),
(133, 194, 10, 'karlos', '123', '2026-02-03 02:28:12', '2026-02-03 02:28:12'),
(134, 194, 11, 'juan', '231', '2026-02-03 02:28:12', '2026-02-03 02:28:12'),
(135, 194, 10, 'karlos', '123', '2026-02-03 02:28:13', '2026-02-03 02:28:13'),
(136, 194, 11, 'juan', '231', '2026-02-03 02:28:13', '2026-02-03 02:28:13'),
(137, 194, 10, 'karlos', '123', '2026-02-03 02:28:13', '2026-02-03 02:28:13'),
(138, 194, 11, 'juan', '231', '2026-02-03 02:28:13', '2026-02-03 02:28:13'),
(139, 194, 10, 'karlos', '123', '2026-02-03 02:28:13', '2026-02-03 02:28:13'),
(140, 194, 11, 'juan', '231', '2026-02-03 02:28:13', '2026-02-03 02:28:13'),
(141, 194, 10, 'karlos', '123', '2026-02-03 02:28:13', '2026-02-03 02:28:13'),
(142, 194, 11, 'juan', '231', '2026-02-03 02:28:13', '2026-02-03 02:28:13'),
(143, 194, 10, 'karlos', '123', '2026-02-03 02:28:13', '2026-02-03 02:28:13'),
(144, 194, 11, 'juan', '231', '2026-02-03 02:28:13', '2026-02-03 02:28:13'),
(145, 194, 10, 'karlos', '123', '2026-02-03 02:28:14', '2026-02-03 02:28:14'),
(146, 194, 11, 'juan', '231', '2026-02-03 02:28:14', '2026-02-03 02:28:14'),
(147, 194, 10, 'karlos', '123', '2026-02-03 02:28:14', '2026-02-03 02:28:14'),
(148, 194, 11, 'juan', '231', '2026-02-03 02:28:14', '2026-02-03 02:28:14'),
(149, 194, 10, 'karlos', '123', '2026-02-03 02:28:14', '2026-02-03 02:28:14'),
(150, 194, 11, 'juan', '231', '2026-02-03 02:28:14', '2026-02-03 02:28:14'),
(151, 202, 10, 'juni', '33', '2026-02-03 03:15:57', '2026-02-03 03:15:57'),
(152, 202, 11, 'LIE', '22', '2026-02-03 03:15:57', '2026-02-03 03:15:57'),
(153, 209, 10, 'kuyakoy', '2223', '2026-02-03 06:16:03', '2026-02-03 06:16:03'),
(154, 211, 10, 'test', '213', '2026-02-03 07:50:10', '2026-02-03 07:50:10'),
(155, 214, 10, 'test2', '332', '2026-02-03 08:41:11', '2026-02-03 08:41:11'),
(156, 214, 11, 'test1', '223', '2026-02-03 08:41:11', '2026-02-03 08:41:11'),
(163, 221, 10, '123', '213', '2026-02-04 05:38:06', '2026-02-04 05:38:06'),
(164, 221, 11, 'dfsf', '321', '2026-02-04 05:38:06', '2026-02-04 05:38:06'),
(187, 222, 10, 'sdf', '123', '2026-02-04 05:58:17', '2026-02-04 05:58:17'),
(188, 222, 11, 'sdf', '213', '2026-02-04 05:58:17', '2026-02-04 05:58:17'),
(191, 229, 10, 'dfg', '123', '2026-02-06 02:37:00', '2026-02-06 02:37:00'),
(192, 229, 11, 'gfddfg', '123', '2026-02-06 02:37:00', '2026-02-06 02:37:00'),
(193, 230, 10, '34', '34', '2026-02-06 02:54:16', '2026-02-06 02:54:16'),
(194, 232, 11, 'sdf', 'sdf', '2026-02-09 01:02:39', '2026-02-09 01:02:39'),
(195, 232, 13, 'sdf', 'sdf', '2026-02-09 01:02:39', '2026-02-09 01:02:39'),
(196, 236, 11, 'fsdfsd', '232', '2026-02-09 06:44:40', '2026-02-09 06:44:40'),
(197, 236, 11, 'fsdfsd', '232', '2026-02-09 06:44:41', '2026-02-09 06:44:41'),
(198, 243, 10, 'dfsf', '12324', '2026-02-09 07:20:33', '2026-02-09 07:20:33'),
(199, 247, 11, 'fdssdf', '12312', '2026-02-09 08:25:12', '2026-02-09 08:25:12'),
(200, 248, 11, 'sdf', 'sdf', '2026-02-09 08:28:07', '2026-02-09 08:28:07'),
(201, 250, 11, 'fdsdf', '12342', '2026-02-09 08:45:34', '2026-02-09 08:45:34'),
(202, 249, 11, 'asdf', 'asdf', '2026-02-09 08:55:00', '2026-02-09 08:55:00'),
(203, 252, 10, 'ggf', '22', '2026-02-11 00:36:26', '2026-02-11 00:36:26'),
(204, 253, 10, 'sssd', '23', '2026-02-11 00:57:30', '2026-02-11 00:57:30'),
(205, 254, 10, 'dsd', '321', '2026-02-11 01:07:16', '2026-02-11 01:07:16'),
(206, 255, 10, 'fdsfsd', '12312', '2026-02-11 01:11:18', '2026-02-11 01:11:18'),
(207, 256, 10, 'fdsfd', 's123', '2026-02-11 01:15:02', '2026-02-11 01:15:02'),
(208, 257, 10, 'fsdf', '123', '2026-02-11 01:17:13', '2026-02-11 01:17:13'),
(209, 258, 10, 'fsdfsd', '123', '2026-02-11 01:27:21', '2026-02-11 01:27:21'),
(210, 259, 10, 'fdsdfs', '123', '2026-02-11 01:29:45', '2026-02-11 01:29:45'),
(211, 260, 11, 'fsdfs', '123', '2026-02-11 01:34:07', '2026-02-11 01:34:07'),
(212, 224, 11, 'qer', 'qwer', '2026-02-11 02:29:42', '2026-02-11 02:29:42'),
(213, 261, 10, 'dsfsd', '123', '2026-02-11 02:39:59', '2026-02-11 02:39:59'),
(214, 263, 10, 'Teodora', '009223', '2026-02-11 03:23:21', '2026-02-11 03:23:21'),
(215, 264, 10, 'new', '123', '2026-02-11 03:39:37', '2026-02-11 03:39:37'),
(216, 265, 10, 'trwefew', '123', '2026-02-11 03:47:10', '2026-02-11 03:47:10'),
(217, 266, 10, 'newtest', '12312', '2026-02-11 03:51:19', '2026-02-11 03:51:19'),
(218, 267, 10, 'rffds', '12312', '2026-02-11 03:56:38', '2026-02-11 03:56:38'),
(219, 268, 11, 'fsdfsd', '12312', '2026-02-11 03:57:50', '2026-02-11 03:57:50'),
(220, 269, 11, 'sfsdds', '12321', '2026-02-11 03:59:50', '2026-02-11 03:59:50'),
(221, 271, 10, 'fdsfdssf', '12312', '2026-02-11 04:01:55', '2026-02-11 04:01:55'),
(222, 270, 10, 'fdsfsd', '213', '2026-02-11 04:03:59', '2026-02-11 04:03:59'),
(223, 272, 10, 'dfsfsdsdf', '123', '2026-02-11 04:06:44', '2026-02-11 04:06:44'),
(224, 273, 10, 'sdfsd', '12312', '2026-02-11 04:12:03', '2026-02-11 04:12:03'),
(225, 274, 10, 'fdsfds', '123', '2026-02-11 04:15:03', '2026-02-11 04:15:03'),
(226, 275, 10, 'test', '123', '2026-02-11 04:18:22', '2026-02-11 04:18:22'),
(227, 276, 10, 'kyle1', '2312', '2026-02-11 04:23:11', '2026-02-11 04:23:11'),
(228, 277, 10, 'test22', '123', '2026-02-11 04:27:10', '2026-02-11 04:27:10'),
(229, 278, 10, 'fdsfds', '123', '2026-02-11 04:28:50', '2026-02-11 04:28:50'),
(230, 279, 10, 'loyi', '212', '2026-02-11 04:31:58', '2026-02-11 04:31:58'),
(231, 280, 10, 'juan', '22', '2026-02-11 05:01:45', '2026-02-11 05:01:45'),
(232, 281, 10, 'karen', '23', '2026-02-11 05:12:48', '2026-02-11 05:12:48'),
(233, 282, 10, 'karen', '1234', '2026-02-11 07:04:39', '2026-02-11 07:04:39'),
(234, 283, 11, 'sdsdf', '123', '2026-02-12 00:52:47', '2026-02-12 00:52:47'),
(235, 286, 11, 'fsdfs', '123', '2026-02-12 02:40:04', '2026-02-12 02:40:04'),
(236, 235, 11, '345', '345', '2026-02-12 07:42:07', '2026-02-12 07:42:07'),
(237, 204, 11, 'pwd#', 'pwd name', '2026-02-13 02:33:39', '2026-02-13 02:33:39'),
(238, 285, 10, 'asdf', 'sdf', '2026-02-16 05:12:33', '2026-02-16 05:12:33'),
(239, 285, 11, 'SDF', 'SDF', '2026-02-18 01:42:16', '2026-02-18 01:42:16'),
(240, 286, 10, 'new2', '2312', '2026-02-18 05:59:03', '2026-02-18 05:59:03'),
(241, 288, 10, 'gfdfg', '123', '2026-02-18 06:02:01', '2026-02-18 06:02:01'),
(242, 285, 11, 'sss', 'sss', '2026-02-18 06:06:59', '2026-02-18 06:06:59'),
(243, 285, 11, 'ddd', 'ddd', '2026-02-18 06:06:59', '2026-02-18 06:06:59'),
(244, 293, 10, 'df', 'sdf', '2026-02-24 06:47:28', '2026-02-24 06:47:28'),
(245, 284, 10, '12', '12', '2026-03-12 08:35:48', '2026-03-12 08:35:48'),
(246, 295, 11, 'asdf', 'sadf', '2026-03-16 03:22:15', '2026-03-16 03:22:15'),
(247, 295, 12, 'asdf', 'sadf', '2026-03-16 03:22:15', '2026-03-16 03:22:15'),
(248, 295, 13, 'sadf', 'sadf', '2026-03-16 03:22:15', '2026-03-16 03:22:15'),
(249, 295, 14, 'asdf', 'sdf', '2026-03-16 03:22:15', '2026-03-16 03:22:15'),
(250, 295, 11, 'sadf', 'asdf', '2026-03-16 03:25:29', '2026-03-16 03:25:29'),
(251, 295, 13, '345', '345', '2026-03-16 03:25:29', '2026-03-16 03:25:29'),
(252, 295, 11, 'sdaf', 'sadf', '2026-03-16 03:42:28', '2026-03-16 03:42:28'),
(253, 295, 13, 'asdf', 'sadf', '2026-03-16 03:42:28', '2026-03-16 03:42:28'),
(254, 296, 11, 'dh', 'fsgh', '2026-03-16 03:44:09', '2026-03-16 03:44:09'),
(255, 296, 13, 'asdf', 'sadf', '2026-03-16 03:44:09', '2026-03-16 03:44:09'),
(256, 297, 11, 'Chris', '251251', '2026-03-16 06:07:11', '2026-03-16 06:07:11'),
(257, 297, 13, 'Kyle', '12223', '2026-03-16 06:07:11', '2026-03-16 06:07:11'),
(258, 296, 11, 'dfg', 'dfg', '2026-03-16 06:47:39', '2026-03-16 06:47:39'),
(259, 296, 13, 'dfg', 'dfg', '2026-03-16 06:47:39', '2026-03-16 06:47:39'),
(260, 298, 11, 'sdfg', 'sdf', '2026-03-16 07:41:08', '2026-03-16 07:41:08'),
(261, 298, 13, 'sadf', 'sdf', '2026-03-16 07:41:08', '2026-03-16 07:41:08'),
(262, 294, 11, 'asdf', 'asdf', '2026-03-17 09:06:12', '2026-03-17 09:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `educational_backgrounds`
--

CREATE TABLE `educational_backgrounds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name_of_school` varchar(255) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `tenure_start` date DEFAULT NULL,
  `tenure_end` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educational_backgrounds`
--

INSERT INTO `educational_backgrounds` (`id`, `user_id`, `name_of_school`, `level`, `tenure_start`, `tenure_end`, `created_at`, `updated_at`) VALUES
(44, 20, 'AMACC', NULL, NULL, NULL, '2026-02-11 01:31:10', '2026-02-11 01:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `employee_work_informations`
--

CREATE TABLE `employee_work_informations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `hire_date` date DEFAULT NULL,
  `employment_status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `regularization` date DEFAULT NULL,
  `designation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `direct_supervisor` varchar(255) DEFAULT NULL,
  `monthly_rate` decimal(12,2) DEFAULT NULL,
  `daily_rate` decimal(12,2) DEFAULT NULL,
  `hourly_rate` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_work_informations`
--

INSERT INTO `employee_work_informations` (`id`, `user_id`, `hire_date`, `employment_status_id`, `regularization`, `designation_id`, `department_id`, `direct_supervisor`, `monthly_rate`, `daily_rate`, `hourly_rate`, `created_at`, `updated_at`) VALUES
(35, 79, '2024-01-01', 2, NULL, 7, 8, NULL, NULL, NULL, NULL, '2026-02-09 07:00:51', '2026-02-09 07:00:51'),
(36, 15, '2024-01-01', 2, NULL, 5, 19, 'admin', 10000.00, 1000.00, 10.00, '2026-02-09 07:01:55', '2026-02-09 07:01:55'),
(46, 56, '2026-01-01', 2, NULL, 10, 20, 'Karl', 10000.00, 1000.00, 10.00, '2026-02-09 07:11:08', '2026-02-09 07:11:08'),
(47, 56, '2026-02-01', 2, NULL, 13, 19, 'Karl', 12000.00, 1200.00, 12.00, '2026-02-09 07:11:08', '2026-02-09 07:11:08'),
(48, 56, '2026-03-03', 3, NULL, 3, 20, 'Karl', 13000.00, 1300.00, 13.00, '2026-02-09 07:11:08', '2026-02-09 07:11:08'),
(50, 106, '2025-01-01', NULL, NULL, 7, NULL, 'admin', 50000.00, 5000.00, 50.00, '2026-02-09 07:15:04', '2026-02-09 07:15:04'),
(54, 20, '2026-01-30', 1, NULL, 8, 8, NULL, NULL, NULL, NULL, '2026-02-11 01:31:10', '2026-02-11 01:31:10'),
(73, 107, '2024-01-01', 2, NULL, 3, 20, 'Karl', 15000.00, 15015.00, NULL, '2026-02-11 02:24:31', '2026-02-11 02:24:31'),
(74, 16, '2025-01-01', 1, NULL, 15, 20, 'Karl', 10000.00, 1000.00, 10.00, '2026-02-11 03:30:08', '2026-02-11 03:30:08'),
(75, 16, '2026-01-01', 2, NULL, 13, 19, 'Karl', 12000.00, 120.00, 12.00, '2026-02-11 03:30:08', '2026-02-11 03:30:08'),
(77, 111, '2026-02-11', 1, NULL, 14, 20, 'Kyle', 12000.00, 1000.00, 100.00, '2026-02-11 06:02:01', '2026-02-11 06:02:01'),
(78, 112, '2026-02-11', 1, NULL, 3, 20, 'admin', 12000.00, 1000.00, 100.00, '2026-02-11 06:43:32', '2026-02-11 06:43:32'),
(79, 17, '2025-01-01', 2, NULL, 5, 20, 'admin', 10000.00, 1000.00, 10.00, '2026-02-19 08:30:22', '2026-02-19 08:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fund_transfers`
--

CREATE TABLE `fund_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_number` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `method_of_transfer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_cash_equivalent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `to_cash_equivalent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `status` enum('pending','approved','archived') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_datetime` datetime DEFAULT NULL,
  `archived_by` bigint(20) UNSIGNED DEFAULT NULL,
  `archived_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fund_transfers`
--

INSERT INTO `fund_transfers` (`id`, `branch_id`, `reference_number`, `created_by`, `method_of_transfer_id`, `from_cash_equivalent_id`, `to_cash_equivalent_id`, `amount`, `description`, `attachments`, `status`, `approved_by`, `approved_datetime`, `archived_by`, `archived_datetime`, `created_at`, `updated_at`) VALUES
(1, NULL, '123', 15, 9, NULL, 4, 100.00, 'test newss', NULL, 'archived', NULL, NULL, NULL, NULL, '2025-11-18 03:06:19', '2025-11-18 08:43:25'),
(2, NULL, '2', 15, 8, 2, 3, 150.00, 'Assemble', NULL, 'approved', NULL, NULL, NULL, NULL, '2025-11-18 06:39:03', '2025-11-18 07:08:28'),
(3, NULL, '12312', 15, 11, 5, 5, 222.00, 'test', '[\"fund_transfer_attachments\\/4SyiXEmchPQ3fvSo2USvBHaHjBtazuiqBhszFw2g.pdf\"]', 'pending', NULL, NULL, NULL, NULL, '2025-11-18 08:08:54', '2025-11-18 08:55:57'),
(4, NULL, '321', 15, 11, 2, 3, 250.00, 'tted', NULL, 'approved', NULL, NULL, NULL, NULL, '2025-11-18 08:10:17', '2025-11-18 08:43:18'),
(5, NULL, '009', 15, 8, 2, 3, 750.00, 'trapsis', '[\"fund_transfer_attachments\\/ArrrGoxDREQWtEpjo5k6iSOixOD0LQBHQJSLjMiW.pdf\"]', 'approved', NULL, NULL, NULL, NULL, '2025-11-18 08:10:46', '2025-11-18 08:55:48'),
(6, NULL, 'FT0001', 20, 8, 4, NULL, 50000.00, NULL, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-11-20 01:18:59', '2025-11-20 01:18:59'),
(7, NULL, '990', 15, 8, 2, NULL, 100.00, 'News', NULL, 'pending', NULL, NULL, NULL, NULL, '2025-11-24 06:55:49', '2025-11-24 06:55:49'),
(8, NULL, '455', 15, 8, NULL, 5, 222.00, 'test', NULL, 'pending', NULL, NULL, NULL, NULL, '2025-11-25 01:28:14', '2025-11-25 01:28:14'),
(9, NULL, '0012', 15, 8, NULL, 3, 500.00, 'testsss', NULL, 'pending', NULL, NULL, NULL, NULL, '2025-11-25 01:30:17', '2025-11-25 01:30:17'),
(10, NULL, 'FT-1-000001', 15, 8, NULL, 5, 5000.00, 'uilly', NULL, 'pending', NULL, NULL, NULL, NULL, '2025-11-25 01:35:00', '2025-11-25 01:35:00'),
(11, NULL, 'FT-1-000002', 15, 8, NULL, 4, 3000.00, 'traps', NULL, 'pending', NULL, NULL, NULL, NULL, '2025-11-25 01:37:23', '2025-11-25 01:37:23'),
(12, NULL, 'FT-1-000003', 15, 8, NULL, 3, 4050.00, 'nap you', NULL, 'pending', NULL, NULL, NULL, NULL, '2025-11-25 01:45:23', '2025-11-25 01:45:23'),
(13, NULL, 'FT-1-000004', 15, 8, 2, 4, 1200.00, 'newtyper', NULL, 'pending', NULL, NULL, NULL, NULL, '2025-11-25 03:02:20', '2025-11-25 03:02:20'),
(14, NULL, 'FT-8-000001', 20, 8, 7, NULL, 3000.00, 'beginning balance', '[\"fund_transfer_attachments\\/BRuh9TepyifJWOkANx8VUcTmN3Vhxq3o83XqwCW3.pdf\"]', 'pending', NULL, NULL, NULL, NULL, '2026-01-21 03:48:51', '2026-02-09 01:06:14'),
(15, NULL, 'FT-1-000005', 15, 8, NULL, NULL, 3500.00, NULL, NULL, 'approved', NULL, NULL, NULL, NULL, '2026-02-06 01:36:10', '2026-02-09 00:59:19'),
(16, NULL, 'FT-8-000002', 20, 8, NULL, NULL, 3000.00, NULL, NULL, 'approved', NULL, NULL, NULL, NULL, '2026-02-09 00:58:50', '2026-02-09 00:59:23'),
(17, NULL, 'FT-1-000006', 15, 8, NULL, 12, 2500.00, 'Fund transfer', NULL, 'pending', NULL, NULL, NULL, NULL, '2026-02-11 06:46:50', '2026-02-11 06:46:50'),
(18, NULL, 'FT-8-000003', 20, 12, 4, 13, 50000.00, 'Starting Capital', NULL, 'approved', 20, '2026-03-17 17:02:43', NULL, NULL, '2026-03-17 09:02:01', '2026-03-17 09:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `type` enum('Regular Holiday','Special (Non-working) holiday','Special (Working) holiday') NOT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `name`, `date`, `type`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'New Year', '2025-12-10', 'Regular Holiday', 'active', 15, '2025-12-10 08:23:37', '2025-12-11 00:37:36'),
(2, 'Christmas', '2025-12-25', 'Regular Holiday', 'active', 20, '2025-12-11 00:37:57', '2025-12-11 00:37:57'),
(3, 'Rizal Day', '2025-12-30', 'Regular Holiday', 'active', 20, '2025-12-11 00:38:34', '2025-12-11 00:38:34');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_audits`
--

CREATE TABLE `inventory_audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `audited_by` bigint(20) UNSIGNED NOT NULL,
  `type` enum('products','components','consumables','assets') NOT NULL DEFAULT 'products',
  `status` enum('active','archived','completed') NOT NULL DEFAULT 'active',
  `entry_datetime` timestamp NULL DEFAULT NULL,
  `audit_datetime` timestamp NULL DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_audits`
--

INSERT INTO `inventory_audits` (`id`, `reference_no`, `audited_by`, `type`, `status`, `entry_datetime`, `audit_datetime`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'AUD-20251120092058', 20, 'components', 'active', '2025-11-19 17:21:07', '2025-11-19 17:21:07', NULL, '2025-11-20 01:21:37', '2025-11-20 01:21:37'),
(2, 'AUD-20251120092148', 19, 'components', 'active', '2025-11-19 17:21:58', '2025-11-19 17:21:58', NULL, '2025-11-20 01:22:32', '2025-11-20 01:22:32'),
(3, 'AUD-20251124112654', 20, 'components', 'completed', '2025-11-23 19:27:06', '2025-11-23 19:27:06', NULL, '2025-11-24 03:30:02', '2025-11-24 03:32:46'),
(4, 'AUD-20251124113941', 20, 'components', 'completed', '2025-11-23 19:39:53', '2025-11-23 19:39:53', NULL, '2025-11-24 03:40:15', '2025-11-24 03:40:46'),
(5, 'AUD-20260121090148', 20, 'components', 'completed', '2026-01-20 17:02:30', '2026-01-20 17:02:30', NULL, '2026-01-21 01:05:46', '2026-01-21 01:06:55'),
(6, 'AUD-20260129085728', 16, 'products', 'active', '2026-01-28 16:58:20', '2026-01-28 16:58:20', NULL, '2026-01-29 00:59:04', '2026-01-29 00:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_audit_items`
--

CREATE TABLE `inventory_audit_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inventory_audit_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `component_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` decimal(15,2) NOT NULL DEFAULT 0.00,
  `prev_quantity` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_deductions`
--

CREATE TABLE `inventory_deductions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `component_id` bigint(20) UNSIGNED NOT NULL,
  `order_detail_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity_deducted` decimal(10,3) NOT NULL,
  `prev_quantity` decimal(10,3) NOT NULL,
  `new_quantity` decimal(10,3) NOT NULL,
  `deduction_type` varchar(50) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_purchase_orders`
--

CREATE TABLE `inventory_purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `po_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `prf_reference_number` varchar(255) DEFAULT NULL,
  `proforma_reference_number` varchar(255) DEFAULT NULL,
  `type_of_request` varchar(255) DEFAULT NULL,
  `select_origin` enum('local','international') NOT NULL DEFAULT 'local',
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attachments` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','completed','disapproved','archived') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `archived_by` bigint(20) UNSIGNED DEFAULT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_purchase_orders`
--

INSERT INTO `inventory_purchase_orders` (`id`, `po_number`, `user_id`, `department`, `prf_reference_number`, `proforma_reference_number`, `type_of_request`, `select_origin`, `supplier_id`, `attachments`, `status`, `approved_by`, `approved_at`, `archived_by`, `archived_at`, `created_at`, `branch_id`, `updated_at`) VALUES
(1, 'PO-SDXEM', 15, 'dsw', '023', NULL, 'Consumables Engineering', 'local', 1, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-10-27 22:32:08', NULL, '2025-10-27 22:32:08'),
(2, 'PO-MAIN-000001', 16, 'dsw', '0002-32', NULL, 'Direct/Indirect Materials', 'local', 2, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-10-27 22:37:46', NULL, '2025-10-27 22:37:46'),
(5, 'PO-1000001', 15, 'Enginer', '02323', NULL, 'Direct/Indirect Materials', 'local', 1, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-10-27 23:12:51', NULL, '2025-10-27 23:12:51'),
(7, 'PO-1-000001', 16, 'test2', '34213', NULL, 'Consumables Engineering', 'local', 2, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-10-27 23:27:23', NULL, '2025-10-27 23:27:23'),
(8, 'PO-1-000002', 15, 'Motorshop Dept', '554', NULL, 'Direct/Indirect Materials', 'local', 5, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-10-27 23:31:58', NULL, '2025-10-27 23:31:58'),
(9, 'PO-1-000003', 15, 'Motorshop Dept', '554', NULL, 'Direct/Indirect Materials', 'local', 5, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-10-27 23:32:36', NULL, '2025-10-27 23:32:36'),
(10, 'PO-1-000004', 20, NULL, NULL, NULL, 'Direct/Indirect Materials', 'local', 5, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-10-27 23:40:19', NULL, '2025-10-27 23:40:19'),
(11, 'PO-1-000005', 17, 'newtest department', '34211', NULL, 'Consumables Engineering', 'local', 1, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-10-28 00:22:56', NULL, '2025-10-28 00:22:56'),
(12, 'PO-1-000006', 15, 'traffic', '3412432', NULL, 'Direct/Indirect Materials', 'local', 1, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-10-28 00:32:30', NULL, '2025-10-28 00:32:30'),
(13, 'PO-1-000007', 16, 'mechanic', '001', NULL, 'Direct/Indirect Materials', 'local', 2, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-10-28 18:55:36', NULL, '2025-10-28 18:55:36'),
(14, 'PO-1-000008', 15, NULL, NULL, NULL, 'Direct/Indirect Materials', 'international', 2, '[\"purchase_order_attachments\\/wWfqdrtL2jDzP4FO6uEhjcRLfjn79SH80wmp4p4X.pdf\"]', 'completed', 15, '2025-11-09 19:53:00', NULL, NULL, '2025-10-28 19:45:50', NULL, '2025-11-12 18:50:40'),
(15, 'PO-1-000009', 16, 'offshore', '2231', NULL, 'Direct/Indirect Materials', 'local', 4, NULL, 'approved', 15, '2025-11-06 00:56:31', NULL, NULL, '2025-10-28 19:56:38', NULL, '2025-11-06 00:56:31'),
(16, 'PO-1-000010', 16, 'offshore', '2231', NULL, 'Direct/Indirect Materials', 'local', 4, NULL, 'archived', 15, '2025-11-06 00:44:05', 15, '2025-11-06 00:47:31', '2025-10-28 19:56:47', NULL, '2025-11-06 00:47:31'),
(17, 'PO-1-000011', 16, 'offshore', '2231', NULL, 'Direct/Indirect Materials', 'local', 4, NULL, 'archived', 15, '2025-11-06 00:20:52', 15, '2025-11-06 00:21:05', '2025-10-28 19:57:05', NULL, '2025-11-06 00:21:05'),
(18, 'PO-1-000012', 16, 'offshore', '2231', NULL, 'Direct/Indirect Materials', 'local', 4, '[\"purchase_order_attachments\\/pkIFVH9gqXpnXT3KEb7Cj8StCHJDwGcHB2NRdWDj.pdf\"]', 'archived', 15, '2025-11-06 00:13:33', NULL, NULL, '2025-10-28 21:15:01', NULL, '2025-11-06 00:13:41'),
(19, 'PO-1-000013', 16, 'offshore', '2231', NULL, 'Direct/Indirect Materials', 'local', 4, '[\"purchase_order_attachments\\/4cC0MWD9iMySvqyZqZkdddRajFwsgpEij1eUBK16.pdf\",\"purchase_order_attachments\\/OSGm1rFFGG2WbadVvr389zZZwoxdsWCfWmiqrfqj.pdf\"]', 'archived', 15, '2025-11-05 23:50:06', NULL, NULL, '2025-10-28 21:15:04', NULL, '2025-11-06 00:04:48'),
(20, 'PO-1-000014', 15, 'Fire Dept', '442', NULL, 'Direct/Indirect Materials', 'local', 1, '[]', 'archived', 15, '2025-11-05 19:51:33', NULL, NULL, '2025-10-28 21:17:02', NULL, '2025-11-05 23:49:50'),
(21, 'PO-1-000015', 16, '3432', '321', NULL, 'Direct/Indirect Materials', 'local', 2, '[\"purchase_order_attachments\\/1bpH0HEv89zaz3rWC1v3kKbcTIGt4u70rDGXoYM4.pdf\"]', 'archived', 15, '2025-11-05 19:20:25', NULL, NULL, '2025-10-28 21:20:27', NULL, '2025-11-05 23:48:47'),
(22, 'PO-1-000016', 16, 'Que', '1111', NULL, 'Direct/Indirect Materials', 'local', 4, '[\"purchase_order_attachments\\/et4ARZJmD19etAJvOf0hvBfdfb2q7KgUBjz5h4lG.pdf\"]', 'archived', NULL, NULL, NULL, NULL, '2025-10-28 21:22:36', NULL, '2025-11-05 23:32:05'),
(23, 'PO-1-000017', NULL, 'Kitchen', NULL, NULL, 'Direct/Indirect Materials', 'local', 5, NULL, 'completed', 20, '2025-11-06 17:22:46', NULL, NULL, '2025-11-06 17:16:17', NULL, '2025-11-11 19:19:32'),
(24, 'PO-8-000001', 16, 'FG depttets', '02323', NULL, 'Direct/Indirect Materials', 'local', 2, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-11-11 22:09:23', 8, '2025-11-11 22:09:23'),
(25, 'PO-4-000001', 15, 'New Dept', '023-239', NULL, 'Direct/Indirect Materials', 'local', 1, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-11-11 22:10:25', 4, '2025-11-11 22:10:25'),
(26, 'PO-4-000002', 15, 'New Dept', '023-239', NULL, 'Direct/Indirect Materials', 'local', 1, NULL, 'approved', 15, '2025-11-12 21:26:43', NULL, NULL, '2025-11-11 22:11:44', 4, '2025-11-12 21:26:43'),
(27, 'PO-4-000003', 16, '23', '02323', NULL, 'Direct/Indirect Materials', 'local', 2, NULL, 'approved', 15, '2025-11-12 21:25:12', NULL, NULL, '2025-11-11 22:12:39', 4, '2025-11-12 21:25:12'),
(28, 'PO-6-000001', NULL, 'Mandaue Dept', '223', NULL, 'Direct/Indirect Materials', 'local', 1, NULL, 'disapproved', 15, '2025-11-11 22:41:55', NULL, NULL, '2025-11-11 22:15:20', 6, '2025-11-11 22:41:55'),
(29, 'PO-1-000018', 16, 'Water Dept', '2322', NULL, 'Direct/Indirect Materials', 'local', 1, NULL, 'approved', 15, '2025-11-12 19:08:58', NULL, NULL, '2025-11-11 22:43:12', 1, '2025-11-12 19:08:58'),
(30, 'PO-1-000019', 15, 'LGU', '223', NULL, 'Direct/Indirect Materials', 'local', 1, NULL, 'completed', 15, '2025-11-12 18:57:05', NULL, NULL, '2025-11-12 17:48:38', 1, '2025-11-12 19:01:53'),
(31, 'PO-8-000002', 20, NULL, NULL, NULL, 'Direct/Indirect Materials', 'local', 5, NULL, 'completed', 20, '2025-11-12 18:15:57', NULL, NULL, '2025-11-12 18:14:45', 8, '2025-11-12 18:19:51'),
(32, 'PO-7-000001', 16, 'DOH', '231', NULL, 'Direct/Indirect Materials', 'local', 4, NULL, 'approved', 15, '2025-11-12 21:40:18', NULL, NULL, '2025-11-12 21:40:07', 7, '2025-11-12 21:40:18'),
(33, 'PO-1-000020', 16, 'BIR', '1', NULL, 'Direct/Indirect Materials', 'local', 2, NULL, 'completed', 15, '2025-11-12 21:58:18', NULL, NULL, '2025-11-12 21:58:00', 1, '2025-11-20 02:16:48'),
(34, 'PO-1-000021', 20, 'IT', NULL, NULL, 'Direct/Indirect Materials', 'local', 5, '[\"purchase_order_attachments\\/pbs8RhUR1KC65Ba1YBs0dIcoA2e4m0R1M68vVURz.jpg\"]', 'completed', 20, '2025-11-12 22:48:27', NULL, NULL, '2025-11-12 22:47:12', 1, '2025-11-13 00:27:36'),
(35, 'PO-1-000022', 15, 'dsw', '12312', NULL, 'Direct/Indirect Materials', 'local', 2, NULL, 'pending', NULL, NULL, NULL, NULL, '2025-11-13 00:37:47', 1, '2025-11-13 00:37:47'),
(36, 'PO-1-000023', 15, 'FG dept', '02323', NULL, 'Direct/Indirect Materials', 'local', 1, NULL, 'approved', 15, '2025-12-01 03:57:45', NULL, NULL, '2025-11-21 02:50:22', 1, '2025-12-01 03:57:45'),
(37, 'PO-1-000024', 17, 'Optum Depart', '882', NULL, 'Direct/Indirect Materials', 'local', 2, NULL, 'completed', 15, '2025-12-01 03:05:01', NULL, NULL, '2025-11-21 05:39:53', 1, '2026-01-29 02:09:28'),
(38, 'PO-1-000025', 20, NULL, 'PRF1000001', NULL, 'Direct/Indirect Materials', 'local', 4, NULL, 'completed', 20, '2025-11-24 03:43:20', NULL, NULL, '2025-11-24 03:43:02', 1, '2025-11-24 03:44:59'),
(39, 'PO-1-000026', 16, 'Engineering', '9023', NULL, 'Direct/Indirect Materials', 'local', 1, NULL, 'approved', 15, '2026-02-11 07:17:38', NULL, NULL, '2026-02-11 07:17:17', 1, '2026-02-11 07:17:38');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transfers`
--

CREATE TABLE `inventory_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `requested_by` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_datetime` datetime NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `transfer_type` enum('request','send') NOT NULL,
  `source_id` bigint(20) UNSIGNED NOT NULL,
  `destination_id` bigint(20) UNSIGNED NOT NULL,
  `attached_file` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','in_transit','completed','disapproved','archived') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `in_transit_by` bigint(20) UNSIGNED DEFAULT NULL,
  `in_transit_datetime` timestamp NULL DEFAULT NULL,
  `completed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `completed_datetime` timestamp NULL DEFAULT NULL,
  `disapproved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `disapproved_datetime` timestamp NULL DEFAULT NULL,
  `archived_by` bigint(20) UNSIGNED DEFAULT NULL,
  `archived_datetime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_transfers`
--

INSERT INTO `inventory_transfers` (`id`, `requested_by`, `requested_datetime`, `reference_no`, `transfer_type`, `source_id`, `destination_id`, `attached_file`, `status`, `approved_by`, `approved_datetime`, `created_at`, `updated_at`, `in_transit_by`, `in_transit_datetime`, `completed_by`, `completed_datetime`, `disapproved_by`, `disapproved_datetime`, `archived_by`, `archived_datetime`) VALUES
(1, 20, '2026-01-16 09:55:00', 'TSO-08-00001', 'send', 8, 4, NULL, 'in_transit', 20, '2026-01-16 02:00:06', '2026-01-16 01:58:22', '2026-01-16 02:01:13', 20, '2026-01-16 02:01:13', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 20, '2026-01-19 10:37:00', 'TSO-08-00002', 'send', 8, 1, NULL, 'in_transit', 20, '2026-01-19 06:02:40', '2026-01-19 02:40:21', '2026-01-19 06:04:10', 20, '2026-01-19 06:04:10', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transfer_items`
--

CREATE TABLE `inventory_transfer_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inventory_transfer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `component_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity_requested` decimal(10,2) NOT NULL,
  `quantity_sent` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_transfer_items`
--

INSERT INTO `inventory_transfer_items` (`id`, `inventory_transfer_id`, `product_id`, `component_id`, `quantity_requested`, `quantity_sent`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 8.00, 3.00, '2026-01-16 01:58:22', '2026-01-16 02:01:13'),
(2, 1, NULL, NULL, 5.00, 2.00, '2026-01-16 01:58:22', '2026-01-16 02:01:13'),
(3, 2, NULL, NULL, 24.00, 12.00, '2026-01-19 02:40:21', '2026-01-19 06:04:10'),
(4, 2, NULL, NULL, 24.00, 24.00, '2026-01-19 02:40:21', '2026-01-19 06:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transfer_send_outs`
--

CREATE TABLE `inventory_transfer_send_outs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inventory_transfer_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_request_no` varchar(255) NOT NULL,
  `personel_name` varchar(255) NOT NULL,
  `items_onload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items_onload`)),
  `received_by` bigint(20) UNSIGNED DEFAULT NULL,
  `received_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_transfer_send_outs`
--

INSERT INTO `inventory_transfer_send_outs` (`id`, `inventory_transfer_id`, `delivery_request_no`, `personel_name`, `items_onload`, `received_by`, `received_datetime`, `created_at`, `updated_at`) VALUES
(1, 1, 'DR-08-00001', 'Chain', '[{\"inventory_transfer_item_id\":1,\"type\":\"component\",\"quantity\":3,\"prev_onhand\":\"103.00\",\"new_onhand\":\"100.00\"},{\"inventory_transfer_item_id\":2,\"type\":\"component\",\"quantity\":2,\"prev_onhand\":\"5.00\",\"new_onhand\":\"3.00\"}]', 20, '2026-01-19 10:16:19', '2026-01-16 02:01:13', '2026-01-19 02:16:19'),
(2, 2, 'DR-08-00002', 'nowe', '[{\"inventory_transfer_item_id\":3,\"type\":\"component\",\"quantity\":12,\"prev_onhand\":\"100.00\",\"new_onhand\":\"88.00\"},{\"inventory_transfer_item_id\":4,\"type\":\"component\",\"quantity\":24,\"prev_onhand\":\"24.00\",\"new_onhand\":\"0.00\"}]', NULL, NULL, '2026-01-19 06:04:10', '2026-01-19 06:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kitchen_mass_productions`
--

CREATE TABLE `kitchen_mass_productions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','completed','disapproved','archived') NOT NULL DEFAULT 'pending',
  `additional_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_items`)),
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_datetime` datetime DEFAULT NULL,
  `completed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `completed_datetime` datetime DEFAULT NULL,
  `disapproved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `disapproved_datetime` datetime DEFAULT NULL,
  `archived_by` bigint(20) UNSIGNED DEFAULT NULL,
  `archived_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_16_033358_create_categories_table', 1),
(5, '2025_09_16_033412_create_subcategories_table', 1),
(6, '2025_09_16_033508_create_products_table', 1),
(7, '2025_09_16_033540_create_components_table', 1),
(8, '2025_09_19_023116_create_recipes_table', 1),
(9, '2025_09_22_083920_create_system_settings_table', 1),
(10, '2025_09_23_032113_create_branches_table', 1),
(11, '2025_09_24_084755_create_branch_user_table', 1),
(12, '2025_09_25_063614_add_image_to_products_table', 2),
(13, '2025_09_29_031428_add_created_by_to_categories_table', 3),
(14, '2025_09_29_062447_create_units_table', 4),
(15, '2025_09_29_064043_add_created_by_to_units_table', 5),
(16, '2025_09_29_082017_create_payments_table', 6),
(17, '2025_09_29_084835_create_discounts_table', 7),
(18, '2025_09_30_024323_add_status_to_payments_table', 8),
(19, '2025_09_30_031841_add_status_to_discounts_table', 9),
(20, '2025_09_30_053903_add_status_to_categories_table', 10),
(21, '2025_09_30_055807_add_status_to_units_table', 11),
(22, '2025_09_30_070125_add_status_to_products_table', 12),
(23, '2025_09_30_073634_add_status_to_components_table', 13),
(24, '2025_09_30_031541_create_orders_table', 14),
(25, '2025_09_30_031612_create_order_details_table', 14),
(26, '2025_10_01_023750_alter_orders_status_column', 14),
(27, '2025_10_01_030952_remove_quantity_and_unit_from_recipes_table', 15),
(29, '2025_10_01_050936_add_quantity_to_recipes_table', 16),
(30, '2025_10_03_063353_add_component_id_to_order_details_table', 17),
(31, '2025_10_03_080210_make_product_and_component_nullable_in_order_details_table', 18),
(32, '2025_10_03_012156_create_discount_entries_table', 19),
(33, '2025_10_03_065150_add_charges_and_discounts_to_orders_table', 19),
(34, '2025_10_07_031754_create_roles_table', 20),
(35, '2025_10_07_031825_create_role_user_table', 20),
(36, '2025_10_07_031906_update_users_table_remove_branch_id', 20),
(37, '2025_10_07_082359_add_status_to_users_table', 21),
(38, '2025_10_08_065849_create_permission_tables', 22),
(39, '2025_10_08_075511_add_guard_name_to_roles_and_permissions_tables', 22),
(40, '2025_10_13_000001_create_cash_equivalents_table', 23),
(41, '2025_10_13_073539_add_conversion_in_peso_to_cash_equivalents_table', 24),
(42, '2025_10_14_000001_create_order_payments_table', 25),
(43, '2025_10_14_070206_create_payment_details_table', 26),
(44, '2025_10_15_022245_add_payment_summary_to_orders_table', 27),
(45, '2025_10_15_022508_add_rendered_and_change_to_payment_details_table', 27),
(46, '2025_10_15_034159_add_permit_and_pos_columns_to_branches_table', 28),
(47, '2025_10_15_120000_add_order_id_to_payment_details', 29),
(48, '2025_10_16_000001_add_reg_bill_to_orders_table', 30),
(49, '2025_10_16_120000_drop_reg_bill_from_orders_table', 31),
(50, '2025_10_17_072513_create_remarks_table', 32),
(51, '2025_10_17_000000_add_remarks_column_to_products_and_components', 33),
(52, '2025_10_16_064323_add_time_submitted_to_orders_table', 34),
(53, '2025_10_17_052551_create_order_items_table', 34),
(54, '2025_10_17_071409_add_cook_id_to_order_items_table', 34),
(55, '2025_10_17_085204_update_order_items_replace_product_id_with_name', 34),
(56, '2025_10_18_013113_add_status_to_order_details_table', 34),
(57, '2025_10_18_042717_clean_up_order_items_table', 34),
(58, '2025_10_18_043240_add_order_detail_id_to_order_items_table', 34),
(59, '2025_10_22_014149_create_suppliers_table', 35),
(60, '2025_10_21_024921_create_pos_sessions_table', 36),
(61, '2025_10_21_033045_create_pos_session_summaries_table', 36),
(62, '2025_10_22_054739_add_status_to_suppliers_table', 37),
(63, '2025_10_22_055121_add_order_type_to_orders_table', 38),
(64, '2025_10_22_072619_remove_supplier_no_from_suppliers_table', 39),
(65, '2025_10_23_013756_create_customers_table', 40),
(66, '2025_10_23_022335_add_status_to_customers_table', 41),
(67, '2025_10_23_030142_add_customer_since_to_customers_table', 42),
(68, '2025_10_27_051814_add_status_to_remarks_table', 43),
(69, '2025_10_23_024507_create_inventory_deductions_table', 44),
(70, '2025_10_24_013535_update_deduction_type_enum_in_inventory_deductions', 44),
(71, '2025_10_24_054613_update_status_enum_in_orders_table', 45),
(72, '2025_10_28_025255_create_inventory_purchase_orders_table', 46),
(73, '2025_10_28_033802_add_status_to_inventory_purchase_orders_table', 47),
(74, '2025_10_28_060552_add_fields_to_inventory_purchase_orders_table', 48),
(75, '2025_10_29_022757_create_po_details_table', 49),
(76, '2025_10_29_035301_add_tax_to_po_details_table', 50),
(77, '2025_10_29_073227_add_supplier_id_to_components_table', 51),
(78, '2025_10_30_062140_add_attachment_to_inventory_purchase_orders_table', 52),
(79, '2025_10_30_065256_rename_attachment_to_attachments_in_inventory_purchase_orders_table', 53),
(80, '2025_10_30_024824_create_cash_audit_table', 54),
(81, '2025_10_30_072459_add_total_sales_to_cash_audits_table', 54),
(82, '2025_11_06_024156_add_approval_fields_to_inventory_purchase_orders_table', 55),
(83, '2025_11_06_053839_add_archived_fields_to_inventory_purchase_orders_table', 56),
(84, '2025_11_12_000001_add_received_qty_to_po_details', 57),
(85, '2025_11_12_000003_add_delivery_dr_to_po_details', 57),
(86, '2025_11_12_000004_add_branch_id_to_inventory_purchase_orders', 58),
(87, '2025_11_12_000005_add_unit_cost_to_po_details', 59),
(88, '2025_11_11_082627_create_inventory_audits_table', 60),
(89, '2025_11_12_004438_create_inventory_audit_items_table', 60),
(90, '2025_11_13_000001_create_po_detail_receipts_table', 61),
(91, '2025_11_13_000001_create_po_delivery_table', 62),
(92, '2025_11_13_000002_create_po_delivery_items_table', 62),
(93, '2025_11_13_000003_drop_delivery_dr_from_po_details', 62),
(94, '2025_11_13_025608_drop_po_detail_receipts_table', 63),
(95, '2025_11_13_013315_update_terminal_no_to_string_in_cash_audits_table', 64),
(96, '2025_11_14_030654_create_departments_table', 65),
(99, '2025_11_14_114807_add_unique_constraint_to_departments_name_column', 66),
(100, '2025_11_17_000001_create_asset_categories_table', 67),
(101, '2025_11_18_071200_create_fund_transfers_table', 68),
(102, '2025_11_18_153502_add_attachments_to_fund_transfers_table', 69),
(103, '2025_11_13_033243_add_status_to_inventory_audits_table', 70),
(104, '2025_11_13_083428_update_inventory_audit_items_make_product_id_nullable', 70),
(105, '2025_11_18_021000_add_completed_to_inventory_audits_status', 70),
(106, '2025_11_18_030000_add_prev_quantity_to_inventory_audit_items_table', 70),
(107, '2025_11_19_110417_create_accounting_category_table', 71),
(108, '2025_11_19_132923_add_status_to_accounting_category_table', 72),
(109, '2025_11_19_110417_create_accounting_categories_table', 73),
(110, '2025_11_20_141118_update_accounting_categories_table', 74),
(111, '2025_11_19_000001_make_mobile_and_address_nullable', 75),
(112, '2025_11_19_104604_add_status_to_branches_table', 75),
(113, '2025_11_21_133218_add_onhand_to_po_details_table', 76),
(114, '2025_11_24_102959_create_account_receivables_table', 77),
(115, '2025_11_24_152028_add_branch_id_to_fund_transfers_table', 77),
(116, '2025_11_25_090808_add_other_to_cash_audit_table', 78),
(117, '2025_11_26_095034_create_account_payables_table', 79),
(118, '2025_11_26_095326_create_account_payable_details_table', 79),
(119, '2025_11_28_085739_create_taxes_table', 80),
(120, '2025_11_25_112337_create_accounts_receivable_table', 81),
(121, '2025_11_26_141326_create_accounts_receivable_details_table', 81),
(122, '2025_12_01_131412_add_amount_to_pay_to_account_payable_details_table', 82),
(123, '2025_12_01_145221_add_payment_columns_to_account_payable_details_table', 83),
(124, '2025_12_01_113331_add_action_by_and_timestamps_to_accounts_receivables_table', 84),
(125, '2025_12_01_162958_create_accounts_receivables_payments_table', 84),
(126, '2025_12_02_135505_add_branch_id_to_account_payables_table', 85),
(127, '2025_12_02_143643_add_tax_id_to_account_payable_details_table', 86),
(128, '2025_12_02_135600_remove_payee_details_from_accounts_receivables_table', 87),
(129, '2025_12_04_111239_create_designations_table', 88),
(130, '2025_12_05_105438_modify_status_in_users_table', 89),
(131, '2025_12_05_144633_create_statuses_table', 90),
(132, '2025_12_09_112111_add_cashier_to_orders_table', 91),
(133, '2025_12_09_142055_remove_cashier_column_from_orders_table', 92),
(134, '2025_12_09_142235_add_cashier_id_to_orders_table', 93),
(135, '2025_12_09_142251_add_cashier_id_to_orders_table', 93),
(136, '2025_12_10_000001_create_night_differentials_table', 94),
(137, '2025_12_04_114313_update_cash_audits_table_structure', 95),
(138, '2025_12_04_141840_add_branch_id_to_orders_table', 95),
(139, '2025_12_10_000000_create_holidays_table', 96),
(140, '2025_12_10_161527_create_workforce_leaves_table', 97),
(141, '2025_12_11_000000_create_benefits_table', 98),
(142, '2025_12_11_101500_create_benefit_details_table', 99),
(143, '2025_12_11_203945_create_workforce_allowances_table', 100),
(144, '2025_12_12_000020_add_profile_columns_to_users_table', 101),
(145, '2025_12_12_000021_create_spouse_details_table', 101),
(146, '2025_12_12_000022_create_contact_persons_table', 101),
(147, '2025_12_12_000023_create_salary_methods_table', 101),
(148, '2025_12_12_000024_create_educational_backgrounds_table', 101),
(149, '2025_12_12_000025_create_dependents_table', 101),
(150, '2025_12_12_000026_create_employee_work_informations_table', 101),
(151, '2025_12_12_114106_create_workforce_shifts_table', 102),
(152, '2025_12_12_000030_create_user_allowances_table', 103),
(153, '2025_12_12_000031_create_user_leaves_table', 103),
(154, '2025_12_12_000032_add_shift_id_to_salary_methods_table', 103),
(155, '2025_12_15_000034_alter_users_gender_blood_civil_to_string', 104),
(156, '2025_12_15_160656_add_new_fields_to_users_table', 105),
(157, '2025_12_16_000001_create_branch_permission_table', 106),
(158, '2025_12_15_130830_modify_cash_audits_table', 107),
(159, '2025_12_15_141503_update_status_enum_in_cash_audits_table', 107),
(160, '2025_12_15_145826_create_cash_audit_records_table', 107),
(161, '2025_12_15_151403_add_cash_audit_record_id_to_cash_audits_table', 107),
(162, '2025_12_16_150308_fix_transfer_to_fk_on_cash_audit_records', 107),
(163, '2025_12_17_151517_create_inventory_transfers_table', 108),
(164, '2026_01_05_143555_add_requested_by_to_inventory_transfers_table', 108),
(165, '2026_01_06_104525_create_inventory_transfer_items_table', 108),
(166, '2026_01_06_152342_add_approval_columns_to_inventory_transfers_table', 108),
(167, '2025_12_16_000002_make_users_email_nullable', 109),
(168, '2026_01_08_095517_change_direct_supervisor_to_string', 109),
(169, '2026_01_08_111011_remove_position_from_employee_work_informations_table', 110),
(170, '2026_01_08_151607_add_custom_shift_fields_to_salary_methods_table', 111),
(171, '2026_01_08_161946_add_custom_weekly_schedule_to_salary_methods_table', 112),
(172, '2026_01_09_104128_fix_salary_method_columns_to_string', 113),
(173, '2026_01_09_134523_create_attachments_table', 114),
(174, '2026_01_07_092922_create_branch_products_table', 115),
(175, '2026_01_07_093013_create_branch_components_table', 115),
(176, '2026_01_07_104104_update_inventory_transfer_items_quantities', 115),
(177, '2026_01_07_141037_create_inventory_transfer_send_outs_table', 115),
(178, '2026_01_12_110456_alter_quantities_to_decimal_on_inventory_transfer_items', 115),
(179, '2026_01_12_163022_add_status_tracking_columns_to_inventory_transfers_table', 115),
(180, '2026_01_13_145523_update_branch_components_table_add_pricing_and_status', 115),
(181, '2026_01_14_133442_add_received_fields_to_inventory_transfer_send_outs_table', 115),
(182, '2026_01_20_000000_alter_user_leaves_add_tracking_columns', 116),
(183, '2026_01_20_000000_create_daily_time_records_table', 117),
(184, '2026_01_22_000001_create_branch_role_table', 118),
(185, '2026_01_22_120000_add_branch_id_to_users_table', 119),
(186, '2026_01_23_160707_rename_level_id_to_level_and_change_to_string_in_educational_backgrounds', 120),
(187, '2026_01_16_142052_create_request_leaves_table', 121),
(188, '2026_01_20_164955_update_attachments_column_on_request_leaves_table', 121),
(189, '2026_01_22_100109_change_period_dates_to_datetime_in_request_leaves', 121),
(190, '2026_01_22_134339_add_cancelled_columns_to_request_leaves_table', 121),
(191, '2026_01_22_134921_add_completed_columns_to_request_leaves_table', 121),
(192, '2026_01_26_111758_update_request_leaves_requested_and_remove_completed_columns', 121),
(193, '2026_01_26_133853_add_unit_to_products_table', 122),
(194, '2026_02_03_145112_add_vat_exempt_12_to_orders_table', 123),
(195, '2026_02_02_153412_add_cost_price_status_supplier_to_branch_products_table', 124),
(196, '2026_02_06_085427_add_quantity_to_products_table', 124),
(197, '2026_02_06_143811_add_accountable_id_to_cash_equivalents_table', 124),
(198, '2026_02_09_150103_create_stations_table', 125),
(199, '2026_02_09_152304_add_status_enum_to_stations_table', 125),
(200, '2026_02_10_132730_add_station_foreign_key_to_products_table', 126),
(201, '2026_02_10_142003_change_unit_to_unit_id_on_products_table', 126),
(202, '2026_02_10_152522_update_branch_products_table', 126),
(203, '2026_02_16_101208_add_bundle_columns_to_products_table', 127),
(204, '2026_02_16_101658_create_bundle_items_table', 127),
(205, '2026_02_18_091935_update_bundle_items_table_structure', 127),
(206, '2026_02_18_115022_make_station_id_nullable_on_products_table', 127),
(207, '2026_02_18_131350_make_station_id_nullable_on_branch_products_table', 127),
(208, '2026_02_18_141334_add_type_to_branch_products_table', 127),
(209, '2026_02_19_144416_create_order_and_reservations_table', 128),
(210, '2026_02_20_092452_create_order_reservation_details_table', 128),
(211, '2026_02_20_093018_alter_order_and_reservations_table', 128),
(212, '2026_02_20_162223_update_status_enum_order_reservation_details_table', 128),
(213, '2026_02_23_111524_add_reservation_id_to_orders_and_order_id_to_reservations_table', 128),
(214, '2026_02_23_142621_add_branch_id_to_order_and_reservations_table', 128),
(215, '2026_02_25_085302_add_brand_supplier_to_products_table', 129),
(216, '2026_02_25_090900_remove_brand_name_and_supplier_id_from_products_table', 129),
(217, '2026_02_25_092955_add_brand_name_to_components_table', 129),
(218, '2026_02_25_134941_add_account_code_to_accounting_categories_table', 129),
(219, '2026_02_25_164434_alter_fix_column_accounting_categories_table', 129),
(220, '2026_02_25_164839_fix_column_accounting_categories_table', 129),
(221, '2026_02_26_103012_create_accounting_sub_categories', 130),
(222, '2026_02_26_103659_remove_column_accounting_categories_table', 130),
(223, '2026_02_25_112549_create_chart_accounts_table', 131),
(224, '2026_02_26_110310_update_chart_accounts_table_columns', 131),
(225, '2026_02_26_163557_drop_chart_accounts_table', 131),
(226, '2026_02_27_114048_add_totals_to_accounts_receivables_table', 131),
(227, '2026_02_27_114144_add_chart_account_id_to_accounts_receivable_details_table', 131),
(228, '2026_02_27_130525_add_tax_and_chart_to_accounts_receivable_details_table', 131),
(229, '2026_02_27_132057_add_created_by_to_chart_accounts_table', 131),
(230, '2026_03_02_093540_create_kitchen_mass_productions_table', 132),
(231, '2026_03_02_100334_add_branch_id_to_kitchen_mass_productions_table', 132),
(232, '2026_03_02_104953_add_reference_no_to_kitchen_mass_productions_table', 132),
(233, '2026_03_02_155324_add_created_by_and_remarks_to_kitchen_mass_productions_table', 132),
(234, '2026_03_03_091612_add_additional_items_to_kitchen_mass_productions_table', 132),
(235, '2026_03_03_110037_change_deduction_type_to_string_on_inventory_deductions_table', 132),
(236, '2026_03_03_151424_add_chart_account_id_to_account_payable_details_table', 133),
(237, '2026_03_09_132020_fix_unit_id_in_components_table', 134),
(238, '2026_03_10_140908_update_defaults_on_components_table', 135),
(239, '2026_03_10_155522_update_default_price_in_products_table', 136),
(240, '2026_03_13_141435_add_regular_bill_to_orders_table', 137),
(241, '2026_03_16_131143_add_sr_pwd_bill_to_orders_table', 137),
(242, '2026_03_17_132611_add_approval_and_archive_columns_to_fund_transfers_table', 138),
(243, '2026_03_17_160453_add_paid_datetime_to_orders_table', 138);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 57),
(1, 'App\\Models\\User', 58),
(1, 'App\\Models\\User', 63),
(1, 'App\\Models\\User', 64),
(1, 'App\\Models\\User', 66),
(2, 'App\\Models\\User', 57),
(2, 'App\\Models\\User', 58),
(2, 'App\\Models\\User', 63),
(2, 'App\\Models\\User', 65),
(2, 'App\\Models\\User', 66),
(3, 'App\\Models\\User', 56),
(3, 'App\\Models\\User', 57),
(3, 'App\\Models\\User', 58),
(3, 'App\\Models\\User', 63),
(3, 'App\\Models\\User', 65),
(3, 'App\\Models\\User', 66),
(4, 'App\\Models\\User', 20),
(4, 'App\\Models\\User', 57),
(4, 'App\\Models\\User', 58),
(4, 'App\\Models\\User', 63),
(5, 'App\\Models\\User', 57),
(5, 'App\\Models\\User', 63),
(6, 'App\\Models\\User', 57),
(6, 'App\\Models\\User', 63);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(4, 'App\\Models\\User', 15),
(4, 'App\\Models\\User', 20),
(4, 'App\\Models\\User', 22),
(4, 'App\\Models\\User', 73),
(4, 'App\\Models\\User', 79),
(4, 'App\\Models\\User', 105),
(4, 'App\\Models\\User', 108),
(4, 'App\\Models\\User', 109),
(4, 'App\\Models\\User', 110),
(5, 'App\\Models\\User', 15),
(5, 'App\\Models\\User', 17),
(5, 'App\\Models\\User', 22),
(5, 'App\\Models\\User', 79),
(5, 'App\\Models\\User', 106),
(5, 'App\\Models\\User', 108),
(5, 'App\\Models\\User', 109),
(5, 'App\\Models\\User', 110),
(5, 'App\\Models\\User', 112),
(6, 'App\\Models\\User', 22),
(6, 'App\\Models\\User', 24),
(6, 'App\\Models\\User', 79),
(6, 'App\\Models\\User', 107),
(6, 'App\\Models\\User', 108),
(6, 'App\\Models\\User', 109),
(6, 'App\\Models\\User', 110),
(6, 'App\\Models\\User', 112),
(7, 'App\\Models\\User', 23),
(7, 'App\\Models\\User', 79),
(7, 'App\\Models\\User', 107),
(7, 'App\\Models\\User', 108),
(7, 'App\\Models\\User', 109),
(7, 'App\\Models\\User', 111),
(8, 'App\\Models\\User', 21),
(8, 'App\\Models\\User', 79),
(8, 'App\\Models\\User', 107),
(8, 'App\\Models\\User', 109),
(9, 'App\\Models\\User', 79),
(9, 'App\\Models\\User', 107),
(9, 'App\\Models\\User', 109),
(10, 'App\\Models\\User', 79),
(10, 'App\\Models\\User', 107),
(10, 'App\\Models\\User', 109),
(11, 'App\\Models\\User', 79),
(11, 'App\\Models\\User', 109),
(12, 'App\\Models\\User', 79),
(12, 'App\\Models\\User', 109);

-- --------------------------------------------------------

--
-- Table structure for table `mytable`
--

CREATE TABLE `mytable` (
  `product_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `quantity` decimal(5,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mytable`
--

INSERT INTO `mytable` (`product_id`, `component_id`, `quantity`) VALUES
(196, 458, 0.090),
(197, 458, 0.090),
(198, 458, 0.090),
(212, 458, 0.270),
(214, 464, 0.010),
(216, 464, 0.010),
(218, 466, 0.020),
(223, 499, 0.010),
(228, 502, 0.150),
(238, 473, 3.000),
(239, 464, 0.010),
(250, 473, 3.000),
(262, 464, 0.010),
(264, 459, 0.250),
(265, 459, 0.250),
(268, 500, 0.120),
(274, 499, 0.010),
(275, 499, 0.003),
(288, 458, 0.270),
(300, 458, 0.090),
(305, 500, 0.120),
(306, 500, 0.120),
(309, 458, 0.300),
(310, 458, 0.270),
(311, 458, 0.270),
(312, 458, 0.090),
(313, 458, 0.090),
(314, 458, 0.090),
(315, 458, 0.270),
(316, 458, 0.090),
(318, 458, 0.270),
(320, 458, 0.290),
(321, 458, 0.090),
(322, 458, 0.040),
(323, 458, 0.540),
(324, 458, 0.270),
(325, 458, 0.270),
(326, 458, 0.270),
(327, 500, 0.120),
(328, 458, 0.090);

-- --------------------------------------------------------

--
-- Table structure for table `night_differentials`
--

CREATE TABLE `night_differentials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `percentage` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `night_differentials`
--

INSERT INTO `night_differentials` (`id`, `time_from`, `time_to`, `percentage`, `created_at`, `updated_at`) VALUES
(1, '21:00:00', '03:00:00', 10, '2025-12-10 03:21:40', '2025-12-10 03:21:40'),
(2, '22:00:00', '03:00:00', 10, '2025-12-10 03:24:50', '2025-12-10 03:24:50'),
(3, '22:00:00', '03:00:00', 10, '2025-12-10 03:24:51', '2025-12-10 03:24:51'),
(4, '11:25:00', '17:00:00', 20, '2025-12-10 03:25:49', '2025-12-10 03:25:49'),
(5, '11:27:00', '11:29:00', 12, '2025-12-10 03:27:18', '2025-12-10 03:27:18'),
(6, '00:00:00', '04:00:00', 30, '2025-12-10 03:30:02', '2025-12-10 03:30:02'),
(7, '22:00:00', '06:00:00', 30, '2025-12-11 00:41:03', '2025-12-11 00:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_type` enum('Dine-In','Take-Out','Delivery') NOT NULL DEFAULT 'Dine-In',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `cashier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reservation_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Links POS order back to the source reservation',
  `table_no` int(11) NOT NULL,
  `number_pax` int(11) NOT NULL,
  `gross_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sr_pwd_bill` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT 'SR/PWD portion of the bill',
  `sr_pwd_discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `other_discounts` decimal(10,2) NOT NULL DEFAULT 0.00,
  `net_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vatable` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vat_12` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vat_exempt_12` decimal(10,2) NOT NULL DEFAULT 0.00,
  `non_taxable` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `regular_bill` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_payment_rendered` decimal(10,2) NOT NULL DEFAULT 0.00,
  `change_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `charges_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `time_submitted` datetime DEFAULT NULL,
  `paid_datetime` datetime DEFAULT NULL,
  `status` enum('walked','served','serving','billout','payments','closed','cancelled') NOT NULL DEFAULT 'serving'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_type`, `user_id`, `branch_id`, `cashier_id`, `reservation_id`, `table_no`, `number_pax`, `gross_amount`, `sr_pwd_bill`, `sr_pwd_discount`, `other_discounts`, `net_amount`, `vatable`, `vat_12`, `vat_exempt_12`, `non_taxable`, `total_charge`, `regular_bill`, `total_payment_rendered`, `change_amount`, `discount_total`, `charges_description`, `created_at`, `updated_at`, `time_submitted`, `paid_datetime`, `status`) VALUES
(92, 'Dine-In', 17, 1, 15, NULL, 23, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 189.29, 22.71, 0.00, 0.00, 212.00, 0.00, 212.00, 0.00, 0.00, '\nPayments added on 2025-12-10 14:40:42', '2025-10-17 02:54:46', '2025-12-10 06:40:42', NULL, NULL, 'payments'),
(170, 'Dine-In', 15, 6, 15, NULL, 3, 5, 0.00, 0.00, 0.00, 0.00, 0.00, 2964.29, 355.71, 0.00, 0.00, 3320.00, 0.00, 3320.00, 0.00, 0.00, '\nPayments added on 2025-12-10 14:47:32', '2025-12-10 06:45:45', '2025-12-10 06:47:32', '2025-12-10 14:45:44', NULL, 'payments'),
(181, 'Dine-In', 17, 1, 15, NULL, 5, 11, 0.00, 0.00, 0.00, 0.00, 0.00, 1500.00, 180.00, 0.00, 0.00, 1680.00, 0.00, 1680.00, 0.00, 0.00, '\nPayments added on 2026-01-28 08:47:11', '2026-01-26 06:30:46', '2026-01-28 00:47:11', '2026-01-26 14:30:45', NULL, 'payments'),
(182, 'Dine-In', 16, 1, 15, NULL, 2, 10, 0.00, 0.00, 0.00, 0.00, 0.00, 464.29, 55.71, 0.00, 0.00, 520.00, 0.00, 700.00, 180.00, 0.00, NULL, '2026-01-28 06:57:21', '2026-02-02 08:16:55', '2026-01-28 14:57:20', NULL, 'billout'),
(183, 'Dine-In', 16, 4, 15, NULL, 1, 1, 0.00, 0.00, 0.00, 120.00, 0.00, 535.71, 64.29, 0.00, 0.00, 480.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-01-29 02:19:53', '2026-01-30 01:52:08', '2026-01-29 10:19:01', NULL, 'billout'),
(184, 'Dine-In', 17, 4, 20, NULL, 2, 2, 0.00, 0.00, 58.04, 0.00, 232.14, 290.18, 34.82, 0.00, 0.00, 557.14, 0.00, 1000.00, 442.86, 0.00, 'Payments added on 2026-01-30 10:01:16', '2026-01-29 02:40:27', '2026-01-30 02:01:16', '2026-01-29 10:39:34', NULL, 'billout'),
(185, 'Dine-In', 17, 1, 15, NULL, 12, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-01-30 01:54:41', '2026-01-30 01:54:59', '2026-01-30 09:54:40', NULL, 'billout'),
(186, 'Dine-In', 16, 1, 20, NULL, 2, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 220.89, 0.00, 0.00, NULL, '2026-01-30 03:14:13', '2026-01-30 05:05:31', '2026-01-30 11:14:13', NULL, 'billout'),
(187, 'Dine-In', 17, 4, 20, NULL, 15, 5, 1150.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-01-30 08:14:20', '2026-01-30 08:14:20', '2026-01-30 16:13:27', NULL, 'serving'),
(188, 'Dine-In', 16, 1, 15, NULL, 2, 5, 0.00, 0.00, 0.00, 0.00, 0.00, 1116.07, 133.93, 0.00, 0.00, 1250.00, 0.00, 2000.00, 750.00, 0.00, '\nPayments added on 2026-02-09 09:07:10', '2026-02-02 08:22:35', '2026-02-09 01:07:10', '2026-02-02 16:22:35', NULL, 'payments'),
(189, 'Dine-In', 15, 1, 15, NULL, 2, 10, 0.00, 0.00, 0.00, 0.00, 0.00, 464.29, 55.71, 0.00, 0.00, 520.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-02 08:29:32', '2026-02-02 08:29:44', '2026-02-02 16:29:32', NULL, 'billout'),
(190, 'Dine-In', 15, 1, 15, NULL, 2, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 580.36, 69.64, 0.00, 0.00, 650.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-02 08:31:09', '2026-02-02 08:31:20', '2026-02-02 16:31:08', NULL, 'billout'),
(191, 'Dine-In', 19, 1, 15, NULL, 2, 12, 0.00, 0.00, 9.67, 0.00, 38.69, 531.99, 63.84, 0.00, 0.00, 634.52, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-02 08:32:26', '2026-02-02 08:32:47', '2026-02-02 16:32:25', NULL, 'billout'),
(192, 'Dine-In', 16, 1, 15, NULL, 2, 13, 0.00, 0.00, 0.00, 0.00, 0.00, 1428.57, 171.43, 0.00, 0.00, 1600.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-02 08:55:52', '2026-02-02 08:56:01', '2026-02-02 16:55:52', NULL, 'billout'),
(193, 'Dine-In', 16, 1, 15, NULL, 4, 8, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-03 00:44:04', '2026-02-03 00:45:38', '2026-02-03 08:44:04', NULL, 'billout'),
(194, 'Dine-In', 16, 1, 15, NULL, 2, 6, 0.00, 0.00, 38.69, 0.00, 154.76, 386.90, 46.43, 0.00, 0.00, 588.10, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-03 00:58:41', '2026-02-03 02:28:14', '2026-02-03 08:58:41', NULL, 'billout'),
(195, 'Dine-In', 19, 1, 15, NULL, 2, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 1044.64, 125.36, 0.00, 0.00, 1170.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-03 02:30:24', '2026-02-03 02:35:39', '2026-02-03 10:30:23', NULL, 'billout'),
(197, 'Dine-In', 19, 1, 15, NULL, 6, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 892.86, 107.14, 0.00, 0.00, 1000.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-03 02:41:49', '2026-02-03 02:43:46', '2026-02-03 10:41:48', NULL, 'billout'),
(198, 'Dine-In', 17, 1, 15, NULL, 1, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 1000.00, 120.00, 0.00, 0.00, 1120.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-03 02:45:20', '2026-02-03 02:45:41', '2026-02-03 10:45:20', NULL, 'payments'),
(200, 'Dine-In', 17, 1, 15, NULL, 76, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 1339.29, 160.71, 0.00, 0.00, 1500.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-03 02:48:06', '2026-03-06 01:23:22', '2026-02-03 10:48:06', NULL, 'billout'),
(201, 'Dine-In', 17, 1, 15, NULL, 2, 3, 0.00, 0.00, 0.00, 0.00, 0.00, 1160.71, 139.29, 0.00, 0.00, 1300.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-03 03:09:08', '2026-02-03 03:09:21', '2026-02-03 11:09:08', NULL, 'billout'),
(202, 'Dine-In', 19, 1, 15, NULL, 2, 5, 0.00, 0.00, 18.57, 0.00, 74.29, 139.29, 16.71, 0.00, 0.00, 230.29, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-03 03:14:52', '2026-02-03 03:15:57', '2026-02-03 11:14:51', NULL, 'billout'),
(203, 'Dine-In', 20, 1, 15, NULL, 5, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 1875.00, 225.00, 0.00, 0.00, 2100.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-03 03:24:30', '2026-02-03 03:24:49', '2026-02-03 11:24:30', NULL, 'billout'),
(204, 'Dine-In', 20, 1, 20, NULL, 2, 2, 0.00, 0.00, 650.00, 0.00, 464.29, 580.36, 69.64, 580.36, 0.00, 1114.29, 0.00, 1500.00, 385.71, 0.00, '\nPayments added on 2026-02-13 10:38:41', '2026-02-03 03:28:41', '2026-02-13 02:38:41', '2026-02-03 11:28:40', NULL, 'payments'),
(205, 'Dine-In', 17, 1, 15, NULL, 5, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 1116.07, 133.93, 0.00, 0.00, 1250.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-03 03:33:07', '2026-02-03 03:33:52', '2026-02-03 11:33:07', NULL, 'billout'),
(207, 'Dine-In', 17, 1, 15, NULL, 3, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 964.29, 115.71, 0.00, 0.00, 1080.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-03 03:38:31', '2026-02-03 03:42:14', '2026-02-03 11:38:30', NULL, 'billout'),
(208, 'Dine-In', 19, 1, 15, NULL, 2, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 982.14, 117.86, 0.00, 0.00, 1100.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-03 03:52:46', '2026-02-03 03:53:14', '2026-02-03 11:52:46', NULL, 'billout'),
(209, 'Dine-In', 19, 1, 20, NULL, 2, 3, 0.00, 0.00, 13.69, 0.00, 54.76, 136.90, 16.43, 0.00, 0.00, 208.10, 0.00, 209.00, 0.90, 0.00, '\nPayments added on 2026-03-06 09:46:24', '2026-02-03 05:58:01', '2026-03-06 01:46:24', '2026-02-03 13:58:00', NULL, 'payments'),
(210, 'Dine-In', 20, 1, 15, NULL, 55, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 1428.57, 171.43, 0.00, 0.00, 1600.00, 0.00, 2000.00, 400.00, 0.00, '\nPayments added on 2026-02-09 11:54:55', '2026-02-03 06:19:36', '2026-02-09 03:54:55', '2026-02-03 14:19:35', NULL, 'payments'),
(211, 'Dine-In', 20, 1, 15, NULL, 1, 1, 0.00, 0.00, 89.29, 0.00, 357.14, 0.00, 0.00, 446.43, 0.00, 357.14, 0.00, 500.00, 142.86, 0.00, '\nPayments added on 2026-02-09 11:53:38', '2026-02-03 06:31:06', '2026-02-09 03:53:38', '2026-02-03 14:31:05', NULL, 'payments'),
(212, 'Dine-In', 20, 1, 15, NULL, 2, 3, 0.00, 0.00, 0.00, 0.00, 0.00, 982.14, 117.86, 982.14, 0.00, 1100.00, 0.00, 1200.00, 100.00, 0.00, '\nPayments added on 2026-02-09 11:50:01', '2026-02-03 08:22:15', '2026-02-09 03:50:01', '2026-02-03 16:22:14', NULL, 'payments'),
(213, 'Dine-In', 19, 1, 15, NULL, 21, 5, 0.00, 0.00, 0.00, 0.00, 0.00, 1473.21, 176.79, 1473.21, 0.00, 1650.00, 0.00, 2000.00, 350.00, 0.00, '\nPayments added on 2026-02-09 11:48:03', '2026-02-03 08:31:19', '2026-02-09 03:48:03', '2026-02-03 16:31:19', NULL, 'payments'),
(214, 'Dine-In', 20, 1, 15, NULL, 2, 3, 0.00, 0.00, 130.95, 0.00, 523.81, 327.38, 39.29, 982.14, 0.00, 890.48, 0.00, 1000.00, 109.52, 0.00, '\nPayments added on 2026-02-09 11:46:41', '2026-02-03 08:36:35', '2026-02-09 03:46:41', '2026-02-03 16:36:35', NULL, 'payments'),
(221, 'Dine-In', 17, 1, 15, NULL, 2, 3, 0.00, 0.00, 746.67, 0.00, 533.33, 333.33, 40.00, 1000.00, 0.00, 906.67, 0.00, 1000.00, 93.33, 0.00, '\nPayments added on 2026-02-09 11:21:58', '2026-02-04 05:37:47', '2026-02-09 03:21:58', '2026-02-04 13:37:47', NULL, 'payments'),
(222, 'Dine-In', 20, 1, 15, NULL, 5, 5, 0.00, 0.00, 440.00, 0.00, 314.29, 589.29, 70.71, 982.14, 0.00, 974.29, 0.00, 1000.00, 25.71, 0.00, '\nPayments added on 2026-02-09 11:21:31', '2026-02-04 05:57:50', '2026-02-09 03:21:31', '2026-02-04 13:57:49', NULL, 'payments'),
(223, 'Dine-In', 20, 8, 20, NULL, 8, 8, 0.00, 0.00, 187.50, 225.00, 133.93, 502.23, 60.27, 669.64, 0.00, 471.43, 0.00, 500.00, 28.57, 0.00, '\nPayments added on 2026-02-09 11:01:56', '2026-02-05 01:13:25', '2026-02-09 03:01:56', '2026-02-05 09:12:25', NULL, 'payments'),
(224, 'Dine-In', 19, 6, 20, NULL, 1, 3, 0.00, 0.00, 236.67, 0.00, 169.05, 422.62, 50.71, 211.31, 0.00, 642.38, 0.00, 700.00, 57.62, 0.00, '\nPayments added on 2026-02-11 11:15:49', '2026-02-05 01:14:19', '2026-02-11 03:15:49', '2026-02-05 09:13:19', NULL, 'payments'),
(225, 'Dine-In', 19, 1, 15, NULL, 12, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 1116.07, 133.93, 1116.07, 0.00, 1250.00, 0.00, 1300.00, 50.00, 0.00, '\nPayments added on 2026-02-09 11:19:16', '2026-02-05 05:29:03', '2026-02-09 03:19:16', '2026-02-05 13:29:03', NULL, 'payments'),
(226, 'Dine-In', 17, 1, 15, NULL, 13, 3, 0.00, 0.00, 0.00, 0.00, 0.00, 982.14, 117.86, 982.14, 0.00, 1100.00, 0.00, 1200.00, 100.00, 0.00, '\nPayments added on 2026-02-09 11:15:48', '2026-02-05 06:14:00', '2026-02-09 03:15:48', '2026-02-05 14:14:00', NULL, 'payments'),
(228, 'Dine-In', 20, 1, 20, NULL, 2, 4, 0.00, 0.00, 0.00, 0.00, 0.00, 1517.86, 182.14, 1517.86, 0.00, 1700.00, 0.00, 2000.00, 300.00, 0.00, '\nPayments added on 2026-02-09 09:05:42', '2026-02-05 06:47:34', '2026-02-09 01:05:42', '2026-02-05 14:47:34', NULL, 'payments'),
(229, 'Dine-In', 19, 1, 20, NULL, 3, 3, 0.00, 0.00, 333.33, 0.00, 238.10, 148.81, 17.86, 446.43, 0.00, 404.76, 0.00, 500.00, 95.24, 0.00, '\nPayments added on 2026-02-09 09:04:22', '2026-02-06 02:36:36', '2026-02-09 01:04:22', '2026-02-06 10:36:35', NULL, 'payments'),
(230, 'Dine-In', 20, 8, 20, NULL, 11, 2, 0.00, 0.00, 675.00, 0.00, 482.14, 602.68, 72.32, 1205.36, 0.00, 1157.14, 0.00, 2000.00, 842.86, 0.00, '\nPayments added on 2026-02-09 11:01:32', '2026-02-06 02:48:08', '2026-02-09 03:01:32', '2026-02-06 10:47:06', NULL, 'payments'),
(232, 'Dine-In', 19, 1, 20, NULL, 5, 5, 0.00, 0.00, 220.00, 220.00, 157.14, 785.71, 94.29, 982.14, 0.00, 817.14, 0.00, 818.00, 0.86, 0.00, '\nPayments added on 2026-02-09 09:03:27', '2026-02-06 05:42:12', '2026-02-09 01:03:27', '2026-02-06 13:42:12', NULL, 'payments'),
(233, 'Dine-In', 19, 1, 15, NULL, 3, 3, 0.00, 0.00, 0.00, 0.00, 0.00, 446.43, 53.57, 446.43, 0.00, 500.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-09 02:21:39', '2026-02-09 06:42:50', '2026-02-09 10:21:38', NULL, 'billout'),
(235, 'Dine-In', 20, 1, 15, NULL, 2, 3, 0.00, 0.00, 200.00, 0.00, 142.86, 357.14, 42.86, 178.57, 0.00, 542.86, 0.00, 600.00, 57.14, 0.00, '\nPayments added on 2026-02-12 16:10:30', '2026-02-09 06:43:23', '2026-02-12 08:10:30', '2026-02-09 14:43:23', NULL, 'payments'),
(236, 'Dine-In', 20, 1, 20, NULL, 2, 4, 0.00, 0.00, 0.00, 0.00, 0.00, 848.21, 101.79, 0.00, 0.00, 950.00, 0.00, 950.00, 0.00, 0.00, '\nPayments added on 2026-03-06 09:43:23', '2026-02-09 06:44:13', '2026-03-06 01:43:23', '2026-02-09 14:44:13', NULL, 'payments'),
(238, 'Dine-In', 51, 1, 15, NULL, 3, 5, 0.00, 0.00, 0.00, 0.00, 0.00, 803.57, 96.43, 803.57, 0.00, 900.00, 0.00, 1000.00, 100.00, 0.00, '\nPayments added on 2026-02-11 11:46:40', '2026-02-09 06:46:10', '2026-02-11 03:46:40', '2026-02-09 14:46:10', NULL, 'payments'),
(239, 'Dine-In', 19, 1, 15, NULL, 3, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 1517.86, 182.14, 1517.86, 0.00, 1700.00, 0.00, 2000.00, 300.00, 0.00, '\nPayments added on 2026-02-11 13:02:28', '2026-02-09 06:47:07', '2026-02-11 05:02:28', '2026-02-09 14:47:07', NULL, 'payments'),
(240, 'Dine-In', 51, 1, 15, NULL, 6, 6, 0.00, 0.00, 0.00, 0.00, 0.00, 803.57, 96.43, 803.57, 0.00, 900.00, 0.00, 1000.00, 100.00, 0.00, '\nPayments added on 2026-02-11 11:56:12', '2026-02-09 06:52:54', '2026-02-11 03:56:12', '2026-02-09 14:52:54', NULL, 'payments'),
(242, 'Dine-In', 19, 1, 15, NULL, 2, 3, 0.00, 0.00, 0.00, 0.00, 0.00, 1607.14, 192.86, 1607.14, 0.00, 1800.00, 0.00, 2000.00, 200.00, 0.00, '\nPayments added on 2026-02-11 11:46:25', '2026-02-09 07:01:26', '2026-02-11 03:46:25', '2026-02-09 15:01:26', NULL, 'payments'),
(243, 'Dine-In', 19, 1, 15, NULL, 6, 6, 0.00, 0.00, 183.33, 0.00, 130.95, 818.45, 98.21, 982.14, 0.00, 1047.62, 0.00, 1500.00, 452.38, 0.00, '\nPayments added on 2026-02-09 15:48:19', '2026-02-09 07:05:16', '2026-02-09 07:48:19', '2026-02-09 15:05:16', NULL, 'payments'),
(244, 'Dine-In', 20, 1, 15, NULL, 4, 4, 0.00, 0.00, 0.00, 0.00, 0.00, 982.14, 117.86, 982.14, 0.00, 1100.00, 0.00, 2000.00, 900.00, 0.00, '\nPayments added on 2026-02-09 15:19:04', '2026-02-09 07:11:32', '2026-02-09 07:19:04', '2026-02-09 15:11:32', NULL, 'payments'),
(245, 'Dine-In', 56, 1, 15, NULL, 4, 7, 0.00, 0.00, 0.00, 0.00, 0.00, 982.14, 117.86, 982.14, 0.00, 1100.00, 0.00, 1500.00, 400.00, 0.00, '\nPayments added on 2026-02-09 16:09:22', '2026-02-09 08:02:19', '2026-02-09 08:09:22', '2026-02-09 16:02:18', NULL, 'payments'),
(246, 'Take-Out', 56, 1, 15, NULL, 100, 1, 0.00, 0.00, 560.00, 0.00, 400.00, 0.00, 0.00, 500.00, 0.00, 400.00, 0.00, 500.00, 100.00, 0.00, '\nPayments added on 2026-02-11 11:46:08', '2026-02-09 08:20:45', '2026-02-11 03:46:08', '2026-02-09 16:19:38', NULL, 'payments'),
(247, 'Dine-In', 17, 1, 15, NULL, 3, 10, 0.00, 0.00, 110.00, 0.00, 78.57, 883.93, 106.07, 982.14, 0.00, 1068.57, 0.00, 1100.00, 31.43, 0.00, '\nPayments added on 2026-02-11 11:34:45', '2026-02-09 08:24:45', '2026-02-11 03:34:45', '2026-02-09 16:24:45', NULL, 'payments'),
(248, 'Dine-In', 20, 1, 15, NULL, 2, 2, 0.00, 0.00, 340.00, 0.00, 242.86, 303.57, 36.43, 607.14, 0.00, 582.86, 0.00, 600.00, 17.14, 0.00, '\nPayments added on 2026-02-11 11:30:45', '2026-02-09 08:27:14', '2026-02-11 03:30:45', '2026-02-09 16:26:07', NULL, 'payments'),
(249, 'Dine-In', 19, 1, 15, NULL, 3, 3, 0.00, 0.00, 226.67, 0.00, 161.90, 404.76, 48.57, 607.14, 0.00, 615.24, 0.00, 1000.00, 384.76, 0.00, '\nPayments added on 2026-02-11 11:30:17', '2026-02-09 08:41:07', '2026-02-11 03:30:17', '2026-02-09 16:41:07', NULL, 'payments'),
(250, 'Dine-In', 19, 1, 15, NULL, 34, 2, 0.00, 0.00, 850.00, 0.00, 607.14, 758.93, 91.07, 1517.86, 0.00, 1457.14, 0.00, 1500.00, 42.86, 0.00, '\nPayments added on 2026-02-11 11:20:10', '2026-02-09 08:45:23', '2026-02-11 03:20:10', '2026-02-09 16:45:22', NULL, 'payments'),
(251, 'Dine-In', 17, 1, 15, NULL, 2, 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-11 00:20:31', '2026-02-11 08:48:12', '2026-02-11 08:20:30', NULL, 'walked'),
(252, 'Dine-In', 16, 1, 15, NULL, 1, 3, 0.00, 0.00, 226.67, 0.00, 161.90, 404.76, 48.57, 202.38, 0.00, 615.24, 0.00, 700.00, 84.76, 0.00, '\nPayments added on 2026-02-11 11:05:19', '2026-02-11 00:24:56', '2026-02-11 03:05:19', '2026-02-11 08:24:55', NULL, 'payments'),
(253, 'Dine-In', 104, 1, 15, NULL, 3, 3, 0.00, 0.00, 226.67, 0.00, 161.90, 404.76, 48.57, 202.38, 0.00, 615.24, 0.00, 1000.00, 384.76, 0.00, '\nPayments added on 2026-02-11 11:01:14', '2026-02-11 00:57:10', '2026-02-11 03:01:14', '2026-02-11 08:57:09', NULL, 'payments'),
(254, 'Dine-In', 19, 1, 15, NULL, 2, 3, 0.00, 0.00, 226.67, 0.00, 161.90, 404.76, 48.57, 202.38, 0.00, 615.24, 0.00, 900.00, 284.76, 0.00, '\nPayments added on 2026-02-11 10:59:10', '2026-02-11 00:59:30', '2026-02-11 02:59:10', '2026-02-11 08:59:30', NULL, 'payments'),
(255, 'Dine-In', 20, 1, 15, NULL, 2, 3, 0.00, 0.00, 226.67, 0.00, 161.90, 404.76, 48.57, 202.38, 0.00, 615.24, 0.00, 1200.00, 584.76, 0.00, '\nPayments added on 2026-02-11 10:55:41', '2026-02-11 01:11:00', '2026-02-11 02:55:41', '2026-02-11 09:10:59', NULL, 'payments'),
(256, 'Dine-In', 19, 1, 15, NULL, 2, 3, 0.00, 0.00, 226.67, 0.00, 161.90, 404.76, 48.57, 202.38, 0.00, 615.24, 0.00, 800.00, 184.76, 0.00, '\nPayments added on 2026-02-11 10:54:26', '2026-02-11 01:14:00', '2026-02-11 02:54:26', '2026-02-11 09:13:59', NULL, 'payments'),
(257, 'Dine-In', 51, 1, 15, NULL, 3, 3, 0.00, 0.00, 226.67, 0.00, 161.90, 404.76, 48.57, 202.38, 0.00, 615.24, 0.00, 700.00, 84.76, 0.00, '\nPayments added on 2026-02-11 10:46:57', '2026-02-11 01:16:52', '2026-02-11 02:46:57', '2026-02-11 09:16:52', NULL, 'payments'),
(258, 'Dine-In', 20, 1, 15, NULL, 2, 3, 0.00, 0.00, 226.67, 0.00, 161.90, 404.76, 48.57, 202.38, 0.00, 615.24, 0.00, 1000.00, 384.76, 0.00, '\nPayments added on 2026-02-11 10:42:28', '2026-02-11 01:27:08', '2026-02-11 02:42:28', '2026-02-11 09:27:08', NULL, 'payments'),
(259, 'Dine-In', 19, 1, 15, NULL, 2, 3, 0.00, 0.00, 226.67, 0.00, 161.90, 404.76, 48.57, 202.38, 0.00, 615.24, 0.00, 700.00, 84.76, 0.00, '\nPayments added on 2026-02-11 10:35:44', '2026-02-11 01:29:31', '2026-02-11 02:35:44', '2026-02-11 09:29:31', NULL, 'payments'),
(260, 'Dine-In', 20, 1, 15, NULL, 2, 3, 0.00, 0.00, 226.67, 0.00, 161.90, 404.76, 48.57, 202.38, 0.00, 615.24, 0.00, 700.00, 84.76, 0.00, '\nPayments added on 2026-02-11 10:30:27', '2026-02-11 01:33:57', '2026-02-11 02:30:27', '2026-02-11 09:33:56', NULL, 'payments'),
(261, 'Dine-In', 19, 1, 15, NULL, 2, 2, 0.00, 0.00, 300.00, 0.00, 214.29, 267.86, 32.14, 267.86, 0.00, 514.29, 0.00, 600.00, 85.71, 0.00, '\nPayments added on 2026-02-11 10:40:25', '2026-02-11 02:39:25', '2026-02-11 02:40:25', '2026-02-11 10:39:25', NULL, 'payments'),
(262, 'Dine-In', 19, 6, 20, NULL, 2, 3, 600.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-11 03:15:32', '2026-02-11 03:15:32', '2026-02-11 11:14:20', NULL, 'serving'),
(263, 'Dine-In', 51, 1, 15, NULL, 2, 2, 0.00, 0.00, 560.00, 0.00, 400.00, 500.00, 60.00, 500.00, 0.00, 960.00, 0.00, 1000.00, 40.00, 0.00, '\nPayments added on 2026-02-11 11:23:57', '2026-02-11 03:20:52', '2026-02-11 03:23:57', '2026-02-11 11:20:52', NULL, 'payments'),
(264, 'Dine-In', 17, 1, 15, NULL, 2, 3, 0.00, 0.00, 183.33, 0.00, 130.95, 327.38, 39.29, 163.69, 0.00, 497.62, 0.00, 500.00, 2.38, 0.00, '\nPayments added on 2026-02-11 11:43:35', '2026-02-11 03:39:20', '2026-02-11 03:43:35', '2026-02-11 11:39:20', NULL, 'payments'),
(265, 'Dine-In', 51, 1, 15, NULL, 2, 3, 0.00, 0.00, 353.33, 0.00, 252.38, 630.95, 75.71, 315.48, 0.00, 959.05, 0.00, 1000.00, 40.95, 0.00, '\nPayments added on 2026-02-11 11:47:28', '2026-02-11 03:46:56', '2026-02-11 03:47:28', '2026-02-11 11:46:56', NULL, 'payments'),
(266, 'Dine-In', 20, 1, 15, NULL, 3, 3, 0.00, 0.00, 333.33, 0.00, 238.10, 595.24, 71.43, 297.62, 0.00, 904.76, 0.00, 1000.00, 95.24, 0.00, '\nPayments added on 2026-02-11 11:51:32', '2026-02-11 03:51:06', '2026-02-11 03:51:32', '2026-02-11 11:51:06', NULL, 'payments'),
(267, 'Dine-In', 56, 1, 15, NULL, 2, 3, 0.00, 0.00, 450.00, 0.00, 321.43, 803.57, 96.43, 401.79, 0.00, 1221.43, 0.00, 13000.00, 11778.57, 0.00, '\nPayments added on 2026-02-11 11:56:56', '2026-02-11 03:56:26', '2026-02-11 03:56:56', '2026-02-11 11:56:26', NULL, 'payments'),
(268, 'Dine-In', 51, 1, 15, NULL, 2, 3, 0.00, 0.00, 200.00, 0.00, 142.86, 357.14, 42.86, 178.57, 0.00, 542.86, 0.00, 600.00, 57.14, 0.00, '\nPayments added on 2026-02-11 11:58:10', '2026-02-11 03:57:38', '2026-02-11 03:58:10', '2026-02-11 11:57:38', NULL, 'payments'),
(269, 'Dine-In', 20, 1, 15, NULL, 3, 3, 0.00, 0.00, 450.00, 0.00, 321.43, 803.57, 96.43, 401.79, 0.00, 1221.43, 0.00, 1300.00, 78.57, 0.00, '\nPayments added on 2026-02-11 12:00:05', '2026-02-11 03:59:24', '2026-02-11 04:00:05', '2026-02-11 11:59:24', NULL, 'payments'),
(270, 'Dine-In', 56, 1, 15, NULL, 32, 3, 0.00, 0.00, 466.67, 0.00, 333.33, 833.33, 100.00, 416.67, 0.00, 1266.67, 0.00, 1300.00, 33.33, 0.00, '\nPayments added on 2026-02-11 12:04:14', '2026-02-11 04:01:24', '2026-02-11 04:04:14', '2026-02-11 12:01:24', NULL, 'payments'),
(271, 'Dine-In', 51, 1, 15, NULL, 2, 3, 0.00, 0.00, 433.33, 0.00, 309.52, 773.81, 92.86, 386.90, 0.00, 1176.19, 0.00, 1200.00, 23.81, 0.00, '\nPayments added on 2026-02-11 12:02:09', '2026-02-11 04:01:36', '2026-02-11 04:02:09', '2026-02-11 12:01:36', NULL, 'payments'),
(272, 'Dine-In', 20, 1, 15, NULL, 2, 3, 0.00, 0.00, 213.33, 0.00, 152.38, 380.95, 45.71, 190.48, 0.00, 579.05, 0.00, 600.00, 20.95, 0.00, '\nPayments added on 2026-02-11 12:07:12', '2026-02-11 04:06:31', '2026-02-11 04:07:12', '2026-02-11 12:06:31', NULL, 'payments'),
(273, 'Dine-In', 79, 1, 15, NULL, 2, 3, 0.00, 0.00, 700.00, 0.00, 500.00, 1250.00, 150.00, 625.00, 0.00, 1900.00, 0.00, 2000.00, 100.00, 0.00, '\nPayments added on 2026-02-11 12:12:17', '2026-02-11 04:11:52', '2026-02-11 04:12:17', '2026-02-11 12:11:52', NULL, 'payments'),
(274, 'Dine-In', 107, 1, 15, NULL, 3, 4, 0.00, 0.00, 150.00, 0.00, 107.14, 401.79, 48.21, 133.93, 0.00, 557.14, 0.00, 600.00, 42.86, 0.00, '\nPayments added on 2026-02-11 12:15:17', '2026-02-11 04:14:51', '2026-02-11 04:15:17', '2026-02-11 12:14:50', NULL, 'payments'),
(275, 'Dine-In', 20, 1, 15, NULL, 3, 3, 0.00, 0.00, 200.00, 0.00, 142.86, 357.14, 42.86, 178.57, 0.00, 542.86, 0.00, 600.00, 57.14, 0.00, '\nPayments added on 2026-02-11 12:18:38', '2026-02-11 04:18:09', '2026-02-11 04:18:38', '2026-02-11 12:18:09', NULL, 'payments'),
(276, 'Dine-In', 56, 1, 15, NULL, 2, 3, 0.00, 0.00, 416.67, 0.00, 297.62, 744.05, 89.29, 372.02, 0.00, 1130.95, 0.00, 2200.00, 1069.05, 0.00, '\nPayments added on 2026-02-11 12:23:35', '2026-02-11 04:22:58', '2026-02-11 04:23:35', '2026-02-11 12:22:58', NULL, 'payments'),
(277, 'Dine-In', 56, 1, 15, NULL, 2, 3, 0.00, 0.00, 166.67, 0.00, 119.05, 297.62, 35.71, 148.81, 0.00, 452.38, 0.00, 500.00, 47.62, 0.00, '\nPayments added on 2026-02-11 12:27:24', '2026-02-11 04:26:56', '2026-02-11 04:27:24', '2026-02-11 12:26:56', NULL, 'payments'),
(278, 'Dine-In', 56, 1, 15, NULL, 2, 3, 0.00, 0.00, 220.00, 0.00, 157.14, 392.86, 47.14, 196.43, 0.00, 597.14, 0.00, 600.00, 2.86, 0.00, '\nPayments added on 2026-02-11 12:29:04', '2026-02-11 04:28:38', '2026-02-11 04:29:04', '2026-02-11 12:28:37', NULL, 'payments'),
(279, 'Dine-In', 56, 1, 15, NULL, 2, 3, 0.00, 0.00, 200.00, 0.00, 142.86, 357.14, 42.86, 178.57, 0.00, 542.86, 0.00, 600.00, 57.14, 0.00, '\nPayments added on 2026-02-11 12:32:13\nPayments added on 2026-02-11 12:32:13', '2026-02-11 04:31:42', '2026-02-11 04:32:13', '2026-02-11 12:31:41', NULL, 'payments'),
(280, 'Dine-In', 20, 1, 15, NULL, 3, 4, 0.00, 0.00, 150.00, 0.00, 107.14, 401.79, 48.21, 133.93, 0.00, 557.14, 0.00, 600.00, 42.86, 0.00, '\nPayments added on 2026-02-11 13:02:01', '2026-02-11 05:01:27', '2026-02-11 05:02:01', '2026-02-11 13:01:26', NULL, 'payments'),
(281, 'Dine-In', 106, 1, 15, NULL, 2, 3, 0.00, 0.00, 200.00, 0.00, 142.86, 357.14, 42.86, 178.57, 0.00, 542.86, 0.00, 600.00, 57.14, 0.00, '\nPayments added on 2026-02-11 13:13:02', '2026-02-11 05:12:34', '2026-02-11 05:13:02', '2026-02-11 13:12:33', NULL, 'payments'),
(282, 'Dine-In', 56, 1, 20, NULL, 4, 3, 0.00, 0.00, 0.00, 0.00, 0.00, 937.50, 112.50, 0.00, 0.00, 1050.00, 0.00, 1050.00, 0.00, 0.00, '\nPayments added on 2026-03-06 09:39:18', '2026-02-11 06:54:21', '2026-03-06 01:39:18', '2026-02-11 14:54:21', NULL, 'payments'),
(283, 'Dine-In', 16, 1, 15, NULL, 3, 2, 0.00, 0.00, 850.00, 0.00, 607.14, 758.93, 91.07, 758.93, 0.00, 1457.14, 0.00, 1500.00, 42.86, 0.00, '\nPayments added on 2026-02-12 08:54:09', '2026-02-11 07:38:50', '2026-02-12 00:54:09', '2026-02-11 15:38:49', NULL, 'payments'),
(284, 'Dine-In', 56, 8, 20, NULL, 2, 5, 0.00, 0.00, 270.00, 0.00, 192.86, 964.29, 115.71, 28.93, 0.00, 1272.86, 0.00, 1500.00, 227.14, 0.00, '\nPayments added on 2026-03-12 16:37:05', '2026-03-12 08:49:15', '2026-03-12 08:37:05', '2026-03-12 16:48:03', NULL, 'payments'),
(285, 'Dine-In', 20, 8, 20, NULL, 5, 5, 0.00, 0.00, 440.00, 0.00, 314.29, 589.29, 70.71, 47.14, 0.00, 974.29, 0.00, 1000.00, 25.71, 0.00, '\nPayments added on 2026-02-18 14:09:05', '2026-02-11 08:53:52', '2026-02-18 06:09:05', '2026-02-11 16:52:41', NULL, 'payments'),
(286, 'Dine-In', 17, 1, 15, NULL, 2, 3, 0.00, 0.00, 223.33, 0.00, 159.52, 398.81, 47.86, 23.93, 0.00, 606.19, 0.00, 700.00, 93.81, 0.00, '\nPayments added on 2026-02-18 13:59:20', '2026-02-12 02:38:16', '2026-02-18 05:59:20', '2026-02-12 10:38:16', NULL, 'payments'),
(287, 'Dine-In', 20, 1, 15, NULL, 2, 3, 0.00, 0.00, 0.00, 0.00, 0.00, 1339.29, 160.71, 0.00, 0.00, 1500.00, 0.00, 2000.00, 500.00, 0.00, '\nPayments added on 2026-02-12 11:04:22', '2026-02-12 03:03:15', '2026-02-12 03:04:22', '2026-02-12 11:03:15', NULL, 'payments'),
(288, 'Dine-In', 56, 1, 15, NULL, 2, 3, 0.00, 0.00, 333.33, 0.00, 238.10, 595.24, 71.43, 35.71, 0.00, 904.76, 0.00, 1000.00, 95.24, 0.00, '\nPayments added on 2026-02-18 14:02:14', '2026-02-18 06:00:59', '2026-02-18 06:02:14', '2026-02-18 14:00:59', NULL, 'payments'),
(289, 'Dine-In', 19, 1, 20, NULL, 8, 8, 1500.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-02-19 03:27:17', '2026-02-19 09:00:12', '2026-02-19 11:25:59', NULL, 'walked'),
(290, 'Dine-In', 56, 1, 20, NULL, 1, 2, 0.00, 0.00, 0.00, 0.00, 0.00, 2789.51, 334.74, 0.00, 0.00, 3124.25, 0.00, 4000.00, 875.75, 0.00, '\nPayments added on 2026-03-06 09:38:18', '2026-02-23 00:40:52', '2026-03-06 01:38:18', '2026-02-23 08:40:52', NULL, 'payments'),
(291, 'Dine-In', 51, 8, 20, NULL, 5, 5, 1250.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-03-12 00:43:51', '2026-03-12 00:43:51', '2026-03-12 08:42:31', NULL, 'serving'),
(292, 'Dine-In', 15, 1, 15, NULL, 2, 3, 0.00, 0.00, 0.00, 0.00, 0.00, 1830.36, 219.64, 0.00, 0.00, 2050.00, 0.00, 3000.00, 950.00, 0.00, '\nPayments added on 2026-03-06 09:32:19', '2026-02-23 08:16:20', '2026-03-06 01:32:19', '2026-02-23 16:16:19', NULL, 'payments'),
(293, 'Dine-In', 20, 8, 20, 2, 999, 3, 0.00, 0.00, 516.67, 0.00, 369.05, 922.62, 110.71, 55.36, 0.00, 1402.38, 0.00, 2000.00, 597.62, 0.00, '\nPayments added on 2026-02-24 14:48:13', '2026-02-24 06:43:10', '2026-02-24 06:53:42', '2026-02-24 14:43:10', NULL, 'walked'),
(294, 'Dine-In', 20, 8, 20, 3, 9, 3, 900.00, 300.00, 53.57, 0.00, 214.29, 535.71, 64.29, 32.14, 0.00, 814.29, 600.00, 814.29, 0.00, 0.00, 'Payments added on 2026-03-17 17:06:49', '2026-03-12 01:44:44', '2026-03-17 09:06:49', '2026-03-12 09:44:44', '2026-03-17 17:06:49', 'payments'),
(295, 'Dine-In', 19, 1, 20, NULL, 4, 4, 0.00, 0.00, 350.00, 280.00, 250.00, 937.50, 112.50, 37.50, 0.00, 1020.00, 0.00, 0.00, 0.00, 0.00, NULL, '2026-03-16 03:17:55', '2026-03-16 03:42:28', '2026-03-16 11:15:34', NULL, 'billout'),
(296, 'Dine-In', 20, 1, 20, NULL, 5, 5, 1400.00, 280.00, 50.00, 280.00, 200.00, 1000.00, 120.00, 30.00, 0.00, 1040.00, 1120.00, 1500.00, 460.00, 0.00, '\nPayments added on 2026-03-16 14:58:31', '2026-03-16 03:43:17', '2026-03-16 06:58:31', '2026-03-16 11:40:57', NULL, 'payments'),
(297, 'Dine-In', 17, 1, 15, NULL, 1, 5, 0.00, 0.00, 245.00, 245.00, 175.00, 875.00, 105.00, 26.25, 0.00, 910.00, 0.00, 911.00, 1.00, 0.00, '\nPayments added on 2026-03-16 14:07:54', '2026-03-16 06:06:40', '2026-03-16 06:07:54', '2026-03-16 14:06:40', NULL, 'payments'),
(298, 'Dine-In', 20, 1, 20, NULL, 3, 3, 1800.00, 600.00, 107.14, 360.00, 428.57, 1071.43, 128.57, 64.29, 0.00, 1268.57, 1200.00, 1268.57, 0.00, 0.00, '\nPayments added on 2026-03-16 15:42:37', '2026-03-16 07:40:31', '2026-03-16 07:42:37', '2026-03-16 15:38:10', NULL, 'payments');

-- --------------------------------------------------------

--
-- Table structure for table `order_and_reservations`
--

CREATE TABLE `order_and_reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `reference_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `type_of_reservation` varchar(255) DEFAULT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `number_of_guest` int(10) UNSIGNED DEFAULT NULL,
  `downpayment_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cash_equivalent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gross_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `special_request` text DEFAULT NULL,
  `status` enum('reservations','prepared_service','ready_for_service') NOT NULL DEFAULT 'reservations',
  `order_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'The POS Order created when moved to Ready for Service',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_and_reservations`
--

INSERT INTO `order_and_reservations` (`id`, `branch_id`, `reference_number`, `customer_id`, `type_of_reservation`, `reservation_date`, `reservation_time`, `number_of_guest`, `downpayment_amount`, `payment_method_id`, `cash_equivalent_id`, `gross_amount`, `special_request`, `status`, `order_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'RSV-0000001', 3, 'Table Reservation', '2026-02-17', '13:00:00', 3, 0.00, NULL, NULL, 600.00, 'new', 'reservations', NULL, 15, '2026-02-24 05:39:21', '2026-02-26 01:43:51'),
(2, 8, 'RSV-0000002', 1, 'Table Reservation', '2026-02-25', '12:00:00', 3, 0.00, NULL, NULL, 1550.00, NULL, 'ready_for_service', NULL, 20, '2026-02-24 06:36:55', '2026-02-24 06:43:10'),
(3, 8, 'RSV-0000003', 2, 'Table Reservation', '2026-02-27', '18:00:00', 3, 0.00, NULL, NULL, 0.00, NULL, 'ready_for_service', NULL, 20, '2026-02-26 01:42:36', '2026-02-26 01:44:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `component_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `status` enum('serving','served','walked','cancelled') NOT NULL DEFAULT 'serving',
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `component_id`, `quantity`, `status`, `price`, `discount`, `notes`, `created_at`, `updated_at`) VALUES
(831, 294, 248, NULL, 1, 'serving', 300.00, 0.00, NULL, '2026-03-12 08:27:14', '2026-03-12 08:27:56'),
(832, 294, 247, NULL, 1, 'serving', 350.00, 0.00, NULL, '2026-03-12 08:27:14', '2026-03-12 08:27:56'),
(833, 294, 175, NULL, 1, 'serving', 250.00, 0.00, NULL, '2026-03-12 08:27:56', '2026-03-12 08:27:56'),
(834, 284, 298, NULL, 1, 'serving', 450.00, 0.00, NULL, '2026-03-12 08:30:26', '2026-03-12 08:30:26'),
(835, 284, 304, NULL, 1, 'serving', 300.00, 0.00, NULL, '2026-03-12 08:30:26', '2026-03-12 08:30:26'),
(836, 284, 241, NULL, 1, 'serving', 600.00, 0.00, NULL, '2026-03-12 08:30:26', '2026-03-12 08:30:26'),
(837, 291, 233, NULL, 1, 'serving', 75.00, 0.00, NULL, '2026-03-12 08:33:37', '2026-03-12 08:33:37'),
(838, 291, 234, NULL, 1, 'serving', 100.00, 0.00, NULL, '2026-03-12 08:33:37', '2026-03-12 08:33:37'),
(839, 291, 203, NULL, 1, 'serving', 150.00, 0.00, NULL, '2026-03-12 08:33:37', '2026-03-12 08:33:37'),
(840, 295, 268, NULL, 1, 'serving', 300.00, 0.00, NULL, '2026-03-16 03:17:55', '2026-03-16 03:17:55'),
(841, 295, 257, NULL, 1, 'serving', 700.00, 0.00, NULL, '2026-03-16 03:17:55', '2026-03-16 03:17:55'),
(842, 295, 270, NULL, 1, 'serving', 400.00, 0.00, NULL, '2026-03-16 03:17:55', '2026-03-16 03:17:55'),
(843, 296, 270, NULL, 1, 'serving', 400.00, 0.00, NULL, '2026-03-16 03:43:17', '2026-03-16 03:43:17'),
(844, 296, 256, NULL, 1, 'serving', 450.00, 0.00, NULL, '2026-03-16 03:43:17', '2026-03-16 03:43:17'),
(845, 296, 276, NULL, 1, 'serving', 550.00, 0.00, NULL, '2026-03-16 03:43:17', '2026-03-16 03:43:17'),
(846, 297, 233, NULL, 1, 'serving', 75.00, 0.00, NULL, '2026-03-16 06:06:40', '2026-03-16 06:06:40'),
(847, 297, 217, NULL, 1, 'serving', 0.00, 0.00, NULL, '2026-03-16 06:06:40', '2026-03-16 06:06:40'),
(848, 297, 268, NULL, 1, 'serving', 300.00, 0.00, NULL, '2026-03-16 06:06:40', '2026-03-16 06:06:40'),
(849, 297, 327, NULL, 1, 'serving', 0.00, 0.00, NULL, '2026-03-16 06:06:40', '2026-03-16 06:06:40'),
(850, 297, 186, NULL, 1, 'serving', 0.00, 0.00, NULL, '2026-03-16 06:06:40', '2026-03-16 06:06:40'),
(851, 297, 246, NULL, 1, 'serving', 0.00, 0.00, NULL, '2026-03-16 06:06:40', '2026-03-16 06:06:40'),
(852, 297, 270, NULL, 1, 'serving', 400.00, 0.00, NULL, '2026-03-16 06:06:40', '2026-03-16 06:06:40'),
(853, 297, 256, NULL, 1, 'serving', 450.00, 0.00, NULL, '2026-03-16 06:06:40', '2026-03-16 06:06:40'),
(854, 298, 267, NULL, 1, 'serving', 500.00, 0.00, NULL, '2026-03-16 07:40:31', '2026-03-16 07:40:31'),
(855, 298, 266, NULL, 1, 'serving', 400.00, 0.00, NULL, '2026-03-16 07:40:31', '2026-03-16 07:40:31'),
(856, 298, 265, NULL, 1, 'serving', 900.00, 0.00, NULL, '2026-03-16 07:40:31', '2026-03-16 07:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_detail_id` bigint(20) UNSIGNED NOT NULL,
  `cook_id` bigint(20) UNSIGNED DEFAULT NULL,
  `time_submitted` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_payments`
--

CREATE TABLE `order_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `cash_equivalent_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_reference_no` varchar(255) DEFAULT NULL,
  `amount_paid` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_reservation_details`
--

CREATE TABLE `order_reservation_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_and_reservations_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `component_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT 1.00,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `status` enum('serving','done','cancelled','pending') NOT NULL DEFAULT 'serving',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_reservation_details`
--

INSERT INTO `order_reservation_details` (`id`, `order_and_reservations_id`, `product_id`, `component_id`, `quantity`, `price`, `discount`, `notes`, `status`, `created_at`, `updated_at`) VALUES
(11, 2, NULL, NULL, 1.00, 500.00, 0.00, 'no squid', 'serving', '2026-02-24 06:40:35', '2026-02-24 06:40:35'),
(12, 2, NULL, NULL, 1.00, 600.00, 0.00, 'no pasta', 'serving', '2026-02-24 06:40:35', '2026-02-24 06:40:35'),
(13, 2, NULL, NULL, 3.00, 50.00, 0.00, 'not carbonated', 'serving', '2026-02-24 06:40:35', '2026-02-24 06:40:35'),
(14, 2, NULL, NULL, 1.00, 300.00, 0.00, 'no coke', 'serving', '2026-02-24 06:40:35', '2026-02-24 06:40:35'),
(15, 1, NULL, NULL, 1.00, 500.00, 0.00, NULL, 'serving', '2026-02-26 01:43:51', '2026-02-26 01:43:51'),
(16, 1, NULL, NULL, 1.00, 100.00, 0.00, NULL, 'serving', '2026-02-26 01:43:51', '2026-02-26 01:43:51');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `name`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(8, 'Cash', 15, 'active', '2025-10-12 19:35:43', '2025-10-12 19:35:43'),
(9, 'GCash', 15, 'active', '2025-10-12 19:35:58', '2025-10-12 19:35:58'),
(10, 'Debit Card', 15, 'active', '2025-10-12 19:36:15', '2025-10-12 19:36:15'),
(11, 'Credit Card', 15, 'active', '2025-10-12 19:36:28', '2025-10-12 19:36:28'),
(12, 'Check', 15, 'active', '2025-10-12 19:36:39', '2025-10-12 19:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `cash_equivalent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_reference_no` varchar(255) DEFAULT NULL,
  `amount_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_rendered` decimal(10,2) NOT NULL DEFAULT 0.00,
  `change_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `order_id`, `payment_id`, `cash_equivalent_id`, `transaction_reference_no`, `amount_paid`, `total_rendered`, `change_amount`, `created_at`, `updated_at`) VALUES
(1, NULL, 9, 5, '123', 800.00, 0.00, 0.00, '2025-10-13 23:30:59', '2025-10-13 23:30:59'),
(2, NULL, 11, 4, '442334', 538.33, 0.00, 0.00, '2025-10-13 23:48:10', '2025-10-13 23:48:10'),
(3, NULL, 9, NULL, '123123', 857.14, 0.00, 0.00, '2025-10-14 00:05:02', '2025-10-14 00:05:02'),
(4, NULL, 10, 4, '880', 700.00, 0.00, 0.00, '2025-10-14 18:39:30', '2025-10-14 18:39:30'),
(5, NULL, 9, 3, '12312', 100.00, 0.00, 0.00, '2025-10-14 18:41:01', '2025-10-14 18:41:01'),
(6, NULL, 12, NULL, '00001', 600.00, 600.00, 13.66, '2025-10-14 18:46:07', '2025-10-14 18:46:07'),
(7, NULL, 12, 4, '3223', 100.00, 100.00, 34.29, '2025-10-14 23:20:17', '2025-10-14 23:20:17'),
(8, NULL, 11, NULL, '123', 100.00, 100.00, 34.29, '2025-10-14 23:22:29', '2025-10-14 23:22:29'),
(9, NULL, 8, NULL, '123', 100.00, 100.00, 34.29, '2025-10-14 23:24:15', '2025-10-14 23:24:15'),
(10, NULL, 8, NULL, '123', 100.00, 100.00, 34.29, '2025-10-14 23:24:35', '2025-10-14 23:24:35'),
(11, NULL, 8, NULL, '123', 100.00, 100.00, 34.29, '2025-10-14 23:27:45', '2025-10-14 23:27:45'),
(12, NULL, 8, NULL, '213', 100.00, 100.00, 34.29, '2025-10-14 23:29:07', '2025-10-14 23:29:07'),
(73, 92, 8, NULL, '34', 200.00, 212.00, 0.00, '2025-10-16 18:55:37', '2025-12-10 06:40:42'),
(213, NULL, 8, NULL, 'AP-692d356b877a5', 112.00, 112.00, 0.00, '2025-12-01 06:27:55', '2025-12-01 06:27:55'),
(214, NULL, 8, NULL, 'AP-692D47ACF23C3', 250.00, 250.00, 0.00, '2025-12-01 07:45:49', '2025-12-01 07:45:49'),
(215, NULL, 8, NULL, 'AP-692D51B7D2C68', 100.00, 100.00, 0.00, '2025-12-01 08:28:39', '2025-12-01 08:28:39'),
(223, 92, 8, NULL, '', 212.00, 212.00, 0.00, '2025-12-10 06:40:42', '2025-12-10 06:40:42'),
(224, 170, 8, NULL, '', 700.00, 3320.00, 0.00, '2025-12-10 06:47:32', '2025-12-10 06:47:32'),
(225, 170, 11, 7, '', 1320.00, 3320.00, 0.00, '2025-12-10 06:47:32', '2025-12-10 06:47:32'),
(226, 170, 10, 4, '', 1290.00, 3320.00, 0.00, '2025-12-10 06:47:32', '2025-12-10 06:47:32'),
(227, 170, 9, 5, '', 10.00, 3320.00, 0.00, '2025-12-10 06:47:32', '2025-12-10 06:47:32'),
(242, 181, 9, 5, '223', 1000.00, 1680.00, 0.00, '2026-01-28 00:47:11', '2026-01-28 00:47:11'),
(243, 181, 8, NULL, '44', 680.00, 1680.00, 0.00, '2026-01-28 00:47:11', '2026-01-28 00:47:11'),
(248, 182, 8, NULL, '', 400.00, 700.00, 180.00, '2026-01-28 06:57:52', '2026-01-28 06:57:52'),
(249, 182, 9, 5, '', 300.00, 700.00, 0.00, '2026-01-28 06:57:52', '2026-01-28 06:57:52'),
(250, 184, 9, 5, 'sss', 500.00, 1000.00, 0.00, '2026-01-30 01:57:03', '2026-01-30 02:01:16'),
(251, 184, 8, NULL, '500', 500.00, 1000.00, 0.00, '2026-01-30 01:57:03', '2026-01-30 02:01:16'),
(252, 184, 9, 5, '', 500.00, 1000.00, 0.00, '2026-01-30 02:01:16', '2026-01-30 02:01:16'),
(253, 184, 8, NULL, '', 500.00, 1000.00, 442.86, '2026-01-30 02:01:16', '2026-01-30 02:01:16'),
(254, 186, 8, NULL, '', 220.89, 220.89, 0.00, '2026-01-30 04:24:34', '2026-01-30 04:24:34'),
(255, 232, 8, NULL, '', 818.00, 818.00, 0.86, '2026-02-09 01:03:27', '2026-02-09 01:03:27'),
(257, 229, 8, NULL, '', 500.00, 500.00, 95.24, '2026-02-09 01:04:22', '2026-02-09 01:04:22'),
(258, 228, 8, NULL, '', 2000.00, 2000.00, 300.00, '2026-02-09 01:05:42', '2026-02-09 01:05:42'),
(259, 188, 8, NULL, '2asddsa', 2000.00, 2000.00, 750.00, '2026-02-09 01:07:10', '2026-02-09 01:07:10'),
(260, 230, 8, NULL, '', 2000.00, 2000.00, 842.86, '2026-02-09 03:01:32', '2026-02-09 03:01:32'),
(261, 223, 8, NULL, '', 500.00, 500.00, 28.57, '2026-02-09 03:01:56', '2026-02-09 03:01:56'),
(264, 226, 8, NULL, 'ffsd', 1200.00, 1200.00, 100.00, '2026-02-09 03:15:48', '2026-02-09 03:15:48'),
(265, 225, 8, NULL, 'DSF', 1300.00, 1300.00, 50.00, '2026-02-09 03:19:16', '2026-02-09 03:19:16'),
(266, 222, 8, NULL, '213', 1000.00, 1000.00, 25.71, '2026-02-09 03:21:31', '2026-02-09 03:21:31'),
(267, 221, 8, NULL, 'D22', 1000.00, 1000.00, 93.33, '2026-02-09 03:21:58', '2026-02-09 03:21:58'),
(279, 214, 8, NULL, '', 500.00, 1000.00, 109.52, '2026-02-09 03:46:41', '2026-02-09 03:46:41'),
(280, 214, 9, 5, '', 500.00, 1000.00, 0.00, '2026-02-09 03:46:41', '2026-02-09 03:46:41'),
(281, 213, 8, NULL, '', 1000.00, 2000.00, 350.00, '2026-02-09 03:48:03', '2026-02-09 03:48:03'),
(282, 213, 9, 5, '', 1000.00, 2000.00, 0.00, '2026-02-09 03:48:03', '2026-02-09 03:48:03'),
(283, 212, 8, NULL, '', 1000.00, 1200.00, 100.00, '2026-02-09 03:50:01', '2026-02-09 03:50:01'),
(284, 212, 9, 5, '', 200.00, 1200.00, 0.00, '2026-02-09 03:50:01', '2026-02-09 03:50:01'),
(285, 211, 8, NULL, '', 250.00, 500.00, 142.86, '2026-02-09 03:53:38', '2026-02-09 03:53:38'),
(286, 211, 9, 5, '', 250.00, 500.00, 0.00, '2026-02-09 03:53:38', '2026-02-09 03:53:38'),
(287, 210, 12, NULL, '', 2000.00, 2000.00, 0.00, '2026-02-09 03:54:55', '2026-02-09 03:54:55'),
(288, 244, 8, NULL, '', 1000.00, 2000.00, 900.00, '2026-02-09 07:19:04', '2026-02-09 07:19:04'),
(289, 244, 9, 5, '', 1000.00, 2000.00, 0.00, '2026-02-09 07:19:04', '2026-02-09 07:19:04'),
(290, 243, 8, NULL, '', 1000.00, 1500.00, 452.38, '2026-02-09 07:48:19', '2026-02-09 07:48:19'),
(291, 243, 9, 5, '', 500.00, 1500.00, 0.00, '2026-02-09 07:48:19', '2026-02-09 07:48:19'),
(292, 245, 8, NULL, '', 1500.00, 1500.00, 400.00, '2026-02-09 08:09:22', '2026-02-09 08:09:22'),
(293, 260, 8, NULL, '2213', 200.00, 700.00, 84.76, '2026-02-11 02:30:26', '2026-02-11 02:30:27'),
(294, 260, 9, 5, '2231', 500.00, 700.00, 0.00, '2026-02-11 02:30:27', '2026-02-11 02:30:27'),
(295, 259, 8, NULL, '22', 500.00, 700.00, 84.76, '2026-02-11 02:35:44', '2026-02-11 02:35:44'),
(296, 259, 9, 5, '33', 200.00, 700.00, 0.00, '2026-02-11 02:35:44', '2026-02-11 02:35:44'),
(297, 261, 8, NULL, '600ps', 600.00, 600.00, 85.71, '2026-02-11 02:40:25', '2026-02-11 02:40:25'),
(298, 258, 8, NULL, '223', 1000.00, 1000.00, 384.76, '2026-02-11 02:42:28', '2026-02-11 02:42:28'),
(299, 257, 8, NULL, '', 700.00, 700.00, 84.76, '2026-02-11 02:46:57', '2026-02-11 02:46:57'),
(300, 256, 8, NULL, '', 800.00, 800.00, 184.76, '2026-02-11 02:54:26', '2026-02-11 02:54:26'),
(301, 255, 8, 10, '', 1200.00, 1200.00, 584.76, '2026-02-11 02:55:41', '2026-02-11 02:55:41'),
(302, 254, 8, NULL, '', 900.00, 900.00, 284.76, '2026-02-11 02:59:10', '2026-02-11 02:59:10'),
(303, 253, 8, NULL, '', 500.00, 1000.00, 384.76, '2026-02-11 03:01:14', '2026-02-11 03:01:14'),
(304, 253, 12, 10, '', 500.00, 1000.00, 0.00, '2026-02-11 03:01:14', '2026-02-11 03:01:14'),
(305, 252, 8, NULL, '', 700.00, 700.00, 84.76, '2026-02-11 03:05:19', '2026-02-11 03:05:19'),
(306, 224, 8, NULL, '', 700.00, 700.00, 57.62, '2026-02-11 03:15:49', '2026-02-11 03:15:50'),
(307, 250, 8, 4, '', 1500.00, 1500.00, 42.86, '2026-02-11 03:20:10', '2026-02-11 03:20:10'),
(308, 263, 8, NULL, '', 1000.00, 1000.00, 40.00, '2026-02-11 03:23:57', '2026-02-11 03:23:57'),
(309, 249, 8, NULL, '', 1000.00, 1000.00, 384.76, '2026-02-11 03:30:17', '2026-02-11 03:30:17'),
(310, 248, 8, NULL, '', 600.00, 600.00, 17.14, '2026-02-11 03:30:45', '2026-02-11 03:30:45'),
(311, 247, 8, NULL, '', 1100.00, 1100.00, 31.43, '2026-02-11 03:34:45', '2026-02-11 03:34:45'),
(312, 264, 8, NULL, '', 500.00, 500.00, 2.38, '2026-02-11 03:43:35', '2026-02-11 03:43:35'),
(313, 246, 8, NULL, '', 500.00, 500.00, 100.00, '2026-02-11 03:46:08', '2026-02-11 03:46:08'),
(314, 242, 8, NULL, '', 2000.00, 2000.00, 200.00, '2026-02-11 03:46:25', '2026-02-11 03:46:25'),
(315, 238, 8, NULL, '', 1000.00, 1000.00, 100.00, '2026-02-11 03:46:40', '2026-02-11 03:46:40'),
(316, 265, 8, NULL, '', 1000.00, 1000.00, 40.95, '2026-02-11 03:47:28', '2026-02-11 03:47:28'),
(317, 266, 8, NULL, '', 1000.00, 1000.00, 95.24, '2026-02-11 03:51:32', '2026-02-11 03:51:32'),
(318, 240, 8, NULL, '', 1000.00, 1000.00, 100.00, '2026-02-11 03:56:12', '2026-02-11 03:56:12'),
(319, 267, 8, NULL, '', 13000.00, 13000.00, 11778.57, '2026-02-11 03:56:56', '2026-02-11 03:56:56'),
(320, 268, 8, NULL, '12321', 600.00, 600.00, 57.14, '2026-02-11 03:58:10', '2026-02-11 03:58:10'),
(321, 269, 12, NULL, '', 1300.00, 1300.00, 0.00, '2026-02-11 04:00:05', '2026-02-11 04:00:05'),
(322, 271, 11, NULL, '', 1200.00, 1200.00, 0.00, '2026-02-11 04:02:09', '2026-02-11 04:02:09'),
(323, 270, 12, 10, '', 1300.00, 1300.00, 0.00, '2026-02-11 04:04:14', '2026-02-11 04:04:14'),
(324, 272, 8, NULL, '', 600.00, 600.00, 20.95, '2026-02-11 04:07:12', '2026-02-11 04:07:12'),
(325, 273, 12, NULL, '', 2000.00, 2000.00, 0.00, '2026-02-11 04:12:17', '2026-02-11 04:12:17'),
(326, 274, 12, NULL, '', 600.00, 600.00, 0.00, '2026-02-11 04:15:17', '2026-02-11 04:15:17'),
(327, 275, 8, NULL, '', 600.00, 600.00, 57.14, '2026-02-11 04:18:38', '2026-02-11 04:18:38'),
(328, 276, 8, NULL, '', 1000.00, 2200.00, 1069.05, '2026-02-11 04:23:35', '2026-02-11 04:23:35'),
(329, 276, 9, 5, '', 1200.00, 2200.00, 0.00, '2026-02-11 04:23:35', '2026-02-11 04:23:35'),
(330, 277, 8, NULL, '', 500.00, 500.00, 47.62, '2026-02-11 04:27:24', '2026-02-11 04:27:24'),
(331, 278, 8, NULL, '', 600.00, 600.00, 2.86, '2026-02-11 04:29:04', '2026-02-11 04:29:04'),
(332, 279, 8, NULL, '', 600.00, 600.00, 57.14, '2026-02-11 04:32:13', '2026-02-11 04:32:13'),
(333, 279, 8, NULL, '', 600.00, 600.00, 0.00, '2026-02-11 04:32:13', '2026-02-11 04:32:13'),
(334, 280, 8, NULL, '', 600.00, 600.00, 42.86, '2026-02-11 05:02:01', '2026-02-11 05:02:01'),
(335, 239, 8, NULL, '', 1000.00, 2000.00, 300.00, '2026-02-11 05:02:28', '2026-02-11 05:02:28'),
(336, 239, 9, 5, '', 1000.00, 2000.00, 0.00, '2026-02-11 05:02:28', '2026-02-11 05:02:28'),
(337, 281, 8, NULL, '', 600.00, 600.00, 57.14, '2026-02-11 05:13:02', '2026-02-11 05:13:02'),
(338, 282, 8, NULL, '123', 500.00, 1050.00, 0.00, '2026-02-11 07:06:49', '2026-03-06 01:39:18'),
(339, 282, 9, 5, '223', 500.00, 1050.00, 0.00, '2026-02-11 07:06:49', '2026-03-06 01:39:18'),
(340, 283, 8, NULL, '231', 1500.00, 1500.00, 42.86, '2026-02-12 00:54:09', '2026-02-12 00:54:09'),
(341, 286, 8, NULL, '', 500.00, 700.00, 0.00, '2026-02-12 02:40:19', '2026-02-18 05:59:20'),
(342, 287, 8, NULL, '', 2000.00, 2000.00, 500.00, '2026-02-12 03:04:22', '2026-02-12 03:04:22'),
(343, 235, 8, 16, '', 600.00, 600.00, 57.14, '2026-02-12 08:10:29', '2026-02-12 08:10:30'),
(344, 204, 8, 17, '', 1500.00, 1500.00, 385.71, '2026-02-13 02:38:41', '2026-02-13 02:38:41'),
(345, 285, 8, 17, '', 2000.00, 1000.00, 0.00, '2026-02-16 05:14:57', '2026-02-18 06:09:05'),
(346, 286, 8, 16, '', 700.00, 700.00, 93.81, '2026-02-18 05:59:20', '2026-02-18 05:59:20'),
(347, 288, 8, 16, '', 1000.00, 1000.00, 95.24, '2026-02-18 06:02:14', '2026-02-18 06:02:14'),
(348, 285, 9, 5, 'gc285', 500.00, 1000.00, 0.00, '2026-02-18 06:09:05', '2026-02-18 06:09:05'),
(349, 285, 8, 17, '', 500.00, 1000.00, 25.71, '2026-02-18 06:09:05', '2026-02-18 06:09:05'),
(350, 293, 9, 5, '', 1000.00, 2000.00, 0.00, '2026-02-24 06:48:13', '2026-02-24 06:48:13'),
(351, 293, 8, 17, '', 1000.00, 2000.00, 597.62, '2026-02-24 06:48:13', '2026-02-24 06:48:13'),
(352, 292, 8, 16, '', 3000.00, 3000.00, 950.00, '2026-03-06 01:32:19', '2026-03-06 01:32:19'),
(353, 290, 8, 17, '', 4000.00, 4000.00, 875.75, '2026-03-06 01:38:18', '2026-03-06 01:38:18'),
(354, 282, 8, 17, '', 1000.00, 1050.00, 0.00, '2026-03-06 01:39:18', '2026-03-06 01:39:18'),
(355, 282, 9, 5, '', 50.00, 1050.00, 0.00, '2026-03-06 01:39:18', '2026-03-06 01:39:18'),
(356, 236, 8, 17, '', 500.00, 950.00, 0.00, '2026-03-06 01:43:23', '2026-03-06 01:43:23'),
(357, 236, 9, 5, '', 450.00, 950.00, 0.00, '2026-03-06 01:43:23', '2026-03-06 01:43:23'),
(358, 209, 8, 17, '', 200.00, 209.00, 0.90, '2026-03-06 01:46:24', '2026-03-06 01:46:24'),
(359, 209, 9, 5, '', 9.00, 209.00, 0.00, '2026-03-06 01:46:24', '2026-03-06 01:46:24'),
(360, 284, 9, 5, '', 1000.00, 1500.00, 0.00, '2026-03-12 08:37:05', '2026-03-12 08:37:05'),
(361, 284, 8, 17, '', 500.00, 1500.00, 227.14, '2026-03-12 08:37:05', '2026-03-12 08:37:05'),
(362, 297, 8, 16, '', 500.00, 911.00, 1.00, '2026-03-16 06:07:54', '2026-03-16 06:07:54'),
(363, 297, 9, 5, '', 411.00, 911.00, 0.00, '2026-03-16 06:07:54', '2026-03-16 06:07:54'),
(364, 296, 9, 5, '', 1000.00, 1500.00, 0.00, '2026-03-16 06:58:31', '2026-03-16 06:58:31'),
(365, 296, 8, 17, '', 500.00, 1500.00, 460.00, '2026-03-16 06:58:31', '2026-03-16 06:58:31'),
(366, 298, 8, 17, '', 1000.00, 1268.57, 0.00, '2026-03-16 07:42:37', '2026-03-16 07:42:37'),
(367, 298, 9, 5, '', 268.57, 1268.57, 0.00, '2026-03-16 07:42:37', '2026-03-16 07:42:37'),
(368, 294, 10, 13, 'asdf', 814.29, 814.29, 0.00, '2026-03-17 09:06:49', '2026-03-17 09:06:49');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view POS', 'web', '2025-10-08 21:07:15', '2025-10-08 21:07:15'),
(2, 'view Inventory', 'web', '2025-10-08 21:07:15', '2025-10-08 21:07:15'),
(3, 'view People', 'web', '2025-10-08 21:07:15', '2025-10-08 21:07:15'),
(4, 'view Workforce', 'web', '2025-10-08 21:07:15', '2025-10-08 21:07:15'),
(5, 'view Accounting', 'web', '2025-10-08 21:07:15', '2025-10-08 21:07:15'),
(6, 'view Reports', 'web', '2025-10-08 21:07:15', '2025-10-08 21:07:15'),
(7, 'view Settings', 'web', '2026-01-22 01:32:38', '2026-01-22 01:32:38');

-- --------------------------------------------------------

--
-- Table structure for table `pos_sessions`
--

CREATE TABLE `pos_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `cashier_id` bigint(20) UNSIGNED NOT NULL,
  `terminal_no` varchar(255) DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `transaction_time` time NOT NULL,
  `cash_fund` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `closed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_session_summaries`
--

CREATE TABLE `pos_session_summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `cash_sales` decimal(12,2) NOT NULL DEFAULT 0.00,
  `charge_sales` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cash_out` decimal(12,2) NOT NULL DEFAULT 0.00,
  `short_over` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tip` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `po_delivery`
--

CREATE TABLE `po_delivery` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inventory_purchase_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_receipt` varchar(255) NOT NULL,
  `received_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `po_delivery`
--

INSERT INTO `po_delivery` (`id`, `inventory_purchase_order_id`, `user_id`, `delivery_receipt`, `received_at`, `created_at`, `updated_at`) VALUES
(1, 14, 15, 'DR-BR-000001', '2025-11-12 18:50:00', '2025-11-12 18:50:40', '2025-11-12 18:50:40'),
(2, 30, 15, 'DR-1-000001', '2025-11-12 18:57:00', '2025-11-12 18:57:18', '2025-11-12 18:57:18'),
(3, 30, 15, 'DR-1-000002', '2025-11-12 19:01:00', '2025-11-12 19:01:53', '2025-11-12 19:01:53'),
(4, 26, 15, 'DR-4-000001', '2025-11-12 21:26:00', '2025-11-12 21:27:08', '2025-11-12 21:27:08'),
(5, 33, 15, 'DR-1-000092', '2025-11-12 22:09:00', '2025-11-12 22:10:05', '2025-11-12 22:10:05'),
(6, 34, 15, 'DR-1-000093', '2025-11-13 00:23:00', '2025-11-13 00:24:12', '2025-11-13 00:24:12'),
(7, 34, 20, 'DR-1-000094', '2025-11-13 00:26:00', '2025-11-13 00:26:43', '2025-11-13 00:26:43'),
(8, 34, 20, 'DR-1-000095', '2025-11-13 00:27:00', '2025-11-13 00:27:36', '2025-11-13 00:27:36'),
(9, 33, 15, 'DR-1-000096', '2025-11-17 18:00:00', '2025-11-18 02:00:13', '2025-11-18 02:00:13'),
(10, 33, 15, 'DR-1-000097', '2025-11-19 18:16:00', '2025-11-20 02:16:48', '2025-11-20 02:16:48'),
(11, 38, 20, 'DR-1-000098', '2025-11-23 19:44:00', '2025-11-24 03:44:59', '2025-11-24 03:44:59'),
(12, 37, 20, 'DR-1-000099', '2026-01-28 18:08:00', '2026-01-29 02:09:28', '2026-01-29 02:09:28');

-- --------------------------------------------------------

--
-- Table structure for table `po_delivery_items`
--

CREATE TABLE `po_delivery_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `po_delivery_id` bigint(20) UNSIGNED NOT NULL,
  `po_detail_id` bigint(20) UNSIGNED NOT NULL,
  `component_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty_received` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `po_delivery_items`
--

INSERT INTO `po_delivery_items` (`id`, `po_delivery_id`, `po_detail_id`, `component_id`, `qty_received`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 4, 1, '2025-11-12 18:50:40', '2025-11-12 18:50:40'),
(2, 2, 15, 4, 2, '2025-11-12 18:57:18', '2025-11-12 18:57:18'),
(3, 2, 16, 7, 2, '2025-11-12 18:57:18', '2025-11-12 18:57:18'),
(4, 3, 15, 4, 3, '2025-11-12 19:01:53', '2025-11-12 19:01:53'),
(5, 3, 16, 7, 3, '2025-11-12 19:01:53', '2025-11-12 19:01:53'),
(6, 4, 11, 20, 2, '2025-11-12 21:27:08', '2025-11-12 21:27:08'),
(7, 5, 20, 4, 1, '2025-11-12 22:10:05', '2025-11-12 22:10:05'),
(8, 6, 21, 10, 1, '2025-11-13 00:24:12', '2025-11-13 00:24:12'),
(9, 7, 21, 10, 9, '2025-11-13 00:26:43', '2025-11-13 00:26:43'),
(10, 7, 22, 13, 5, '2025-11-13 00:26:43', '2025-11-13 00:26:43'),
(11, 8, 22, 13, 5, '2025-11-13 00:27:36', '2025-11-13 00:27:36'),
(12, 9, 20, 4, 1, '2025-11-18 02:00:13', '2025-11-18 02:00:13'),
(13, 10, 20, 4, 8, '2025-11-20 02:16:48', '2025-11-20 02:16:48'),
(14, 11, 26, 4, 100, '2025-11-24 03:44:59', '2025-11-24 03:44:59'),
(15, 12, 25, 22, 1, '2026-01-29 02:09:28', '2026-01-29 02:09:28');

-- --------------------------------------------------------

--
-- Table structure for table `po_details`
--

CREATE TABLE `po_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inventory_purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `component_id` bigint(20) UNSIGNED NOT NULL,
  `onhand` int(11) NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 1,
  `unit_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `received_qty` int(11) NOT NULL DEFAULT 0,
  `sub_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `type` enum('simple','bundle') NOT NULL DEFAULT 'simple',
  `quantity` decimal(8,2) NOT NULL DEFAULT 0.00,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `station_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `image` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `price`, `type`, `quantity`, `unit_id`, `station_id`, `status`, `image`, `remarks`, `category_id`, `subcategory_id`, `created_at`, `updated_at`) VALUES
(174, 'CF3', 'Chicken Feet', 250.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(175, 'BCT', 'B.Chix Teriyaki', 250.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(176, 'JS4', 'Jap Siomai 4pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(177, 'JS1', 'Jap Siomai 1pc', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(178, 'FPSS', 'Frz PS Siomai 16pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(179, 'FPMS', 'Frz PM Siomai 16pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(180, 'FPBS', 'Frz PB Siopao 6pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(181, 'FPAS', 'Frz PA Siopao 6pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(182, 'KD1', 'Kuchay Dump 1pc', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(183, 'FJS', 'Frz Jap Siomai 16pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(184, 'KD3', 'Kuchay Dump 3pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(185, 'BPB3', 'BP Buns 3pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(186, 'BPB1', 'BP Bun 1pc', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(187, 'GPS', 'Pandan.S Groupies Promo', 100.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 48, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(188, 'PS', 'Pandan Salad', 120.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 48, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(189, 'GMFS', 'M.Float Groupies Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 48, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(190, 'MFS', 'M.Float (s)', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 48, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(191, 'MFW', 'M.Float (W)', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 48, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(192, 'FKD', 'Frz Kuchay Dump 12pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(193, 'PMS4', 'PM Siomai 4pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(194, 'SSPAG', 'Spaghetti', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 52, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(195, 'SCARB', 'Carbonara', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 52, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(196, 'KR3', 'Kare Rice 3 BCT', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 59, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(197, 'KR2', 'Kare Rice 2 PBBQ2', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 59, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(198, 'KR1', 'Kare Rice 1 IBAB', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 59, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(199, 'SPSR3', 'Pork Sp.Ribs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(200, 'PSS4', 'PS Siomai 4pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(201, 'JS1W', 'Jap Siomai WS', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(202, 'PMS1W', 'PM Siomai WS', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(203, 'GBUKS', 'B.Pandan Groupies Promo', 150.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 48, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(204, 'PMS1', 'PM Siomai 1pc', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(205, 'PBS1W', 'PB Siopao WS', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(206, 'PBS3', 'PB Siopao 3pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(207, 'PBS1', 'PB Siopao 1pc', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(208, 'PAS1W', 'PA Siopao WS', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(209, 'PAS3', 'PA Siopao 3pcs', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(210, 'PAS1', 'PA Siopao 1pc', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(211, 'PSS1', 'PS Siomai 1pc', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 49, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(212, 'SR4', 'SS Rice Platter', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(213, 'PNUTS', 'Peanuts', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 44, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(214, 'TOKWA', 'Fried Tokwa', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 44, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(215, 'FF', 'French Fries', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 44, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(216, 'CALAM', 'Calamares', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 44, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(217, 'BTC', 'Better Chicharon', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 44, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(218, 'SPICY', 'Swt.Spc.Squid', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(219, 'GSS', 'Sisig Groupies Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(220, 'GLF', 'Leche Flan Groupies Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 48, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(221, 'SOR', 'Shrimp Oriental', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(222, 'KAREBE', 'Kare Beef', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 45, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(223, 'KAREG', 'Kareng Gulay', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(224, 'FFOR', 'Fish Oriental', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(225, 'FGC2', 'F.G.Chix 12', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(226, 'FGC1', 'F.G.Chix 1', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(227, 'SS', 'Crunchy Pork Sisig', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(228, 'CG', 'Canton Guisado', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(229, 'BGRAV', 'Beef Gravy', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(230, 'SIGBB', 'Sig. Bangus', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 43, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(231, 'GFC1', 'G.F.Chix 1', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(232, 'GCG', 'Canton Groupies Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 60, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(233, 'BUKS', 'B.Pandan (s)', 75.00, 'simple', 75.00, NULL, NULL, 'active', NULL, NULL, 22, 48, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(234, 'BUKW', 'B.Pandan (W)', 100.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 48, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(235, 'SSFC4', 'Sw Sp FC 1/4', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(236, 'SSFC2', 'Sw Sp FC 1/2', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(237, 'SSFC1', 'Sw Sp FC 1', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(238, 'RCHIX2', 'R. Chix 1/2', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(239, 'TB', 'Tokwa Baboy', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 44, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(240, 'GFC2', 'G.F.Chix 1/2', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(241, 'BCAL', 'Beef Caldereta', 600.00, 'simple', 0.00, 1, 3, 'active', NULL, NULL, 22, 45, '2026-03-12 03:13:24', '2026-03-12 03:58:24'),
(242, 'FGC4', 'F.G.Chix 1/4', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(243, 'FC2', 'F.Chix.2pcs L&T', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(244, 'EGG', 'Egg', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(245, 'CCF', 'Crispy Chix Fillet', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(246, 'YAKI', 'Chix BBQ 3sticks', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(247, 'FC8', '8pc Frd Chicken', 350.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(248, 'FC6', '6pc Frd Chicken', 300.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(249, 'LF', 'Leche Flan', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 48, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(250, 'RCHIX1', 'R. Chix 1', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 46, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(251, 'SPSQ', 'S&P Squid', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 55, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(252, 'SIGH', 'Sig.Hipon', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(253, 'SIGBAK', 'Sig.Baka', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(254, 'SIGB', 'Sig.Baboy', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(255, 'NILAGA', 'Nilaga Baka', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(256, 'BINA', 'Chix Binakol', 450.00, 'simple', 0.00, 1, 3, 'active', 'products/rzVq4NlIs9WSvi07k1eboypIKlLkDmxI0kOP0XVY.png', NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-13 02:49:05'),
(257, 'BSOUP', 'Bulalo Soup', 700.00, 'simple', 0.00, 1, 5, 'active', 'products/FjuYyurdtSlHlmCNeGLvBwTbmOIcAbmF9eujmoP6.png', NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-13 02:49:44'),
(258, 'SGAM', 'Sizzling Gambas', 600.00, 'simple', 0.00, 1, 2, 'active', 'products/laNIHlIDSltRTk3mRjbD53UfOnqkqYa1jP8fK51Y.png', NULL, 22, 55, '2026-03-12 03:13:24', '2026-03-13 02:50:02'),
(259, 'GRAVY', 'Gravy', 50.00, 'simple', 0.00, 1, 1, 'active', 'products/Bv0OfFMKmET5CSGim56oLlVy2ijHI5dzrqroq2VJ.png', NULL, 22, 61, '2026-03-12 03:13:24', '2026-03-13 02:50:15'),
(260, 'STO', 'Shrimp Tofu Oriental', 450.00, 'simple', 0.00, 1, 2, 'active', 'products/2Ti3BeaB82kPPauWMGUtbZlCw4Ggm0GoJnlxhAAZ.png', NULL, 22, 55, '2026-03-12 03:13:24', '2026-03-13 02:50:30'),
(261, 'SIGSB', 'Sinigang Salmon Belly', 650.00, 'simple', 0.00, 1, 3, 'active', 'products/C1k0RguOPKkMnnrTszJHu0poLZQb11OcBxVUthbh.png', NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-13 02:50:45'),
(262, 'GP', 'Grilled Pusit', 0.00, 'simple', 800.00, 1, 1, 'active', 'products/nROYV11UXP20xa3Zg1y9h4CqkYD9jH9xS1kPUq6P.png', NULL, 22, 55, '2026-03-12 03:13:24', '2026-03-13 04:59:31'),
(263, 'GB', 'Grilled Bangus', 350.00, 'simple', 0.00, 1, 1, 'active', 'products/5ojrI2Sx5AJEMZkvzeMgmJ86TNcUDJpxG7ZFI1ZB.png', NULL, 22, 55, '2026-03-12 03:13:24', '2026-03-13 02:48:36'),
(264, 'GTB', 'Grilled Tuna Belly', 650.00, 'simple', 0.00, 1, 1, 'active', 'products/w1Nb0GGrQ7D2AUgiPRQP059gy6z2ErPSKaGXrb8Y.png', NULL, 22, 55, '2026-03-12 03:13:24', '2026-03-13 05:01:16'),
(265, 'GSB', 'Grilled Salmon Belly', 900.00, 'simple', 0.00, 1, 1, 'active', 'products/JdEVV8aVlcPFvlpoMx3bjDZ9z1pjMAKyE8awWrNh.png', NULL, 22, 55, '2026-03-12 03:13:24', '2026-03-13 05:02:27'),
(266, 'PFBB', 'Fried Bangus', 400.00, 'simple', 0.00, 1, 2, 'active', 'products/LYI1JWNneRQdnF8P7eEo35gUfB7Feaxi9JKi9Gu9.png', NULL, 22, 55, '2026-03-12 03:13:24', '2026-03-13 05:03:40'),
(267, 'FISHF', 'Fish Fingers', 500.00, 'simple', 0.00, 1, 2, 'active', 'products/lCgtqK4ydcZV72R7GIgzxW5MifeFeJrby2XkfIIY.png', NULL, 22, 55, '2026-03-12 03:13:24', '2026-03-13 05:05:18'),
(268, 'GBG', 'Bihon Guisado', 300.00, 'simple', 0.00, 1, 5, 'active', 'products/Y2heo66kjxMlRhwOzrwEqGjWBhR3XT7cp9RyZxFT.png', NULL, 22, 60, '2026-03-12 03:13:24', '2026-03-13 05:12:30'),
(269, 'SSRF', 'Sweet & Sour Fish Fillet', 500.00, 'simple', 0.00, 1, 1, 'active', 'products/F2a1ijjko2dSvul9Yixw92a5GfYlyvsji0xRkXS4.png', NULL, 22, 55, '2026-03-12 03:13:24', '2026-03-13 05:13:48'),
(270, 'SKCCF', 'Chicken Fillet', 400.00, 'simple', 0.00, 1, 2, 'active', 'products/sC6MXDqHpHQ0CI32NT7YaG2feV4HnlvAt7WfJe9Z.png', NULL, 22, 62, '2026-03-12 03:13:24', '2026-03-13 05:15:22'),
(271, 'STOFU', 'Sizzling Tofu', 350.00, 'simple', 0.00, 1, 2, 'active', 'products/dSkG3Ul0wQNpHQP4PUQpfZZU49AR79NWoM4CMOYa.png', NULL, 22, 58, '2026-03-12 03:13:24', '2026-03-13 05:59:39'),
(272, 'PAK', 'Pinakbet', 200.00, 'simple', 0.00, 1, 3, 'active', 'products/Vr8YFOv8FdPd7UuI9V0JtG1pkIs3LUGck4OIbQ43.png', NULL, 22, 58, '2026-03-12 03:13:24', '2026-03-13 06:03:35'),
(273, 'MANGGA', 'Manga Hilaw w/ Bagoong', 150.00, 'simple', 0.00, 1, 4, 'active', 'products/uScljw5hHTaQHeMRo8PbDEtdArFItIR06BaHBwsx.png', NULL, 22, 58, '2026-03-12 03:13:24', '2026-03-13 06:01:57'),
(274, 'KG4', 'Kare G. 4 Bowls', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 63, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(275, 'KG1', 'Kare G. 1 Bowl', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 63, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(276, 'CHOP', 'Chopsuey', 550.00, 'simple', 0.00, 1, 1, 'active', 'products/cKlm8nxO4ARHkDYU5jaRQgjOn6Zct9kHVpsg0KhM.png', NULL, 22, 58, '2026-03-12 03:13:24', '2026-03-13 05:58:17'),
(277, 'SKFF', 'SK Swt Sr Fish Fillet', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 62, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(278, 'SIGIM', 'Sig.I.Manok', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(279, 'SKLS', 'SK L.Shanghai', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 62, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(280, 'SIGIB', 'Sig.Ihaw Liempo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(281, 'SKBQ', 'SK 2pc PBBQ', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 62, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(282, 'SKFC', 'SK 1pc FChix', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 62, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(283, 'SINAM', 'Sinampalukan Soup', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(284, 'GSIM', 'Sinamp. Groupies Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(285, 'SIB6', 'Sig.iBab 6 Bowls', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(286, 'SIB5', 'Sig.iBab 5 Bowls', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(287, 'SIB4', 'Sig.iBab 4 Bowls', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 57, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(288, 'UPSR', 'Up Sisig Rice Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(289, 'SKSS', 'SK P.Sisig', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 62, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(290, 'CPATAL', 'C.Pata Large', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(291, 'RP', 'Roasted Pork', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(292, 'PBBQ4', 'Pork BBQ 4sticks', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(293, 'PBBQ', 'Pork BBQ 3sticks', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(294, 'LSG', 'L.Shanghai Groupies Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(295, 'LS', 'L.Shanghai', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(296, 'LK2', 'L.Kawali 1/2', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(297, 'LK', 'L.Kawali 1', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(298, 'BSALP', 'Bangus Salpicao', 450.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 55, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(299, 'CPATAM', 'C.Pata Reg.', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(300, 'XR', 'Extra Rice Groupies Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(301, 'BICOL', 'Bicol Express', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(302, 'GPICA', 'Pica-Pica Platter', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 64, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(303, 'GGPLAT', 'G.Grd.Platter', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 64, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(304, 'GBP', 'BBQ Platter', 300.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 64, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(305, 'MIKI', 'Miki Bihon Guisado', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 60, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(306, 'GMIKI', 'Miki Bihon Groupies Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 60, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(307, 'TOFUE', 'Tofu.Eggplant', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 63, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(308, 'IBAB', 'Inihaw Liempo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(309, 'PRUC6', 'RUC Groupies6 Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(310, 'UPGCR', 'Up Garl.Rice Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(311, 'UPGFR', 'Up Frd. Rice Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(312, 'PRMP', 'Unli-Rice AK Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(313, 'SRMP', 'Sisig Rice MP Convert', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(314, 'SR', 'Sisig Rice', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(315, 'PR4', 'Rice Plain 4', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(316, 'PR', 'Rice Plain', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(317, 'SPP', 'S&P Pork', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(318, 'GCR4', 'Rice Garlc 4', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(319, 'SSP', 'Swt Sr Pork', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 53, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(320, 'PRUC4', 'RUC Groupies4 Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(321, 'PR1', 'Plain Rice Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(322, 'HR', 'Half Rice', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(323, 'PR6G', 'Groupies6 Rice Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(324, 'PR4G', 'Groupies4 Rice Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(325, 'GFR6G', 'GFR6 Groupies6 Rice Promo', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(326, 'GFR', 'Fried Rice', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(327, 'BG', 'Bihon Guisado', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 60, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(328, 'GCR', 'Rice Garlic', 0.00, 'simple', 0.00, NULL, NULL, 'active', NULL, NULL, 22, 54, '2026-03-12 03:13:24', '2026-03-12 03:13:24');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `component_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `product_id`, `component_id`, `quantity`, `created_at`, `updated_at`) VALUES
(218, 316, 458, 0.09, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(219, 326, 458, 0.27, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(220, 325, 458, 0.27, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(221, 197, 458, 0.09, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(222, 324, 458, 0.27, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(223, 323, 458, 0.54, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(224, 322, 458, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(225, 321, 458, 0.09, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(226, 320, 458, 0.29, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(227, 300, 458, 0.09, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(228, 328, 458, 0.09, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(229, 309, 458, 0.30, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(230, 315, 458, 0.27, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(231, 314, 458, 0.09, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(232, 313, 458, 0.09, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(233, 312, 458, 0.09, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(234, 311, 458, 0.27, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(235, 310, 458, 0.27, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(236, 288, 458, 0.27, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(237, 196, 458, 0.09, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(238, 212, 458, 0.27, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(239, 318, 458, 0.27, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(240, 198, 458, 0.09, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(243, 216, 464, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(246, 239, 464, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(247, 214, 464, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(250, 218, 466, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(252, 250, 473, 3.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(253, 238, 473, 3.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(254, 238, 490, 7.50, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(255, 250, 490, 15.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(256, 218, 494, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(257, 198, 499, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(258, 275, 499, 0.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(259, 196, 499, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(260, 223, 499, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(261, 274, 499, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(262, 197, 499, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(263, 327, 500, 0.12, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(265, 306, 500, 0.12, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(266, 305, 500, 0.12, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(267, 228, 502, 0.15, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(268, 232, 502, 0.15, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(270, 328, 505, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(271, 228, 505, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(272, 250, 505, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(273, 238, 505, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(275, 327, 505, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(276, 232, 505, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(277, 216, 506, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(278, 319, 513, 0.07, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(279, 216, 513, 0.11, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(280, 302, 514, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(281, 215, 514, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(282, 218, 517, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(283, 213, 517, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(284, 216, 517, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(285, 216, 517, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(290, 306, 522, 0.15, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(291, 305, 522, 0.15, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(293, 274, 526, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(294, 198, 526, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(295, 222, 526, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(296, 197, 526, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(297, 196, 526, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(298, 223, 526, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(299, 275, 526, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(301, 214, 535, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(302, 215, 542, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(304, 218, 543, 0.06, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(306, 213, 546, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(307, 328, 546, 0.38, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(308, 216, 546, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(309, 215, 546, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(310, 214, 561, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(311, 239, 561, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(313, 214, 564, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(314, 239, 564, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(315, 238, 567, 0.25, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(316, 250, 567, 0.50, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(319, 244, 581, 1.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(320, 319, 581, 1.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(323, 255, 596, 0.15, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(324, 253, 596, 0.15, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(325, 253, 596, 0.15, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(326, 229, 596, 0.15, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(327, 222, 597, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(328, 304, 601, 0.16, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(329, 245, 601, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(331, 246, 601, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(332, 243, 603, 0.25, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(333, 282, 603, 0.13, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(334, 303, 604, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(335, 175, 604, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(336, 196, 604, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(337, 278, 604, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(338, 284, 605, 0.25, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(339, 283, 605, 0.25, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(340, 294, 607, 0.12, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(341, 295, 607, 0.12, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(342, 302, 607, 0.12, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(343, 279, 607, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(344, 297, 608, 0.25, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(346, 228, 608, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(347, 303, 608, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(348, 286, 608, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(349, 254, 608, 0.25, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(350, 296, 608, 0.13, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(351, 287, 608, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(352, 285, 608, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(353, 198, 608, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(354, 327, 608, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(355, 301, 608, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(356, 308, 608, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(357, 232, 608, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(358, 306, 608, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(359, 305, 608, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(360, 280, 608, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(361, 217, 608, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(362, 239, 608, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(364, 302, 608, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(365, 314, 610, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(366, 313, 610, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(367, 289, 610, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(368, 219, 610, 0.09, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(369, 212, 610, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(370, 195, 610, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(371, 194, 610, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(372, 227, 610, 0.09, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(373, 288, 610, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(374, 291, 614, 0.15, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(375, 293, 614, 0.12, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(376, 319, 614, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(377, 301, 614, 0.16, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(378, 281, 614, 0.08, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(379, 197, 614, 0.08, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(380, 292, 614, 0.16, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(381, 304, 614, 0.16, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(383, 231, 623, 1.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(384, 242, 623, 0.25, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(385, 247, 623, 1.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(386, 248, 623, 0.75, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(387, 250, 623, 1.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(388, 236, 623, 0.50, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(389, 225, 623, 0.50, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(391, 238, 623, 0.50, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(392, 237, 623, 1.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(393, 240, 623, 0.50, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(394, 235, 623, 0.25, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(395, 226, 623, 1.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(396, 290, 625, 1.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(397, 299, 626, 1.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(398, 277, 629, 0.07, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(399, 224, 629, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(402, 216, 630, 0.11, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(407, 251, 632, 0.15, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(408, 306, 632, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(409, 303, 632, 0.30, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(410, 305, 632, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(411, 232, 632, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(412, 218, 632, 0.15, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(413, 228, 632, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(414, 326, 632, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(415, 327, 632, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(417, 303, 634, 0.30, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(421, 252, 638, 0.13, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(422, 221, 638, 0.26, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(424, 230, 639, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(426, 298, 639, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(428, 327, 640, 2.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(429, 232, 640, 3.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(430, 305, 640, 3.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(432, 306, 640, 3.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(433, 228, 640, 3.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(440, 255, 646, 0.07, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(441, 216, 647, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(442, 319, 648, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(447, 255, 652, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(448, 252, 655, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(449, 254, 655, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(451, 222, 655, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(452, 285, 655, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(453, 275, 655, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(454, 196, 655, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(455, 274, 655, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(456, 286, 655, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(457, 223, 655, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(458, 198, 655, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(459, 307, 655, 0.20, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(460, 287, 655, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(461, 197, 655, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(462, 302, 656, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(463, 213, 656, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(464, 238, 658, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(465, 213, 658, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(467, 218, 658, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(468, 250, 658, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(469, 328, 658, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(471, 219, 660, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(475, 227, 660, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(477, 252, 662, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(478, 285, 662, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(479, 254, 662, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(480, 287, 662, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(481, 286, 662, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(484, 287, 669, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(485, 252, 669, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(486, 286, 669, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(487, 285, 669, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(489, 254, 669, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(490, 239, 671, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(492, 227, 672, 0.06, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(495, 219, 672, 0.06, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(496, 214, 672, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(497, 287, 672, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(498, 285, 672, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(499, 239, 672, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(501, 252, 672, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(503, 286, 672, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(505, 255, 672, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(506, 254, 672, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(508, 223, 676, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(509, 196, 676, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(510, 197, 676, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(511, 274, 676, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(512, 275, 676, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(513, 222, 676, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(514, 198, 676, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(516, 255, 676, 0.07, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(519, 255, 677, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(520, 198, 678, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(521, 197, 678, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(522, 275, 678, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(523, 196, 678, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(524, 274, 678, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(525, 223, 678, 0.10, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(526, 222, 678, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(527, 285, 679, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(528, 254, 679, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(529, 286, 679, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(530, 287, 679, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(531, 252, 679, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(532, 319, 681, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(534, 214, 683, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(535, 252, 683, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(537, 255, 688, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(538, 223, 688, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(539, 196, 688, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(540, 252, 688, 0.04, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(541, 197, 688, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(542, 274, 688, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(544, 275, 688, 0.01, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(545, 286, 688, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(546, 287, 688, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(547, 198, 688, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(548, 222, 688, 0.03, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(549, 254, 688, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(550, 285, 688, 0.02, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(551, 287, 692, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(552, 254, 692, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(554, 252, 692, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(555, 285, 692, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(557, 286, 692, 0.05, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(559, 255, 696, 0.50, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(560, 307, 697, 2.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(561, 214, 697, 3.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(563, 239, 697, 2.00, '2026-03-12 03:59:42', '2026-03-12 03:59:42'),
(729, 241, 520, 0.03, '2026-03-12 03:58:24', '2026-03-12 03:58:24'),
(730, 241, 527, 0.02, '2026-03-12 03:58:24', '2026-03-12 03:58:24'),
(731, 241, 542, 0.15, '2026-03-12 03:58:24', '2026-03-12 03:58:24'),
(732, 241, 543, 0.15, '2026-03-12 03:58:24', '2026-03-12 03:58:24'),
(733, 241, 596, 0.15, '2026-03-12 03:58:24', '2026-03-12 03:58:24'),
(734, 241, 648, 0.04, '2026-03-12 03:58:24', '2026-03-12 03:58:24'),
(735, 241, 660, 0.01, '2026-03-12 03:58:24', '2026-03-12 03:58:24'),
(736, 241, 677, 0.05, '2026-03-12 03:58:24', '2026-03-12 03:58:24'),
(737, 241, 681, 0.01, '2026-03-12 03:58:24', '2026-03-12 03:58:24'),
(805, 263, 639, 0.25, '2026-03-13 02:48:36', '2026-03-13 02:48:36'),
(806, 256, 505, 0.02, '2026-03-13 02:49:05', '2026-03-13 02:49:05'),
(807, 256, 589, 0.50, '2026-03-13 02:49:05', '2026-03-13 02:49:05'),
(808, 256, 623, 0.25, '2026-03-13 02:49:05', '2026-03-13 02:49:05'),
(809, 256, 658, 0.01, '2026-03-13 02:49:05', '2026-03-13 02:49:05'),
(810, 256, 659, 0.02, '2026-03-13 02:49:05', '2026-03-13 02:49:05'),
(811, 256, 661, 0.01, '2026-03-13 02:49:05', '2026-03-13 02:49:05'),
(812, 256, 672, 0.02, '2026-03-13 02:49:05', '2026-03-13 02:49:05'),
(813, 256, 674, 0.15, '2026-03-13 02:49:05', '2026-03-13 02:49:05'),
(814, 257, 622, 1.00, '2026-03-13 02:49:44', '2026-03-13 02:49:44'),
(815, 257, 643, 0.03, '2026-03-13 02:49:44', '2026-03-13 02:49:44'),
(816, 257, 646, 0.07, '2026-03-13 02:49:44', '2026-03-13 02:49:44'),
(817, 257, 652, 0.05, '2026-03-13 02:49:44', '2026-03-13 02:49:44'),
(818, 257, 672, 0.05, '2026-03-13 02:49:44', '2026-03-13 02:49:44'),
(819, 257, 676, 0.07, '2026-03-13 02:49:44', '2026-03-13 02:49:44'),
(820, 257, 677, 0.05, '2026-03-13 02:49:44', '2026-03-13 02:49:44'),
(821, 257, 696, 0.50, '2026-03-13 02:49:44', '2026-03-13 02:49:44'),
(822, 258, 581, 1.00, '2026-03-13 02:50:02', '2026-03-13 02:50:02'),
(823, 258, 636, 0.15, '2026-03-13 02:50:02', '2026-03-13 02:50:02'),
(824, 258, 660, 0.03, '2026-03-13 02:50:02', '2026-03-13 02:50:02'),
(825, 258, 671, 0.03, '2026-03-13 02:50:02', '2026-03-13 02:50:02'),
(826, 259, 568, 0.02, '2026-03-13 02:50:15', '2026-03-13 02:50:15'),
(827, 259, 517, 0.02, '2026-03-13 02:50:15', '2026-03-13 02:50:15'),
(828, 259, 473, 0.02, '2026-03-13 02:50:15', '2026-03-13 02:50:15'),
(829, 260, 638, 0.13, '2026-03-13 02:50:30', '2026-03-13 02:50:30'),
(830, 260, 697, 2.00, '2026-03-13 02:50:30', '2026-03-13 02:50:30'),
(831, 261, 631, 0.15, '2026-03-13 02:50:45', '2026-03-13 02:50:45'),
(832, 261, 666, 0.05, '2026-03-13 02:50:45', '2026-03-13 02:50:45'),
(833, 261, 668, 0.05, '2026-03-13 02:50:45', '2026-03-13 02:50:45'),
(834, 261, 672, 0.04, '2026-03-13 02:50:45', '2026-03-13 02:50:45'),
(835, 261, 692, 0.05, '2026-03-13 02:50:45', '2026-03-13 02:50:45'),
(836, 262, 464, 0.01, '2026-03-13 04:59:31', '2026-03-13 04:59:31'),
(837, 262, 517, 0.01, '2026-03-13 04:59:31', '2026-03-13 04:59:31'),
(838, 262, 562, 0.05, '2026-03-13 04:59:31', '2026-03-13 04:59:31'),
(839, 262, 632, 0.30, '2026-03-13 04:59:31', '2026-03-13 04:59:31'),
(845, 264, 459, 0.25, '2026-03-13 05:01:16', '2026-03-13 05:01:16'),
(846, 264, 464, 0.01, '2026-03-13 05:01:16', '2026-03-13 05:01:16'),
(847, 264, 466, 0.01, '2026-03-13 05:01:16', '2026-03-13 05:01:16'),
(848, 264, 517, 0.01, '2026-03-13 05:01:16', '2026-03-13 05:01:16'),
(849, 264, 634, 0.30, '2026-03-13 05:01:16', '2026-03-13 05:01:16'),
(850, 265, 459, 0.25, '2026-03-13 05:02:27', '2026-03-13 05:02:27'),
(851, 265, 464, 0.01, '2026-03-13 05:02:27', '2026-03-13 05:02:27'),
(852, 265, 466, 0.01, '2026-03-13 05:02:27', '2026-03-13 05:02:27'),
(853, 265, 517, 0.01, '2026-03-13 05:02:27', '2026-03-13 05:02:27'),
(854, 265, 631, 0.30, '2026-03-13 05:02:27', '2026-03-13 05:02:27'),
(855, 266, 639, 0.25, '2026-03-13 05:03:40', '2026-03-13 05:03:40'),
(856, 267, 629, 0.20, '2026-03-13 05:05:18', '2026-03-13 05:05:18'),
(857, 268, 500, 0.12, '2026-03-13 05:12:30', '2026-03-13 05:12:30'),
(858, 268, 505, 0.01, '2026-03-13 05:12:30', '2026-03-13 05:12:30'),
(859, 268, 608, 0.04, '2026-03-13 05:12:30', '2026-03-13 05:12:30'),
(860, 268, 632, 0.02, '2026-03-13 05:12:30', '2026-03-13 05:12:30'),
(861, 268, 640, 2.00, '2026-03-13 05:12:30', '2026-03-13 05:12:30'),
(862, 269, 629, 0.20, '2026-03-13 05:13:48', '2026-03-13 05:13:48'),
(863, 270, 601, 0.05, '2026-03-13 05:15:22', '2026-03-13 05:15:22'),
(874, 276, 525, 0.02, '2026-03-13 05:58:17', '2026-03-13 05:58:17'),
(875, 276, 640, 2.00, '2026-03-13 05:58:17', '2026-03-13 05:58:17'),
(876, 276, 643, 0.02, '2026-03-13 05:58:17', '2026-03-13 05:58:17'),
(877, 276, 645, 0.03, '2026-03-13 05:58:17', '2026-03-13 05:58:17'),
(878, 276, 646, 0.03, '2026-03-13 05:58:17', '2026-03-13 05:58:17'),
(879, 276, 648, 0.01, '2026-03-13 05:58:17', '2026-03-13 05:58:17'),
(880, 276, 649, 0.03, '2026-03-13 05:58:17', '2026-03-13 05:58:17'),
(881, 276, 660, 0.04, '2026-03-13 05:58:17', '2026-03-13 05:58:17'),
(882, 276, 672, 0.02, '2026-03-13 05:58:17', '2026-03-13 05:58:17'),
(892, 273, 573, 2.00, '2026-03-13 06:01:57', '2026-03-13 06:01:57'),
(893, 273, 635, 0.04, '2026-03-13 06:01:57', '2026-03-13 06:01:57'),
(894, 271, 697, 3.00, '2026-03-13 06:02:25', '2026-03-13 06:02:25'),
(895, 272, 608, 0.04, '2026-03-13 06:03:35', '2026-03-13 06:03:35'),
(896, 272, 635, 0.02, '2026-03-13 06:03:35', '2026-03-13 06:03:35'),
(897, 272, 655, 0.03, '2026-03-13 06:03:35', '2026-03-13 06:03:35'),
(898, 272, 669, 0.04, '2026-03-13 06:03:35', '2026-03-13 06:03:35'),
(899, 272, 672, 0.02, '2026-03-13 06:03:35', '2026-03-13 06:03:35'),
(900, 272, 687, 0.04, '2026-03-13 06:03:35', '2026-03-13 06:03:35'),
(901, 272, 688, 0.03, '2026-03-13 06:03:35', '2026-03-13 06:03:35'),
(902, 272, 692, 0.05, '2026-03-13 06:03:35', '2026-03-13 06:03:35');

-- --------------------------------------------------------

--
-- Table structure for table `remarks`
--

CREATE TABLE `remarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `component_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('unread','read') NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_leaves`
--

CREATE TABLE `request_leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_datetime` datetime NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `workforce_leave_id` bigint(20) UNSIGNED NOT NULL,
  `period_start` datetime NOT NULL,
  `period_end` datetime NOT NULL,
  `no_of_days` decimal(5,2) NOT NULL,
  `reason` text NOT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `status` enum('pending','approved','disapproved','cancelled') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_datetime` datetime DEFAULT NULL,
  `disapproved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `cancelled_by` bigint(20) UNSIGNED DEFAULT NULL,
  `cancelled_datetime` datetime DEFAULT NULL,
  `disapproved_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `requested_by` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_datetime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_leaves`
--

INSERT INTO `request_leaves` (`id`, `application_datetime`, `employee_id`, `workforce_leave_id`, `period_start`, `period_end`, `no_of_days`, `reason`, `attachments`, `status`, `approved_by`, `approved_datetime`, `disapproved_by`, `cancelled_by`, `cancelled_datetime`, `disapproved_datetime`, `created_at`, `updated_at`, `requested_by`, `requested_datetime`) VALUES
(1, '2026-01-28 15:41:00', 20, 1, '2026-02-05 15:41:00', '2026-02-06 15:41:00', 2.00, 'test', '[]', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-28 07:44:33', '2026-01-28 07:44:33', 15, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `description`) VALUES
(4, 'Administrator', 'web', NULL, NULL, NULL),
(5, 'Manager', 'web', NULL, NULL, NULL),
(6, 'Cashier', 'web', NULL, NULL, NULL),
(7, 'Waiter', 'web', NULL, NULL, NULL),
(8, 'Chef', 'web', NULL, NULL, NULL),
(9, 'Cook', 'web', NULL, NULL, NULL),
(10, 'Bartender', 'web', NULL, NULL, NULL),
(11, 'Utility', 'web', NULL, NULL, NULL),
(12, 'HR', 'web', '2025-10-08 21:07:40', '2025-10-08 21:07:40', 'HR NEW');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 4),
(2, 4),
(2, 12),
(3, 4),
(3, 12),
(4, 4),
(5, 4),
(6, 4),
(7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_methods`
--

CREATE TABLE `salary_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `method_id` varchar(255) DEFAULT NULL,
  `period_id` varchar(255) DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `custom_time_start` varchar(255) DEFAULT NULL,
  `custom_time_end` varchar(255) DEFAULT NULL,
  `custom_break_start` varchar(255) DEFAULT NULL,
  `custom_break_end` varchar(255) DEFAULT NULL,
  `custom_work_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`custom_work_days`)),
  `custom_rest_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`custom_rest_days`)),
  `custom_open_time` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`custom_open_time`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_methods`
--

INSERT INTO `salary_methods` (`id`, `user_id`, `method_id`, `period_id`, `account`, `created_at`, `updated_at`, `shift_id`, `custom_time_start`, `custom_time_end`, `custom_break_start`, `custom_break_end`, `custom_work_days`, `custom_rest_days`, `custom_open_time`) VALUES
(19, 51, NULL, 'bi-monthly', NULL, '2026-01-09 06:31:33', '2026-01-09 06:31:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 17, NULL, 'bi-monthly', NULL, '2026-01-22 00:45:32', '2026-01-22 00:45:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 16, NULL, 'bi-monthly', NULL, '2026-01-22 00:58:27', '2026-01-22 00:58:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 20, NULL, 'bi-monthly', NULL, '2026-01-22 07:46:48', '2026-01-22 08:04:04', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 79, NULL, 'bi-monthly', NULL, '2026-01-22 08:01:00', '2026-01-22 08:01:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 15, NULL, 'bi-monthly', NULL, '2026-01-22 08:04:49', '2026-01-22 08:04:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 104, 'cash', 'weekly', '231', '2026-01-29 08:04:49', '2026-01-29 08:04:49', 1, '23:00', '07:00', '03:00', '16:00', '\"[\\\"2026-01-29\\\",\\\"2026-01-30\\\"]\"', NULL, '\"{\\\"2026-01-29\\\":{\\\"start\\\":\\\"23:00\\\",\\\"end\\\":\\\"07:00\\\",\\\"lunch_start\\\":\\\"03:00\\\",\\\"lunch_end\\\":\\\"16:00\\\",\\\"day_type\\\":\\\"work\\\"},\\\"2026-01-30\\\":{\\\"start\\\":\\\"23:00\\\",\\\"end\\\":\\\"07:00\\\",\\\"lunch_start\\\":\\\"03:00\\\",\\\"lunch_end\\\":\\\"16:00\\\",\\\"day_type\\\":\\\"work\\\"}}\"'),
(68, 19, 'cash', 'bi-monthly', NULL, '2026-02-09 06:54:21', '2026-02-09 06:54:21', 3, '07:00', '15:00', NULL, NULL, NULL, NULL, '\"{\\\"2026-01-01\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-02\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-03\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-04\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-05\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-06\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-07\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-08\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-09\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-10\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-11\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-12\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-13\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-14\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-15\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-16\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-17\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-18\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-19\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-20\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-21\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-22\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-23\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-24\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-25\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-26\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-27\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-28\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-29\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-30\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-01-31\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-01\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-02\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-03\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-04\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-05\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-06\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-07\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-08\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-09\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-10\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-11\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-12\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-13\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-14\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-15\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-16\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-17\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-18\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-19\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-20\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-21\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-22\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-23\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-24\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-25\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-26\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-27\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-02-28\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-03-01\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-03-02\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-03-03\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-03-04\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-03-05\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-03-06\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-03-07\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-03-08\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-03-09\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-03-10\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-03-11\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null},\\\"2026-03-12\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null}}\"'),
(69, 56, NULL, 'bi-monthly', NULL, '2026-02-09 06:59:01', '2026-02-09 06:59:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 106, NULL, 'bi-monthly', NULL, '2026-02-09 07:15:04', '2026-02-09 07:15:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 107, NULL, 'bi-monthly', NULL, '2026-02-11 01:26:55', '2026-02-11 01:50:39', 2, '07:00', '15:00', NULL, NULL, NULL, NULL, NULL),
(72, 110, NULL, 'bi-monthly', NULL, '2026-02-11 01:41:56', '2026-02-11 01:41:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 111, 'cash', 'monthly', '12345', '2026-02-11 06:01:08', '2026-02-11 06:02:01', 1, '23:00', '07:00', '03:00', '16:00', '\"\\\"[\\\\\\\"2026-02-11\\\\\\\",\\\\\\\"2026-02-12\\\\\\\",\\\\\\\"2026-02-13\\\\\\\"]\\\"\"', '\"\\\"[\\\\\\\"2026-02-14\\\\\\\"]\\\"\"', '\"\\\"{\\\\\\\"2026-02-11\\\\\\\":{\\\\\\\"start\\\\\\\":\\\\\\\"23:00\\\\\\\",\\\\\\\"end\\\\\\\":\\\\\\\"07:00\\\\\\\",\\\\\\\"lunch_start\\\\\\\":\\\\\\\"03:00\\\\\\\",\\\\\\\"lunch_end\\\\\\\":\\\\\\\"16:00\\\\\\\",\\\\\\\"day_type\\\\\\\":\\\\\\\"work\\\\\\\"},\\\\\\\"2026-02-12\\\\\\\":{\\\\\\\"start\\\\\\\":\\\\\\\"23:00\\\\\\\",\\\\\\\"end\\\\\\\":\\\\\\\"07:00\\\\\\\",\\\\\\\"lunch_start\\\\\\\":\\\\\\\"03:00\\\\\\\",\\\\\\\"lunch_end\\\\\\\":\\\\\\\"16:00\\\\\\\",\\\\\\\"day_type\\\\\\\":\\\\\\\"work\\\\\\\"},\\\\\\\"2026-02-13\\\\\\\":{\\\\\\\"start\\\\\\\":\\\\\\\"23:00\\\\\\\",\\\\\\\"end\\\\\\\":\\\\\\\"07:00\\\\\\\",\\\\\\\"lunch_start\\\\\\\":\\\\\\\"03:00\\\\\\\",\\\\\\\"lunch_end\\\\\\\":\\\\\\\"16:00\\\\\\\",\\\\\\\"day_type\\\\\\\":\\\\\\\"work\\\\\\\"},\\\\\\\"2026-02-14\\\\\\\":{\\\\\\\"start\\\\\\\":\\\\\\\"23:00\\\\\\\",\\\\\\\"end\\\\\\\":\\\\\\\"07:00\\\\\\\",\\\\\\\"lunch_start\\\\\\\":\\\\\\\"03:00\\\\\\\",\\\\\\\"lunch_end\\\\\\\":\\\\\\\"16:00\\\\\\\",\\\\\\\"day_type\\\\\\\":\\\\\\\"rest\\\\\\\"}}\\\"\"'),
(74, 112, 'cash', 'monthly', '00221', '2026-02-11 06:43:32', '2026-02-11 06:43:32', 3, '07:00', '15:00', NULL, NULL, '\"[\\\"2026-02-11\\\",\\\"2026-02-12\\\",\\\"2026-02-13\\\"]\"', '\"[\\\"2026-02-14\\\",\\\"2026-02-15\\\"]\"', '\"{\\\"2026-02-11\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null,\\\"day_type\\\":\\\"work\\\"},\\\"2026-02-12\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null,\\\"day_type\\\":\\\"work\\\"},\\\"2026-02-13\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null,\\\"day_type\\\":\\\"work\\\"},\\\"2026-02-14\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null,\\\"day_type\\\":\\\"rest\\\"},\\\"2026-02-15\\\":{\\\"start\\\":\\\"07:00\\\",\\\"end\\\":\\\"15:00\\\",\\\"lunch_start\\\":null,\\\"lunch_end\\\":null,\\\"day_type\\\":\\\"rest\\\"}}\"');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('95OYhzqtRQz5Fc8kW0qT13vLtK7pFCZoLqts73Ai', 20, '192.168.0.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRktwckRzNURycG01a1U4cWZ3amZsbWI0S2NxdGVVU29UUk5tR2o4QiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTE4OiJodHRwOi8vMTkyLjE2OC4wLjE5ODo4MDAwL3JlcG9ydHMvZ2VuZXJhbC1sZWRnZXIvZmV0Y2g/Y2FzaF9lcXVpdmFsZW50X2lkPTEzJmVuZF9kYXRlPTIwMjYtMDMtMTcmc3RhcnRfZGF0ZT0yMDI2LTAyLTE2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjA7czo5OiJicmFuY2hfaWQiO2k6ODt9', 1773738863),
('WKS9uk9AnE35D4MiEvy7BY6cskSvJZzm9FlGuKHi', 20, '192.168.0.33', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMlVrbmtzREFScXpYSWJ3bWtvSkdvZUhYWW5DUktXVnl3eE1kQnZYdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjY6Imh0dHA6Ly8xOTIuMTY4LjAuMTk4OjgwMDAvcG9zL3Nlc3Npb24vY2hlY2s/dGVybWluYWxfbm89TWFjT1NfTk9FTCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjIwO3M6OToiYnJhbmNoX2lkIjtpOjE7fQ==', 1773738309);

-- --------------------------------------------------------

--
-- Table structure for table `spouse_details`
--

CREATE TABLE `spouse_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spouse_details`
--

INSERT INTO `spouse_details` (`id`, `user_id`, `name`, `date_of_birth`, `age`, `created_at`, `updated_at`) VALUES
(7, 51, 'Liv Tyler', '1980-01-02', 46, '2026-01-09 06:31:33', '2026-01-09 06:31:33'),
(9, 20, NULL, NULL, NULL, '2026-01-16 02:25:44', '2026-01-16 02:25:44'),
(11, 17, NULL, NULL, NULL, '2026-01-22 00:45:32', '2026-01-22 00:45:32'),
(12, 16, NULL, NULL, NULL, '2026-01-22 00:58:27', '2026-01-22 00:58:27'),
(13, 15, NULL, NULL, NULL, '2026-01-22 08:04:49', '2026-01-22 08:04:49'),
(14, 79, NULL, NULL, NULL, '2026-01-22 08:05:07', '2026-01-22 08:05:07'),
(26, 19, NULL, NULL, NULL, '2026-02-09 06:54:21', '2026-02-09 06:54:21'),
(27, 56, NULL, NULL, NULL, '2026-02-09 06:59:01', '2026-02-09 06:59:01'),
(28, 107, NULL, NULL, NULL, '2026-02-11 01:28:41', '2026-02-11 01:28:41'),
(29, 110, NULL, NULL, NULL, '2026-02-11 01:42:11', '2026-02-11 01:42:11'),
(30, 111, NULL, NULL, NULL, '2026-02-11 06:02:01', '2026-02-11 06:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE `stations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `description` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stations`
--

INSERT INTO `stations` (`id`, `name`, `status`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Grill Station', 'active', 'A kitchen station responsible for cooking meats, seafood, and vegetables on the grill to ensure proper doneness, flavor, and presentation.', 20, '2026-02-09 09:07:03', '2026-02-09 09:11:41'),
(2, 'Fry Station', 'active', 'A kitchen station responsible for preparing fried menu items using deep fryers while maintaining food quality, consistency, and safety.', 20, '2026-02-09 09:10:51', '2026-02-09 09:10:51'),
(3, 'Sauté Station', 'active', 'A kitchen station responsible for quickly cooking proteins, vegetables, and sauces in pans over high heat, ensuring proper flavor, texture, and presentation.', 20, '2026-02-09 09:12:43', '2026-02-09 09:12:43'),
(4, 'Garde Manger', 'active', 'A kitchen station responsible for preparing cold dishes, salads, appetizers, and garnishes with a focus on freshness, presentation, and consistency.', 20, '2026-02-09 09:13:27', '2026-02-09 09:13:27'),
(5, 'Prep Station', 'active', 'A kitchen station responsible for preparing ingredients in advance, including washing, chopping, marinating, and portioning, to ensure smooth and efficient kitchen operations.', 20, '2026-02-09 09:14:09', '2026-02-09 09:14:09'),
(6, 'Dishwashing / Stewarding', 'active', 'A station responsible for cleaning and sanitizing all kitchenware, utensils, and equipment, ensuring a safe and efficient kitchen environment.', 20, '2026-02-09 09:14:55', '2026-02-09 09:14:55');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'New Status Column', 'archived', 15, '2025-12-05 07:47:29', '2025-12-05 07:55:42'),
(2, 'Married', 'active', 15, '2025-12-05 08:13:28', '2025-12-11 00:34:24'),
(3, 'Single', 'active', 15, '2025-12-10 01:00:13', '2025-12-11 00:33:49'),
(4, 'Separated', 'active', 20, '2025-12-11 00:34:34', '2025-12-11 00:34:34'),
(5, 'Widow', 'active', 20, '2025-12-11 00:35:23', '2025-12-11 00:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `category_id`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Condiments', 2, 'Condiments', '2025-09-24 18:29:20', '2025-09-24 18:29:20'),
(6, 'Rice', 3, 'Rice', '2025-09-24 22:40:31', '2025-09-24 22:40:31'),
(8, 'Vegetables', 3, NULL, '2025-09-30 00:38:45', '2025-09-30 00:38:45'),
(13, 'Chicken', 3, NULL, '2025-10-09 18:41:48', '2025-10-09 18:41:48'),
(14, 'Beef', 3, NULL, '2025-10-09 18:41:56', '2025-10-09 18:41:56'),
(15, 'Pork', 3, NULL, '2025-10-09 18:45:35', '2025-10-09 18:45:35'),
(16, 'Appetizers', 3, NULL, '2025-10-09 18:48:26', '2025-10-09 18:48:26'),
(17, 'Seafoods', 3, NULL, '2025-10-09 18:52:11', '2025-10-09 18:52:11'),
(18, 'Noodles', 3, NULL, '2025-10-09 18:55:40', '2025-10-09 18:55:40'),
(19, 'Dairy Products', 4, NULL, '2025-10-09 19:11:14', '2025-10-09 19:11:14'),
(21, 'Meat', 2, NULL, '2025-10-13 01:03:41', '2025-10-13 01:03:41'),
(22, 'Soup', 3, NULL, '2025-10-14 21:18:18', '2025-10-14 21:18:18'),
(23, 'Alcoholic', 4, NULL, '2025-10-14 21:24:36', '2025-10-14 21:24:36'),
(24, 'Non Alcoholic', 4, NULL, '2025-10-14 21:25:19', '2025-10-14 21:25:19'),
(29, 'Fresh', 16, NULL, '2026-02-23 05:21:36', '2026-02-23 05:21:36'),
(30, 'Pork', 19, NULL, '2026-02-23 05:23:19', '2026-02-23 05:23:19'),
(31, 'Beef', 19, NULL, '2026-02-23 05:23:32', '2026-02-23 05:23:32'),
(32, 'Chicken', 19, NULL, '2026-02-23 05:23:41', '2026-02-23 05:23:41'),
(36, 'Softdrinks/Juice', 4, NULL, '2026-03-10 03:49:10', '2026-03-10 03:49:10'),
(37, 'Seasoning', 2, NULL, '2026-03-10 03:50:29', '2026-03-10 03:50:29'),
(39, 'Fruits', 2, NULL, '2026-03-10 06:14:05', '2026-03-10 06:14:05'),
(40, 'Combo Meals', 3, NULL, '2026-03-10 08:52:59', '2026-03-10 08:52:59'),
(41, 'Desserts', 3, NULL, '2026-03-10 08:53:18', '2026-03-10 08:53:18'),
(42, 'Dimsum', 3, NULL, '2026-03-10 08:53:31', '2026-03-10 08:53:31'),
(43, 'ALL-TIME FAV', 22, NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32'),
(44, 'APPETIZERS', 22, NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32'),
(45, 'BEEF', 22, NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32'),
(46, 'CHICKEN', 22, NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32'),
(47, 'COMBO MEALS', 22, NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32'),
(48, 'DESSERTS', 22, NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32'),
(49, 'DIMSUM', 22, NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32'),
(50, 'FRUITS', 22, NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32'),
(51, 'MEAL PROMO', 22, NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32'),
(52, 'NOODLES', 22, NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32'),
(53, 'PORK', 22, NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32'),
(54, 'RICE', 22, NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32'),
(55, 'SEAFOOD', 22, NULL, '2026-03-10 08:57:33', '2026-03-10 08:57:33'),
(56, 'SET MEALS', 22, NULL, '2026-03-10 08:57:33', '2026-03-10 08:57:33'),
(57, 'SOUPS', 22, NULL, '2026-03-10 08:57:33', '2026-03-10 08:57:33'),
(58, 'VEGETABLES', 22, NULL, '2026-03-10 08:57:33', '2026-03-10 08:57:33'),
(59, 'KARE RICE', 22, NULL, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(60, 'PANCIT', 22, NULL, '2026-03-12 03:13:23', '2026-03-12 03:13:23'),
(61, 'SAUCE', 22, NULL, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(62, 'SUPER ABOT', 22, NULL, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(63, 'VEG', 22, NULL, '2026-03-12 03:13:24', '2026-03-12 03:13:24'),
(64, 'PLATTER', 22, NULL, '2026-03-12 03:13:24', '2026-03-12 03:13:24');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `landline_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `supplier_since` date DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `supplier_type` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `fullname`, `mobile_no`, `landline_no`, `email`, `supplier_since`, `company`, `tin`, `supplier_type`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Chain Cleaners', 'test111', 'test111', 'test111@gmail.com', '2025-10-23', 'Rokossss', '3332', 'Service Providers', 'Alang-alangssss', 'active', '2025-10-21 18:23:15', '2025-10-23 00:47:57'),
(2, 'Japerson Gasul', '9988223', '8990-2392-302', 'John@enforcer.com', '2025-10-22', 'teleperformance', '2332', 'Equipment Supplier', 'Cebu', 'active', '2025-10-21 19:12:16', '2025-10-23 00:47:21'),
(3, 'new', '323223', '12312', 'enforcer1@gmail.com', '2025-10-22', 'testss', '2321', 'Newsssss', 'Mandaue', 'archived', '2025-10-21 23:29:32', '2025-10-22 00:06:40'),
(4, 'SM Supermarket', '34423', '4534312', 'new@gmail.com', '2025-10-23', 'omni', '343', 'Food and Beverage Supplier', 'lapulapu', 'active', '2025-10-22 00:07:28', '2025-10-23 00:46:18'),
(5, 'Super Metro', '09923', '9823-239-23', 'kyle@omni.com', '2025-10-22', 'nabe', '2332', 'Food and Beverage Supplier', 'Lapu-lapu', 'active', '2025-10-22 00:51:43', '2025-10-23 00:46:42');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `default_currency` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `default_language` varchar(255) NOT NULL,
  `time_zone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `created_by`, `name`, `value`, `type`, `status`, `created_at`, `updated_at`) VALUES
(2, 15, 'Sin Tax', 25.00, 'percentage', 'active', '2025-11-28 01:10:26', '2025-11-28 01:10:26'),
(3, 15, 'Brokerage Tax', 150.00, 'fixed', 'active', '2025-11-28 01:10:47', '2025-11-28 01:10:47');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Kilos', 'active', NULL, '2025-09-28 22:39:00', '2025-09-28 22:39:00'),
(2, 'pc', 'active', NULL, '2025-09-28 22:41:00', '2026-03-10 03:56:26'),
(3, 'Grams', 'active', NULL, '2025-09-28 22:42:17', '2025-09-28 22:42:17'),
(4, 'KG', 'active', NULL, '2025-09-29 02:50:00', '2026-03-10 03:54:13'),
(5, 'Bottle', 'active', NULL, '2025-09-29 01:00:42', '2025-09-29 01:00:42'),
(6, 'meter', 'archived', NULL, '2025-09-30 23:48:30', '2026-02-05 02:26:57'),
(7, 'BIB', 'active', 20, '2026-03-10 03:53:05', '2026-03-10 03:53:05'),
(8, 'Can', 'active', 20, '2026-03-10 03:53:40', '2026-03-10 03:53:40'),
(9, 'Liter', 'active', 20, '2026-03-10 03:54:48', '2026-03-10 03:54:48'),
(10, 'ml', 'active', 20, '2026-03-10 03:55:43', '2026-03-10 03:55:43'),
(11, 'pack', 'active', 20, '2026-03-10 03:56:33', '2026-03-10 03:56:33'),
(12, 'shot', 'active', 20, '2026-03-10 03:57:07', '2026-03-10 03:57:07'),
(13, 'pcs', 'active', NULL, '2026-03-10 08:57:32', '2026-03-10 08:57:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `biometric_number` varchar(255) DEFAULT NULL,
  `id_number` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `sss_number` varchar(255) DEFAULT NULL,
  `phil_health_number` varchar(255) DEFAULT NULL,
  `pag_ibig_number` varchar(255) DEFAULT NULL,
  `blood_type_id` varchar(255) DEFAULT NULL,
  `gender_id` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `civil_status_id` varchar(255) DEFAULT NULL,
  `allow_liquidation` tinyint(1) NOT NULL DEFAULT 0,
  `allow_fund_transfer` tinyint(1) NOT NULL DEFAULT 0,
  `allow_sales_report` tinyint(1) NOT NULL DEFAULT 0,
  `allow_processed_goods_logging` tinyint(1) NOT NULL DEFAULT 0,
  `allow_inventory_request` tinyint(1) NOT NULL DEFAULT 0,
  `allow_prf_access` tinyint(1) NOT NULL DEFAULT 0,
  `allow_timekeeper_access` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `landline_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` enum('active','resigned','terminated') NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `image`, `avatar`, `biometric_number`, `id_number`, `tin`, `sss_number`, `phil_health_number`, `pag_ibig_number`, `blood_type_id`, `gender_id`, `date_of_birth`, `age`, `civil_status_id`, `allow_liquidation`, `allow_fund_transfer`, `allow_sales_report`, `allow_processed_goods_logging`, `allow_inventory_request`, `allow_prf_access`, `allow_timekeeper_access`, `name`, `last_name`, `first_name`, `middle_name`, `email`, `mobile_number`, `landline_number`, `address`, `status`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `branch_id`) VALUES
(15, 'Kyle', '$2y$12$UQt0PY3X5xpIik.NfQHeI.r54Nu9qiXocTUnPA32JPjutVsujuct2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 'Kyle', 'kyle', 'kyle', 'kyle', 'kyle@example.com', '555-1234', NULL, '123 Main St', 'active', NULL, NULL, '2025-10-08 19:44:02', '2026-01-22 08:04:49', 1),
(16, 'Sam', '$2y$12$nna9qiEaqITizWeGLHWV6edjGnqkpiDE93t2UZGhG/xUM5Afz3vUW', NULL, NULL, NULL, NULL, '444', NULL, '44444', '44444', 'AB+', 'Male', '2000-02-02', NULL, 'Married', 0, 0, 0, 0, 0, 0, 0, 'Sam', 'Trinidad', 'Sammy', NULL, 'sam@example.com', '4444444444', NULL, '456 Side St', 'active', NULL, NULL, '2025-10-08 19:44:02', '2026-01-22 00:58:27', 6),
(17, 'Karl', '$2y$12$nB8rU8RACQnxsKiNX0WfZeviUG.QtdVBLo8OCpzijN1r5WsCo5WBC', NULL, NULL, NULL, NULL, '99999', NULL, '9999', '099999', 'A-', 'Male', '2020-02-02', NULL, 'Single', 0, 0, 0, 0, 0, 0, 0, 'Karl', 'Sanico', 'John Carl', 'Test', 'karl@example.com', '666-5678', NULL, '789 Left St', 'active', NULL, NULL, '2025-10-08 19:44:03', '2026-01-22 00:45:32', 8),
(19, 'ed', '$2y$12$xJpAMmU8WoI6e7QRHN2rdu.gX7eBJClYH3rNEbjYnyTGkiyxCqe8u', NULL, NULL, '22222', '22222', '22222', NULL, '2222222222', '22222', 'B+', 'Male', '1980-12-02', NULL, 'Married', 0, 0, 0, 0, 0, 0, 0, 'edsel', 'Cimafranca', 'Edsel', 'X', 'e@gmail.com', '22222222', NULL, '22222', 'active', NULL, NULL, '2025-10-19 23:14:00', '2026-02-09 06:54:21', 7),
(20, 'Noel', '$2y$12$tDXdBJhhN53nIl9Z4kHsxunyyhncZTU1QtNJ5HVHL6VMWHX.QhtvS', 'users/sOqcr7tpRAnlA2VSJqVSQm8GB4ii61PFYsPTA8gb.jpg', NULL, '10005', '10005', '33333', NULL, '33333', '33333', 'A-', 'Male', '2003-03-03', NULL, 'Married', 0, 0, 0, 0, 0, 0, 0, 'NOEL', 'Nacilla', 'Noel', 'F', 'NOELNACILLA@OMNISYSTEMS.TECH', '09778568750', NULL, 'OMNI SYSTEMS SOLUTION, A.C. CORTEZ AVE', 'active', NULL, NULL, '2025-10-21 21:38:40', '2026-02-09 07:02:42', 1),
(51, 'michael', '$2y$12$sriFcoMKjxfzJ2Xkxo/Nk.r.FGaIywe0yVRxt.f0RFo9biU578jUe', 'users/7adoTtmPF7qa7WJsqpPQcfQsp6nAi4wAkaLDwQQI.jpg', NULL, '100007', '100007', '7777777', NULL, '7777777', '77777777', 'A+', 'Male', '1980-01-01', NULL, 'Single', 0, 0, 0, 0, 0, 0, 0, 'Michael Jordan', 'Jordan', 'Michael', 'Bulls', '777@gmail.com', '09777777777', NULL, 'Chicago', 'terminated', NULL, NULL, '2026-01-09 06:31:33', '2026-02-09 07:02:03', 1),
(56, 'Chain', '$2y$12$YU0q.18Pyk18Fp6oB1cBYOZy5dBJlT6dvTmuhVGob/yv0CwAZjjji', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 'Chain', 'Burlat', 'Chain', NULL, 'Chain@gmail.com', NULL, NULL, NULL, 'active', NULL, NULL, '2026-01-13 03:15:49', '2026-02-09 06:59:01', 8),
(79, 'admin', '$2y$12$ax4Mc.3gzvMw.mAnlb8OfuapCiLTE0g.I5g0NbrYYtDKpSqiZ/uSO', NULL, NULL, '5633', '4324', '4343', NULL, '3453', '1232', NULL, NULL, '2026-01-22', NULL, 'Single', 0, 0, 0, 0, 0, 0, 0, 'admin admin', 'admin', 'admin12345', 'admin', 'admin@gmail.com', '53434', NULL, 'CEBU', 'active', NULL, NULL, '2026-01-22 08:01:00', '2026-01-23 01:29:26', 1),
(104, 'rich', '$2y$12$BMgGLdlrC8nIoaBg7QZeLOeEIxjTBR7m0dRI9SZ/Xqw8GmHibIUem', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 'Rich Mel', 'Mel', 'Rich', 'Loi', 'rich@gmail.com', NULL, NULL, NULL, 'terminated', NULL, NULL, '2026-01-29 08:04:49', '2026-02-09 07:02:11', 1),
(106, 'mike', '$2y$12$1aZeUPoI6FVEhuIL..eqOOP5Kj4sAsw6exokj1wbdtApD5jPzAdsy', NULL, NULL, '66666', '66666', '666666', NULL, '66666', '66666', 'B+', 'Male', '2025-01-01', NULL, 'Single', 0, 0, 0, 0, 0, 0, 0, 'Mike Villanueva', 'Villanueva', 'Mike', NULL, 'mv@gmail.com', '66666666', NULL, NULL, 'active', NULL, NULL, '2026-02-09 07:15:04', '2026-02-09 07:15:04', 6),
(107, 'KR', '$2y$12$bV6FouDrSOnbJnpb8fXJnOzRBsVQEDlCwqglgtNDJn0S.ru.SUINW', NULL, NULL, '010001', '010001', '010001', NULL, '11111', '1111', 'B+', 'Female', '2000-05-05', NULL, 'Married', 0, 0, 0, 0, 0, 0, 0, 'Karen Ramos', 'Ramos', 'Karen', NULL, 'KR@gmail.com', '11111111', NULL, NULL, 'active', NULL, NULL, '2026-02-11 01:26:55', '2026-02-11 01:26:55', 1),
(110, 'Okuno', '$2y$12$566PNOLgEauHr4MjbFvc6eTbn9XYiBIyk9rGmz6floaruu6oLC4/e', NULL, NULL, '232', '2213', NULL, NULL, NULL, '1232', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 'Junya Okuno', 'Okuno', 'Junya', 'C', 'Okuno@gmail.com', NULL, NULL, NULL, 'resigned', NULL, NULL, '2026-02-11 01:41:56', '2026-02-11 06:02:30', 1),
(111, 'diane123', '$2y$12$HXjI72G2sQU.Qj1OhDq5QeVN6LGJHMEtzP7m/b/Cg7hJOmQDGH7DK', NULL, NULL, '010003', '90', 'TIN90', NULL, '29848', '8283', 'A+', 'Male', '2000-02-11', NULL, 'Single', 0, 0, 0, 0, 0, 0, 0, 'Diane Concepcion', 'Concepcion', 'Diane', 'A', 'diane@gmail.com', '091519095950', NULL, 'Liloan Cebu', 'active', NULL, NULL, '2026-02-11 06:01:08', '2026-02-11 06:01:08', 1),
(112, 'philip', '$2y$12$XxbWgvGvWnHxJHL7IHXV7ecj7jBrSlIGb6kqjXsJ2OR.XcsHtmNxS', NULL, NULL, '0031', '9002', 'TIN12', NULL, '9882', '823821', 'A+', 'Male', '2001-02-11', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 'Philip Roble', 'Roble', 'Philip', 'A', 'philip@gmail.com', '09882837283', NULL, NULL, 'active', NULL, NULL, '2026-02-11 06:43:31', '2026-02-11 06:43:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_allowances`
--

CREATE TABLE `user_allowances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `allowance_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `monthly_count` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_allowances`
--

INSERT INTO `user_allowances` (`id`, `user_id`, `allowance_id`, `amount`, `monthly_count`, `created_at`, `updated_at`) VALUES
(18, 20, 1, 2000.00, NULL, '2026-01-23 01:59:24', '2026-02-11 01:31:10'),
(24, 104, 1, 100.00, NULL, '2026-01-29 08:04:49', '2026-01-29 08:04:49'),
(25, 104, 2, 200.00, NULL, '2026-01-29 08:04:49', '2026-01-29 08:04:49'),
(30, 19, 1, 1000.00, NULL, '2026-02-09 06:54:21', '2026-02-09 06:54:21'),
(31, 19, 2, 500.00, NULL, '2026-02-09 06:54:21', '2026-02-09 06:54:21'),
(32, 111, 1, 300.00, NULL, '2026-02-11 06:01:08', '2026-02-11 06:02:01'),
(33, 112, 1, 1000.00, NULL, '2026-02-11 06:43:32', '2026-02-11 06:43:32'),
(34, 112, 2, 500.00, NULL, '2026-02-11 06:43:32', '2026-02-11 06:43:32'),
(35, 17, 1, 2000.00, NULL, '2026-02-19 08:30:22', '2026-02-19 08:30:22'),
(36, 17, 2, 500.00, NULL, '2026-02-19 08:30:22', '2026-02-19 08:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `user_leaves`
--

CREATE TABLE `user_leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `leave_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_days` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `earn` int(11) NOT NULL DEFAULT 0,
  `used` int(11) NOT NULL DEFAULT 0,
  `balance` int(11) NOT NULL DEFAULT 0,
  `effective_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_leaves`
--

INSERT INTO `user_leaves` (`id`, `user_id`, `leave_id`, `assigned_days`, `earn`, `used`, `balance`, `effective_date`, `created_at`, `updated_at`) VALUES
(18, 20, 1, 10, 10, 0, 10, NULL, '2026-01-23 01:59:24', '2026-01-23 02:02:35'),
(19, 20, 2, 10, 0, 0, 0, NULL, '2026-01-23 01:59:24', '2026-01-23 02:02:35'),
(20, 20, 3, 1, 0, 0, 0, NULL, '2026-01-23 01:59:24', '2026-01-23 02:02:35'),
(34, 104, 1, 30, 0, 0, 0, NULL, '2026-01-29 08:04:49', '2026-01-29 08:04:49'),
(35, 104, 2, 15, 0, 0, 0, NULL, '2026-01-29 08:04:49', '2026-01-29 08:04:49'),
(43, 19, 1, 5, 0, 0, 5, NULL, '2026-02-09 06:54:21', '2026-02-09 06:54:21'),
(44, 19, 2, 5, 0, 0, 5, NULL, '2026-02-09 06:54:21', '2026-02-09 06:54:21'),
(45, 111, 2, 5, 0, 0, 0, NULL, '2026-02-11 06:01:08', '2026-02-11 06:01:08'),
(46, 112, 1, 0, 0, 0, 0, NULL, '2026-02-11 06:43:32', '2026-02-11 06:43:32'),
(47, 17, 1, 5, 0, 0, 5, NULL, '2026-02-19 08:30:22', '2026-02-19 08:30:22'),
(48, 17, 2, 10, 0, 0, 10, NULL, '2026-02-19 08:30:22', '2026-02-19 08:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `workforce_allowances`
--

CREATE TABLE `workforce_allowances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workforce_allowances`
--

INSERT INTO `workforce_allowances` (`id`, `created_by`, `name`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, 20, 'Gasoline Allowance', NULL, 'active', '2025-12-16 01:11:50', '2025-12-16 01:12:34'),
(2, 20, 'Communication Allowance', NULL, 'active', '2025-12-16 01:12:12', '2025-12-16 01:12:12'),
(3, 20, 'Travel Allowance', NULL, 'active', '2025-12-16 01:12:22', '2025-12-16 01:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `workforce_leaves`
--

CREATE TABLE `workforce_leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `notice_period` int(11) NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workforce_leaves`
--

INSERT INTO `workforce_leaves` (`id`, `created_by`, `name`, `notice_period`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, 20, 'Vacation Leave', 7, NULL, 'active', '2025-12-16 01:07:55', '2025-12-16 01:07:55'),
(2, 20, 'Sick Leave', 0, NULL, 'active', '2025-12-16 01:08:14', '2025-12-16 01:08:14'),
(3, 20, 'Birthday Leave', 7, NULL, 'active', '2025-12-16 01:08:34', '2025-12-16 01:08:34'),
(4, 20, 'Bereavement Leave', 0, NULL, 'active', '2025-12-16 01:08:46', '2025-12-16 01:09:05');

-- --------------------------------------------------------

--
-- Table structure for table `workforce_shifts`
--

CREATE TABLE `workforce_shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `break_start` time DEFAULT NULL,
  `break_end` time DEFAULT NULL,
  `work_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`work_days`)),
  `rest_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rest_days`)),
  `open_time` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`open_time`)),
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workforce_shifts`
--

INSERT INTO `workforce_shifts` (`id`, `name`, `time_start`, `time_end`, `break_start`, `break_end`, `work_days`, `rest_days`, `open_time`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'Graveyard Shift', '23:00:00', '07:00:00', '03:00:00', '16:00:00', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]', '[\"Saturday\",\"Sunday\"]', '[]', 'active', NULL, '2025-12-12 08:13:37', '2025-12-16 01:15:07'),
(2, 'Swing Shift', '15:00:00', '23:00:00', NULL, NULL, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]', '[\"Saturday\",\"Sunday\"]', '[]', 'active', NULL, '2025-12-16 01:16:12', '2025-12-16 01:16:12'),
(3, 'Day Shift', '07:00:00', '15:00:00', NULL, NULL, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]', '[\"Saturday\",\"Sunday\"]', '[]', 'active', NULL, '2025-12-16 01:16:58', '2025-12-16 01:16:58'),
(4, 'Regular Shift', '08:00:00', '17:00:00', NULL, NULL, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]', '[\"Saturday\",\"Sunday\"]', '[]', 'active', NULL, '2025-12-16 01:17:42', '2025-12-16 01:17:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounting_categories`
--
ALTER TABLE `accounting_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accounting_categories_created_by_foreign` (`created_by`);

--
-- Indexes for table `accounting_sub_categories`
--
ALTER TABLE `accounting_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accounting_sub_categories_accounting_category_id_foreign` (`accounting_category_id`),
  ADD KEY `accounting_sub_categories_created_by_foreign` (`created_by`);

--
-- Indexes for table `accounts_receivables`
--
ALTER TABLE `accounts_receivables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_receivables_reference_no_unique` (`reference_no`),
  ADD KEY `accounts_receivables_user_id_foreign` (`user_id`),
  ADD KEY `accounts_receivables_approved_by_foreign` (`approved_by`),
  ADD KEY `accounts_receivables_completed_by_foreign` (`completed_by`),
  ADD KEY `accounts_receivables_disapproved_by_foreign` (`disapproved_by`),
  ADD KEY `accounts_receivables_archived_by_foreign` (`archived_by`),
  ADD KEY `accounts_receivables_branch_id_reference_no_index` (`branch_id`,`reference_no`);

--
-- Indexes for table `accounts_receivables_payments`
--
ALTER TABLE `accounts_receivables_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accounts_receivables_payments_account_receivable_id_foreign` (`account_receivable_id`),
  ADD KEY `accounts_receivables_payments_cash_equivalent_id_foreign` (`cash_equivalent_id`),
  ADD KEY `accounts_receivables_payments_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `accounts_receivable_details`
--
ALTER TABLE `accounts_receivable_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accounts_receivable_details_accounts_receivable_id_foreign` (`accounts_receivable_id`),
  ADD KEY `accounts_receivable_details_type_id_foreign` (`type_id`),
  ADD KEY `accounts_receivable_details_chart_account_id_foreign` (`chart_account_id`);

--
-- Indexes for table `account_payables`
--
ALTER TABLE `account_payables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_payables_reference_number_unique` (`reference_number`);

--
-- Indexes for table `account_payable_details`
--
ALTER TABLE `account_payable_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_payable_details_account_payable_id_foreign` (`account_payable_id`),
  ADD KEY `account_payable_details_accounting_category_id_foreign` (`accounting_category_id`),
  ADD KEY `account_payable_details_payment_id_foreign` (`payment_id`),
  ADD KEY `account_payable_details_cash_equivalent_id_foreign` (`cash_equivalent_id`),
  ADD KEY `account_payable_details_tax_id_foreign` (`tax_id`),
  ADD KEY `account_payable_details_chart_account_id_foreign` (`chart_account_id`);

--
-- Indexes for table `asset_categories`
--
ALTER TABLE `asset_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asset_categories_name_unique` (`name`),
  ADD KEY `asset_categories_created_by_foreign` (`created_by`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_user_id_foreign` (`user_id`);

--
-- Indexes for table `benefits`
--
ALTER TABLE `benefits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `benefits_name_unique` (`name`),
  ADD KEY `benefits_created_by_foreign` (`created_by`);

--
-- Indexes for table `benefit_details`
--
ALTER TABLE `benefit_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `benefit_details_benefit_id_foreign` (`benefit_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_components`
--
ALTER TABLE `branch_components`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branch_components_branch_id_component_id_unique` (`branch_id`,`component_id`),
  ADD KEY `branch_components_component_id_foreign` (`component_id`),
  ADD KEY `branch_components_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `branch_products`
--
ALTER TABLE `branch_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branch_products_branch_id_product_id_unique` (`branch_id`,`product_id`),
  ADD KEY `branch_products_product_id_foreign` (`product_id`),
  ADD KEY `branch_products_supplier_id_foreign` (`supplier_id`),
  ADD KEY `branch_products_station_id_foreign` (`station_id`),
  ADD KEY `branch_products_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `branch_role`
--
ALTER TABLE `branch_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_role_branch_id_foreign` (`branch_id`),
  ADD KEY `branch_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `branch_user`
--
ALTER TABLE `branch_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_user_user_id_foreign` (`user_id`),
  ADD KEY `branch_user_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `bundle_items`
--
ALTER TABLE `bundle_items`
  ADD UNIQUE KEY `bundle_items_bundle_id_product_id_unique` (`bundle_id`,`item_id`),
  ADD KEY `bundle_items_product_id_foreign` (`item_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cash_audits`
--
ALTER TABLE `cash_audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_audit_branch_id_index` (`branch_id`),
  ADD KEY `cash_audit_cashier_id_index` (`cashier_id`),
  ADD KEY `cash_audits_cash_audit_record_id_foreign` (`cash_audit_record_id`);

--
-- Indexes for table `cash_audit_records`
--
ALTER TABLE `cash_audit_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cash_audit_records_reference_no_unique` (`reference_no`),
  ADD KEY `cash_audit_records_submitted_by_foreign` (`submitted_by`),
  ADD KEY `cash_audit_records_transfer_to_foreign` (`transfer_to`);

--
-- Indexes for table `cash_equivalents`
--
ALTER TABLE `cash_equivalents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_equivalents_created_by_foreign` (`created_by`),
  ADD KEY `cash_equivalents_accountable_id_foreign` (`accountable_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_created_by_foreign` (`created_by`);

--
-- Indexes for table `chart_accounts`
--
ALTER TABLE `chart_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chart_accounts_code_unique` (`code`),
  ADD KEY `chart_accounts_accounting_category_id_foreign` (`accounting_category_id`),
  ADD KEY `chart_accounts_accounting_subcategory_id_foreign` (`accounting_subcategory_id`),
  ADD KEY `chart_accounts_created_by_foreign` (`created_by`);

--
-- Indexes for table `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `components_code_unique` (`code`),
  ADD KEY `components_category_id_foreign` (`category_id`),
  ADD KEY `components_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `components_supplier_id_foreign` (`supplier_id`),
  ADD KEY `components_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `contact_persons`
--
ALTER TABLE `contact_persons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_persons_user_id_foreign` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_customer_no_unique` (`customer_no`),
  ADD KEY `customers_discount_id_foreign` (`discount_id`);

--
-- Indexes for table `daily_time_records`
--
ALTER TABLE `daily_time_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_time_records_user_id_foreign` (`user_id`),
  ADD KEY `daily_time_records_salary_method_id_foreign` (`salary_method_id`),
  ADD KEY `daily_time_records_created_by_foreign` (`created_by`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`),
  ADD KEY `departments_created_by_foreign` (`created_by`);

--
-- Indexes for table `dependents`
--
ALTER TABLE `dependents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dependents_user_id_foreign` (`user_id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `designations_name_unique` (`name`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discounts_created_by_foreign` (`created_by`);

--
-- Indexes for table `discount_entries`
--
ALTER TABLE `discount_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discount_entries_order_id_foreign` (`order_id`),
  ADD KEY `discount_entries_discount_id_foreign` (`discount_id`);

--
-- Indexes for table `educational_backgrounds`
--
ALTER TABLE `educational_backgrounds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `educational_backgrounds_user_id_foreign` (`user_id`);

--
-- Indexes for table `employee_work_informations`
--
ALTER TABLE `employee_work_informations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_work_informations_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fund_transfers`
--
ALTER TABLE `fund_transfers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fund_transfers_reference_number_unique` (`reference_number`),
  ADD KEY `fund_transfers_created_by_foreign` (`created_by`),
  ADD KEY `fund_transfers_method_of_transfer_id_foreign` (`method_of_transfer_id`),
  ADD KEY `fund_transfers_from_cash_equivalent_id_foreign` (`from_cash_equivalent_id`),
  ADD KEY `fund_transfers_to_cash_equivalent_id_foreign` (`to_cash_equivalent_id`),
  ADD KEY `fund_transfers_approved_by_foreign` (`approved_by`),
  ADD KEY `fund_transfers_archived_by_foreign` (`archived_by`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `holidays_name_unique` (`name`),
  ADD KEY `holidays_created_by_foreign` (`created_by`);

--
-- Indexes for table `inventory_audits`
--
ALTER TABLE `inventory_audits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_audits_reference_no_unique` (`reference_no`),
  ADD KEY `inventory_audits_audited_by_foreign` (`audited_by`);

--
-- Indexes for table `inventory_audit_items`
--
ALTER TABLE `inventory_audit_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_audit_items_inventory_audit_id_product_id_unique` (`inventory_audit_id`,`product_id`),
  ADD KEY `inventory_audit_items_product_id_foreign` (`product_id`),
  ADD KEY `inventory_audit_items_component_id_foreign` (`component_id`);

--
-- Indexes for table `inventory_deductions`
--
ALTER TABLE `inventory_deductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_deductions_component_id_foreign` (`component_id`),
  ADD KEY `inventory_deductions_order_detail_id_foreign` (`order_detail_id`),
  ADD KEY `inventory_deductions_user_id_foreign` (`user_id`);

--
-- Indexes for table `inventory_purchase_orders`
--
ALTER TABLE `inventory_purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_purchase_orders_po_number_unique` (`po_number`),
  ADD KEY `inventory_purchase_orders_user_id_foreign` (`user_id`),
  ADD KEY `inventory_purchase_orders_supplier_id_foreign` (`supplier_id`),
  ADD KEY `inventory_purchase_orders_approved_by_foreign` (`approved_by`),
  ADD KEY `inventory_purchase_orders_archived_by_foreign` (`archived_by`);

--
-- Indexes for table `inventory_transfers`
--
ALTER TABLE `inventory_transfers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_transfers_reference_no_unique` (`reference_no`),
  ADD KEY `inventory_transfers_source_id_foreign` (`source_id`),
  ADD KEY `inventory_transfers_destination_id_foreign` (`destination_id`),
  ADD KEY `inventory_transfers_requested_by_foreign` (`requested_by`),
  ADD KEY `inventory_transfers_approved_by_foreign` (`approved_by`),
  ADD KEY `inventory_transfers_in_transit_by_foreign` (`in_transit_by`),
  ADD KEY `inventory_transfers_completed_by_foreign` (`completed_by`),
  ADD KEY `inventory_transfers_disapproved_by_foreign` (`disapproved_by`),
  ADD KEY `inventory_transfers_archived_by_foreign` (`archived_by`);

--
-- Indexes for table `inventory_transfer_items`
--
ALTER TABLE `inventory_transfer_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_transfer_items_inventory_transfer_id_foreign` (`inventory_transfer_id`),
  ADD KEY `inventory_transfer_items_product_id_foreign` (`product_id`),
  ADD KEY `inventory_transfer_items_component_id_foreign` (`component_id`);

--
-- Indexes for table `inventory_transfer_send_outs`
--
ALTER TABLE `inventory_transfer_send_outs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_transfer_send_outs_delivery_request_no_unique` (`delivery_request_no`),
  ADD KEY `inventory_transfer_send_outs_inventory_transfer_id_foreign` (`inventory_transfer_id`),
  ADD KEY `inventory_transfer_send_outs_received_by_foreign` (`received_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kitchen_mass_productions`
--
ALTER TABLE `kitchen_mass_productions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kitchen_mass_productions_reference_no_unique` (`reference_no`),
  ADD KEY `kitchen_mass_productions_product_id_foreign` (`product_id`),
  ADD KEY `kitchen_mass_productions_approved_by_foreign` (`approved_by`),
  ADD KEY `kitchen_mass_productions_completed_by_foreign` (`completed_by`),
  ADD KEY `kitchen_mass_productions_disapproved_by_foreign` (`disapproved_by`),
  ADD KEY `kitchen_mass_productions_archived_by_foreign` (`archived_by`),
  ADD KEY `kitchen_mass_productions_branch_id_foreign` (`branch_id`),
  ADD KEY `kitchen_mass_productions_created_by_foreign` (`created_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `mytable`
--
ALTER TABLE `mytable`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `night_differentials`
--
ALTER TABLE `night_differentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_cashier_id_foreign` (`cashier_id`),
  ADD KEY `orders_branch_id_foreign` (`branch_id`),
  ADD KEY `orders_reservation_id_foreign` (`reservation_id`);

--
-- Indexes for table `order_and_reservations`
--
ALTER TABLE `order_and_reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_and_reservations_reference_number_unique` (`reference_number`),
  ADD KEY `order_and_reservations_customer_id_foreign` (`customer_id`),
  ADD KEY `order_and_reservations_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `order_and_reservations_cash_equivalent_id_foreign` (`cash_equivalent_id`),
  ADD KEY `order_and_reservations_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`),
  ADD KEY `order_details_component_id_foreign` (`component_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_cook_id_foreign` (`cook_id`),
  ADD KEY `order_items_order_detail_id_foreign` (`order_detail_id`);

--
-- Indexes for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_payments_order_id_foreign` (`order_id`),
  ADD KEY `order_payments_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `order_payments_cash_equivalent_id_foreign` (`cash_equivalent_id`);

--
-- Indexes for table `order_reservation_details`
--
ALTER TABLE `order_reservation_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_reservation_details_order_and_reservations_id_foreign` (`order_and_reservations_id`),
  ADD KEY `order_reservation_details_product_id_foreign` (`product_id`),
  ADD KEY `order_reservation_details_component_id_foreign` (`component_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_created_by_foreign` (`created_by`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_details_payment_id_foreign` (`payment_id`),
  ADD KEY `payment_details_cash_equivalent_id_foreign` (`cash_equivalent_id`),
  ADD KEY `payment_details_order_id_index` (`order_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `pos_sessions`
--
ALTER TABLE `pos_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pos_sessions_branch_id_foreign` (`branch_id`),
  ADD KEY `pos_sessions_cashier_id_foreign` (`cashier_id`);

--
-- Indexes for table `pos_session_summaries`
--
ALTER TABLE `pos_session_summaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pos_session_summaries_session_id_foreign` (`session_id`);

--
-- Indexes for table `po_delivery`
--
ALTER TABLE `po_delivery`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `po_delivery_delivery_receipt_unique` (`delivery_receipt`),
  ADD KEY `po_delivery_inventory_purchase_order_id_index` (`inventory_purchase_order_id`),
  ADD KEY `po_delivery_user_id_index` (`user_id`);

--
-- Indexes for table `po_delivery_items`
--
ALTER TABLE `po_delivery_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `po_delivery_items_po_delivery_id_index` (`po_delivery_id`),
  ADD KEY `po_delivery_items_po_detail_id_index` (`po_detail_id`),
  ADD KEY `po_delivery_items_component_id_index` (`component_id`);

--
-- Indexes for table `po_details`
--
ALTER TABLE `po_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `po_details_inventory_purchase_order_id_foreign` (`inventory_purchase_order_id`),
  ADD KEY `po_details_component_id_foreign` (`component_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_unique` (`code`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `products_station_id_foreign` (`station_id`),
  ADD KEY `products_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipes_product_id_foreign` (`product_id`),
  ADD KEY `recipes_component_id_foreign` (`component_id`);

--
-- Indexes for table `remarks`
--
ALTER TABLE `remarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `remarks_product_id_foreign` (`product_id`),
  ADD KEY `remarks_component_id_foreign` (`component_id`),
  ADD KEY `remarks_user_id_foreign` (`user_id`);

--
-- Indexes for table `request_leaves`
--
ALTER TABLE `request_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_leaves_workforce_leave_id_foreign` (`workforce_leave_id`),
  ADD KEY `request_leaves_approved_by_foreign` (`approved_by`),
  ADD KEY `request_leaves_disapproved_by_foreign` (`disapproved_by`),
  ADD KEY `request_leaves_employee_status_idx` (`employee_id`,`status`),
  ADD KEY `request_leaves_requested_by_foreign` (`requested_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `salary_methods`
--
ALTER TABLE `salary_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_methods_user_id_foreign` (`user_id`),
  ADD KEY `salary_methods_shift_id_foreign` (`shift_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `spouse_details`
--
ALTER TABLE `spouse_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spouse_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stations_created_by_foreign` (`created_by`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `statuses_name_unique` (`name`),
  ADD KEY `statuses_created_by_foreign` (`created_by`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taxes_created_by_foreign` (`created_by`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_name_unique` (`name`),
  ADD KEY `units_created_by_foreign` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `user_allowances`
--
ALTER TABLE `user_allowances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_allowances_user_id_foreign` (`user_id`),
  ADD KEY `user_allowances_allowance_id_foreign` (`allowance_id`);

--
-- Indexes for table `user_leaves`
--
ALTER TABLE `user_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_leaves_user_id_foreign` (`user_id`),
  ADD KEY `user_leaves_leave_id_foreign` (`leave_id`);

--
-- Indexes for table `workforce_allowances`
--
ALTER TABLE `workforce_allowances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `workforce_allowances_name_unique` (`name`),
  ADD KEY `workforce_allowances_created_by_foreign` (`created_by`);

--
-- Indexes for table `workforce_leaves`
--
ALTER TABLE `workforce_leaves`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `workforce_leaves_name_unique` (`name`),
  ADD KEY `workforce_leaves_created_by_foreign` (`created_by`);

--
-- Indexes for table `workforce_shifts`
--
ALTER TABLE `workforce_shifts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `workforce_shifts_name_unique` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounting_categories`
--
ALTER TABLE `accounting_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `accounting_sub_categories`
--
ALTER TABLE `accounting_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `accounts_receivables`
--
ALTER TABLE `accounts_receivables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `accounts_receivables_payments`
--
ALTER TABLE `accounts_receivables_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `accounts_receivable_details`
--
ALTER TABLE `accounts_receivable_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `account_payables`
--
ALTER TABLE `account_payables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `account_payable_details`
--
ALTER TABLE `account_payable_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `asset_categories`
--
ALTER TABLE `asset_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `benefits`
--
ALTER TABLE `benefits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `benefit_details`
--
ALTER TABLE `benefit_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `branch_components`
--
ALTER TABLE `branch_components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=683;

--
-- AUTO_INCREMENT for table `branch_products`
--
ALTER TABLE `branch_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

--
-- AUTO_INCREMENT for table `branch_role`
--
ALTER TABLE `branch_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `branch_user`
--
ALTER TABLE `branch_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `cash_audits`
--
ALTER TABLE `cash_audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `cash_audit_records`
--
ALTER TABLE `cash_audit_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cash_equivalents`
--
ALTER TABLE `cash_equivalents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `chart_accounts`
--
ALTER TABLE `chart_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `components`
--
ALTER TABLE `components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=698;

--
-- AUTO_INCREMENT for table `contact_persons`
--
ALTER TABLE `contact_persons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `daily_time_records`
--
ALTER TABLE `daily_time_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `dependents`
--
ALTER TABLE `dependents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `discount_entries`
--
ALTER TABLE `discount_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

--
-- AUTO_INCREMENT for table `educational_backgrounds`
--
ALTER TABLE `educational_backgrounds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `employee_work_informations`
--
ALTER TABLE `employee_work_informations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fund_transfers`
--
ALTER TABLE `fund_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inventory_audits`
--
ALTER TABLE `inventory_audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory_audit_items`
--
ALTER TABLE `inventory_audit_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `inventory_deductions`
--
ALTER TABLE `inventory_deductions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `inventory_purchase_orders`
--
ALTER TABLE `inventory_purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `inventory_transfers`
--
ALTER TABLE `inventory_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory_transfer_items`
--
ALTER TABLE `inventory_transfer_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory_transfer_send_outs`
--
ALTER TABLE `inventory_transfer_send_outs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kitchen_mass_productions`
--
ALTER TABLE `kitchen_mass_productions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `night_differentials`
--
ALTER TABLE `night_differentials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;

--
-- AUTO_INCREMENT for table `order_and_reservations`
--
ALTER TABLE `order_and_reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=857;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `order_payments`
--
ALTER TABLE `order_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_reservation_details`
--
ALTER TABLE `order_reservation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=369;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pos_sessions`
--
ALTER TABLE `pos_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pos_session_summaries`
--
ALTER TABLE `pos_session_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `po_delivery`
--
ALTER TABLE `po_delivery`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `po_delivery_items`
--
ALTER TABLE `po_delivery_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `po_details`
--
ALTER TABLE `po_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=903;

--
-- AUTO_INCREMENT for table `remarks`
--
ALTER TABLE `remarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `request_leaves`
--
ALTER TABLE `request_leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `salary_methods`
--
ALTER TABLE `salary_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `spouse_details`
--
ALTER TABLE `spouse_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `user_allowances`
--
ALTER TABLE `user_allowances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user_leaves`
--
ALTER TABLE `user_leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `workforce_allowances`
--
ALTER TABLE `workforce_allowances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `workforce_leaves`
--
ALTER TABLE `workforce_leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `workforce_shifts`
--
ALTER TABLE `workforce_shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounting_categories`
--
ALTER TABLE `accounting_categories`
  ADD CONSTRAINT `accounting_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `accounting_sub_categories`
--
ALTER TABLE `accounting_sub_categories`
  ADD CONSTRAINT `accounting_sub_categories_accounting_category_id_foreign` FOREIGN KEY (`accounting_category_id`) REFERENCES `accounting_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accounting_sub_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `accounts_receivables`
--
ALTER TABLE `accounts_receivables`
  ADD CONSTRAINT `accounts_receivables_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `accounts_receivables_archived_by_foreign` FOREIGN KEY (`archived_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `accounts_receivables_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `accounts_receivables_completed_by_foreign` FOREIGN KEY (`completed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `accounts_receivables_disapproved_by_foreign` FOREIGN KEY (`disapproved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `accounts_receivables_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `accounts_receivables_payments`
--
ALTER TABLE `accounts_receivables_payments`
  ADD CONSTRAINT `accounts_receivables_payments_account_receivable_id_foreign` FOREIGN KEY (`account_receivable_id`) REFERENCES `accounts_receivables` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accounts_receivables_payments_cash_equivalent_id_foreign` FOREIGN KEY (`cash_equivalent_id`) REFERENCES `cash_equivalents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `accounts_receivables_payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `accounts_receivable_details`
--
ALTER TABLE `accounts_receivable_details`
  ADD CONSTRAINT `accounts_receivable_details_accounts_receivable_id_foreign` FOREIGN KEY (`accounts_receivable_id`) REFERENCES `accounts_receivables` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accounts_receivable_details_chart_account_id_foreign` FOREIGN KEY (`chart_account_id`) REFERENCES `chart_accounts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `account_payable_details`
--
ALTER TABLE `account_payable_details`
  ADD CONSTRAINT `account_payable_details_account_payable_id_foreign` FOREIGN KEY (`account_payable_id`) REFERENCES `account_payables` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `account_payable_details_cash_equivalent_id_foreign` FOREIGN KEY (`cash_equivalent_id`) REFERENCES `cash_equivalents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `account_payable_details_chart_account_id_foreign` FOREIGN KEY (`chart_account_id`) REFERENCES `chart_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `account_payable_details_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `account_payable_details_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `asset_categories`
--
ALTER TABLE `asset_categories`
  ADD CONSTRAINT `asset_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `benefits`
--
ALTER TABLE `benefits`
  ADD CONSTRAINT `benefits_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `benefit_details`
--
ALTER TABLE `benefit_details`
  ADD CONSTRAINT `benefit_details_benefit_id_foreign` FOREIGN KEY (`benefit_id`) REFERENCES `benefits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `branch_components`
--
ALTER TABLE `branch_components`
  ADD CONSTRAINT `branch_components_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branch_components_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branch_components_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `branch_products`
--
ALTER TABLE `branch_products`
  ADD CONSTRAINT `branch_products_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branch_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branch_products_station_id_foreign` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`),
  ADD CONSTRAINT `branch_products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `branch_products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `branch_role`
--
ALTER TABLE `branch_role`
  ADD CONSTRAINT `branch_role_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branch_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `branch_user`
--
ALTER TABLE `branch_user`
  ADD CONSTRAINT `branch_user_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branch_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bundle_items`
--
ALTER TABLE `bundle_items`
  ADD CONSTRAINT `bundle_items_bundle_id_foreign` FOREIGN KEY (`bundle_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cash_audits`
--
ALTER TABLE `cash_audits`
  ADD CONSTRAINT `cash_audits_cash_audit_record_id_foreign` FOREIGN KEY (`cash_audit_record_id`) REFERENCES `cash_audit_records` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cash_audit_records`
--
ALTER TABLE `cash_audit_records`
  ADD CONSTRAINT `cash_audit_records_submitted_by_foreign` FOREIGN KEY (`submitted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_audit_records_transfer_to_foreign` FOREIGN KEY (`transfer_to`) REFERENCES `cash_equivalents` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cash_equivalents`
--
ALTER TABLE `cash_equivalents`
  ADD CONSTRAINT `cash_equivalents_accountable_id_foreign` FOREIGN KEY (`accountable_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cash_equivalents_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `chart_accounts`
--
ALTER TABLE `chart_accounts`
  ADD CONSTRAINT `chart_accounts_accounting_category_id_foreign` FOREIGN KEY (`accounting_category_id`) REFERENCES `accounting_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chart_accounts_accounting_subcategory_id_foreign` FOREIGN KEY (`accounting_subcategory_id`) REFERENCES `accounting_sub_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `chart_accounts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `components`
--
ALTER TABLE `components`
  ADD CONSTRAINT `components_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `components_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `components_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `components_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `contact_persons`
--
ALTER TABLE `contact_persons`
  ADD CONSTRAINT `contact_persons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `daily_time_records`
--
ALTER TABLE `daily_time_records`
  ADD CONSTRAINT `daily_time_records_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `daily_time_records_salary_method_id_foreign` FOREIGN KEY (`salary_method_id`) REFERENCES `salary_methods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `daily_time_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `dependents`
--
ALTER TABLE `dependents`
  ADD CONSTRAINT `dependents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discount_entries`
--
ALTER TABLE `discount_entries`
  ADD CONSTRAINT `discount_entries_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discount_entries_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `educational_backgrounds`
--
ALTER TABLE `educational_backgrounds`
  ADD CONSTRAINT `educational_backgrounds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_work_informations`
--
ALTER TABLE `employee_work_informations`
  ADD CONSTRAINT `employee_work_informations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fund_transfers`
--
ALTER TABLE `fund_transfers`
  ADD CONSTRAINT `fund_transfers_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fund_transfers_archived_by_foreign` FOREIGN KEY (`archived_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fund_transfers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fund_transfers_from_cash_equivalent_id_foreign` FOREIGN KEY (`from_cash_equivalent_id`) REFERENCES `cash_equivalents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fund_transfers_method_of_transfer_id_foreign` FOREIGN KEY (`method_of_transfer_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fund_transfers_to_cash_equivalent_id_foreign` FOREIGN KEY (`to_cash_equivalent_id`) REFERENCES `cash_equivalents` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `holidays`
--
ALTER TABLE `holidays`
  ADD CONSTRAINT `holidays_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_audits`
--
ALTER TABLE `inventory_audits`
  ADD CONSTRAINT `inventory_audits_audited_by_foreign` FOREIGN KEY (`audited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_audit_items`
--
ALTER TABLE `inventory_audit_items`
  ADD CONSTRAINT `inventory_audit_items_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_audit_items_inventory_audit_id_foreign` FOREIGN KEY (`inventory_audit_id`) REFERENCES `inventory_audits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_audit_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_deductions`
--
ALTER TABLE `inventory_deductions`
  ADD CONSTRAINT `inventory_deductions_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_deductions_order_detail_id_foreign` FOREIGN KEY (`order_detail_id`) REFERENCES `order_details` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_deductions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_purchase_orders`
--
ALTER TABLE `inventory_purchase_orders`
  ADD CONSTRAINT `inventory_purchase_orders_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_purchase_orders_archived_by_foreign` FOREIGN KEY (`archived_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_purchase_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_transfers`
--
ALTER TABLE `inventory_transfers`
  ADD CONSTRAINT `inventory_transfers_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_transfers_archived_by_foreign` FOREIGN KEY (`archived_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_transfers_completed_by_foreign` FOREIGN KEY (`completed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_transfers_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `inventory_transfers_disapproved_by_foreign` FOREIGN KEY (`disapproved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_transfers_in_transit_by_foreign` FOREIGN KEY (`in_transit_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_transfers_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_transfers_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `branches` (`id`);

--
-- Constraints for table `inventory_transfer_items`
--
ALTER TABLE `inventory_transfer_items`
  ADD CONSTRAINT `inventory_transfer_items_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_transfer_items_inventory_transfer_id_foreign` FOREIGN KEY (`inventory_transfer_id`) REFERENCES `inventory_transfers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_transfer_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_transfer_send_outs`
--
ALTER TABLE `inventory_transfer_send_outs`
  ADD CONSTRAINT `inventory_transfer_send_outs_inventory_transfer_id_foreign` FOREIGN KEY (`inventory_transfer_id`) REFERENCES `inventory_transfers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_transfer_send_outs_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `kitchen_mass_productions`
--
ALTER TABLE `kitchen_mass_productions`
  ADD CONSTRAINT `kitchen_mass_productions_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kitchen_mass_productions_archived_by_foreign` FOREIGN KEY (`archived_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kitchen_mass_productions_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kitchen_mass_productions_completed_by_foreign` FOREIGN KEY (`completed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kitchen_mass_productions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kitchen_mass_productions_disapproved_by_foreign` FOREIGN KEY (`disapproved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kitchen_mass_productions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_cashier_id_foreign` FOREIGN KEY (`cashier_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `order_and_reservations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_and_reservations`
--
ALTER TABLE `order_and_reservations`
  ADD CONSTRAINT `order_and_reservations_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_and_reservations_cash_equivalent_id_foreign` FOREIGN KEY (`cash_equivalent_id`) REFERENCES `cash_equivalents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_and_reservations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_and_reservations_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_cook_id_foreign` FOREIGN KEY (`cook_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_order_detail_id_foreign` FOREIGN KEY (`order_detail_id`) REFERENCES `order_details` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD CONSTRAINT `order_payments_cash_equivalent_id_foreign` FOREIGN KEY (`cash_equivalent_id`) REFERENCES `cash_equivalents` (`id`),
  ADD CONSTRAINT `order_payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payments` (`id`);

--
-- Constraints for table `order_reservation_details`
--
ALTER TABLE `order_reservation_details`
  ADD CONSTRAINT `order_reservation_details_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_reservation_details_order_and_reservations_id_foreign` FOREIGN KEY (`order_and_reservations_id`) REFERENCES `order_and_reservations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_reservation_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD CONSTRAINT `payment_details_cash_equivalent_id_foreign` FOREIGN KEY (`cash_equivalent_id`) REFERENCES `cash_equivalents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payment_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_details_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pos_sessions`
--
ALTER TABLE `pos_sessions`
  ADD CONSTRAINT `pos_sessions_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pos_sessions_cashier_id_foreign` FOREIGN KEY (`cashier_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pos_session_summaries`
--
ALTER TABLE `pos_session_summaries`
  ADD CONSTRAINT `pos_session_summaries_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `pos_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `po_details`
--
ALTER TABLE `po_details`
  ADD CONSTRAINT `po_details_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `po_details_inventory_purchase_order_id_foreign` FOREIGN KEY (`inventory_purchase_order_id`) REFERENCES `inventory_purchase_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_station_id_foreign` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `remarks`
--
ALTER TABLE `remarks`
  ADD CONSTRAINT `remarks_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `remarks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `remarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `request_leaves`
--
ALTER TABLE `request_leaves`
  ADD CONSTRAINT `request_leaves_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `request_leaves_disapproved_by_foreign` FOREIGN KEY (`disapproved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `request_leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_leaves_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `request_leaves_workforce_leave_id_foreign` FOREIGN KEY (`workforce_leave_id`) REFERENCES `workforce_leaves` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salary_methods`
--
ALTER TABLE `salary_methods`
  ADD CONSTRAINT `salary_methods_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `workforce_shifts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `salary_methods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `spouse_details`
--
ALTER TABLE `spouse_details`
  ADD CONSTRAINT `spouse_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stations`
--
ALTER TABLE `stations`
  ADD CONSTRAINT `stations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `statuses`
--
ALTER TABLE `statuses`
  ADD CONSTRAINT `statuses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `taxes`
--
ALTER TABLE `taxes`
  ADD CONSTRAINT `taxes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_allowances`
--
ALTER TABLE `user_allowances`
  ADD CONSTRAINT `user_allowances_allowance_id_foreign` FOREIGN KEY (`allowance_id`) REFERENCES `workforce_allowances` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_allowances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_leaves`
--
ALTER TABLE `user_leaves`
  ADD CONSTRAINT `user_leaves_leave_id_foreign` FOREIGN KEY (`leave_id`) REFERENCES `workforce_leaves` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_leaves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `workforce_allowances`
--
ALTER TABLE `workforce_allowances`
  ADD CONSTRAINT `workforce_allowances_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `workforce_leaves`
--
ALTER TABLE `workforce_leaves`
  ADD CONSTRAINT `workforce_leaves_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
