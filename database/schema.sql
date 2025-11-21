-- Database schema for Potions Game Refactoring
-- Compatible with PHP 7.4 and MySQL 5.7+

-- Table: recipes
-- Stores all potion recipe metadata
CREATE TABLE IF NOT EXISTS `recipes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `potion_key` VARCHAR(50) NOT NULL COMMENT 'Unique identifier like potion1, potion2, kmarst3',
  `potion_number` VARCHAR(20) NOT NULL COMMENT 'Number or string identifier from GET param',
  `name` VARCHAR(255) NOT NULL COMMENT 'Recipe display name',
  `cost` DECIMAL(10, 2) NOT NULL DEFAULT 0.00 COMMENT 'Ingredient cost',
  `image_url` VARCHAR(512) NOT NULL COMMENT 'URL to potion image',
  `usage_keyword` TEXT NULL COMMENT 'Flavor text when using the potion',
  `description` TEXT NULL COMMENT 'Full potion description and effects',
  `redirect_url` VARCHAR(512) NULL COMMENT 'Custom redirect URL after completion (null = default)',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Whether recipe is currently available',
  `requires_tournament` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Whether recipe requires tournament access',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_potion_key` (`potion_key`),
  UNIQUE KEY `idx_potion_number` (`potion_number`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Potion recipes master table';

-- Table: recipe_ingredients
-- Stores the ingredients required for each recipe
CREATE TABLE IF NOT EXISTS `recipe_ingredients` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` INT(11) NOT NULL COMMENT 'Foreign key to recipes table',
  `ingredient_name` VARCHAR(255) NOT NULL COMMENT 'Name of the ingredient',
  `sort_order` INT(11) NOT NULL DEFAULT 0 COMMENT 'Order in which ingredient should be added',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_recipe_id` (`recipe_id`),
  KEY `idx_sort_order` (`recipe_id`, `sort_order`),
  CONSTRAINT `fk_recipe_ingredients_recipe`
    FOREIGN KEY (`recipe_id`)
    REFERENCES `recipes` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Ingredients required for each potion recipe';

-- Create indexes for better performance
CREATE INDEX `idx_ingredient_name` ON `recipe_ingredients` (`ingredient_name`);
