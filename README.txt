////////////////////////////
/////      README      /////
////////////////////////////

La version 7.0 ou supérieure est requise.

Il faut vérifier qu'il y a bien un vhos apache nommé "Testubes" qui pointe vers la racine du projet. 
Le driver php MongoDb doit être installé.
Le service "MongoDb" doit être activé. 

Pour importer la base de données mongoDB il faut taper les commandes suivantes (a la racine du projet):
	mongoimport --db testubes --collection categories --file testubes_mongodb.categories.json
	mongoimport --db testubes --collection problems --file testubes_mongodb.problems.json
	mongoimport --db testubes --collection questions --file testubes_mongodb.questions.json

Pour importer la base de données MySQL il faut exécuter le script sql dans le fichier "testubes_mysql.sql"

Pour fonctionner il faut également éditer le fichier sous "include/config.php" en vérifiant que les valeurs 
renseignées sont correctes.