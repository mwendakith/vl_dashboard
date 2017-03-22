DROP PROCEDURE IF EXISTS `proc_get_sites_vl_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_vl_outcomes`
(IN S_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
       SUM(`confirmtx`) AS `confirmtx`,
        SUM(`confirm2vl`) AS `confirm2vl`,
        SUM(`Undetected`) AS `undetected`,
        SUM(`less1000`) AS `less1000`,
        SUM(`less5000`) AS `less5000`,
        SUM(`above5000`) AS `above5000`,
        SUM(`alltests`) AS `alltests`,
        SUM(`sustxfail`) AS `sustxfail`,
        SUM(`rejected`) AS `rejected`, 
        SUM(`repeattests`) AS `repeats`, 
        SUM(`invalids`) AS `invalids`,
        SUM(`received`) AS `received`,
        AVG(`sitessending`) AS `sitessending`
    FROM `vl_site_summary`
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
