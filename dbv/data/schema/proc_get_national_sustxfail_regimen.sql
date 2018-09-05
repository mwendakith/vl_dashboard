DROP PROCEDURE IF EXISTS `proc_get_national_sustxfail_regimen`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_sustxfail_regimen`
<<<<<<< HEAD
(IN filter_year INT(11), IN filter_month INT(11))
=======
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
BEGIN
  SET @QUERY =    "SELECT `vp`.`name`, SUM(`vnr`.`sustxfail`) AS `sustxfail`
                    FROM `vl_national_regimen` `vnr`
                    JOIN `viralprophylaxis` `vp`
                        ON `vnr`.`regimen` = `vp`.`ID`
                WHERE 1";

<<<<<<< HEAD
    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnr`.`year` = '",filter_year,"' AND `vnr`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnr`.`year` = '",filter_year,"' ");
=======
    

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
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
    END IF;

    SET @QUERY = CONCAT(@QUERY, "  GROUP BY `vp`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
<<<<<<< HEAD
DELIMITER ;
=======
DELIMITER ;
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
