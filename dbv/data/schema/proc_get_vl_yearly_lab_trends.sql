DROP PROCEDURE IF EXISTS `proc_get_vl_yearly_lab_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_yearly_lab_trends`
(IN lab INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vls`.`year`, `vls`.`month`,  
                    SUM(`vls`.`Undetected` + `vls`.`less1000`) AS `suppressed`, 
                    SUM(`vls`.`above5000` + `vls`.`less5000`) AS `nonsuppressed`,
                    SUM(`vls`.`alltests`) AS `alltests`, 
                    SUM(`vls`.`received`) AS `received`, 
                    SUM(`vls`.`rejected`) AS `rejected`,
                    SUM(`vls`.`tat4`) AS `tat4`
                FROM `vl_lab_summary` `vls`
                WHERE 1  ";

      IF (lab != 0 && lab != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `vls`.`lab` = '",lab,"' ");
      END IF;  

    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `vls`.`month`, `vls`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `vls`.`year` DESC, `vls`.`month` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
