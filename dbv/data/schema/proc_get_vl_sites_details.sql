DROP PROCEDURE IF EXISTS `proc_get_vl_sites_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_sites_details`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN type INT(11), IN ID INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    SUM(`vss`.`received`) AS `received`, 
                    SUM(`vss`.`rejected`) AS `rejected`,  
                    SUM(`vss`.`invalids`) AS `invalids`,
                    SUM(`vss`.`alltests`) AS `alltests`,  
                    SUM(`vss`.`Undetected`) AS `undetected`,  
                    SUM(`vss`.`less1000`) AS `less1000`,  
                    SUM(`vss`.`less5000`) AS `less5000`,  
                    SUM(`vss`.`above5000`) AS `above5000`,
                    SUM(`vss`.`baseline`) AS `baseline`,
                    SUM(`vss`.`baselinesustxfail`) AS `baselinesustxfail`,
                    SUM(`vss`.`confirmtx`) AS `confirmtx`,
                    SUM(`vss`.`confirm2vl`) AS `confirm2vl`,  
                    `vf`.`name` as `facility`,
                    `vf`.`facilitycode` as `facilitycode`,
                    `vf`.`subcounty` 
                  FROM `vl_site_summary` `vss` 
                  JOIN `view_facilitys` `vf` ON `vf`.`ID` = `vss`.`facility`
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

     -- If 0 if passed under type the query gets all the facilities
    IF (type=1 OR type='1') THEN -- Get the facilities per county
      SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",ID,"' ");
    END IF;
    IF (type=2 OR type='2') THEN -- Get the facilities per partner
      SET @QUERY = CONCAT(@QUERY, " AND `vf`.`partner` = '",ID,"' ");
    END IF;
    IF (type=3 OR type='3') THEN  -- Get the facilities per subcounty
      SET @QUERY = CONCAT(@QUERY, " AND `vf`.`district` = '",ID,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, "  GROUP BY `vss`.`facility` ORDER BY `alltests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

