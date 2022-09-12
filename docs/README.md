Test
#------------------------------------------------------------

# Script MySQL.

#------------------------------------------------------------

#------------------------------------------------------------

# Table: TiersLibStatuts

#------------------------------------------------------------

CREATE TABLE TiersLibStatuts(
id Int Auto_increment NOT NULL ,<br>
statutJuridique Varchar (150) NOT NULL<br>
,CONSTRAINT TiersLibStatuts_PK PRIMARY KEY (id)<br>
)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: TiersStructures

#------------------------------------------------------------

CREATE TABLE TiersStructures(
id Int Auto_increment NOT NULL ,
nomEntite Varchar (150) NOT NULL ,
raisonSociale Varchar (150) NOT NULL ,
Acronyme Varchar (150) NOT NULL ,
logo Varchar (150) NOT NULL ,
CreatedAt Datetime NOT NULL ,
updatedAt Datetime NOT NULL ,
id_TiersLibStatuts Int
,CONSTRAINT TiersStructures_PK PRIMARY KEY (id)

	,CONSTRAINT TiersStructures_TiersLibStatuts_FK FOREIGN KEY (id_TiersLibStatuts) REFERENCES TiersLibStatuts(id)

)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: TiersLibDomaineActivite

#------------------------------------------------------------

CREATE TABLE TiersLibDomaineActivite(
id Int Auto_increment NOT NULL ,
domaineActivites Varchar (150) NOT NULL
,CONSTRAINT TiersLibDomaineActivite_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: TiersLibCommunication

#------------------------------------------------------------

CREATE TABLE TiersLibCommunication(
id Int Auto_increment NOT NULL ,
type Varchar (150) NOT NULL ,
libelle Varchar (150) NOT NULL ,
icon Varchar (150) NOT NULL
,CONSTRAINT TiersLibCommunication_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: TiersIdentification

#------------------------------------------------------------

CREATE TABLE TiersIdentification(
id Int Auto_increment NOT NULL ,
content Varchar (150) NOT NULL ,
createdAt Datetime NOT NULL ,
updatedAt Datetime NOT NULL ,
id_TiersStructures Int
,CONSTRAINT TiersIdentification_PK PRIMARY KEY (id)

	,CONSTRAINT TiersIdentification_TiersStructures_FK FOREIGN KEY (id_TiersStructures) REFERENCES TiersStructures(id)

)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: TiersLibIdentification

#------------------------------------------------------------

CREATE TABLE TiersLibIdentification(
id Int Auto_increment NOT NULL ,
identification Varchar (150) NOT NULL ,
id_TiersIdentification Int
,CONSTRAINT TiersLibIdentification_PK PRIMARY KEY (id)

	,CONSTRAINT TiersLibIdentification_TiersIdentification_FK FOREIGN KEY (id_TiersIdentification) REFERENCES TiersIdentification(id)

)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: TiersAdresses

#------------------------------------------------------------

CREATE TABLE TiersAdresses(
id Int Auto_increment NOT NULL ,
title Varchar (150) NOT NULL ,
default Bool NOT NULL ,
adresse Varchar (150) NOT NULL ,
codePostale Int NOT NULL ,
ville Varchar (150) NOT NULL ,
lgt Float NOT NULL ,
lat Float NOT NULL ,
createdAt Datetime NOT NULL ,
updatedAt Datetime NOT NULL ,
id_TiersStructures Int
,CONSTRAINT TiersAdresses_PK PRIMARY KEY (id)

	,CONSTRAINT TiersAdresses_TiersStructures_FK FOREIGN KEY (id_TiersStructures) REFERENCES TiersStructures(id)

)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: TiersLibDocuaments

#------------------------------------------------------------

CREATE TABLE TiersLibDocuaments(
id Int Auto_increment NOT NULL ,
libelle Varchar (150) NOT NULL ,
obligatoire Bool NOT NULL
,CONSTRAINT TiersLibDocuaments_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: User

#------------------------------------------------------------

CREATE TABLE User(
id Int Auto_increment NOT NULL ,
email Varchar (150) NOT NULL ,
password Varchar (150) NOT NULL ,
isverifed Bool NOT NULL ,
etat Bool NOT NULL ,
createdAt Datetime NOT NULL ,
updatedAt Datetime NOT NULL
,CONSTRAINT User_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: TiersLibCivilite

#------------------------------------------------------------

CREATE TABLE TiersLibCivilite(
id Int Auto_increment NOT NULL ,
libelle Varchar (150) NOT NULL
,CONSTRAINT TiersLibCivilite_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: TiersProfil

#------------------------------------------------------------

CREATE TABLE TiersProfil(
id Int Auto_increment NOT NULL ,
nom Varchar (150) NOT NULL ,
prenom Varchar (150) NOT NULL ,
email Varchar (150) NOT NULL ,
avatar Varchar (150) NOT NULL ,
naissanceAt Date NOT NULL ,
createdAt Datetime NOT NULL ,
updatedAt Datetime NOT NULL ,
id_User Int NOT NULL ,
id_TiersLibCivilite Int
,CONSTRAINT TiersProfil_PK PRIMARY KEY (id)

	,CONSTRAINT TiersProfil_User_FK FOREIGN KEY (id_User) REFERENCES User(id)
	,CONSTRAINT TiersProfil_TiersLibCivilite0_FK FOREIGN KEY (id_TiersLibCivilite) REFERENCES TiersLibCivilite(id)

)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: TiersCommunication

#------------------------------------------------------------

CREATE TABLE TiersCommunication(
id Int Auto_increment NOT NULL ,
content Varchar (150) NOT NULL ,
numero Int NOT NULL ,
libelle Varchar (150) NOT NULL ,
createdAt Datetime NOT NULL ,
updatedAt Datetime NOT NULL ,
id_TiersStructures Int ,
id_TiersLibCommunication Int ,
id_TiersProfil Int
,CONSTRAINT TiersCommunication_PK PRIMARY KEY (id)

	,CONSTRAINT TiersCommunication_TiersStructures_FK FOREIGN KEY (id_TiersStructures) REFERENCES TiersStructures(id)
	,CONSTRAINT TiersCommunication_TiersLibCommunication0_FK FOREIGN KEY (id_TiersLibCommunication) REFERENCES TiersLibCommunication(id)
	,CONSTRAINT TiersCommunication_TiersProfil1_FK FOREIGN KEY (id_TiersProfil) REFERENCES TiersProfil(id)

)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: TiersDocuments

#------------------------------------------------------------

CREATE TABLE TiersDocuments(
id Int Auto_increment NOT NULL ,
libelle Varchar (150) NOT NULL ,
fichier Text NOT NULL ,
createdAt Datetime NOT NULL ,
updatedAt Datetime NOT NULL ,
id_TiersStructures Int ,
id_TiersLibDocuaments Int ,
id_TiersProfil Int
,CONSTRAINT TiersDocuments_PK PRIMARY KEY (id)

	,CONSTRAINT TiersDocuments_TiersStructures_FK FOREIGN KEY (id_TiersStructures) REFERENCES TiersStructures(id)
	,CONSTRAINT TiersDocuments_TiersLibDocuaments0_FK FOREIGN KEY (id_TiersLibDocuaments) REFERENCES TiersLibDocuaments(id)
	,CONSTRAINT TiersDocuments_TiersProfil1_FK FOREIGN KEY (id_TiersProfil) REFERENCES TiersProfil(id)

)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: TiersProfilPoste

#------------------------------------------------------------

CREATE TABLE TiersProfilPoste(
id Int Auto_increment NOT NULL ,
libelle Varchar (150) NOT NULL
,CONSTRAINT TiersProfilPoste_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: Tiers_Types

#------------------------------------------------------------

CREATE TABLE Tiers_Types(
id Int Auto_increment NOT NULL ,
libelle Varchar (50) NOT NULL ,
id_TiersStructures Int
,CONSTRAINT Tiers_Types_PK PRIMARY KEY (id)

	,CONSTRAINT Tiers_Types_TiersStructures_FK FOREIGN KEY (id_TiersStructures) REFERENCES TiersStructures(id)

)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: Disposer Activités

#------------------------------------------------------------

CREATE TABLE Disposer_Activites(
id Int NOT NULL ,
id_TiersStructures Int NOT NULL
,CONSTRAINT Disposer_Activites_PK PRIMARY KEY (id,id_TiersStructures)

	,CONSTRAINT Disposer_Activites_TiersLibDomaineActivite_FK FOREIGN KEY (id) REFERENCES TiersLibDomaineActivite(id)
	,CONSTRAINT Disposer_Activites_TiersStructures0_FK FOREIGN KEY (id_TiersStructures) REFERENCES TiersStructures(id)

)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: Disposer Contact

#------------------------------------------------------------

CREATE TABLE Disposer_Contact(
id Int NOT NULL ,
id_TiersStructures Int NOT NULL
,CONSTRAINT Disposer_Contact_PK PRIMARY KEY (id,id_TiersStructures)

	,CONSTRAINT Disposer_Contact_TiersProfil_FK FOREIGN KEY (id) REFERENCES TiersProfil(id)
	,CONSTRAINT Disposer_Contact_TiersStructures0_FK FOREIGN KEY (id_TiersStructures) REFERENCES TiersStructures(id)

)ENGINE=InnoDB;

#------------------------------------------------------------

# Table: Disposer Adresse Profil Pro

#------------------------------------------------------------

CREATE TABLE Disposer_Adresse_Profil_Pro(
id Int NOT NULL ,
id_TiersProfil Int NOT NULL
,CONSTRAINT Disposer_Adresse_Profil_Pro_PK PRIMARY KEY (id,id_TiersProfil)

	,CONSTRAINT Disposer_Adresse_Profil_Pro_TiersAdresses_FK FOREIGN KEY (id) REFERENCES TiersAdresses(id)
	,CONSTRAINT Disposer_Adresse_Profil_Pro_TiersProfil0_FK FOREIGN KEY (id_TiersProfil) REFERENCES TiersProfil(id)

)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: occupe poste
#------------------------------------------------------------

CREATE TABLE occupe_poste(
id Int NOT NULL ,
id_TiersProfil Int NOT NULL
,CONSTRAINT occupe_poste_PK PRIMARY KEY (id,id_TiersProfil)

	,CONSTRAINT occupe_poste_TiersProfilPoste_FK FOREIGN KEY (id) REFERENCES TiersProfilPoste(id)
	,CONSTRAINT occupe_poste_TiersProfil0_FK FOREIGN KEY (id_TiersProfil) REFERENCES TiersProfil(id)

)ENGINE=InnoDB;

