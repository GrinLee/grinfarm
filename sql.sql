-- phpMyAdmin SQL Dump
-- version 4.8.3

-- Host: localhost
-- Generation Time: Jan 17, 2023
-- Server version: 10.1.36-MariaDB
-- PHP Version: _._._

-- Database: `grinfarm`

-- ALTER TABLE `order_items` 
-- ADD `order_status` varchar(100) NULL DEFAULT 'on_hold' AFTER `order_cost`;

-- ALTER TABLE `orders`
-- ALTER `order_status` SET DEFAULT 'on_hold';

-- ALTER TABLE `orders` 
-- ADD `order_myId` varchar(255) NULL DEFAULT 0 AFTER `order_id`;

-- ALTER TABLE `products` DROP `product_thumb_desc`;
-- ALTER TABLE `products` DROP `product_description`;

-- ALTER TABLE `products` ADD  `product_thumb_desc` varchar(655) NOT NULL AFTER `product_name`;
-- ALTER TABLE `products` ADD  `product_description` varchar(6553) NOT NULL AFTER `product_category`;

-- ALTER TABLE `reviews` DROP `review_text`;

-- ALTER TABLE `reviews` ADD  `review_text` varchar(6553) NOT NULL AFTER `star_rate`;

-- DROP TABLE `products`, `admins`, `card`, `orders`, `order_items`, `payments`, `reviews`, `users`;

-- DROP TABLE `products`;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
-- SET time_zone = "+00:00";



CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `product_thumb_desc` varchar(655) NOT NULL,
  `product_category` varchar(100) NOT NULL,
  `product_description` varchar(6553) NOT NULL,
  `product_image1` varchar(255) NOT NULL,
  `product_image2` varchar(255) NOT NULL,
  `product_image3` varchar(255) NOT NULL,
  `product_image4` varchar(255) NOT NULL,
  `ingredient` varchar(255) NOT NULL,
  `product_price` decimal(6,2) NOT NULL, 
  `shipping` integer(2) NOT NULL,
  `product_weight` decimal(6,2) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `star_rate` int(11) NOT NULL,
  `review_text` varchar(6553) NOT NULL,
  `review_date` DATETIME  NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_cost` decimal(6,2) NOT NULL,
  `order_status` varchar(100) NULL DEFAULT 'on_hold',
  `user_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `prov` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal` varchar(255) NOT NULL,
  `saveAddress` int(3) NULL DEFAULT 0,
  `order_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `order_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image1` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `card` (
  `card_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `card_cvv` int(11) NOT NULL,
  `card_expire` int(11) NOT NULL,
  `card_number` int(11) NOT NULL,
  `printname` varchar(255) NOT NULL,
  PRIMARY KEY (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` int(11) NULL,
  `bod` varchar(255) NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `UX_Constraint` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(250) NOT NULL,
  `transaction_date` DATETIME  NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_password` varchar(100) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






INSERT INTO `users`(`firstName`, `lastName`, `username`, `email`, `password`) VALUES
('whil', 'whil', 'whilwhil', 'whil1009@gmail.com', '19dc41fa8c27276f53699ee2cadb5640e03c570e80dc0de95b0629aeb2cfcc78a69952141b69f5baf04da3a4c2ed0a38f6e0ee2d473fa0b24e4f1ed737f25bb4' ),
('shel', 'shel', 'shelshel', 'shel2001@gmail.com', 'ce57d8bc990447c7ec35557040756db2a9ff7cdab53911f3c7995bc6bf3572cda8c94fa53789e523a680de9921c067f6717e79426df467185fc7a6dbec4b2d57' ),
('bobs', 'bobs', 'bobsbobs', 'bobs2003@gmail.com', '19dc41fa8c27276f53699ee2cadb5640e03c570e80dc0de95b0629aeb2cfcc78a69952141b69f5baf04da3a4c2ed0a38f6e0ee2d473fa0b24e4f1ed737f25bb4' );





INSERT INTO `reviews`(`user_id`, `user_name`, `product_id`, `star_rate`, `review_text`, `review_date`) VALUES

( 1, 'whil', 19, 3, 'Excellent quality and great to put in smoothies. Walnuts are in good shape - not crushed, and the flavor is mild. No bitterness at ','2006-02-10 22:07:53'),
( 2, 'shel', 21, 5, 'I use this to make chia pudding - so easy, just mix a couple tablespoons of chia with some almond milk and let sit. You can add cocao power if you want and some maple syrup to sweeten it up or eat it as is. Its good to throw in a shake and you can use it','2002-12-09 22:07:53'),
( 1, 'jack', 31, 4, 'I was eating Walnuts but somehow stopped. Well now I''ll need them again, for my Fudge & other cooking','2014-10-17 22:07:53'),
( 1, 'chuc', 23, 5, 'These chia seeds are delicious! I put 2 tablespoons into my oatmeal and they taste great together. Very filling combination. The packaging is terrible - my first package arrived with a tear in it and the seeds were everywhere. Well.ca customer service was excellent and quickly reshipped a new package placed inside a separate clear bag in case it ripped again. Thanks for the great customer service and the fantastic product. I will definitely ','2014-05-14 22:07:53'),
( 3, 'gnut', 25, 4, 'I buy this all the time on well. serves as a great addition to oatmeal, smoothies, and can be used to make chia seed pudding. Great ','2001-05-11 22:07:53'),
( 4, 'cony', 48, 5, 'Everyone should use this product Chia seed is so good for you. I put it in my soup and I make desert with it. 2 table spoons of Chia seed in 1 cup of almond milk and one package of Stevia. half a teaspoon of cinnamon mix together and Let sit for an hour and eat Delicious low cal ','2002-07-19 22:07:53'),
( 2, 'bobs', 22, 3, 'Excellent product! I will buy these chia seeds again. Love them in my mid-morning smoothies. As others have stated the packaging leaves something to be desired. These little seeds easily leak out of the ','2007-06-03 22:07:53'),
( 1, 'john', 44, 3, 'Delicious and very filling I am enjoying these chia seeds. However, as others have mentioned, the packaging is not the ','2014-03-04 22:07:53'),
( 3, 'jimy', 23, 4, 'Excellent quality and great to put in smoothies. Walnuts are in good shape - not crushed, and the flavor is mild. No bitterness at ','2018-04-08 22:07:53'),
( 1, 'jack', 28, 3, 'I use this to make chia pudding - so easy, just mix a couple tablespoons of chia with some almond milk and let sit. You can add cocao power if you want and some maple syrup to sweeten it up or eat it as is. It''s good to throw in a shake and you can use it','2000-05-29 22:07:53'),
( 1, 'nuke', 29, 3, 'I was eating Walnuts but somehow stopped. Well now I''ll need them again, for my Fudge & other cooking','2014-01-13 22:07:53'),
( 2, 'pete', 12, 3, 'Excellent quality and great to put in smoothies. Walnuts are in good shape - not crushed, and the flavor is mild. No bitter','2018-04-08 22:07:53'),
( 4, 'babe', 21, 5, 'These chia seeds are delicious! I put 2 tablespoons into my oatmeal and they taste great together. Very filling combination. The packaging is terrible - my first package arrived with a tear in it and the seeds were everywhere. I will definitely ','2010-10-28 22:07:53'),
( 1, 'babe', 34, 3, 'I buy this all the time on well. serves as a great addition to oatmeal, smoothies, and can be used to make chia seed pudding. Great ','2014-06-11 22:07:53'),
( 4, 'sato', 12, 4, 'Everyone should use this product Chia seed is so good for you. I put it in my soup and I make desert with it. 2 table spoons of Chia seed in 1 cup of almond milk and one package of Stevia. half a teaspoon of cinnamon mix together','2018-02-26 22:07:53'),
( 2, 'jack', 43, 1, 'Excellent product! I will buy these chia seeds again. Love them in my mid-morning smoothies. As others have stated the packaging leaves something to be desired. These little seeds easily leak out of the ','2007-06-25 22:07:53'),
( 3, 'nell', 21, 3, 'Delicious and very filling I am enjoying these chia seeds. However, as others have mentioned, the packaging is not the ','2010-07-06 22:07:53'),
( 1, 'carl', 37, 3, 'Excellent quality and great to put in smoothies. Walnuts are in good shape - not crushed, and the flavor is mild. No bitterness at', '2007-04-18 22:07:53'),
( 2, 'jack', 34, 2, 'I use this to make chia pudding so easy, just mix a couple tablespoons of chia with some almond milk and let sit. You can add cocao power if you want and some maple syrup to sweeten it up or eat it as is. It''s good to throw in a shake and you can use it', '2008-08-26 22:07:53'),
( 2, 'maxx', 21, 3, 'I was eating Walnuts but somehow stopped. Well now I''ll need them again, for my Fudge & other cookin', '2013-09-11 22:07:53'),
( 2, 'suho', 21, 3, 'These chia seeds are delicious! I put 2 tablespoons into my oatmeal and they taste great together. Very filling combination. The packaging is terrible - my first package arrived with a tear in it and the seeds were everywhere.', '2008-07-24 22:07:53'),
( 1, 'lexi', 34, 4, 'I buy this all the time on well. serves as a great addition to oatmeal, smoothies, and can be used to make chia seed pudding. Great', '2013-04-04 22:07:53'),
( 1, 'lexi', 25, 5, 'Everyone should use this product Chia seed is so good for you. I put it in my soup and I make desert with it. 2 table spoons of Chia seed in 1 cup of almond milk and one package of Stevia. half a teaspoon of cinnamon mix together and Let sit for an hour and eat Delicious low cal', '2003-04-29 22:07:53'),
( 2, 'suzi', 28, 3, 'Excellent product! I will buy these chia seeds again. Love them in my mid-morning smoothies. As others have stated the packaging leaves something to be desired. These little seeds easily leak out of the', '2018-12-13 22:07:53'),
( 1, 'jack', 19, 4, 'Delicious and very filling I am enjoying these chia seeds. However, as others have mentioned, the packaging is not the', '2012-10-19 22:07:53'),
( 4, 'colr', 32, 4, 'Excellent quality and great to put in smoothies. Walnuts are in good shape - not crushed, and the flavor is mild. No bitterness at ', '2004-08-19 22:07:53'),
( 2, 'adey', 29, 3, 'I use this to make chia pudding - so easy, just mix a couple tablespoons of chia with some almond milk and let sit. You can add cocao power if you want and some maple syrup to sweeten it up or eat it as is. It''s good to throw in a shake and you can use it', '2007-09-27 22:07:53'),
( 3, 'john', 40, 3, 'I was eating Walnuts but somehow stopped. Well now I''ll need them again, for my Fudge & other cooking', '2011-03-10 22:07:53'),
( 2, 'colr', 21, 4, 'These chia seeds are delicious! I put 2 tablespoons into my oatmeal and they taste great together. Very filling combination. The packaging is terrible - my first package arrived with a tear in it and the seeds were everywhere.', '2004-01-09 22:07:53'),
( 1, 'colr', 10, 3, 'I buy this all the time on well. serves as a great addition to oatmeal, smoothies, and can be used to make chia seed pudding. Great ', '2007-10-31 22:07:53'),
( 2, 'doll', 15, 3, 'Everyone should use this product Chia seed is so good for you. I put it in my soup and I make desert with it. 2 table spoons of Chia seed in 1 cup of almond milk and one package of Stevia. half a teaspoon of cinnamon mix together', '2010-05-10 22:07:53'),
( 4, 'marx', 18, 3, 'Excellent product! I will buy these chia seeds again. Love them in my mid-morning smoothies. As others have stated the packaging leaves something to be desired. These little seeds easily leak out of the ', '2013-05-03 22:07:53'),
( 2, 'jack', 29, 4, 'Delicious and very filling I am enjoying these chia seeds. However, as others have mentioned, the packaging is not the ', '2009-12-20 22:07:53'),
( 1, 'whil', 13, 3, 'Excellent quality and great to put in smoothies. Walnuts are in good shape - not crushed, and the flavor is mild. No bitterness at ','2006-02-10 22:07:53'),
( 2, 'shel', 27, 5, 'I use this to make chia pudding - so easy, just mix a couple tablespoons of chia with some almond milk and let sit. You can add cocao power if you want and some maple syrup to sweeten it up or eat it as is. It''s good to throw in a shake and you can use it','2002-12-09 22:07:53'),
( 1, 'jack', 35, 4, 'I was eating Walnuts but somehow stopped. Well now I''ll need them again, for my Fudge & other cooking','2014-10-17 22:07:53'),
( 1, 'chuc', 27, 5, 'These chia seeds are delicious! I put 2 tablespoons into my oatmeal and they taste great together. Very filling combination. The packaging is terrible - my first package arrived with a tear in it and the seeds were everywhere. Well.ca customer service was excellent and quickly reshipped a new package placed inside a separate clear bag in case it ripped again. Thanks for the great customer service and the fantastic product. I will definitely ','2014-05-14 22:07:53'),
( 3, 'gnut', 15, 4, 'I buy this all the time on well. serves as a great addition to oatmeal, smoothies, and can be used to make chia seed pudding. Great ','2001-05-11 22:07:53'),
( 4, 'cony', 39, 5, 'Everyone should use this product Chia seed is so good for you. I put it in my soup and I make desert with it. 2 table spoons of Chia seed in 1 cup of almond milk and one package of Stevia. half a teaspoon of cinnamon mix together and Let sit for an hour and eat Delicious low cal ','2002-07-19 22:07:53'),
( 2, 'bobs', 29, 3, 'Excellent product! I will buy these chia seeds again. Love them in my mid-morning smoothies. As others have stated the packaging leaves something to be desired. These little seeds easily leak out of the ','2007-06-03 22:07:53'),
( 1, 'john', 34, 3, 'Delicious and very filling I am enjoying these chia seeds. However, as others have mentioned, the packaging is not the ','2014-03-04 22:07:53'),
( 3, 'jimy', 31, 4, 'Excellent quality and great to put in smoothies. Walnuts are in good shape - not crushed, and the flavor is mild. No bitterness at ','2018-04-08 22:07:53'),
( 1, 'jack', 20, 3, 'I use this to make chia pudding - so easy, just mix a couple tablespoons of chia with some almond milk and let sit. You can add cocao power if you want and some maple syrup to sweeten it up or eat it as is. It''s good to throw in a shake and you can use it','2000-05-29 22:07:53'),
( 1, 'nuke', 21, 3, 'I was eating Walnuts but somehow stopped. Well now I''ll need them again, for my Fudge & other cooking','2014-01-13 22:07:53'),
( 2, 'pete', 37, 3, 'Excellent quality and great to put in smoothies. Walnuts are in good shape - not crushed, and the flavor is mild. No bitter','2018-04-08 22:07:53'),
( 4, 'babe', 15, 5, 'These chia seeds are delicious! I put 2 tablespoons into my oatmeal and they taste great together. Very filling combination. The packaging is terrible - my first package arrived with a tear in it and the seeds were everywhere. I will definitely ','2010-10-28 22:07:53'),
( 1, 'babe', 23, 3, 'I buy this all the time on well. serves as a great addition to oatmeal, smoothies, and can be used to make chia seed pudding. Great ','2014-06-11 22:07:53'),
( 4, 'sato', 37, 4, 'Everyone should use this product Chia seed is so good for you. I put it in my soup and I make desert with it. 2 table spoons of Chia seed in 1 cup of almond milk and one package of Stevia. half a teaspoon of cinnamon mix together','2018-02-26 22:07:53'),
( 2, 'jack', 17, 1, 'Excellent product! I will buy these chia seeds again. Love them in my mid-morning smoothies. As others have stated the packaging leaves something to be desired. These little seeds easily leak out of the ','2007-06-25 22:07:53'),
( 3, 'nell', 19, 3, 'Delicious and very filling I am enjoying these chia seeds. However, as others have mentioned, the packaging is not the ','2010-07-06 22:07:53'),
( 1, 'carl', 30, 3, 'Excellent quality and great to put in smoothies. Walnuts are in good shape - not crushed, and the flavor is mild. No bitterness at', '2007-04-18 22:07:53'),
( 2, 'jack', 38, 2, 'I use this to make chia pudding - so easy, just mix a couple tablespoons of chia with some almond milk and let sit. You can add cocao power if you want and some maple syrup to sweeten it up or eat it as is. It''s good to throw in a shake and you can use it', '2008-08-26 22:07:53'),
( 2, 'maxx', 27, 3, 'I was eating Walnuts but somehow stopped. Well now I''ll need them again, for my Fudge & other cookin', '2013-09-11 22:07:53'),
( 2, 'suho', 18, 3, 'These chia seeds are delicious! I put 2 tablespoons into my oatmeal and they taste great together. Very filling combination. The packaging is terrible - my first package arrived with a tear in it and the seeds were everywhere.', '2008-07-24 22:07:53'),
( 1, 'lexi', 26, 4, 'I buy this all the time on well. serves as a great addition to oatmeal, smoothies, and can be used to make chia seed pudding. Great', '2013-04-04 22:07:53'),
( 1, 'lexi', 25, 5, 'Everyone should use this product Chia seed is so good for you. I put it in my soup and I make desert with it. 2 table spoons of Chia seed in 1 cup of almond milk and one package of Stevia. half a teaspoon of cinnamon mix together and Let sit for an hour and eat Delicious low cal', '2003-04-29 22:07:53'),
( 2, 'suzi', 34, 3, 'Excellent product! I will buy these chia seeds again. Love them in my mid-morning smoothies. As others have stated the packaging leaves something to be desired. These little seeds easily leak out of the', '2018-12-13 22:07:53'),
( 1, 'jack', 17, 4, 'Delicious and very filling I am enjoying these chia seeds. However, as others have mentioned, the packaging is not the', '2012-10-19 22:07:53'),
( 4, 'colr', 11, 4, 'Excellent quality and great to put in smoothies. Walnuts are in good shape - not crushed, and the flavor is mild. No bitterness at ', '2004-08-19 22:07:53'),
( 2, 'adey', 29, 3, 'I use this to make chia pudding - so easy, just mix a couple tablespoons of chia with some almond milk and let sit. You can add cocao power if you want and some maple syrup to sweeten it up or eat it as is. It''s good to throw in a shake and you can use it', '2007-09-27 22:07:53'),
( 3, 'john', 40, 3, 'I was eating Walnuts but somehow stopped. Well now I''ll need them again, for my Fudge & other cooking', '2011-03-10 22:07:53'),
( 2, 'colr', 37, 4, 'These chia seeds are delicious! I put 2 tablespoons into my oatmeal and they taste great together. Very filling combination. The packaging is terrible - my first package arrived with a tear in it and the seeds were everywhere.', '2004-01-09 22:07:53'),
( 1, 'colr', 16, 3, 'I buy this all the time on well. serves as a great addition to oatmeal, smoothies, and can be used to make chia seed pudding. Great ', '2007-10-31 22:07:53'),
( 2, 'doll', 18, 3, 'Everyone should use this product Chia seed is so good for you. I put it in my soup and I make desert with it. 2 table spoons of Chia seed in 1 cup of almond milk and one package of Stevia. half a teaspoon of cinnamon mix together', '2010-05-10 22:07:53'),
( 4, 'marx', 13, 3, 'Excellent product! I will buy these chia seeds again. Love them in my mid-morning smoothies. As others have stated the packaging leaves something to be desired. These little seeds easily leak out of the ', '2013-05-03 22:07:53'),
( 2, 'jack', 37, 4, 'Delicious and very filling I am enjoying these chia seeds. However, as others have mentioned, the packaging is not the ', '2009-12-20 22:07:53');

ALTER TABLE `reviews` DROP `user_name`;





INSERT INTO `products`(`product_name`, `product_thumb_desc`, `product_category`,`product_description`, `product_image1`, `product_image2`, `product_image3`, `product_image4`, `ingredient`, `product_price`, `shipping`, `product_weight`) VALUES

('Veg & Fruit, Small', 'Organic fruit & veggie box for 2-3 people.', 'foodbox', 'The Small Veg & Fruit box contains seven to ten organically grown veggies and fruits, including at least one salad or cooking green. It typically feeds two to three adults per week, depending on appetites and cooking habits. We prioritize local and add imports during the colder months for variety. You can customize this box for free by either creating substitution pairings (e.g. always substitute carrots for radishes) or completely emptying your box and shopping the Market instead.', 'prd_fb_1-1.PNG', 'prd_fb_1-1.PNG', 'prd_fb_1-1.PNG', 'prd_fb_1-1.PNG', 'Produce box contents are updated every Friday afternoon for deliveries on the following Monday to Sunday.', 155, 0, 1220),

('Veg Only, Small', 'The Small Veg Only bpx contains seven to nine organically grown veggies, with at least one cooking green', 'foodbox', 'It typically feeds two to three adults per week, depending on appetites and cooking habits. We prioritize local and add imports during the colder months for variety. You can customize this box for free by either creating substitution pairings (e.g. always substitute carrots for radishes) or completely emptying your box and shopping the Market instead.', 'prd_fb_3-1.PNG', 'prd_fb_3-1.PNG', 'prd_fb_3-1.PNG', 'prd_fb_3-1.PNG', 'Produce box contents are updated every Friday afternoon for deliveries on the following Monday to Sunday.', 35, 0, 2600),

('Fruit Only, Small', 'The Small Fruit Only box contains eight to twelve organically grown fruits.', 'foodbox', 'It typically feeds two to three adults per week, depending on appetites and cooking habits. It contains a balance of more perishable fruit (such as berries) and longer lasting fruit (such as apples). We prioritize local and add imports during the colder months for variety. You can customize this box for free by either creating substitution pairings (e.g. always substitute apples for oranges) or completely emptying your box and shopping the Market instead.', 'prd_fb_3-1.PNG', 'prd_fb_3-1.PNG', 'prd_fb_3-1.PNG', 'prd_fb_3-1.PNG', 'Produce box contents are updated every Friday afternoon for deliveries on the following Monday to Sunday.', 60, 0, 2800),

('Veg & Fruit, Regular', 'The Regular Veg & Fruit box contains nine to twelve organically grown veggies and fruits', 'foodbox', 'It typically feeds three to four adults per week, depending on appetites and cooking habits. We prioritize local and add imports during the colder months for variety. You can customize this box for free by either creating substitution pairings (e.g. always substitute carrots for radishes) or completely emptying your box and shopping the Market instead.', 'prd_fb_4-1.PNG', 'prd_fb_4-1.PNG', 'prd_fb_4-1.PNG', 'prd_fb_4-1.PNG', 'Produce box contents are updated every Friday afternoon for deliveries on the following Monday to Sunday.', 45, 0, 2660),

('Local Only Veg & Fruit', 'The Local Only box contains eight to twelve local, organically grown veggies with some fruits during the Ontario growing season.', 'foodbox', 'It typically feeds two to three adults per week, depending on appetites and cooking habits. In late winter, we may supplement the box with Quebec-grown greenhoues produce to keep the contents interesting and variable. To keep the local spirit of this box, no substitutions are allowed with the Local Only Box.', 'prd_fb_5-1.PNG', 'prd_fb_5-1.PNG', 'prd_fb_5-1.PNG', 'prd_fb_5-1.PNG', 'Produce box contents are updated every Friday afternoon for deliveries on the following Monday to Sunday.', 60, 0, 3100),

('Artisan Smoked Farmstead Gouda Cheese', 'Delicious Artisan Smoked Gouda Cheese by Mountainoak Cheese', 'diary', 'Naturally Applewood smoked at Mountainoak Cheese Farm facility, they take their smooth and creamy Farmstead Mild and give it an enjoyable smoky flavour. It is quickly becoming a crowd favourite. Mountainoak Cheese is founded on love for quality Gouda Cheese. Mountainoak Cheese is a modern, state-of-the-art processing plant that allows the van Bergeijks to continue the tradition of great-tasting, high-quality, Gouda-style cheeses made with high-quality fresh milk from their own dairy cows.', 'prd_dy_6-1.PNG', 'prd_dy_6-1.PNG', 'prd_dy_6-1.PNG', 'prd_dy_6-1.PNG', 'Unpasteurized whole milk, bacterial culture, calcium chloride,rennet,salt.', 25.00, 0, 210),

('Grass Fed Goat Milk 1L ( Gordon''s Goat Farm )', 'Goat Milk by Gorgon''s Dairy Farm, ON', 'diary', 'Pure Natural Goats'' milk is one of the earliest known superfoods, in fact evidence shows humans have been enjoying goats'' milk for millennia. Goat''s milk is slightly lower in lactose than cow''s milk — about 12 percent less per cup — and, in fact, becomes even lower in lactose when cultured into yogurt. People with mild lactose intolerance, therefore, may find goat''s milk dairy somewhat less disruptive to digestion than cow''s milk. Health Benefits of Organic Non-Homogenized Goat Milk : Easier to Digest Fewer Allergens and Less Inflammatory High in Calcium Helps Reduce Cholesterol Levels Promotes Glowing Skin Enhances Nutrient Absorption.', 'prd_dy_4-1.PNG', 'prd_dy_4-1.PNG', 'prd_dy_4-1.PNG', 'prd_dy_4-1.PNG', 'pasteurized goat milk.', 11.95, 0, 990),

('Grass Fed Organic Raw Honey Yogurt (Sugar Free)', 'Certified Organic Raw Honey Yogurt by MC Dairy 1L glass jar 3.8% M.F.', 'diary', 'MC Dairy Yogurt is made by culturing beta carotene rich Jersey cow milk (which gives it a rich golden color). Jersey milk is also 20% higher in calcium and richer in minerals and vitamins. Jersey cows produce A2 protein milk which some find easier to digest. MC Dairy sour cream is made from non-homogenized whole milk. No preservatives or colors are added.', 'prd_dy_3-1.PNG', 'prd_dy_3-2.PNG', 'prd_dy_3-1.PNG', 'prd_dy_3-1.PNG', 'Grass Fed Organic Milk (Pasteurized, Not Homogenized), Raw Organic Honey, Live Bacteria Culture, Microbial Enzyme.', 7.25, 0, 320),

('Fresh Pastured Quail Eggs ( 2 dozen package)', 'Fresh high quality farm quail eggs', 'diary', 'Please note quail eggs are very delicate and have very thin shell. We try our best to deliver it safely to your doorstep. Please handle it with care ! No refunds are made on broken eggs. If you have any issues please contact us within 24 hours after your delivery.', 'prd_dy_1-1.PNG', 'prd_dy_1-1.PNG', 'prd_dy_1-1.PNG', 'prd_dy_1-1.PNG', 'prd_dy_1-1.PNG', 5.99, 0, 260),

('Gourmet Onion & Parsley Mozzarella Cheese', 'Fresh high quality farm quail eggs', 'diary', 'Please note quail eggs are very delicate and have very thin shell. We try our best to deliver it safely to your doorstep. Please handle it with care ! No refunds are made on broken eggs. If you have any issues please contact us within 24 hours after your delivery.', 'prd_dy_2-1.PNG', 'prd_dy_2-1.PNG', 'prd_dy_2-1.PNG', 'prd_dy_2-1.PNG', 'prd__1-4.PNG', 7.95, 0, 200),

('All Natural Feta from Sheldon Creek Dairy Farm', 'Grass Fed High Quality Butter from Thornloe Cheese Farm', 'diary', 'All Natural. Made from grass- fed non-homogenized whole milk. No preservatives are added. No modified milk ingredientients. Has bright fresh taste with a balance of saltiness', 'prd_dy_7-1.PNG', 'prd_dy_7-1.PNG', 'prd_dy_7-1.PNG', 'prd_dy_7-1.PNG', 'cream , salt ( for salted butter only).', 7.95, 0, 250),

('Sheep''s Milk Feta', 'Grass Fed High Quality Butter from Thornloe Cheese Farm', 'diary', 'Delicious Sheep''s Milk Feta by Ovino Family Farm in Acton, ON. 200gr package. ingredientients: pasteurized sheep milk, microbial enzyme, salt, calcium chloride, microbial rennet.', 'prd_dy_8-1.PNG', 'prd_dy_8-1.PNG', 'prd_dy_8-1.PNG', 'prd_dy_8-1.PNG', 'cream , salt ( for salted butter only).', 7.95, 0, 250),

('"Flat on Your Baco" Alpine Style Artisan Cheese', 'Little Bee Farmers Market', 'diary', '180gr piece . Flat on Your Baco is an Alpine style cheese aged in Baco Noir from Ridge Road Winery. Its signature velvety purple rind adds flavourful fruity notes to the tangy cheese.', 'prd_dy_9-1.PNG', 'prd_dy_9-1.PNG', 'prd_dy_9-1.PNG', 'prd_dy_9-1.PNG', 'cream , salt ( for salted butter only).', 12.75, 0, 250),

('Thornloe Grass Fed Butter', 'Grass Fed High Quality Butter from Thornloe Cheese Farm', 'diary', 'Made from 100% grass fed milk. Locally made in small batches. No antibiotics or hormones. Rich Source of Omega 3', 'prd_dy_4-1.PNG', 'prd_dy_4-1.PNG', 'prd_dy_4-1.PNG', 'prd_dy_4-1.PNG', 'cream , salt ( for salted butter only).', 12.75, 0, 120),

('Fresh Whole Pastured Bronze Heritage Turkey', 'Organically raised pastured turkey by Tanjo Family Farm', 'meat', 'Antibiotics free. Hormones free. Non GMO. Orlopp Bronze Heritage Turkey. Pastured organically raised. Will be delivered fresh! Never frozen. Unique flavor turkey', 'prd_mt_1-1.PNG', 'prd_mt_1-1.PNG', 'prd_mt_1-1.PNG', 'prd_mt_1-1.PNG', 'cream , salt ( for salted butter only).', 96.65, 0, 2000),

('Gluten Free Hot Dogs with Cheese', 'Price per package of 5 hot large dogs', 'meat', '', 'prd_mt_2-1.PNG', 'prd_mt_2-1.PNG', 'prd_mt_2-1.PNG', 'prd_mt_2-1.PNG', 'Salt, Sugar , Wild Boar ,  Sodium Nitrate.', 7.95, 0, 1500),

('Fresh Whole Pastured Bronze Heritage Turkey', 'Organically raised pastured turkey by Tanjo Family Farm', 'meat', 'Made with local pork and beef. Gluten Free.', 'prd_mt_3-1.PNG', 'prd_mt_3-1.PNG', 'prd_mt_3-1.PNG', 'prd_mt_3-1.PNG', 'cream , salt ( for salted butter only).', 7.95, 0, 990),

('Chicken Sausages with Spinach and Feta (Gluten Free)', 'Package of 5 large sausages', 'meat', 'Package of 5 large sausages ( around 600gr per package). No nitrates are added. Gluten Free. Will be delivered frozen ( not cooked).', 'prd_mt_4-1.PNG', 'prd_mt_4-1.PNG', 'prd_mt_4-1.PNG', 'prd_mt_4-1.PNG', 'cream , salt ( for salted butter only).', 12.95, 0, 450),

('Summer Sausage Pork&Beef Tanjo Family Farm', 'Pure natural beef and pork summer sausage ( salami )', 'meat', 'Freshly made on the farm in small batches. Amazing quality delicious salami ( summer sausage) ! Directly from Tanjo Family Farm in Millbank , ON. Pastured organically raised. Will be delivered fresh! Never frozen. Unique flavor turkey', 'prd_mt_5-1.PNG', 'prd_mt_5-1.PNG', 'prd_mt_5-1.PNG', 'prd_mt_5-1.PNG', 'Tanjo Family Farm is small family operated with government inspected processing facilities.', 23.50, 0, 650),

('Nitrate Free Bacon', 'Pure natural beef and pork summer sausage ( salami )', 'meat', 'Pure natural delicious bacon', 'prd_mt_6-1.PNG', 'prd_mt_6-1.PNG', 'prd_mt_6-1.PNG', 'prd_mt_6-1.PNG', 'Each package is slightly over 1lb ( 1.2 to 1.4lb) Amazing quality delicious bacon !', 14.50, 0, 700),

('Pure natural beef summer sausage ( dry naturally cured salami )', 'Naturally smoked', 'meat', 'Freshly made on the farm in small batches. Amazing quality delicious salami ( summer sausage) ! Gluten- Free. No fillers. No MSG. Hormone free. Antibiotics free', 'prd_mt_7-1.PNG', 'prd_mt_7-1.PNG', 'prd_mt_7-1.PNG', 'prd_mt_7-1.PNG', 'Tanjo Family Farm is small family operated with government inspected processing facilities.', 25.50, 0, 1100),

('Beef Stew', 'Made from naturally raised free range meat ', 'meat', 'Freshly made on the farm in small batches. Amazing quality delicious salami ( summer sausage) ! Gluten- Free. No fillers. No MSG. Hormone free. Antibiotics free', 'prd_mt_8-1.PNG', 'prd_mt_8-1.PNG', 'prd_mt_8-1.PNG', 'prd_mt_8-1.PNG', 'Tanjo Family Farm is small family operated with government inspected processing facilities.', 25.50, 0, 1100),

('Mild Pepperettes Earlidale', 'Delicious high quality Mild Pepperettes', 'meat', 'Directly from Earlidale Butcher in Elmira ON ( mennonite family farm ).', 'prd_mt_9-1.PNG', 'prd_mt_9-1.PNG', 'prd_mt_9-1.PNG', 'prd_mt_9-1.PNG', 'Tanjo Family Farm is small family operated with government inspected processing facilities.', 6.50, 0, 230),

('Ground Beef', 'Pure natural ground beef', 'meat', 'Each package is around 1lb to 1.1lb. Organically grown! No hormones, no antibiotics, non GMO ! Grass Fed Only ! Will be delivered frozen. Tanjo Family Farm is small family operated with government inspected processing facilities.', 'prd_mt_10-1.PNG', 'prd_mt_10-1.PNG', 'prd_mt_10-1.PNG', 'prd_mt_10-1.PNG', 'Tanjo Family Farm is small family operated with government inspected processing facilities.', 9.00, 0, 450),

('Home-Made Style Canned Ontario''s Peaches', 'Delicious Home-Made Style Canned Ontario''s Peaches', 'breadSweet', 'Made with Ontario''s farm grown peaches. Directly from Auntie''s Groove Preserves in Montrose ON. Perfect for a snack or dessert! ingredientients: peaches, water, sugar.', 'prd_sw_1-1.PNG', 'prd_sw_1-1.PNG', 'prd_sw_1-1.PNG', 'prd_sw_1-1.PNG', 'cream , salt ( for salted butter only).', 9.95, 0, 220),

('Strawberry Rhubarb Pie', 'Delicious All Natural Home-Style Strawberry', 'breadSweet', 'Rhubarb Pie from Mennonite''s Family Bakery in Elmira, ON. No artificial flavors or colors. No preservatives. Baked fresh in small batches', 'prd_sw_2-1.PNG', 'prd_sw_2-1.PNG', 'prd_sw_2-1.PNG', 'prd_sw_2-1.PNG', 'local fresh organic rhubarb, local frozen strawberries , flour, sugar , corn starch and butter .', 11.95, 0, 350),

('Delicious Chocolate Marble Cookies', 'Delicious pure natural home-made style Chocolate Marble Cookies', 'breadSweet', 'Perfect for a snack, school lunch or tea party. Made with all natural and organic ingredientients from local farms. No artificial colors or flavors are added. No preservatives.', 'prd_sw_3-1.PNG', 'prd_sw_3-1.PNG', 'prd_sw_3-1.PNG', 'prd_sw_3-1.PNG', 'Grass Fed natural butter, free range farm eggs, organic sugar, organic wheat flour, organic cocoa powder, pure natural vanilla extract, salt, baking powder, icing sugar.', 6.95, 0, 350),

('Omega 3 Power Seed Gluten Free Vegan Loaf', 'Omega 3 Power Seed Bread', 'breadSweet', 'Best Alternative to traditional "Whole Grain Bread" from Gemaro Bakery Toronto, ON.  700g each. Will be delivered frozen !', 'prd_sw_4-1.PNG', 'prd_sw_4-1.PNG', 'prd_sw_4-1.PNG', 'prd_sw_4-1.PNG', 'Filtered Water, Brown Rice Flour, Tapioca Flour, Sunflower Seed Oil, Chickpea Flour, Organic Flax, Organic Golden Flax', 7.99, 0, 120),

('Organic Chia Lemon Poppy Gluten Free Vegan Biscotti', 'Artisian Hand-Grafted Biscotti with unique flavor.', 'breadSweet', 'Perfect for your snack or tea time with your loved ones. Once you try it be prepared to crave for more ! It''s so good !!!.', 'prd_sw_5-1.PNG', 'prd_sw_5-1.PNG', 'prd_sw_5-1.PNG', 'prd_sw_5-1.PNG', 'Organic Black Chia Seeds, Poppy Seeds, Coconut Milk, Vanilla, Lemon Juice, Non GMO Palm Shortening,', 6.50, 0, 330),

('All Natural Freshly Baked Bagels ( Package of 3 )', 'All Natural Freshly Baked Bagel of your choice', 'breadSweet', 'Baked by Future Bakery, Toronto ON. No preservatives. No colors or flavors are added. Made with high quality ingredientients', 'prd_sw_6-1.PNG', 'prd_sw_6-1.PNG', 'prd_sw_6-1.PNG', 'prd_sw_6-1.PNG', 'cream , salt ( for salted butter only).', 2.50, 0, 250),

('Delicious All Natural Oatmeal Cookies', 'Delicious Oatmeal Cookies " Goldies" from New Moon Kitchen', 'breadSweet', 'The perfect wholesome cookie : toasty oats with warm vanilla and unforgettable homemade taste. Made with organic spelt flour. Vegan. Dairy and Egg Free. Peanut Free. Cholesterol free', 'prd_sw_7-1.PNG', 'prd_sw_7-1.PNG', 'prd_sw_7-1.PNG', 'prd_sw_7-1.PNG', 'Oats, Organic Spelt Flour, Unrefined Cane Sugar, Organic Evaporated Cane Juice, Pure Sunflower', 6.99, 0, 450),

('Freshly Milled Organic Raven Rye Flour', 'High Quality Organic Dark Rye Flour', 'breadSweet', 'Organic Rye Flour contains less gluten than flour obtained from other cereals. It''s an excellent source of manganese, selenium, phosphorus, magnesium. It contains vitamins E and B and contains a significant percentage of proteins.', 'prd_sw_8-1.PNG', 'prd_sw_8-1.PNG', 'prd_sw_8-1.PNG', 'prd_sw_8-1.PNG', 'Oats, Organic Spelt Flour, Unrefined Cane Sugar, Organic Evaporated Cane Juice, Pure Sunflower', 8.99, 0, 125),

('Freshly Milled Organic Blackbird Buckwheat Flour', 'High Quality Organic Artisan Buckwheat Flour', 'breadSweet', 'Organic buckwheat flour is milled from hulled buckwheat groats creating flour that is light in color, finely textured, with a clean, nutty flavor. Suitable for wheat-free baking, buckwheat flour works well in cookie, pancake, quick bread and biscuit recipes.', 'prd_sw_9-1.PNG', 'prd_sw_9-1.PNG', 'prd_sw_9-1.PNG', 'prd_sw_9-1.PNG', 'Oats, Organic Spelt Flour, Unrefined Cane Sugar, Organic Evaporated Cane Juice, Pure Sunflower', 8.95, 0, 450),

('Broccoli Microgreens 50gr', 'Freshly Cut Broccoli Microgreens', 'vegetables', 'Organically grown by Wild Acres Farm, Milton ON. Studies have shown that broccoli microgreens can have up to 40 times the amount of vitamins and minerals than mature broccoli. Broccoli microgreens have larger quantities of magnesium, manganese, copper, and zinc. These are very essential minerals that most people are deficient in. ', 'prd_vg_1-1.PNG', 'prd_vg_1-1.PNG', 'prd_vg_1-1.PNG', 'prd_vg_1-1.PNG', 'Broccoli microgreens contain the highest amount of sulforaphane available compared to almost any other food available. ', 3.95, 0, 90),

('High Quality Large Avocado ( Package of 3)', 'High quality large size avocado. Price per 3 avocados',  'vegetables', 'High quality large size avocado. Price per 3 avocados. Grown in Mexico.', 'prd_vg_2-1.PNG', 'prd_vg_2-1.PNG', 'prd_vg_2-1.PNG', 'prd_vg_2-1.PNG', 'Broccoli microgreens contain the highest amount of sulforaphane available compared to almost any other food available. ', 7.95, 0, 440),

('Organic Dried Herb Blends', 'ingredientients: thyme, summer savory, oregano, marjoram, rosemary, fennel seed, lavender flowers, tarragon.', 'vegetables', 'Herbes de Provence (sometimes called Provençal herbs) is used to flavour grilled foods such as chicken & fish. Potatoes are especially good with Herbes de Provence. This blend can be added to any other meat as well as a huge variety of soups and sauces. It is excellent on game meats like elk and venison and is delicious in recipes with red wine sauces. ', 'prd_vg_3-1.PNG', 'prd_vg_3-1.PNG', 'prd_vg_3-1.PNG', 'prd_vg_3-1.PNG', 'Broccoli microgreens contain the highest amount of sulforaphane available compared to almost any other food available. ', 6.95, 0, 1120),

('Freshly Harvested Brussel Sprouts', 'Price per lb. Naturally grown by small Mennonite''s Family Farm in Elmira ON.', 'vegetables', 'Organically grown by Wild Acres Farm, Milton ON. Studies have shown that broccoli microgreens can have up to 40 times the amount of vitamins and minerals than mature broccoli. Broccoli microgreens have larger quantities of magnesium, manganese, copper, and zinc. These are very essential minerals that most people are deficient in. ', 'prd_vg_4-1.PNG', 'prd_vg_4-1.PNG', 'prd_vg_4-1.PNG', 'prd_vg_4-1.PNG', 'Broccoli microgreens contain the highest amount of sulforaphane available compared to almost any other food available. ', 4.95, 0, 400),

('Large Garlic ( 3 garlics bag )', 'Price per 3 large garlics. Organically grown by small Family Farm in Elmira ON .', 'vegetables', 'Organically grown by Wild Acres Farm, Milton ON. Studies have shown that broccoli microgreens can have up to 40 times the amount of vitamins and minerals than mature broccoli. Broccoli microgreens have larger quantities of magnesium, manganese, copper, and zinc. These are very essential minerals that most people are deficient in. ', 'prd_vg_5-1.PNG', 'prd_vg_5-1.PNG', 'prd_vg_5-1.PNG', 'prd_vg_5-1.PNG', 'Broccoli microgreens contain the highest amount of sulforaphane available compared to almost any other food available. ', 5.95, 0, 300),

('Green Cabbage', 'Price per each medium head of young cabbage.', 'vegetables', 'Price per each medium head of young cabbage. Naturally grown by small Mennonite''s Family Farm in Elmira ON.', 'prd_vg_6-1.PNG', 'prd_vg_6-1.PNG', 'prd_vg_6-1.PNG', 'prd_vg_6-1.PNG', 'Broccoli microgreens contain the highest amount of sulforaphane available compared to almost any other food available. ', 4.45, 0, 230),

('First Ontario''s Heirloom Carrots', 'Price per lb. Naturally grown by small', 'vegetables', 'Price per lb. Naturally grown by small Mennonite''s Family Farm in Elmira ON.', 'prd_vg_7-1.PNG', 'prd_vg_7-1.PNG', 'prd_vg_7-1.PNG', 'prd_vg_7-1.PNG', 'Broccoli microgreens contain the highest amount of sulforaphane available compared to almost any other food available. ', 2.99, 0, 230),

('Fresh spinach', 'Fresh spinach  8oz bag Naturally grown by small', 'vegetables', 'Fresh spinach  8oz bag Naturally grown by small Mennonite''s family farm in Elmira ON.', 'prd_vg_8-1.PNG', 'prd_vg_8-1.PNG', 'prd_vg_8-1.PNG', 'prd_vg_8-1.PNG', 'Broccoli microgreens contain the highest amount of sulforaphane available compared to almost any other food available. ', 5.50, 0, 220),

('Ontario''s Greenhouse Strawberries', 'Ontario''s Greenhouse Strawberries from DelFresco Pure Greenhouse ', 'fruits', 'Greenhouse Strawberries from DelFresco Pure Greenhouse , Kingsville ON. price per 12 oz (340gr) container. Sweet, juicy and crunchy strawberries.', 'prd_fr_1-1.PNG', 'prd_fr_1-1.PNG', 'prd_fr_1-1.PNG', 'prd_fr_1-1.PNG', 'The sweet flavour and delicate texture of the Gala apple shines when prepared fresh. They are perfect for fruit or green salads, diced in fruit salsas and chutneys, or sliced and added to burgers, paninis, and crostini.', 6.95, 0, 90),

('Cortland Apples', 'Price per lb. Naturally grown by Drummond Farm, ON', 'fruits', 'Greenhouse Strawberries from DelFresco Pure Greenhouse , Kingsville ON. price per 12 oz (340gr) container. Sweet, juicy and crunchy strawberries.', 'prd_fr_2-1.PNG', 'prd_fr_2-1.PNG', 'prd_fr_2-1.PNG', 'prd_fr_2-1.PNG', 'no chemicals, no GMOs, just organically grown Papaya.', 2.50, 0, 90),

('Freshly Picked First Ontario''s Bocs Pears', 'Price per lb. Naturally grown by small Mennonite''s Family Farm in Elmira ON', 'fruits', 'Greenhouse Strawberries from DelFresco Pure Greenhouse , Kingsville ON. price per 12 oz (340gr) container. Sweet, juicy and crunchy strawberries.', 'prd_fr_3-1.PNG', 'prd_fr_3-1.PNG', 'prd_fr_3-1.PNG', 'prd_fr_3-1.PNG', 'The sweet flavour and delicate texture of the Gala apple shines when prepared fresh. They are perfect for fruit or green salads, diced in fruit salsas and chutneys, or sliced and added to burgers, paninis, and crostini.', 6.95, 0, 90),

('Certified Organic Sweet Oranges', 'Certified Organic Navel Oranges', 'fruits', 'Navel oranges are bright orange, easy to peel, and have a sweet and seedless pulp. Product of California, USA.', 'prd_fr_4-1.PNG', 'prd_fr_4-1.PNG', 'prd_fr_4-1.PNG', 'prd_fr_4-1.PNG', 'no chemicals, no GMOs, just organically grown Papaya.', 7.95, 0, 300),

('Certified Organic Fresh Lemons', 'Certified Organic Top Quality Lemons. Product of California.', 'fruits', 'Certified Organic Top Quality Lemons. Product of California.Certified Organic Top Quality Lemons. Product of California.', 'prd_fr_5-1.PNG', 'prd_fr_5-1.PNG', 'prd_fr_5-1.PNG', 'prd_fr_5-1.PNG', 'The sweet flavour and delicate texture of the Gala apple shines when prepared fresh. They are perfect for fruit or green salads, diced in fruit salsas and chutneys, or sliced and added to burgers, paninis, and crostini.', 3.95, 0, 120),

('Organic Mango', 'Price per each mango. Grown in Mexico.', 'fruits', 'Price per each mango. Grown in Mexico. Price per each mango. Grown in Mexico.', 'prd_fr_6-1.PNG', 'prd_fr_6-1.PNG', 'prd_fr_6-1.PNG', 'prd_fr_6-1.PNG', 'no chemicals, no GMOs, just organically grown Papaya.', 6.95, 0, 240),

('Fresh Kiwi', 'Fresh kiwi. Grown in Italy. Price per lb.', 'fruits', 'Fresh kiwi. Grown in Italy. Price per lb. Fresh kiwi. Grown in Italy. Price per lb.', 'prd_fr_7-1.PNG', 'prd_fr_7-1.PNG', 'prd_fr_7-1.PNG', 'prd_fr_7-1.PNG', 'The sweet flavour and delicate texture of the Gala apple shines when prepared fresh. They are perfect for fruit or green salads, diced in fruit salsas and chutneys, or sliced and added to burgers, paninis, and crostini.', 6.95, 0, 90),

('Fresh Spanish Clementines with Leafs', 'Price per lb. Grown in Spain.', 'fruits', 'Greenhouse Strawberries from DelFresco Pure Greenhouse , Kingsville ON. price per 12 oz (340gr) container. Sweet, juicy and crunchy strawberries.', 'prd_fr_8-1.PNG', 'prd_fr_8-1.PNG', 'prd_fr_8-1.PNG', 'prd_fr_8-1.PNG', 'no chemicals, no GMOs, just organically grown Papaya.', 2.99, 0, 220);

