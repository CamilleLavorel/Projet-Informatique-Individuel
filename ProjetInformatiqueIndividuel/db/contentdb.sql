

/* UNIVERSITES */
insert into universite values
(1,'Université du Quebec à Montréal','405 Rue Sainte-Catherine Est, Montréal, QC H2L 2C4, Canada','registrariat@uqam.ca',true,'UQAM-logo.jpg',"L'Université du Québec à Montréal (UQAM) offre plus de 300 programmes d'études en plein cœur du centre-ville.Dynamique et innovatrice, l'UQAM connaît un rayonnement international dans de nombreux secteurs de recherche et de création.",'Montréal','Canada');
insert into universite values
(2,'Université de Laval','2325, rue de l''Université Québec (Québec) G1V 0A6','info@ulaval.ca',true,'logo-ulaval.jpg',"L'Université Laval, située dans la ville de Québec au Canada, est reconnue à l'international pour l'excellence de sa formation aux 3 cycles et de sa recherche",'Quebec','Canada');
insert into universite values
(3,'Université catholique de Louvain','1, Place de l''Université B-1348 Louvain-la-Neuve (Belgique)','info@ulouvain.fr',true,'UCL-logo.jpg',"L’université accueille plus de 30 000 étudiants, répartis sur sept sites, à Bruxelles et en Wallonie. Son site principal se trouve à Louvain-la-Neuve, une ville piétonne.Notre Université forme des étudiants dans toutes les disciplines, du bachelier au doctorat, et propose de nombreux programmes de formation continue. Elle est aussi pionnière dans la création des MOOCs (Massive Open Online Courses): elle est la première université francophone en Europe à proposer des cours en ligne sur la plate-forme Edx  (16 cours disponibles en 2016).",' Louvain-la-Neuve','Belgique');
insert into universite values
(4,'RMIT University','124 La Trobe St, Melbourne VIC 3000, Australie','info@rmit.fr',true,'RMIT-logo.jpg',"L'Institut royal de technologie de Melbourne ou Université RMIT est une université australienne publique de Melbourne dans l'état de Victoria. ",'Melbourne','Australie');


/* ENTREPRISES */
insert into entreprise values
(1,'Thales Canada','1405, boul. du Parc-Technologique Québec, Québec G1P 4P5 Canada','info@thales.ca','thales-logo.png',"Thales Canada est une importante société établie au Canada depuis 1972 et qui a développé une solide réputation dans le secteur des systèmes électroniques. Thales Canada emploie 1800 professionnels canadiens et investit 18 % de son chiffre d’affaires dans la Recherche et le Développement (R & D).",'Quebec','Canada');
insert into entreprise values
(2,'Legrand','Estrada da Alagoa 96, 2775-716 Carcavelos Cascais, Portugal','info@legrand.fr','logo-legrand.jpg',"Le groupe Legrand est le spécialiste mondial des produits et systèmes pour infrastructures électriques et numériques du bâtiment.",'Carcavelos','Portugal');
insert into entreprise values
(3,'Ubisoft Montreal','5505 Boul St-Laurent #2000, Montréal, QC H2T 1S6, Canada','info@ubisoft.ca','Ubisoft-logo.png',"Ubisoft est une entreprise française de développement, d'édition et de distribution de jeux vidéo, créée en mars 1986 par les cinq frères Guillemot, originaires de Carentoir en Bretagne.",'Montréal','Canada');


/* LOGEMENTS */
insert into logement values
(1,'270 Rue Saint-Antoine O, Montréal, QC H2Y 0A3, Canada','Logement bien situé au coeur de la ville.','Montreal','Canada',"Appartement cosy, très bien située j'ai adoré vivre dans cet appartement",'logementmontreal@orange.fr','680 euros/mois');
insert into logement values
(2,'4871 Boul St-Laurent, Montréal, QC H2T 1R6, Canada','Logement agréable bien situé au coeur de la ville.','Montreal','Canada',"Chambre chez l'habitant, jai été très bien accueilli",'logement@montreal.fr','500 euros/mois');
insert into logement values
(3,'1348 Ottignies-Louvain-la-Neuve, Belgique','Logement sympa avec balcon près des transports.','Louvain-la-Neuve','Belgique',"Quartier sympa, logement proche de toutes commodités c'était pratique",'logement@louvain.fr','600 euros/mois');
insert into logement values
(4,'R. Gonçalves Crespo 75A, 2775-586 Carcavelos, Portugal',"Logement bien situé pour aller en stage, à deux pas de l'entreprise.",'Carcavelos','Portugal','Je me suis sentie comme chez moi','logement@pekin.fr','700 euros/mois');
insert into logement values
(5,'330 De La Couronne, Ville de Québec, QC G1K 6E6, Canada','Logement bien situé proche de toutes commodités.','Quebec','Canada',"J'ai beaucoup aimé ce logement, je le recommande",'logement@quebec.fr','600 euros/mois');
insert into logement values
(6,'1220 Place George V O, Ville de Québec, QC G1R 5B8, Canada','Logement bien situé au coeur de la ville.','Quebec','Canada',"Ce logement n'était pas top, le quartier ne m'a pas du tout plu",'logementquebec@quebec.fr','600 euros/mois');
insert into logement values
(7,'300 Spencer St, Melbourne VIC 3000, Australie','Logement avec vue sur mer proche du centre ville à vélo','Melbourne','Australie','Ce logement était génial, la vue était parfaite ','logement@australie.fr','800 euros/mois');



