# Déclaration des tables:
```sql
CREATE TABLE concours(
   conc_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
   theme VARCHAR(64) NOT NULL,
   num_pl SMALLINT UNSIGNED,
   d_debut DATE,
   d_fin DATE
);

CREATE TABLE etudiant(
   mat INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
   nom VARCHAR(24),
   prenom VARCHAR(24),
   d_nais DATE,
   l_nais VARCHAR(256),
   email VARCHAR(64),
   pass VARCHAR(24),
   tel VARCHAR(16),
   nat VARCHAR(64),
   pays VARCHAR(64),
   adrs VARCHAR(64),
   lang VARCHAR(12),
   niv VARCHAR(12),
   sit ENUM('att', 'ref', 'acc', 'can', 'dep', 'reu'),
   conc_id INT UNSIGNED NOT NULL,

   FOREIGN KEY (conc_id)
   REFERENCES concours(conc_id)
   ON DELETE NO ACTION
   ON UPDATE CASCADE
);

CREATE TABLE admin(
   mat INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
   nom VARCHAR(24),
   prenom VARCHAR(24),
   email VARCHAR(64),
   pass VARCHAR(24)
);
```

# Documentation:
## setup de ces tables:
aller à 'localhost/setup.php';
## Table concours:
   - conc_id: 'ID de concours'
   - num_pl: 'nombre des places'
   - d_debut: 'date debut'
   - d_fin: 'date fin'

## Table etudiant:
   - mat: 'matricule'
   - pass: 'mot de passe'
   - tel: 'téléphone'
   - nat: 'nationalité'
   - adrs: 'adresse'
   - lang: 'langage'
   - niv: 'niveau'
   - d_nais: 'date de naissance'
   - l_nais: 'lieu de naissance'
   - sit: 'situation' a les differents cas:
      1. att (en attente)
      2. ref (réfusé) (deprecated)
      3. acc (accepter)
      4. con (candidate dans le concours)
      5. dep (dépôt)
      6. reu (réussi)

## Table admin:
   - mat: 'matricule'
   - pass: 'mot de passe'
