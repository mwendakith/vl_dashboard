DROP PROCEDURE IF EXISTS `proc_get_partner_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_gender`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `g`.`name`,
                    SUM(`vng`.`undetected`+`vng`.`less1000`) AS `suppressed`,
                    SUM(`vng`.`less5000`+`vng`.`above5000`) AS `nonsuppressed`
                FROM `vl_partner_gender` `vng`
                JOIN `gender` `g`
                    ON `vng`.`gender` = `g`.`ID`
                WHERE 1";

   
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `vng`.`partner` = '",P_id,"' AND `vng`.`year` = '",filter_year,"' AND `vng`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `vng`.`partner` = '",P_id,"' AND `vng`.`year` = '",filter_year,"' AND `vng`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vng`.`partner` = '",P_id,"' AND `vng`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `g`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
