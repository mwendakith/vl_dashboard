DROP PROCEDURE IF EXISTS `proc_get_vl_tat_ranking`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_tat_ranking`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN type INT(11), IN ID INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `jt`.`name`, 
                    AVG(`mt`.`tat1`) AS `tat1`, 
                    AVG(`mt`.`tat2`) AS `tat2`, 
                    AVG(`mt`.`tat3`) AS `tat3`, 
                    AVG(`mt`.`tat4`) AS `tat4`";
    IF (type = 0 && type = '') THEN
        IF (ID != 0 && ID != '') THEN 
            SET @QUERY = CONCAT(@QUERY, " FROM `vl_subcounty_summary` `mt` JOIN `districts` `jt` ON `jt`.`ID` = `mt`.`subcounty` JOIN `view_facilitys` `vf` ON `vf`.`district` = `jt`.`ID` WHERE `vf`.`county` = '",ID,"' ");
        ELSE 
            SET @QUERY = CONCAT(@QUERY, " FROM `vl_county_summary` `mt` JOIN `countys` `jt` ON `jt`.`ID` = `mt`.`county` WHERE 1 ");
        END IF;
    END IF;
    IF (type = 1) THEN
      IF (ID != 0 && ID != '') THEN 
            SET @QUERY = CONCAT(@QUERY, " FROM `vl_site_summary` `mt` JOIN `view_facilitys` `jt` ON `jt`.`id` = `mt`.`facility` WHERE `jt`.`partner` = '",ID,"' ");
        ELSE 
            SET @QUERY = CONCAT(@QUERY, " FROM `vl_partner_summary` `mt` JOIN `partners` `jt` ON `jt`.`ID` = `mt`.`partner` WHERE `jt`.`flag` = '1'  ");
        END IF;
    END IF;
    IF (type = 2) THEN
      IF (ID != 0 && ID != '') THEN 
            SET @QUERY = CONCAT(@QUERY, " FROM `vl_site_summary` `mt` JOIN `view_facilitys` `jt` ON `jt`.`id` = `mt`.`facility` WHERE `jt`.`district` = '",ID,"' ");
        ELSE 
            SET @QUERY = CONCAT(@QUERY, " FROM `vl_subcounty_summary` `mt` JOIN `districts` `jt` ON `jt`.`ID` = `mt`.`subcounty` WHERE 1 ");
        END IF;
    END IF;
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
    
    SET @QUERY = CONCAT(@QUERY, " GROUP BY `name` ORDER BY `tat4` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
