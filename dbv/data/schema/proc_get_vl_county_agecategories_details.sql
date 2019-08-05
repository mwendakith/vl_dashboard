DROP PROCEDURE IF EXISTS `proc_get_vl_county_agecategories_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_agecategories_details`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN type INT(11), IN ID INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    SUM(`va`.`tests`) AS `tests`,
                    SUM(`va`.`Undetected`) AS `Undetected`, 
                    SUM(`va`.`less1000`) AS `less1000`, 
                    SUM(`va`.`less5000`) AS `less5000`, 
                    SUM(`va`.`above5000`) AS `above5000`,
                    `ac`.`name`, ";
   IF (type=0 OR type='0') THEN 
      SET @QUERY = CONCAT(@QUERY, " `jt`.`name` as `selection` FROM `vl_county_age` `va` JOIN `agecategory` `ac` ON `ac`.`ID` = `va`.`age` JOIN `countys` `jt` ON `jt`.`ID` = `va`.`county`  WHERE `ac`.`subID` = '1' ");
   END IF;
   IF (type=1 OR type='1') THEN
      SET @QUERY = CONCAT(@QUERY, " `jt`.`partnername` as `selection` FROM `vl_partner_age` `va` JOIN `agecategory` `ac` ON `ac`.`ID` = `va`.`age` JOIN `view_facilitys` `jt` ON `jt`.`partner` = `va`.`partner` WHERE `jt`.`county` = '",ID,"' ");
   END IF;
   IF (type=2 OR type='2') THEN
      SET @QUERY = CONCAT(@QUERY, " `va`.`subcounty` as `selection` FROM `vl_subcounty_age` `va` JOIN `agecategory` `ac` ON `ac`.`ID` = `va`.`age` JOIN `districts` `jt` ON `jt`.`id` = `va`.`subcounty` WHERE `jt`.`county` = '",ID,"' ");
   END IF;
   IF (type=3 OR type='3') THEN
      SET @QUERY = CONCAT(@QUERY, " `jt`.`ID` as `selection` FROM `vl_site_age` `va` JOIN `agecategory` `ac` ON `ac`.`ID` = `va`.`age` JOIN `view_facilitys` `jt` ON `jt`.`ID` = `va`.`facility` WHERE `jt`.`county` = '",ID,"' ");
   END IF;
   IF (type=4 OR type='4') THEN
      SET @QUERY = CONCAT(@QUERY, " `jt`.`partnername` as `selection` FROM `vl_site_age` `va` JOIN `agecategory` `ac` ON `ac`.`ID` = `va`.`age` JOIN `view_facilitys` `jt` ON `jt`.`ID` = `va`.`facility` WHERE `jt`.`county` = '",ID,"' ");
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

   SET @QUERY = CONCAT(@QUERY, " GROUP BY `ac`.`name`, `selection` ");

   PREPARE stmt FROM @QUERY;
   EXECUTE stmt;
END //
DELIMITER ;

