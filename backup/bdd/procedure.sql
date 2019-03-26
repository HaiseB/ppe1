DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `resSalle`(IN `deb` DATETIME, IN `fin` DATETIME, IN `info` BOOLEAN, IN `ligue` INT, IN `places` INT, IN `nom` VARCHAR(255) CHARSET utf8, IN `description` TEXT CHARSET utf8)
begin
set @classrooms = (select id
              from classrooms
              where locked_at is null
              and computerized = info
              and number_places >= places
              and id not in (select classrooms.id
                                    from events
                                    join classrooms on events.id_classroom=classrooms.id
                                    where
                                    locked_at is null
                                    and computerized = info
                                    and ( deb between start and end and fin between start and end )
                                    or  ( deb < start and fin > end )
                                    or  ( deb < start and fin between start and end )
                                    or  ( deb between start and end and fin > end))
                                    limit 1);
if ((@classrooms is not null) and (deb<fin)) then
	insert into events (name, start, end, id_league, id_classroom, description)
    values (nom, deb, fin, ligue, @classrooms, description);
    SELECT 1;
ELSE
    SELECT 0;
end if;
if (@classrooms is null ) then
	signal sqlstate '45000' set message_text = 'Reservation impossible pour les critères choisis';
end if;
end$$
DELIMITER ;