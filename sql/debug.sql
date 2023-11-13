-- View queries to check when installing/debugging the database
USE OnlineAppointment;

SELECT *FROM StudentCourse;
SELECT *FROM StudentYear;
SELECT *FROM AppointmentDocument;
SELECT *FROM AppointmentType;
SELECT *FROM AuthenticationID;
SELECT *FROM UserCredentials;
SELECT *FROM TypeDocRelationship;
SELECT *FROM UserDetails;
SELECT *FROM AppointmentList;

SELECT *FROM mysql.user;
SELECT *FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = 'OnlineAppointment';
SHOW EVENTS;
SELECT MD5(CONCAT(RAND(), NOW())) AS STATUS;

/* Drop/Revoke queries for testing
 * REMINDER: Re-execute guest EXECUTE privileges if deleting functions
 */
REVOKE EXECUTE ON *.* FROM guest;
DROP USER guest;

DROP FUNCTION insertCredentials;
DROP FUNCTION insertDetails;
DROP FUNCTION verifyLogin;
DROP FUNCTION verifyToken;
DROP FUNCTION searchKLDID;
DROP FUNCTION searchUserId;
DROP FUNCTION searchToken
DROP PROCEDURE CreateSessionToken;
DROP PROCEDURE DestroySessionToken;

DROP TABLE AppointmentList;
DROP TABLE UserDetails;
DROP TABLE TypeDocRelationship;
DROP TABLE UserCredentials;
DROP TABLE AuthenticationID;
DROP TABLE AppointmentType;
DROP TABLE AppointmentDocument;
DROP TABLE StudentYear;
DROP TABLE StudentCourse;