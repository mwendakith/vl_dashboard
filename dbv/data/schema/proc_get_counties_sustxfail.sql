DROP PROCEDURE IF EXISTS `proc_get_counties_sustxfail`;
DELIMITER //
CREATE PROCEDURE `proc_get_counties_sustxfail`
<<<<<<< HEAD
(IN filter_year INT(11), IN filter_month INT(11))
=======
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
BEGIN
  SET @QUERY =    "SELECT 
                    `c`.`ID`, 
                    `c`.`name`, 
<<<<<<< HEAD
                    ((SUM(`vcs`.`sustxfail`)/SUM(`vcs`.`alltests`))*100) AS `sustxfail` 
=======
                    ((SUM(`less5000`+`above5000`)/(SUM(`Undetected`+`less1000`)+SUM(`less5000`+`above5000`)))*100) AS `sustxfail` 
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
                    FROM `vl_county_summary` `vcs` 
                    JOIN `countys` `c` 
                    ON `vcs`.`county` = `c`.`ID`
                WHERE 1";

<<<<<<< HEAD
    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vcs`.`year` = '",filter_year,"' AND `vcs`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vcs`.`year` = '",filter_year,"' ");
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `c`.`name` ORDER BY `sustxfail` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
<<<<<<< HEAD
DELIMITER ;
=======
DELIMITER ;
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
