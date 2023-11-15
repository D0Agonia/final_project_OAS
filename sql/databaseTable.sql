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
    session_token VARCHAR(32),
    token_expiration DATETIME,
    hash_password BINARY(32) NOT NULL,
    salt VARCHAR(32) NOT NULL
);

CREATE TABLE TypeDocRelationship(
    relationship_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    type_id VARCHAR(16),
    doc_abbreviation VARCHAR(16),
    FOREIGN KEY(type_id) REFERENCES AppointmentType(type_id),
    FOREIGN KEY(doc_abbreviation) REFERENCES AppointmentDocument(doc_abbreviation)
);

CREATE TABLE UserDetails(
    user_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    kld_id VARCHAR(13),
    firstname VARCHAR(32) NOT NULL,
    middlename VARCHAR(32),
    surname VARCHAR(32) NOT NULL,
    email VARCHAR(128) NOT NULL,
    FOREIGN KEY(kld_id) REFERENCES UserCredentials(kld_id)
);

CREATE TABLE AppointmentList(
    appointment_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT,
    auth_abbreviation VARCHAR(3),
    appointment_date DATETIME NOT NULL,
    appointment_location VARCHAR(64) NOT NULL,
    typeDoc_relationship_id BIGINT,
    comment TEXT,
    FOREIGN KEY(user_id) REFERENCES UserDetails(user_id),
    FOREIGN KEY(auth_abbreviation) REFERENCES AuthenticationID(auth_abbreviation),
    FOREIGN KEY(typeDoc_relationship_id) REFERENCES TypeDocRelationship(relationship_id)
);