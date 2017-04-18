DROP PROCEDURE IF EXISTS `proc_get_lab_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_lab_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `l`.`labname`,
                    SUM((`vcs`.`Undetected`+`vcs`.`less1000`)) AS `detectableNless1000`,
                    SUM(`vcs`.`sustxfail`) AS `sustxfl`
                FROM `vl_lab_summary` `vcs` JOIN `labs` `l` ON `vcs`.`lab` = `l`.`ID` WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vcs`.`lab` ORDER BY `detectableNless1000` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
