DROP PROCEDURE IF EXISTS `proc_get_vl_subcounty_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_subcounty_gender`
(IN filter_subcounty INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`maletest`) AS `maletest`,
        SUM(`femaletest`) AS `femaletest`,
        SUM(`nogendertest`) AS `nodata`
    FROM `vl_subcounty_summary`
    WHERE 1 ";

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' AND `year` = '",filter_year,"' ");
    END IF;



     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
