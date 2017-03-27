DROP PROCEDURE IF EXISTS `proc_get_sites_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_age`
(IN S_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                      SUM(`less2`) AS `less2`, 
                      SUM(`less9`) AS `less9`, 
                      SUM(`less14`) AS `less14`, 
                      SUM(`less19`) AS `less19`, 
                      SUM(`less24`) AS `less24`, 
                      SUM(`over25`) AS `over25` 
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
