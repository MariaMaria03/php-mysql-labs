USE `sts402-9143`;

SELECT us1.first_name, us2.login FROM users us1, users us2
WHERE us2.id = us1.coach_id AND us1.id = 45