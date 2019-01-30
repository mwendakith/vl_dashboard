DROP PROCEDURE IF EXISTS `proc_get_vl_partner_yearly_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_yearly_summary`
(IN P_id INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`, `cs`.`month`, 
                    (SUM(`cs`.`Undetected`) + SUM(`cs`.`less1000`)) AS `suppressed`, 
                    (SUM(`cs`.`above5000`) + SUM(`cs`.`less5000`)) AS `nonsuppressed`
                FROM `vl_partner_summary` `cs`
                WHERE 1  ";

      IF (P_id != 0 && P_id != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `cs`.`partner` = '",P_id,"' ");
      END IF;  

    
      SET @QUERY = CONCAT(@QUERY, "  GROUP BY `cs`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
