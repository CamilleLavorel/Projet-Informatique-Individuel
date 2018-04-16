drop table if exists commentaire_semestre;
drop table if exists commentaire_stage;
drop table if exists stage;
drop table if exists cours;
drop table if exists semestre;
drop table if exists logement;
drop table if exists utilisateur;
drop table if exists universite;
drop table if exists entreprise;


create table universite (
    id_universite integer not null primary key auto_increment,
    nom_universite varchar(100) not null,
    adresse_universite varchar(100) not null,
    mail_contact varchar(100) not null,
    partenariat tinyint(1) not null,
    logo_universite varchar(100) not null,
    description_universite varchar(2000) not null,
    ville_universite varchar(100) not null,
    pays_universite varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;


create table entreprise (
    id_entreprise integer not null primary key auto_increment,
    nom_entreprise varchar(100) not null,
    adresse_entreprise varchar(100) not null,
    mail_contact varchar(100) not null,
    logo_entreprise varchar(100) not null,
    description_entreprise varchar(2000) not null,
    ville_entreprise varchar(100) not null,
    pays_entreprise varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table logement(
    id_logement integer not null primary key auto_increment,
    adresse_logement varchar(200) not null,
    description_logement varchar(2000) not null,
    ville_logement varchar(100) not null,
    pays_logement varchar(100) not null,
    ressenti_logement varchar(2000) not null,
    contact_logement varchar(50) not null,
    budget_logement varchar(30) not null
)engine=innodb character set utf8 collate utf8_unicode_ci;


create table utilisateur(
    id_utilisateur integer not null primary key auto_increment,
    nom varchar(50) not null,
    prenom varchar(50) not null,
    promo integer(4) not null,
    email varchar(50) not null,
    login varchar(50) not null,
    mot_de_passe varchar(88) not null,
    description_utilisateur varchar(2000) not null,
    salt_utilisateur varchar(23) not null,
    role_utilisateur varchar(50) not null,
    photo varchar(50) not null
)engine=innodb character set utf8 collate utf8_unicode_ci;

create table stage (
    id_stage integer not null primary key auto_increment,
    titre_stage varchar(100) not null,
    duree_stage varchar(100) not null,
    date_debut_stage date not null,
    date_fin_stage date not null,
    sujet varchar(100) not null,
    description_stage varchar(2000) not null,
    ressenti_stage varchar(100) not null,
    date_publication_stage datetime not null,
    annee_ecole varchar(2) not null,
    id_entreprise integer not null,
    id_logement integer null,
    id_utilisateur integer not null,
    ressenti_entreprise varchar(100) not null,
    constraint foreign key(id_entreprise) references entreprise(id_entreprise),
    constraint foreign key(id_logement) references logement(id_logement) on delete SET NULL,
    constraint foreign key(id_utilisateur) references utilisateur(id_utilisateur)
) engine=innodb character set utf8 collate utf8_unicode_ci;


create table semestre (
    id_semestre integer not null primary key auto_increment,
    titre_semestre varchar(100) not null,
    duree_semestre integer(1) not null,
    date_debut_semestre date not null,
    date_fin_semestre date not null,
    description_semestre varchar(2000) not null,
    ressenti_semestre varchar(100) not null,
    photo_semestre varchar(100) not null,
    annee_ecole varchar(2) not null,
    id_universite integer not null,
    id_logement integer null,
    id_utilisateur integer not null,
    date_publication_semestre datetime not null,
    ressenti_universite varchar(100) not null,
    constraint foreign key(id_universite) references universite(id_universite),
    constraint foreign key(id_logement) references logement(id_logement) on delete SET NULL,
    constraint foreign key(id_utilisateur) references utilisateur(id_utilisateur)
) engine=innodb character set utf8 collate utf8_unicode_ci;


create table cours (
    id_cours integer not null primary key auto_increment,
    titre_cours varchar(100) not null,
    description_cours varchar(2000) not null,
    ressenti_cours varchar(2000) not null,
    id_semestre integer not null,
    constraint foreign key(id_semestre) references semestre(id_semestre)
)engine=innodb character set utf8 collate utf8_unicode_ci;



create table commentaire_semestre (
    id_comment_semestre integer not null primary key auto_increment,
    description_comment_semestre varchar(2000) not null,
    date_comment_semestre datetime not null,
    id_utilisateur integer not null,
    id_semestre integer not null,
    constraint foreign key(id_semestre) references semestre(id_semestre),
    constraint foreign key(id_utilisateur) references utilisateur(id_utilisateur)
)engine=innodb character set utf8 collate utf8_unicode_ci;

create table commentaire_stage (
    id_comment_stage integer not null primary key auto_increment,
    description_comment_stage varchar(2000) not null,
    date_comment_stage datetime not null,
    id_utilisateur integer not null,
    id_stage integer not null,
    constraint foreign key(id_stage) references stage(id_stage),
    constraint foreign key(id_utilisateur) references utilisateur(id_utilisateur)
)engine=innodb character set utf8 collate utf8_unicode_ci;


