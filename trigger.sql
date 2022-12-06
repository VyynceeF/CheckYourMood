DELIMITER //

DROP TRIGGER IF EXISTS testInsertUtilisateur //

CREATE TRIGGER testInsertUtilisateur BEFORE INSERT ON utilisateur
FOR EACH ROW 
BEGIN 
	IF LENGTH(NEW.motDePasse) < 8 THEN
    	SIGNAL SQLSTATE '50001' SET MESSAGE_TEXT = 'Le mot de passe doit contenir au moins 8 caractères';
    END IF;
END //

CREATE TRIGGER testUpdateMDP BEFORE UPDATE ON utilisateur
FOR EACH ROW 
BEGIN 
	IF LENGTH(NEW.motDePasse) < 8 THEN
    	SIGNAL SQLSTATE '50001' SET MESSAGE_TEXT = 'Le mot de passe doit contenir au moins 8 caractères';
    END IF;
END //

DELIMITER ;