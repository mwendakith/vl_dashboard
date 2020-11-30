DROP PROCEDURE IF EXISTS `proc_get_vl_lab_site_rejections`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_lab_site_rejections`
(IN lab INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`v`.`total`) AS `total_rejections`,
        `vr`.`name` AS `rejection_reason`,
        `vf`.`name` AS `facility`,
        `vr`.`alias` 

        FROM `vl_site_rejections` `v`
        LEFT JOIN `viralrejectedreasons` `vr` ON `v`.`rejected_reason` = `vr`.`ID`
        LEFT JOIN `facilitys` `vf` ON `v`.`facility` = `vf`.`ID`

        WHERE 1 and `total_rejections` > 0
        ";


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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`lab` = '",lab,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vr`.`ID` ORDER BY `total` DESC ");
    

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
     
END //
DELIMITER ;
