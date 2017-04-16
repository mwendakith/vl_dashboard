DROP PROCEDURE IF EXISTS `proc_get_labs_sampletypes`;
DELIMITER //
CREATE PROCEDURE `proc_get_labs_sampletypes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `lb`.`labname`, 
                    SUM(`vls`.`dbs`) AS `dbs`, 
                    SUM(`vls`.`plasma`) AS `plasma`, 
                    SUM(`vls`.`edta`) AS `edta`, 
                    `vls`.`year` 
                FROM `vl_lab_summary` `vls` 
                JOIN `labs` `lb` 
                    ON `vls`.`lab` = `lb`.`ID`
                WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND (`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;



    SET @QUERY = CONCAT(@QUERY, " GROUP BY `lb`.`labname` ORDER BY SUM(`dbs`+`plasma`+`edta`) DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
