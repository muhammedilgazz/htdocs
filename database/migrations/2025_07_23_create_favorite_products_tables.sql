-- Favori Ürün Kategorileri Tablosu
CREATE TABLE `favorite_product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Favori Ürünler Tablosu
CREATE TABLE `favorite_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wishlist_item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(2048) DEFAULT NULL,
  `product_link` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `wishlist_item_id` (`wishlist_item_id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `fk_favorite_products_category` FOREIGN KEY (`category_id`) REFERENCES `favorite_product_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Mevcut favorileri yeni tabloya taşıma
-- Bu sorgu, `wishlist_items` tablosundan favori olanları (wishlist_type = 'favori') `favorite_products` tablosuna aktarır.
-- Kategori ataması başlangıçta NULL olacak, kullanıcılar daha sonra kategorilendirebilir.
INSERT INTO favorite_products (wishlist_item_id, user_id, name, description, image_url, product_link)
SELECT id, user_id, item_name, item_description, image_url, item_link
FROM wishlist_items
WHERE wishlist_type = 'favori';