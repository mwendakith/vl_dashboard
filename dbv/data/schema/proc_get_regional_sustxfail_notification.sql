<<<<<<< HEAD
DROP PROCEDURE IF EXISTS `proc_get_regional_sustxfail_notification`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_sustxfail_notification`
(IN C_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        ((SUM(`sustxfail`)/SUM(`alltests`))*100) AS `sustxfail_rate` 
                    FROM `vl_county_summary`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' AND `year` = '",filter_year,"' ");
    END IF;

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
=======
DROP PROCEDURE IF EXISTS `proc_get_regional_sustxfail_notification`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_sustxfail_notification`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        SUM(`sustxfail`) AS `sustxfail`, 
                        ((SUM(`sustxfail`)/SUM(`alltests`))*100) AS `sustxfail_rate` 
                    FROM `vl_county_summary`
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

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
