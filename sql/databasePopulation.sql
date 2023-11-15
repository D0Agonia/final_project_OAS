INSERT INTO AppointmentDocument(doc_abbreviation, doc_name) VALUES
    ('NONE', 'No Document Requested'),
    ('TRR', 'Transcript of Records'),
    ('TRC', 'Transfer Credentials'),
    ('COG', 'Certificate of Grades'),
    ('COE', 'Certificate of Enrollment')
;

INSERT INTO AppointmentType(type_id, type_name) VALUES
    ('INFOCEN', 'Information Center'),
    ('DOCREQ', 'Request of Document')
;

INSERT INTO AuthenticationID(auth_abbreviation, auth_name) VALUES
    ('SCH', 'School ID'),
    ('GOV', 'Government-Issued ID'),
    ('PVT', 'Private ID')
;

INSERT INTO TypeDocRelationship(type_id, doc_abbreviation) VALUES
    ('INFOCEN', 'NONE'),
    ('DOCREQ', 'TRR'),
    ('DOCREQ', 'TRC'),
    ('DOCREQ', 'COG'),
    ('DOCREQ', 'COE')
;

INSERT INTO UserDetails(kld_id, course_id, year_name, firstname, middlename, surname, email, phone_number) VALUES
    ('KLD-22-000247', 'Kenji', '', 'Gabunada', 'gabunada.kenji.kld@gmail.com')
;

INSERT INTO AppointmentList(user_id, auth_abbreviation, appointment_date, appointment_location, typeDoc_relationship_id, comment) VALUES
    (1, 'SCH', '2023-10-12 08:00:00', 'KLD Building No. 1', 3, 'Get grades for 2nd Yr. 1st Sem.')
;



SELECT insertCredentials('KLD-22-000247', 'password') AS STATUS;