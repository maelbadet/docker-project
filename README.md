#  <p align =center>Mon premier projet docker</p>
## Introduction au projet
le but de ce projet est de creer une petit appication e-commerce pour acheter de la moutarde en ligne.

pour ce faire j'ai utiliser comme technologie :
- `Symfony` pour la partie backend, car c'est la technologie avec lequel je suis le plus familier
- `react` pour la partie front, pour me lancer un petit defis sur une partie front que je ne connais pas trop.
- `docker` creer mes conteuneurs de bdd, serveurs apache et de react.

`docker-compose up --build` pour build les differents containeurs et pouvoir utiliser les outils du site.

## ma base de donnee 
toutes les tables de ma base de donnee sont mises dans le dossier backend sous le nom de `setup.sql`

## Symfony
Pour la partie backend, j'ai decider d'utiliser Syfony pour creer mon api car c'est le framework avec 
lequel je suis le plus familier. C'est un framework francais open source et une documentation tres clair.

[liens vers la documentation symfony](https://symfony.com/doc/current/index.html)

## Lancement du projet
Lors du premier lancement du projet, il faudras executer la commande `docker-compose up --build` pour installer 
les differentes dependances lier au framework <font color='red'>react</font> et <font color='red'>Symfony</font>

## poblemes rencontrer

### pour le frontend : 
Sur le front end, etant une technologie que je n'utilise pas trop les principaux problemes rencontrer 
sont surtout liee a la syntax de react. Mais il y a eu aussi:
- le fait de devoir docker-compose down puis up a chaque fois que je veux voir mes modifs
- le fais de devoir faire un return a chaque fois dans lequel je passe le html ce qui n'est pas mon habtitude


### pour le backend : 
Le plus gros probleme que j'ai rencontrer a ete de metter en place le projet, avec plus d'une demi 
journee sur un probleme lors du demarrage de mon server symfony.
- probleme majeur, la non communication a l'exterieur du containeur donc besoin 
d'utiliser ` "--allow-all-ip"` dans la cmd de mon Dockerfile
- le deuxieme gros probleme est la lenteur des comandes symfony sous docker
