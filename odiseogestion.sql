-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         PostgreSQL 15.3, compiled by Visual C++ build 1914, 64-bit
-- SO del servidor:              
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES  */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando datos para la tabla public.documentos: 0 rows
/*!40000 ALTER TABLE "documentos" DISABLE KEYS */;
/*!40000 ALTER TABLE "documentos" ENABLE KEYS */;

-- Volcando datos para la tabla public.failed_jobs: 0 rows
/*!40000 ALTER TABLE "failed_jobs" DISABLE KEYS */;
/*!40000 ALTER TABLE "failed_jobs" ENABLE KEYS */;

-- Volcando datos para la tabla public.flujo_documentos: 0 rows
/*!40000 ALTER TABLE "flujo_documentos" DISABLE KEYS */;
/*!40000 ALTER TABLE "flujo_documentos" ENABLE KEYS */;

-- Volcando datos para la tabla public.flujo_tramite: 0 rows
/*!40000 ALTER TABLE "flujo_tramite" DISABLE KEYS */;
/*!40000 ALTER TABLE "flujo_tramite" ENABLE KEYS */;

-- Volcando datos para la tabla public.migrations: 11 rows
/*!40000 ALTER TABLE "migrations" DISABLE KEYS */;
REPLACE INTO "migrations" ("id", "migration", "batch") VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(9, '2014_10_12_200000_add_two_factor_columns_to_users_table', 2),
	(10, '2023_11_27_063213_create_sessions_table', 2),
	(11, '2023_11_27_143204_create_programas_table', 3),
	(12, '2023_11_27_143306_create_documentos_table', 3),
	(13, '2023_11_27_143310_create_tipo_tramite_table', 3),
	(14, '2023_11_27_143315_create_flujo_tramite_table', 3),
	(15, '2023_11_27_143601_create_flujo_documentos_table', 3);
/*!40000 ALTER TABLE "migrations" ENABLE KEYS */;

-- Volcando datos para la tabla public.password_resets: 0 rows
/*!40000 ALTER TABLE "password_resets" DISABLE KEYS */;
/*!40000 ALTER TABLE "password_resets" ENABLE KEYS */;

-- Volcando datos para la tabla public.personal_access_tokens: 0 rows
/*!40000 ALTER TABLE "personal_access_tokens" DISABLE KEYS */;
/*!40000 ALTER TABLE "personal_access_tokens" ENABLE KEYS */;

-- Volcando datos para la tabla public.programas: 0 rows
/*!40000 ALTER TABLE "programas" DISABLE KEYS */;
/*!40000 ALTER TABLE "programas" ENABLE KEYS */;

-- Volcando datos para la tabla public.sessions: 1 rows
/*!40000 ALTER TABLE "sessions" DISABLE KEYS */;
REPLACE INTO "sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES
	('8BvWsGWzgc0wOVxFbaKfV9LwORTcbG5HxdpaMOza', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNnlxaFIzbjk5d0hiakhleEJEQVlSSFJmazhwTlVta3gzSDRJb3dlbiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQvdGlwby10cmFtaXRlcyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkRmtRUld4YW9Ea2h4SHVXd3VIcWJ3dUgyQklwUFBoU0JEdWtzcmloVlk0dldDeXFDdENNd08iO30=', 1701103008);
/*!40000 ALTER TABLE "sessions" ENABLE KEYS */;

-- Volcando datos para la tabla public.tipo_tramite: 0 rows
/*!40000 ALTER TABLE "tipo_tramite" DISABLE KEYS */;
/*!40000 ALTER TABLE "tipo_tramite" ENABLE KEYS */;

-- Volcando datos para la tabla public.users: 1 rows
/*!40000 ALTER TABLE "users" DISABLE KEYS */;
REPLACE INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "two_factor_secret", "two_factor_recovery_codes", "two_factor_confirmed_at") VALUES
	(1, 'Edgar', 'demo@demo.com', NULL, '$2y$10$FkQRWxaoDkhxHuWwuHqbwuH2BIpPPhSBDuksrihVY4vWCyqCtCMwO', NULL, '2023-11-27 06:38:20', '2023-11-27 06:38:20', NULL, NULL, NULL);
/*!40000 ALTER TABLE "users" ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;