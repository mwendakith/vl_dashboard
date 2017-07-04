DROP PROCEDURE IF EXISTS `proc_get_vl_yearly_lab_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_yearly_lab_summary`
(IN lab INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vls`.`year`, `vls`.`month`, 
                    SUM(`vls`.`Undetected` + `vls`.`less1000`) AS `suppressed`, 
                    SUM(`vls`.`above5000` + `vls`.`less5000`) AS `nonsuppressed`
                FROM `vl_lab_summary` `vls`
                WHERE 1  ";

      IF (lab != 0 && lab != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `vls`.`lab` = '",lab,"' ");
      END IF;  

    
      SET @QUERY = CONCAT(@QUERY, "  GROUP BY `vls`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `vls`.`year` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
