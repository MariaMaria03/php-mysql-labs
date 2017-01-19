USE `sport_school`;
CREATE TABLE `groups` (
    `id` int(4) auto_increment not null PRIMARY KEY,
    `name` varchar(16) not null,
    `description` text not null
);


CREATE TABLE `athletes` (
   `id` int(4) auto_increment not null PRIMARY KEY,
   `full_name` varchar(60) not null,
   `birth_date` date not null,
   `group_id` int(4)  not null,
   `sports_rank` varchar(30) not null,
   FOREIGN KEY (group_id) REFERENCES groups (id)
);

CREATE TABLE `coaches` (
   `id` int(4) auto_increment not null PRIMARY KEY,
   `name_coach` varchar(60) not null,
   `group_id` int(4) not null,
   FOREIGN KEY (group_id) REFERENCES groups (id)
);