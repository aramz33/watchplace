Domaine fonctionnel: Amateur de montres

objet --> Montre : int $id; string $brand; Remontoire $remontoire_id;
inventaire --> Remontoire : int $id; string $nom ; Collection $montres; Member $member
membre --> Member : int $id; string $nom; Collection $remontoires;
galerie --> Vitrine


Lien GitHub:
https://github.com/aramz33/watchplace

Route:
http://127.0.0.1:8000/remontoire --> inventaire liste
http://127.0.0.1:8000/remontoire/{id} --> liste des montres dans un inventaire
http://127.0.0.1:8000/montre/{id} --> detail montre
http://127.0.0.1:8000/admin --> admin crud controller

