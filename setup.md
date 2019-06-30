# Déclaration des tables:
```sql
CREATE TABLE concours(
   conc_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
   theme VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
   num_pl SMALLINT UNSIGNED,
   d_insc_debut DATE,
   d_insc_fin DATE,
   d_doc DATE,
   d_passe_conc DATE,
   d_resu_conc DATE,
   d_fin DATE
);

CREATE TABLE etudiant(
   mat INT(12) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
   nom VARCHAR(24),
   prenom VARCHAR(24),
   d_nais DATE,
   l_nais VARCHAR(256),
   email VARCHAR(64) UNIQUE,
   pass VARCHAR(24),
   tel VARCHAR(16) UNIQUE,
   nat VARCHAR(64),
   pays VARCHAR(64),
   adrs VARCHAR(64),
   etat ENUM('att', 'doc', 'ref', 'can', 'pas', 'nre', 'reu'),
   note FLOAT CHECK (note BETWEEN 0.0 AND 20.0),
   conc_id INT UNSIGNED NOT NULL,

   FOREIGN KEY (conc_id)
   REFERENCES concours(conc_id)
   ON DELETE NO ACTION
   ON UPDATE CASCADE
);

CREATE TABLE administrateur(
   mat INT(12) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
   nom VARCHAR(24),
   prenom VARCHAR(24),
   email VARCHAR(64),
   pass VARCHAR(24)
);
```

# Documentation:
## setup de ces tables:
aller à 'localhost/setup.php';
si vous avez des errors, le possible patch que vous changer le 'user' et le 'pass' de l'utilisateur de base de données daw in file 'root.php'.
### Table concours:
   - conc_id: 'ID de concours'
   - num_pl: 'nombre des places'

   - d_insc_debut: date debut d'inscription.
   - d_insc_fin: date fin de l'inscription après cette date Il y'a aucune personne qui peut s'inscrire dans cet theme. après 2 jours, les etudiant peuvent prendre leurs documents.
   - d_doc: date de dernier acception des documents des etudiant.
   - d_passe_conc: date de fairement de concours, avant une semaine, le processus des documents doit être fini.
   - d_resu_conc: date de résultat de concours
   - d_fin: date fin (les résultats sont cachées après cette date).

### Table etudiant:
   - mat: 'matricule'
   - pass: 'mot de passe'
   - tel: 'téléphone'
   - nat: 'nationalité'
   - adrs: 'adresse'
   - d_nais: 'date de naissance'
   - l_nais: 'lieu de naissance'
   - etat: les differents cas sont:
      1. att (en **att**ente)
      2. doc l'étudiant pris ses **doc**uments.
      3. ref (**ref**usé) (deprecated)
      4. con (accepter, **can**didate dans le concours)
      5. pas l'étudiant **pas**sai l'examen
      6. nre (**n**on-**ré**ussi)
      7. reu (**réu**ssi)

### Table administrateur:
   - mat: 'matricule'
   - pass: 'mot de passe'


```sql
   SELECT etudiant.nom, etudiant.prenom, concours.theme, concours.d_doc FROM etudiant INNER JOIN concours WHERE etudiant.conc_id = concours.conc_id AND etudiant.email='$email' AND etudiant.pass='$pass';


```