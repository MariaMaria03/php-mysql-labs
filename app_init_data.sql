USE `sts402-9143`;
DROP TABLE members IF EXISTS
DROP TABLE tournaments IF EXISTS
DROP TABLE users IF EXISTS

CREATE TABLE `users` (
    `id` int(4) auto_increment not null PRIMARY KEY,
    `login` varchar(32) not null,
    `password` varchar(32 not null,
    `first_name` varchar(16) not null,
    `middle_name` varchar(16),
    `last_name` varchar(16) not null,
    `email` varchar(32),
    `category` ENUM('admin', 'coach', 'athlete', 'manager', 'visitor') not null,
    `block` date,
    `birth_date` date
    `coach_id` int(4)
    `status_user` ENUM('confirmed', 'rejected', 'consideration')
    FOREIGN KEY (coach_id) REFERENCES users (id)
);


CREATE TABLE `tournaments` (
   `id` int(4) auto_increment not null PRIMARY KEY,
   `name` varchar(60) not null,
   `date_start` date not null,
   `date_end` date  not null,
   `description` varchar(255),
   `status` ENUM('expected', 'go', 'completed') not null,
   `referee_id` int(4) not null
   FOREIGN KEY (referee_id) REFERENCES users (id)
);

CREATE TABLE `members` (
   `id` int(4) auto_increment not null PRIMARY KEY,
   `status` ENUM('consideration', 'confirmed', 'rejected') not null,
   `tournament_id` int(4) not null,
   `user_id` int(4) not null,
   `place` int(4)
   FOREIGN KEY (tournament_id) REFERENCES tournaments (id)
   FOREIGN KEY (user_id) REFERENCES users (id)
);

INSERT INTO `users` VALUES 
(1,'admin','admin', 'Константин', 'Николаевич', 'Ветров', 'adminvetrov@mail.ru', 'admin', '', '1987-10-08', '', '');
INSERT INTO `users` VALUES 
(2,'kate_berezova','kate_berezova', 'Екатерина', 'Вячеславовна', 'Березова', 'kate_berezova@mail.ru', 'coach', '', '1981-04-11', '', 'confirmed');
INSERT INTO `users` VALUES 
(3,'vlad_l','vlad_l', 'Владислав', 'Сергеевич', 'Лодочкин', 'vlad_l@mail.ru', 'coach', '', '1979-07-14', '', 'consideration');
INSERT INTO `users` VALUES 
(4,'alexsey','alexsey', 'Алексей', 'Петрович', 'Волков', 'alexsey@mail.ru', 'manager', '', '1986-02-19', '', 'confirmed');
INSERT INTO `users` VALUES 
(5,'kamilla','kamilla', 'Камилла', 'Тимуровна', 'Зайнуллина', 'kamilla_z@mail.ru', 'athlete', '', '1999-02-19', '2', 'confirmed');
INSERT INTO `users` VALUES 
(6,'svetlana_t','svetlana_t', 'Светлана', 'Дмитриевна', 'Тетенева', 'svetlana_t@mail.ru', 'athlete', '', '2001-04-10', '2', 'confirmed');
INSERT INTO `users` VALUES 
(7,'igorkas','igorkas', 'Игорь', 'Михайлович', 'Касаткин', 'igorkas@mail.ru', 'athlete', '', '2002-05-27', '2', 'confirmed');
INSERT INTO `users` VALUES 
(8,'radmir','radmir', 'Радмир', 'Айратович', 'Шаймуратов', 'radmir@mail.ru', 'athlete', '', '2001-09-20', '2', 'confirmed');
INSERT INTO `users` VALUES 
(9,'darya','darya', 'Дарья', 'Сергеевна', 'Мечникова', 'darya@mail.ru', 'visitor', '', '1995-09-20', '', 'confirmed');


INSERT INTO `tournaments` VALUES 
(1,'Турнир имени Роговой','2016-05-11', '2016-05-18', '', 'completed', '4');
INSERT INTO `tournaments` VALUES 
(2,'Турнир Junior','2016-06-19', '2016-06-23', '', 'expected', '4');

INSERT INTO `members` VALUES 
(1,'confirmed', 1, 5, '');
INSERT INTO `members` VALUES 
(2,'confirmed', 1, 6, 1);
INSERT INTO `members` VALUES 
(3,'confirmed', 1, 7, '', 2);
INSERT INTO `members` VALUES 
(4,'confirmed', 1, 5, '', 3);
INSERT INTO `members` VALUES 
(5,'consideration', 2, 8, '');
INSERT INTO `members` VALUES 
(6,'consideration', 2, 7, '');
INSERT INTO `members` VALUES 
(7,'consideration', 2, 6, '');



