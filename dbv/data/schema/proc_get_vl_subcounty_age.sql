DROP PROCEDURE IF EXISTS `proc_get_vl_subcounty_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_subcounty_age`
(IN filter_subcounty INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        `ac`.`name`, 
        SUM(`vsa`.`tests`) AS `tests`, 
        SUM(`vsa`.`undetected`+`vsa`.`less1000`) AS `suppressed`,
        SUM(`vsa`.`less5000`+`vsa`.`above5000`) AS `nonsuppressed`
    FROM `vl_subcounty_age` `vsa`
    JOIN `agecategory` `ac`
        ON `vsa`.`age` = `ac`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' ");

    SET @QUERY = CONCAT(@QUERY, " AND `ac`.`subID` = 1 ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ac`.`ID` ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