/* UTILISATEURS */
insert into utilisateur values
(1,'Lavorel','Camille',2019,'camille.lavorel@ensc.fr','clavorel001','$2y$13$3HEyoq789DyOknMZWTPkFONwlL0f0Riv1/1AznUtXOQLSX9hleA..',"Actuellement étudiante en 2ème année à l'ENSC, j'adore voyage et découvrir de nouvelles choses",'58e6965219da7db171662b5','ROLE_ADMIN','PhotoCamilleLavorel.JPG');
insert into utilisateur values
(2,'Giraudat','Clara',2019,'clara.giraudat@ensc.fr','cgiraudat','$2y$13$vpEErNI4lpifLHTASNZdmudajCNZgNgda09bqb7sFDTn/SLwVLdFq',"Actuellement étudiante en 2ème année à l'ENSC.",'8b69ee2a65c974fc08f6cd4','ROLE_USER','profil-standard.png');
insert into utilisateur values
(3,'Larrere','Mathilde',2019,'mathilde.larrere@ensc.fr','mlarrere','$2y$13$Ep.vct.eVnZ2pYh8rl9TR.Xz3Z//8BpZklnm9ox7MRGHJbpkpNY06',"Actuellement étudiante en 2ème année à l'ENSC",'0dcf3e9e7c1d953da9c2827','ROLE_USER','profil-standard.png');
insert into utilisateur values
(4,'Balssa','Floriane',2019,'floriane.balsa@ensc.fr','fbalssa','$2y$13$zHsybyUi8zGexscnZWbPbupfAVjCeiVdj4fVpMuOgoDywhYJu8jGi',"Actuellement étudiante en 2ème année à l'ENSC, j'ai passé une année d'études au Canada.",'c200c73cbe5d7fc5fe55070','ROLE_USER','profil-standard.png');


/* STAGES */
insert into stage values
(1,'Stage au Canada','3 mois',"2017-05-14","2017-08-17","Amélioration de l'ergonomie dun site web","Pendant le stage, j'ai préparé et réalisé des tests utilisateurs afin d'améliorer l'ergonomie d'un site internet.","Ce stage s'est très bien passé, j'ai fait des choses enrichissante et développé mes compétences en informatique","2018-04-16",'2A',1,6,1,"L'entreprise etait très accueillante, je me suis vite sentie a l'aise.");
insert into stage values
(2,'Stage au pays des caribous','6 mois',"2018-01-10","2017-07-14",'UX design : jeux vidéos',"J'ai mis en place les méthodes de conception centrée utilisateur","Ce stage était interessant mais très stressant, par conséquent je suis un peu mitigée.","2018-04-10",'3A',3,2,2,"Il y avait beaucoup de pression au sein de cette entreprise, je ne me suis pas sentie très bien au sein de celle-ci.");
insert into stage values
(3,'Stage au Portugal','6 mois',"2017-01-03","2017-08-04",'Etude ergonomique dans le domaine résidentiel',"Le stage consistait à déterminer des préconisations ergonomiques pour des interfaces permettant de gérer l'énergie au sein d'une habitation","Jai beaucoup apprécié ce stage, j'ai fait des choses très enrichissantes durant celui-ci","2018-04-15",'3A',2,4,1,"L'entreprise était un grand groupe, cependant l'ambiance était tout de même conviviale.");

