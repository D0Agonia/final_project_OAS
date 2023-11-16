CREATE EVENT refreshTokens
ON SCHEDULE EVERY 1 DAY
DO
BEGIN
    DELETE FROM LoginTokens
    WHERE token_expiration <= NOW();
END;