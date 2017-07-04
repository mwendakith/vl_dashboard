DROP PROCEDURE IF EXISTS `proc_get_eid_national_age_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_age_positivity`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        SUM(`nodatapos`) AS `nodatapos`,
                        SUM(`nodataneg`) AS `nodataneg`,
                        SUM(`less2wpos`) AS `less2wpos`,
                        SUM(`less2wneg`) AS `less2wneg`,
                        SUM(`twoto6wpos`) AS `twoto6wpos`,
                        SUM(`twoto6wneg`) AS `twoto6wneg`,
                        SUM(`sixto8wpos`) AS `sixto8wpos`,
                        SUM(`sixto8wneg`) AS `sixto8wneg`,
                        SUM(`sixmonthpos`) AS `sixmonthpos`,
                        SUM(`sixmonthneg`) AS `sixmonthneg`,
                        SUM(`ninemonthpos`) AS `ninemonthpos`,
                        SUM(`ninemonthneg`) AS `ninemonthneg`,
                        SUM(`twelvemonthpos`) AS `twelvemonthpos`,
                        SUM(`twelvemonthneg`) AS `twelvemonthneg`
                    FROM `national_agebreakdown` 
                WHERE 1 ";

   
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
