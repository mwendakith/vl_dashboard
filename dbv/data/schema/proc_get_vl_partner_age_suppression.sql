DROP PROCEDURE IF EXISTS `proc_get_vl_partner_age_suppression`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_age_suppression`
(IN A_id VARCHAR(100), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        partners.name,
        (SUM(`Undetected`) + SUM(`less1000`)) AS `suppressed`, 
        (SUM(`above5000`) + SUM(`less5000`)) AS `nonsuppressed`
    FROM `vl_partner_age`
    LEFT JOIN partners 
      ON partners.ID = vl_partner_age.partner
    WHERE `partners`.`flag` = '1' ";
  
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

    SET @QUERY = CONCAT(@QUERY, " AND `age` ",A_id," ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `name` ORDER BY `suppressed` desc ");
    

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;