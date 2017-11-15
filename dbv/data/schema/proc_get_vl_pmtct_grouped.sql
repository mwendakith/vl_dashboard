DROP PROCEDURE IF EXISTS `proc_get_vl_pmtct_grouped`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_pmtct_grouped`
(IN Pm_ID INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN county INT(11), IN subcounty INT(11), IN partner INT(11))
BEGIN
  SET @QUERY =    "SELECT
          `com`.`name`,
  				SUM(`vcs`.`rejected`) AS `rejected`,  
          SUM(`vcs`.`invalids`) AS `invalids`,  
          SUM(`vcs`.`Undetected`) AS `undetected`,  
          SUM(`vcs`.`less1000`) AS `less1000`,  
          SUM(`vcs`.`less5000`) AS `less5000`,  
          SUM(`vcs`.`above5000`) AS `above5000`,
          SUM(`vcs`.`confirmtx`) AS `confirmtx`,
          SUM(`vcs`.`confirm2vl`) AS `confirm2vl`,
          SUM(`vcs`.`baseline`) AS `baseline`,
          SUM(`vcs`.`baselinesustxfail`) AS `baselinesustxfail`,
          SUM(`vcs`.`undetected`+`vcs`.`less1000`+`vcs`.`less5000`+`vcs`.`above5000`) AS `routine` 
          FROM `vl_site_pmtct` `vcs` LEFT JOIN `view_facilitys` `com` ON `vcs`.`facility` = `com`.`ID` WHERE 1 ";

    IF (county != 0 || county != '') THEN
        SET @QUERY = CONCAT(@QUERY, " AND `com`.`county` = '",county,"' ");
    END IF;           
		IF (subcounty != 0 || subcounty != '') THEN
        SET @QUERY = CONCAT(@QUERY, " AND `com`.`district` = '",subcounty,"' ");
    END IF;
    IF (partner != 0 || partner != '') THEN
        SET @QUERY = CONCAT(@QUERY, " AND `com`.`partner` = '",partner,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " AND `vcs`.`pmtcttype` = '",Pm_ID,"' ");

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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `com`.`ID` ORDER BY `routine` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
