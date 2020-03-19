# Evaluation PHP
## Sujet

Créer une application Symfony permettant de rechercher des informations de contact et d’horaires sur des établissements publics (mairies, etc) d’une commune donnée, grâce aux API publiques du gouvernement.

L’application peut ne comporter qu’une seule page présentant un formulaire de recherche.
Lorsque le formulaire est envoyé, s’il n’y a aucune erreur, afficher les résultats (la liste des établissements).

## Observation

Pour faire une recherche il faut remplir les champs **ville** et **code postal** obligatoirement.  
*J'aurais aimer pouvoir donner la possibilité de remplir seulement un des deux mais lorsque l'on cherche par le nom, il ne fait pas une recherche exact mais un une recherche partiel donc j'ai plusieurs résultat  
J'ai pensé à utilisé le _score mais il n'était pas cohérent tout le temps (ex: Paris)*

## Petites implémentations
* Input avec auto-complétion.
* Facile d'ajouter dans le code un nouveau type d'établissement à rechercher (HomeController.php).
* Si la connexion à l'API est perdu on sors de la fonction avec un tableau vide, ce qui ne cause pas d'erreur.