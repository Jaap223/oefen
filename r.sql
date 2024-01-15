CREATE TABLE users (
u_id int auto_increment,
naam varchar(255),
adres varchar(255),
wachtwoord varchar(255),
tel_nr int(10),
PRIMARY KEY (u_id)
);

CREATE TABLE Updates (
    update_id INT PRIMARY KEY AUTO_INCREMENT,
    u_id INT,
    status VARCHAR(255),
    datum DATE,
    tijd TIME,
    factuur_id INT,
    FOREIGN KEY (u_id) REFERENCES users(u_id)

);

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`car_id`)
);

INSERT INTO `cars` (`car_id`, `brand`, `model`, `price`) VALUES
(1, 'Toyota', 'Camry', 25000.00),
(2, 'Honda', 'Accord', 28000.00);

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`purchase_id`),
  FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`),
  FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`)
);


INSERT INTO `purchases` (`purchase_id`, `u_id`, `car_id`, `purchase_date`, `amount_paid`) VALUES
(1, 1, 1, '2024-01-20', 25000.00),
(2, 1, 2, '2024-01-22', 28000.00);


ALTER TABLE `updates`
  ADD COLUMN `car_id` int(11) DEFAULT NULL,
  ADD CONSTRAINT `updates_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);


UPDATE `updates` SET `car_id` = NULL WHERE `update_id` = 1;

INSERT INTO `updates` (`u_id`, `status`, `datum`, `tijd`, `factuur_id`, `car_id`) VALUES
(1, 'Purchase', '2024-01-22', '14:30:00', 2, 2);

