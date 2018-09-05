DROP PROCEDURE IF EXISTS `proc_get_vl_county_shortcodes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_shortcodes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    COUNT(shortcodequeries.ID) AS `counts`, 
                    view_facilitys.county, 
                    countys.name
                  FROM shortcodequeries 
                  LEFT JOIN view_facilitys 
                    ON shortcodequeries.mflcode = view_facilitys.facilitycode 
                  LEFT JOIN countys 
                    ON countys.ID = view_facilitys.county 
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY view_facilitys.county ORDER BY COUNT(shortcodequeries.ID) DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
