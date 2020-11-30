DROP PROCEDURE IF EXISTS `proc_get_vl_national_yearly_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_national_yearly_trends`
()
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`, `cs`.`month`, 
                    (SUM(`cs`.`Undetected`) + SUM(`cs`.`less1000`)) AS `suppressed`, 
                    (SUM(`cs`.`above5000`) + SUM(`cs`.`less5000`)) AS `nonsuppressed`, 
                    SUM(`cs`.`received`) AS `received`, 
                    SUM(`cs`.`rejected`) AS `rejected`,
                    SUM(`cs`.`tat4`) AS `tat4`
                FROM `vl_national_summary` `cs`
                WHERE 1  ";
    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `cs`.`month`, `cs`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` DESC, `cs`.`month` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

