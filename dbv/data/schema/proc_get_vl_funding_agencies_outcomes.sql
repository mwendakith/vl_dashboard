DROP PROCEDURE IF EXISTS `proc_get_vl_funding_agencies_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_funding_agencies_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN type INT(11), IN agency INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`baseline`) AS `baseline`, 
        SUM(`baselinesustxfail`) AS `baselinesustxfail`, 
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
    FROM `vl_partner_summary` `vps`
    JOIN `partners` `p` ON `p`.`ID` = `vps`.`partner`
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

    SET @QUERY = CONCAT(@QUERY, " AND `funding_agency_id` = '",agency,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
