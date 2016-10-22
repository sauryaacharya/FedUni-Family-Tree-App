
CREATE TABLE `parent` (
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `parent` (`parent_id`, `child_id`) VALUES
(1, 2),
(2, 3),
(4, 2),
(6, 7);

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `person` (`id`, `name`, `date_of_birth`) VALUES
(1, 'Rujal Shakya', '1965-04-14'),
(2, 'Govinda Thapa', '1985-10-15'),
(3, 'Srijana Gurung', '2005-07-03'),
(4, 'Ayushma Koirala', '1968-08-22'),
(6, 'Dipesh Chaudhary', '1970-12-22'),
(7, 'Barsha Subedi', '1995-12-23');

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`user_id`, `username`, `password`, `is_admin`) VALUES
(1, 'admin', '$2y$12$AZrfhguwbc/xSxqGnw5YQOviOkvLt5wAZ2V5vgMRFZYv5Eu5c35kC', 1),
(2, 'phill', '$2y$12$KLUVPAcynyfPVKLcl8mLIO4QllsvMT2LfWS4yNoZvYR0Qq5/WW7Ii', 0);


ALTER TABLE `parent`
  ADD KEY `parent_id` (`parent_id`,`child_id`),
  ADD KEY `child_id` (`child_id`);

ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);


ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `parent`
  ADD CONSTRAINT `parent_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `parent_ibfk_2` FOREIGN KEY (`child_id`) REFERENCES `person` (`id`);

