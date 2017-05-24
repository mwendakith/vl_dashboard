DROP PROCEDURE IF EXISTS `proc_get_vl_shortcodes_requests`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_shortcodes_requests`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
					COUNT(DISTINCT shortcodequeries.`ID`) AS `count`,
					MONTH(shortcodequeries.`datereceived`) AS `month`,
					YEAR(shortcodequeries.`datereceived`) AS `year`,
					MONTHNAME(shortcodequeries.`datereceived`) AS `monthname`
				FROM shortcodequeries
					LEFT JOIN view_facilitys
				ON view_facilitys.facilitycode = shortcodequeries.mflcode 
                 WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND YEAR(shortcodequeries.datereceived) = '",filter_year,"' AND MONTH(shortcodequeries.datereceived) BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((YEAR(shortcodequeries.datereceived) = '",filter_year,"' AND MONTH(shortcodequeries.datereceived) >= '",from_month,"')  OR (YEAR(shortcodequeries.datereceived) = '",to_year,"' AND MONTH(shortcodequeries.datereceived) <= '",to_month,"') OR (YEAR(shortcodequeries.datereceived) > '",filter_year,"' AND YEAR(shortcodequeries.datereceived) < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND YEAR(shortcodequeries.datereceived) = '",filter_year,"' AND MONTH(shortcodequeries.datereceived)='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND YEAR(shortcodequeries.datereceived) = '",filter_year,"' ");
    END IF;

    IF (C_id != 0 && C_id != '') THEN
        SET @QUERY = CONCAT(@QUERY, "  AND view_facilitys.county = '",C_id,"' ");
    END IF;



    SET @QUERY = CONCAT(@QUERY, " GROUP BY `year` ASC,`month` ASC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;