-- Create additional databases if needed
CREATE DATABASE IF NOT EXISTS `test_db`;

-- Create a sample table for testing
USE `wordpress`;

CREATE TABLE IF NOT EXISTS `sample_table` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
INSERT INTO `sample_table` (`name`, `email`) VALUES
('Test User', 'test@example.com'),
('Demo User', 'demo@example.com');

-- Grant additional permissions
GRANT ALL PRIVILEGES ON `test_db`.* TO 'wp_user'@'%';
FLUSH PRIVILEGES;