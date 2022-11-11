CREATE TABLE Member(
    Id INT NOT NULL AUTO_INCREMENT,
    FirstName VARCHAR(255) NOT NULL,
    LastName VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    MonthlyNewsletter BOOLEAN NOT NULL,
    BreakingNews BOOLEAN NOT NULL,
    PRIMARY KEY (Id)
);

INSERT INTO Member(FirstName,LastName,Email,MonthlyNewsletter,BreakingNews)
VALUES 
	('Bond','James','007@mi5.gov.uk',1,1),
	('Bourne','Jason','bourne@cia.gov',0,1);