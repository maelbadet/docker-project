#  <p align =center>Mon premier projet docker</p>
## <font color='greeen'>Introduction au projet</font>
Le but de ce projet est de créer une petite application e-commerce pour acheter de la moutarde en ligne.

À noter que je n'ai pas eu le temps de finir la partie fonctionnelle de la partie commande de l'application e-commerce, 
mais voici ce que j'ai fait :

## <font color='greeen'>Côté frontend</font>
- Création d'un loader car les requêtes vers la base de données sont très lentes
- Création de la page d'accueil
- Création de la page "Mon compte"
- Création de la page de listing des produits
- Création de la page de fiche produit

## <font color='greeen'>Côté backend</font>
- Création des différentes entités Symfony pour correspondre à la base de données
- Création des différentes routes API
- Création des requêtes personnalisées avec Symfony dans les repositories

<font color="red">Attention, j'ai envoyé le fichier .env pour ne pas avoir à le retaper. C'est fait exprès, 
mais normalement, je ne l'envoie pas !</font>

## <font color='greeen'>Technologies utilisées</font>
- `Symfony` pour la partie backend, car c'est la technologie avec laquelle je suis le plus familier
- `react` pour la partie front, pour me lancer un petit défi sur une partie front que je ne connais pas trop.
- `docker` pour créer mes conteneurs de base de données, serveur Apache et React.

## <font color='greeen'>Ma base de données</font>
Toutes les tables de ma base de données sont mises dans le dossier backend sous le nom de `setup.sql`

## <font color='greeen'>Symfony</font>
Pour la partie backend, j'ai décidé d'utiliser Symfony pour créer mon API car c'est le framework avec lequel je 
suis le plus familier. C'est un framework français open-source avec une documentation très claire.

[liens vers la documentation symfony](https://symfony.com/doc/current/index.html)

## <font color='greeen'>Lancement du projet </font>
Lors du premier lancement du projet, il faudra exécuter la commande `docker-compose up --build` pour installer les 
différentes dépendances liées aux frameworks <font color="red">React</font> et <font color="red">Symfony</font>.

Une fois le projet initialisé une première fois, il suffira de faire uniquement `docker-compose up` pour démarrer 
uniquement les conteneurs sans avoir à tout réinstaller.

## <font color='greeen'>Projet lancé</font>
Une fois le projet lancé, l'accès se fait via deux URLs : 
- http://localhost:3000 pour la partie frontend
- http://localhost:8000 pour la partie backend

### <font color='reed'>Jouer avec l'application côté front</font>

Côté front, pour jouer avec l'application, vous avez un header en haut qui vous redirige vers chaque 
page de l'application.

### <font color='reed'>Jouer avec l'application côté back</font>
Pour tester les routes côté backend, voici une liste de routes à tester avec Postman en POST ou GET :
#### partie utilisateur : 
- http://localhost:8000/api/register, méthode : <font color="darkgreen">[POST]</font>
- http://localhost:8000/api/login, méthode : <font color="darkgreen">[POST]</font>
- http://localhost:8000/api/getInfo/{id}, méthode : <font color="darkgreen">[GET]</font>
- http://localhost:8000/api/updateInfo, méthode : <font color="darkgreen">[POST]</font>
#### partie produit :
- http://localhost:8000/api/product, méthode : <font color="darkgreen">[GET]</font>
- http://localhost:8000/api/product/{id}, méthode : <font color="darkgreen">[GET]</font>
- http://localhost:8000/api/product-home, méthode : <font color="darkgreen">[GET]</font>
#### partie favoris :
- http://localhost:8000/api/addFavorite, méthode : <font color="darkgreen">[POST]</font>
- http://localhost:8000/api/removeFavorite, méthode : <font color="darkgreen">[POST]</font>

## <font color='greeen'>Problèmes rencontrés :</font>

###  <font color='reed'>pour le frontend :</font>
Sur le frontend, étant donné que c'est une technologie que je n'utilise pas souvent, les principaux problèmes 
rencontrés sont surtout liés à la syntaxe de React. Mais il y a eu aussi :
- Le fait de devoir faire un `docker-compose down` puis `docker-compose up` à chaque fois que je voulais voir mes modifications
- Le fait de devoir faire un `return` à chaque fois dans lequel je passe le HTML, ce qui n'est pas mon habitude
- Le temps de réponse moyen de 23 secondes entre l'API et le frontend, ce qui n'est pas du tout optimisé


### <font color='reed'>pour le backend :</font>
Le plus gros problème que j'ai rencontré a été la mise en place du projet, avec plus d'une demi-journée passée 
sur un problème lors du démarrage de mon serveur Symfony.
- Problème majeur : la non-communication vers l'extérieur du conteneur, nécessitant l'utilisation de 
`--allow-all-ip` dans la commande de mon Dockerfile
- Deuxième gros problème : la lenteur des commandes Symfony sous Docker
