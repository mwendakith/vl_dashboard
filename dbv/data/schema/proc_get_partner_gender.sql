DROP PROCEDURE IF EXISTS `proc_get_partner_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_gender`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `g`.`name`,
                    SUM(`vng`.`tests`) AS `gender`, 
                    SUM(`vng`.`sustxfail`) AS `sustxfail`
                FROM `vl_partner_gender` `vng`
                JOIN `gender` `g`
                    ON `vng`.`gender` = `g`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vng`.`partner` = '",P_id,"' AND `vng`.`year` = '",filter_year,"' AND `vng`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vng`.`partner` = '",P_id,"' AND `vng`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `g`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;