/* SEMESTRES */
insert into semestre values
(1,'Semestre au Canada',1,"2017-01-06","2017-08-06",'Lors de ce semestre jai decouvert une nouvelle culture',"Jai beaucoup apprécie ce stage, j'ai fait des choses tres enrichissante",'photo-montreal.jpg','2A',1,1,1,"2018-03-21","L'université était très grande, j'étais un peu perdue au début mais je me suis vite habituée.");
insert into semestre values
(2,'Semestre en Belgique',1,"2017-01-10","2017-07-14",'Au cours du semestre jai etudie les facteurs humains, linformatique et la cognitique ',"Jai beaucoup apprécié ce semestre d'études à létranger, j'ai étudié de nombreuses choses très enrichissantes",'photo-belgique.jpg','3A',3,3,2,"2018-03-22","J'ai beaucoup apprecié l'université, les professeurs étaient à l'écoute et passionnés par leur travail.");
insert into semestre values
(3,'Année au Quebec',2,"2017-07-03","2018-08-04","Cette année a été enrichissante, j'ai suivi des cours de cognitique et de facteurs humains ","Cette année à l'étranger est passée trop vite, j'ai fait des choses très intéressantes et découvert de magnifiques endroits",'photo-quebec.jpg','2A',2,5,4,"2018-04-25","L'université était très bien située, je me suis vite sentie a l'aise pendant les cours.");
insert into semestre values
(4,"Semestre à l'autre bout du monde",1,"2017-09-03","2017-12-19","Lors de ce semestre en Australie, j'ai etudié l'IA et la cognitique dans un cadre idyllique.","Ce semestre à Melbourne était vraiment génial, j'ai fait de superbes rencontres et les cours étaient enrichissants",'photo-melbourne.jpg','2A',4,7,3,"2018-04-25","L'université etait tres bien située sur l'île, le cadre de travail etait juste top.");

/* COURS */
insert into cours values
(1,"Informatique","Comprendre le concept de base de données. Comprendre et concevoir des bases de données.","Cours très interessant",1);
insert into cours values
(2,"Facteurs Humains","L’objectif de l’enseignement de ce cours est de former et de sensibiliser les futurs ingénieurs en cognitique aux concepts, aux outils et méthodes de la prise en compte du facteur humain, de l’utilisabilité et de l’UX.","Les cours étaient longs et pas très approfondis",1);
insert into cours values
(3,"Gestion de projet","L’enseignement aborde de façon théorique puis active (1 appel d’offre en concurrence) les activités de l’ingénieur, les méthodes et les outils et principes mis en oeuvre dans la gestion de projet et l’ingénierie des produits.","Cours particulièrement agréable à suivre.",1);
insert into cours values
(4,"Informatique","Apprentissage des bases de la programmation web statique.","Cours où j'ai appris énormément de choses",2);
insert into cours values
(5,"Interface Homme-Machine","À travers les méthodes et les pratiques de conception des interfaces entre l’homme et les systèmes impliqués dans son environnement de travail, il s’agit de porter un regard critique et constructif sur les exigences liées aux postes de travail et aux outils manipulés.","Ce cours était très bien, rien à dire de spécial.",2);
insert into cours values
(6,"Cognitiques","L'objectif de ce cours est d’appréhender la problématique de la cognitique, de connaître les principales fonctions cognitives, leurs modèles et leur évaluation.","Le professeur n'était pas passionnant ce qui ne rendait pas le cours génial.",3);
insert into cours values
(7,"Informatique","Développement de solutions logicielles simples et d’un premier projet informatique.","Cours qui demande beaucoup de travail.",3);
insert into cours values
(8,"Intelligence Artificielle","Initiation aux problématiques et aux méthodes et algorithmes utilisés en intelligence artificielle, de la logique et la résolution générale de problèmes à la classification automatique, bases de la robotique. ","Cours avec des notions difficiles à comprendre mais très interessant.",4);
insert into cours values
(9,"Cognitique","Lors de ce cours, on aborde les méthodologies de la psychologie cognitive en lien avec l’évaluation de l’état cognitif de l’utilisateur.","Cours qui était dans l'ensemble agréable à suivre et enrichissant.",4);
insert into cours values
(10,"Informatique","Acquisition des notions de base d’algorithmique et de programmation procédurale.","Cours sympa mais sans plus.",4);


/*COMMENTAIRES STAGE */
insert into commentaire_stage values
(1,"Comment as-tu trouvé le logement ?","2018-04-13 15:26:00",2,1);
insert into commentaire_stage values
(2,"Je l'ai trouvé en surfant sur internet, je suis tombée sur le site : www.logementQuebecCity.com . Il y a pleins d'appartements disponibles sur ce site.","2018-04-14 09:15:00",1,1);
insert into commentaire_stage values
(3,"As-tu mis beaucoup de temps pour trouver un logement ?","2018-04-10 18:30:00",1,2);

/*COMMENTAIRES SEMESTRE*/
insert into commentaire_semestre values
(1,"En informatique, avez-vous abordé la programmation orientée objet ?","2018-04-10 17:45:00",4,2);
insert into commentaire_semestre values
(2,"Non, nous avons seulement fait de la programmation web.","2018-04-11 10:00:00",2,2);
insert into commentaire_semestre values
(3,"Quelles démarches as-tu effectué une fois sur place ?","2018-04-16 13:08:00",1,1);
insert into commentaire_semestre values
(4,"Comment as-tu vécu tes premiers jours en Australie?","2018-04-15 16:56:00",2,4);