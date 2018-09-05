DROP PROCEDURE IF EXISTS `proc_get_lab_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_lab_outcomes`
<<<<<<< HEAD
(IN filter_year INT(11), IN filter_month INT(11))
=======
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
BEGIN
  SET @QUERY =    "SELECT
                    `l`.`labname`,
                    SUM((`vcs`.`Undetected`+`vcs`.`less1000`)) AS `detectableNless1000`,
                    SUM(`vcs`.`sustxfail`) AS `sustxfl`
                FROM `vl_lab_summary` `vcs` JOIN `labs` `l` ON `vcs`.`lab` = `l`.`ID` WHERE 1";

<<<<<<< HEAD
    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
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
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

<<<<<<< HEAD
    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vcs`.`lab` ");
=======
    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vcs`.`lab` ORDER BY `detectableNless1000` DESC ");
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
<<<<<<< HEAD
DELIMITER ;
=======
DELIMITER ;
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
