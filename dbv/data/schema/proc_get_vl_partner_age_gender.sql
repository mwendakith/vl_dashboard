DROP PROCEDURE IF EXISTS `proc_get_vl_partner_age_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_age_gender`
(IN P_Id INT(11), IN A_id VARCHAR(100), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
      `g`.`name`,
      SUM(`Undetected`) AS `Undetected`,
      SUM(`less1000`) AS `less1000`,
      SUM(`less5000`) AS `less5000`,
      SUM(`above5000`) AS `above5000`
    FROM vl_partner_age_gender vpag
    JOIN agecategory ag ON ag.ID = vpag.age
    JOIN gender g ON g.ID = vpag.gender
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

    SET @QUERY = CONCAT(@QUERY, " AND `vpag`.`age` ",A_id," AND `vpag`.`partner` = '",P_Id,"' GROUP BY `g`.`name` ");


     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;