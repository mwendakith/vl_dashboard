DROP PROCEDURE IF EXISTS `proc_get_sites_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_gender`
(IN S_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                      SUM(`maletest`) AS `male`, 
                      SUM(`femaletest`) AS `female` 
                FROM `vl_site_summary` `vss`
                WHERE 1 ";

  
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",S_id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",S_id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",S_id,"' AND `year` = '",filter_year,"' ");
    END IF;

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
