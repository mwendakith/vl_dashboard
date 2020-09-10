DROP PROCEDURE IF EXISTS `proc_get_vl_sample_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_sample_summary`
(IN S_id INT(11), IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
            `year`, 
            `month`, 
            (`undetected`+`less1000`) AS `suppressed`,
            (`less5000`+`above5000`) AS `nonsuppressed`, 
            ((`undetected`+`less1000`)*100/(`less5000`+`above5000`+`undetected`+`less1000`)) AS `percentage`  
            FROM `vl_national_sampletype`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `sampletype` = '",S_id,"' AND `year` BETWEEN '",from_year,"' AND '",to_year,"' ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
