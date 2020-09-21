DROP PROCEDURE IF EXISTS `proc_get_vl_samples_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_samples_age`
(IN S_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`noage`) AS `noage`,
        SUM(`less2`) AS `less2`,
        SUM(`less9`) AS `less9`,
        SUM(`less14`) AS `less14`,
        SUM(`less19`) AS `less19`,
        SUM(`less24`) AS `less24`,
        SUM(`over25`) AS `over25`
    FROM `vl_national_sampletype`
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

    IF (S_id = 1) THEN
        SET @QUERY = CONCAT(@QUERY, " AND `sampletype` IN (1, 3) ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `sampletype` = '",S_id,"' ");
    END IF;


     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
