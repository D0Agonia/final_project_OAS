USE OnlineAppointment;

CREATE FUNCTION insertCredentials(
    input_kldID VARCHAR(13),
    input_password VARCHAR(32)
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    DECLARE input_salt VARCHAR(32);
    DECLARE input_hashPassword BINARY(32);

    IF searchKLDID(input_kldID) = false THEN
        REPEAT
            SET input_salt = MD5(CONCAT(RAND(), NOW()));
        UNTIL NOT EXISTS (SELECT salt FROM UserCredentials WHERE salt = input_salt)
        END REPEAT;

        SET input_hashPassword = UNHEX(SHA2(CONCAT(input_password, input_salt), 256));
        
        INSERT INTO UserCredentials(kld_id, hash_password, salt) VALUES(
            input_kldID, input_hashPassword, input_salt
        );

        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;

CREATE FUNCTION insertDetails(
    input_kldID VARCHAR(13),
    input_firstname VARCHAR(32)
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    IF searchKLDID(input_kldID) = true THEN
        INSERT INTO UserDetails(kld_id, name) VALUES(
            input_kldID, input_name
        );
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;

-- Output >>> [Token]: Success; 1: No User; 2: Wrong Password
CREATE FUNCTION verifyLogin(
    input_kldID VARCHAR(13),
    input_password VARCHAR(32)
) RETURNS VARCHAR(32)
READS SQL DATA
BEGIN
    DECLARE result VARCHAR(32);
    DECLARE user_password BINARY(32);
    DECLARE user_salt VARCHAR(32);

    SELECT hash_password, salt 
    INTO user_password, user_salt 
    FROM UserCredentials WHERE kld_id = input_kldID;

    IF SHA2(CONCAT(input_password, user_salt), 256) = HEX(user_password) THEN
        CALL CreateSessionToken(input_kldID);
        SELECT session_token INTO result 
        FROM UserCredentials WHERE kld_id = input_kldID;
    ELSEIF searchKLDID(input_kldID) = false THEN
        SET result = '1';
    ELSE
        SET result = '2';
    END IF;

    RETURN result;
END;

CREATE FUNCTION verifyToken(
    input_token VARCHAR(32)
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    DECLARE user_tokenExpiration DATETIME;

    SELECT token_expiration INTO user_tokenExpiration
    FROM UserCredentials WHERE session_token = input_token;

    IF user_tokenExpiration <= NOW() THEN
        CALL DestroySessionToken(input_token);
        RETURN false;
    ELSEIF searchToken(input_token) = false THEN
        RETURN false;
    ELSE
        RETURN true;
    END IF;
END;

CREATE FUNCTION searchKLDID(
    input_kldID VARCHAR(13)
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    DECLARE user_kldID VARCHAR(13);

    SELECT kld_id INTO user_kldID 
    FROM UserCredentials WHERE kld_id = input_kldID;

    IF user_kldID IS NOT NULL THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;

CREATE FUNCTION searchUserId(
    input_id BIGINT
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    DECLARE user_userId BIGINT;

    SELECT user_id INTO user_userId 
    FROM UserDetails WHERE user_id = input_id;

    IF user_userId IS NOT NULL THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;

CREATE FUNCTION searchToken(
    input_token VARCHAR(32)
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    DECLARE user_token VARCHAR(32);

    SELECT session_token INTO user_token
    FROM UserCredentials WHERE session_token = input_token;

    IF user_token IS NOT NULL THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;



CREATE PROCEDURE CreateSessionToken(
    IN input_kldID VARCHAR(13)
)
BEGIN
    DECLARE token VARCHAR(32);
    
    REPEAT
        SET token := MD5(CONCAT(RAND(), NOW()));
    UNTIL NOT EXISTS(SELECT session_token FROM UserCredentials WHERE session_token = token)
    END REPEAT;

    UPDATE UserCredentials
    SET session_token = token, token_expiration = NOW() + INTERVAL 1 DAY
    WHERE kld_id = input_kldID;
END;

CREATE PROCEDURE DestroySessionToken(
    IN input_token VARCHAR(32)
)
BEGIN
    UPDATE UserCredentials
    SET session_token = NULL, token_expiration = NULL
    WHERE session_token = input_token;
END;