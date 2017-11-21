DROP PROCEDURE IF EXISTS `proc_get_vl_baseline`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_baseline`
(IN param_type INT(11), IN param INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    SUM(`ba`.`tests`) AS `tests`,  
                    SUM(`ba`.`sustxfail`) AS `sustxfail`,  
                    SUM(`ba`.`rejected`) AS `rejected`,  
                    SUM(`ba`.`invalids`) AS `invalids`,  
                    SUM(`ba`.`dbs`) AS `dbs`,  
                    SUM(`ba`.`plasma`) AS `plasma`,  
                    SUM(`ba`.`edta`) AS `edta`,
                    SUM(`ba`.`maletest`) AS `maletest`,
                    SUM(`ba`.`femaletest`) AS `femaletest`,
                    SUM(`ba`.`nogendertest`) AS `nogendertest`,
                    SUM(`ba`.`less2`) AS `less2`,
                    SUM(`ba`.`less9`) AS `less9`,
                    SUM(`ba`.`less14`) AS `less14`,
                    SUM(`ba`.`less19`) AS `less19`,
                    SUM(`ba`.`less24`) AS `less24`,
                    SUM(`ba`.`over25`) AS `over25`,
                    SUM(`ba`.`undetected`) AS `undetected`,
                    SUM(`ba`.`less1000`) AS `less1000`,
                    SUM(`ba`.`less5000`) AS `less5000`,
                    SUM(`ba`.`above5000`) AS `above5000`
                  ";

    IF (param_type = 0) THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_national_justification` `ba`  WHERE 1 ");
    END IF;

    IF (param_type = 1) THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_county_justification` `ba`  WHERE 1 and `county` = '",param,"' ");
    END IF;

    IF (param_type = 2) THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_subcounty_justification` `ba`  WHERE 1 and `subcounty` = '",param,"' ");
    END IF;

    IF (param_type = 3) THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_partner_justification` `ba`  WHERE 1 and `partner` = '",param,"' ");
    END IF;

    IF (param_type = 4) THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_site_justification` `ba`  WHERE 1 and `facility` = '",param,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " AND `justification` = 10 ");

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


     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
