# test-web-service
Symfony project using csv for an api (just get)

## 1 Implémentation

### Pré-requis
Pour installer ce projet il vous faudra un environnement composé des technologies suivantes :
- PHP >7.x
- Composer (getcomposer.org)
- un serveur MySQL

### Point de départ

Commencez par dézipper le fichier zip dans le dossier www de votre plateforme de développement

Placer vous dans le dossier :

`cd test-web-service`

Installez les dépendances du projet

`composer install`

Videz le cache

`php bin/console cache:clear`

### Configuration Apache

Le fichier `.htaccess` du dossier `public`configure l'accès de l'application à l'url

### URL

Pour l'exigence 2 voici l'url à partir de laquelle chaque utilisateur est accessible :

`localhost/test-web-service/api/v1/users/:id` [accès](localhost/test-web-service/api/v1/users/1)

Vous pouvez passer en paramètre de l'url l'id de l'utilisateur demandé en remplaçant `:id` par l'id de l'utilisateur (1, 2, 3, etc.).

Pour l'exigence 2 voici l'url à partir de laquelle les utilisateurs sont accessibles :

`localhost/test-web-service/api/v1/users` [accès](localhost/test-web-service/api/v1/users)

## 2 Réflexion

J'ai choisi d'utiliser le framework Symfony afin d'avoir rapidement une architecture de travail.

Ma première démarche a été de créer une entité `User` pour formater et sécuriser les données reçues.

L'ApiController parcourt le fichier `csv` et formate chaque ligne selon l'entité `User`.

L'adresse de l'api `/api/v1/users` indique premièrement que nous allons accéder à une api, deuxièment la version de l'api qui sera appelée et troisièmement le type de contenu qui est concerné.

Les format reçu est du type `json`. L'api renvoie un statut `error` avec un message lorsqu'une donnée n'est pas accessible.

### 3 Propositions

Voici quelques pistes pour améliorer l'application :

- tester et identifier les séparateurs csv

- valider que chaque ligne du csv correspond bien au type d'entité que l'on souhaite obtenir

- donner une limite de taille au fichier csv

- ajouter des contraintes d'accès à l'api via une clé sécurisé (avec token) qui limitera par exemple l'accès aux données dans le temps (fréquences des requêtes, etc.)

- ajouter des options de requêtes pour par exemple permettre à l'utilisateur de choisir le format de fichier demandé (XML ou JSON) ou choisir la quantité de données (tous les 50 premiers utilisateurs)

- s'appuyer une base de données plutôt qu'à un fichier csv pour stocker les données, la recherche sera plus puissante



