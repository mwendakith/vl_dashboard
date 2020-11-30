DROP PROCEDURE IF EXISTS `proc_get_county_poc_vl_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_poc_vl_outcomes`
(IN filter_county INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
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
                    SUM(`edta`) AS `edta`,
                    SUM(`dbs`) AS `dbs`,
                    SUM(`plasma`) AS `plasma`,
                    SUM(`alledta`) AS `alledta`,
                    SUM(`alldbs`) AS `alldbs`,
                    SUM(`allplasma`) AS `allplasma`,
                    SUM(`ssp`.`undetected`) AS `undetected`,
                    SUM(`ssp`.`less1000`) AS `less1000`,
                    (SUM(`ssp`.`undetected`)+SUM(`ssp`.`less1000`)) AS `suppressed`,
                    (SUM(`ssp`.`less5000`)+SUM(`ssp`.`above5000`)) AS `nonsuppressed`,
                    (SUM(`ssp`.`undetected`)+SUM(`ssp`.`less1000`)+SUM(`ssp`.`less5000`)+SUM(`ssp`.`above5000`)) AS `total`
                  FROM `vl_site_summary_poc` `ssp`
                  LEFT JOIN `view_facilitys` `vf` ON `ssp`.`facility` = `vf`.`ID` 
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

    IF (filter_county != 0 && filter_county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `county` = '",filter_county,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
