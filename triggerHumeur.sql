--
-- Déclencheurs `humeur`
--
DELIMITER //
DROP TRIGGER IF EXISTS check_date_time_range //
CREATE TRIGGER `check_date_time_range` BEFORE INSERT ON `humeur` FOR EACH ROW BEGIN
    IF NEW.dateHumeur  + INTERVAL 1 day > CURRENT_DATE OR NEW.heure  + INTERVAL 1 hour > CURRENT_TIME THEN
        SIGNAL SQLSTATE '45001' SET MESSAGE_TEXT = 'La date et l''heure depassent la plage de 24 heures';
    END IF;
END // 
DELIMITER ;

DELIMITER //
DROP TRIGGER IF EXISTS verifier_date_heure //
CREATE TRIGGER `verifier_date_heure` BEFORE INSERT ON `humeur` FOR EACH ROW BEGIN
    IF NEW.dateHumeur > CURRENT_DATE OR (NEW.dateHumeur = CURRENT_DATE AND NEW.heure > CURRENT_TIME) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La date et l''heure ne peuvent pas dépasser l''heure actuelle';
    END IF;
END
//
DELIMITER ;