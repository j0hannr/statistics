-- Create syntax for 'dayview'

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dayview`
AS SELECT
   `statistics`.`entry`.`user` AS `user`,
   `statistics`.`entry`.`entry` AS `entry`,
   `statistics`.`entry`.`day` AS `day`,
   `statistics`.`entry`.`milestone` AS `milestone`,
   `statistics`.`entry`.`story` AS `story`,
   `statistics`.`entry`.`quote` AS `quote`,
   `statistics`.`entry`.`location` AS `location`,
   `statistics`.`location_day`.`id` AS `location_id`,
   `statistics`.`location_day`.`status` AS `status`,
   `statistics`.`location_day`.`tempAvg` AS `tempAvg`,
   `statistics`.`location`.`name` AS `name`,
   `statistics`.`location`.`latitude` AS `latitude`,
   `statistics`.`location`.`longitude` AS `longitude`
FROM ((`entry` join `location_day` on((`statistics`.`entry`.`entry` = `statistics`.`location_day`.`entry`))) join `location` on((`statistics`.`entry`.`location` = `statistics`.`location`.`id`)));
