DROP PROCEDURE IF EXISTS `proc_get_vl_fundingagencies_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_fundingagencies_gender`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN type INT(11), IN agency INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `g`.`name`,
                    (SUM(`vpg`.`undetected`)+SUM(`vpg`.`less1000`)) AS `suppressed`,
                    (SUM(`vpg`.`less5000`)+SUM(`vpg`.`above5000`)) AS `nonsuppressed`
                FROM `vl_partner_gender` `vpg`
                JOIN `partners` `p` ON `p`.`ID` = `vpg`.`partner`
                JOIN `gender` `g` ON `vpg`.`gender` = `g`.`ID`
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

    

    SET @QUERY = CONCAT(@QUERY, " AND `p`.`funding_agency_id` = '",agency,"' GROUP BY `g`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
