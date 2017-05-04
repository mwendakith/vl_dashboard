DROP PROCEDURE IF EXISTS `proc_get_vl_partner_age_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_age_outcomes`
(IN P_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `ac`.`name`, 
                        SUM(`vna`.`less5000`+`vna`.`above5000`) AS `nonsuppressed`, 
                        SUM(`vna`.`Undetected`+`vna`.`less1000`) AS `suppressed` 
                        FROM `vl_partner_age` `vna`
                        LEFT JOIN `agecategory` `ac` 
                        ON `vna`.`age` = `ac`.`ID`
                    WHERE `ac`.`ID` NOT BETWEEN '1' AND '5'";

 
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


    SET @QUERY = CONCAT(@QUERY, " AND `vna`.`partner` = '",P_Id,"' GROUP BY `name` ORDER BY `suppressed` DESC, `nonsuppressed` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
