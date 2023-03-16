START TRANSACTION;

    ALTER TABLE `trips` ADD `has_time` BOOLEAN NOT NULL DEFAULT FALSE AFTER `timestamp`;
    
    UPDATE `trips` SET `timestamp_time` = IF(DATE_FORMAT(`timestamp`, '%H:%i:%S') = '00:00:00', FALSE, TRUE);
COMMIT;