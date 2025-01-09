# Mon premier projet docker
## Introduction
le but de ce projet est de creer une petit appication e-commerce pour acheter de la moutarde en ligne.

pour ce faire je vais utiliser comme technologie :
- `Symfony` pour la partie backend, car c'est la technologie avec lequel je suis le plus familier
- `react` pour la partie front, pour me lancer un petit defis sur une partie front que je ne connais pas trop.
- `jest` pour les differents test unitaires que je vais realiser dans mon application
- `docker` creer mes conteuneurs de bdd, serveurs apache et de react.

`docker-compose up --build` pour build les differents containeurs et pouvoir utiliser les outils du site.

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