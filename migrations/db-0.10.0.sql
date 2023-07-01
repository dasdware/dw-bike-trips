START TRANSACTION;
    -- Add the has_time column.
    ALTER TABLE `trips` ADD `has_time` BOOLEAN NOT NULL DEFAULT FALSE AFTER `timestamp`;
    
    -- Set the initial values for the has_time column. For old trips, if they are set
    -- to midnight, they are assumed to have no time portion.
    UPDATE `trips` SET `has_time` = IF(DATE_FORMAT(`timestamp`, '%H:%i:%S') = '00:00:00', FALSE, TRUE);
COMMIT;