CREATE DATABASE OnlineAppointment;

USE OnlineAppointment;

CREATE TABLE AppointmentDocument(
    doc_abbreviation VARCHAR(16) PRIMARY KEY NOT NULL,
    doc_name VARCHAR(64) NOT NULL
);

CREATE TABLE AppointmentType(
    type_id VARCHAR(16) PRIMARY KEY NOT NULL,
    type_name VARCHAR(32) NOT NULL
);

CREATE TABLE AuthenticationID(
    auth_abbreviation VARCHAR(3) PRIMARY KEY NOT NULL,
    auth_name VARCHAR(32) NOT NULL
);

CREATE TABLE UserCredentials(
    kld_id VARCHAR(13) PRIMARY KEY NOT NULL,
    hash_password BINARY(32) NOT NULL,
    salt_password VARCHAR(32) NOT NULL
);

CREATE TABLE GuestCredentials(
    guest_id VARCHAR(11) PRIMARY KEY NOT NULL,
    otp_code VARCHAR(6),
    otp_expiration DATETIME
);

CREATE TABLE TypeDocRelationship(
    relationship_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    type_id VARCHAR(16),
    doc_abbreviation VARCHAR(16),
    FOREIGN KEY(type_id) REFERENCES AppointmentType(type_id),
    FOREIGN KEY(doc_abbreviation) REFERENCES AppointmentDocument(doc_abbreviation)
);

CREATE TABLE ChangePasswordRequest(
    changePassword_code VARCHAR(64) PRIMARY KEY NOT NULL,
    changePassword_expiration DATETIME NOT NULL,
    kld_id VARCHAR(13) NOT NULL,
    FOREIGN KEY(kld_id) REFERENCES UserCredentials(kld_id)
);

CREATE TABLE LoginTokens(
    session_token VARCHAR(32) PRIMARY KEY NOT NULL,
    token_expiration DATETIME NOT NULL,
    kld_id VARCHAR(13),
    guest_id VARCHAR(11),
    FOREIGN KEY(kld_id) REFERENCES UserCredentials(kld_id),
    FOREIGN KEY(guest_id) REFERENCES GuestCredentials(guest_id)
);

CREATE TABLE UserDetails(
    user_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    kld_id VARCHAR(13),
    guest_id VARCHAR(11),
    firstname VARCHAR(32) NOT NULL,
    middlename VARCHAR(32),
    surname VARCHAR(32) NOT NULL,
    email VARCHAR(128) NOT NULL,
    phone_number VARCHAR(15),
    FOREIGN KEY(kld_id) REFERENCES UserCredentials(kld_id),
    FOREIGN KEY(guest_id) REFERENCES GuestCredentials(guest_id) ON DELETE SET NULL
);

CREATE TABLE AppointmentList(
    control_number VARCHAR(13) PRIMARY KEY,
    user_id BIGINT,
    auth_abbreviation VARCHAR(3),
    appointment_datetime DATETIME NOT NULL,
    appointment_location VARCHAR(64) NOT NULL,
    typeDoc_relationship_id BIGINT,
    comment TEXT,
    FOREIGN KEY(user_id) REFERENCES UserDetails(user_id),
    FOREIGN KEY(auth_abbreviation) REFERENCES AuthenticationID(auth_abbreviation),
    FOREIGN KEY(typeDoc_relationship_id) REFERENCES TypeDocRelationship(relationship_id)
);