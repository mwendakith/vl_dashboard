DROP PROCEDURE IF EXISTS `proc_get_national_sustxfail_sampletypes`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_sustxfail_sampletypes`
(IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `vsd`.`name`, 
                        SUM(`vns`.`sustxfail`) AS `sustxfail` 
                    FROM `vl_national_sampletype` `vns` 
                    JOIN `viralsampletypedetails` `vsd` 
                        ON `vns`.`sampletype` = `vsd`.`ID`
                WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `vns`.`year` = '",filter_year,"' AND `vns`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `vns`.`year` = '",filter_year,"' AND `vns`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vns`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vsd`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
