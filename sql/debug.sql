-- View queries to check when installing/debugging the database
USE OnlineAppointment;

SHOW TABLES;
SELECT * FROM AppointmentDocument;
SELECT * FROM AppointmentType;
SELECT * FROM AuthenticationID;
SELECT * FROM UserCredentials;
SELECT * FROM GuestCredentials;
SELECT * FROM TypeDocRelationship;
SELECT * FROM ChangePasswordRequest;
SELECT * FROM LoginTokens;
SELECT * FROM UserDetails;
SELECT * FROM AppointmentList;

SELECT *FROM mysql.user;
SELECT *FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = 'OnlineAppointment';
SHOW EVENTS;
SELECT HEX(RANDOM_BYTES(16)) AS STATUS;

/* Drop/Revoke queries for testing
 * REMINDER: Re-execute guest EXECUTE privileges if deleting functions
 */
REVOKE EXECUTE ON *.* FROM guest;
DROP USER guest;

DROP FUNCTION IF EXISTS insertCredentials;
DROP FUNCTION IF EXISTS insertDetails;
DROP FUNCTION IF EXISTS insertGuest;
DROP FUNCTION IF EXISTS verifyLogin;
DROP FUNCTION IF EXISTS verifyToken;
DROP FUNCTION IF EXISTS searchKLDID;
DROP FUNCTION IF EXISTS searchUserId;
DROP FUNCTION IF EXISTS searchToken;
DROP PROCEDURE IF EXISTS CreateChangePasswordCode;
DROP PROCEDURE IF EXISTS CreateGuestSessionToken;
DROP PROCEDURE IF EXISTS CreateUserSessionToken;
DROP PROCEDURE IF EXISTS DestroyChangePasswordCode;
DROP PROCEDURE IF EXISTS DestroySessionToken;

DROP TABLE IF EXISTS AppointmentList;
DROP TABLE IF EXISTS UserDetails;
DROP TABLE IF EXISTS LoginTokens;
DROP TABLE IF EXISTS ChangePasswordRequest;
DROP TABLE IF EXISTS TypeDocRelationship;
DROP TABLE IF EXISTS GuestCredentials;
DROP TABLE IF EXISTS UserCredentials;
DROP TABLE IF EXISTS AuthenticationID;
DROP TABLE IF EXISTS AppointmentType;
DROP TABLE IF EXISTS AppointmentDocument;