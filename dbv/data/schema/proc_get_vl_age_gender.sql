DROP PROCEDURE IF EXISTS `proc_get_vl_age_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_age_gender`
(IN A_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`maletest`) AS `maletest`,
        SUM(`femaletest`) AS `femaletest`,
        SUM('nogendertest') AS `nodata`
    FROM `vl_national_age`
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `age` = '",A_id,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `age` = '",A_id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;