CREATE TABLE IF NOT EXISTS tariff_type (
    id TINYINT(3) NOT NULL AUTO_INCREMENT,
    code VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tariff_type (code) VALUES ('free'), ('pro'), ('business');

CREATE TABLE IF NOT EXISTS tariff (
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    type_id TINYINT(3) NOT NULL,
    name VARCHAR(255) DEFAULT NULL,
    price DECIMAL(10,2) DEFAULT 0,
    description TEXT DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 0,
    PRIMARY KEY (id),
    KEY tariff_type_id_IDX (type_id),
    CONSTRAINT fk_tariff_type_id FOREIGN KEY (type_id) REFERENCES tariff_type(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `log` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `data` JSON DEFAULT NULL,
    `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `obscene_word` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO obscene_word (name) VALUES ('bad_word1'), ('bad_word2'), ('bad_word3'), ('плохое слово1'), ('плохое слово2');