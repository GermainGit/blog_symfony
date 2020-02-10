# TP Blog Symfony

###### Travail réalisé en LP DIM, université Savoie Mont-Blanc.

## Doctrine

#### Quelles relations existent entre les entités (Many To One/Many To Many/...) ? Faire un schéma de la base de données.

#### User
 - OneToMany Comment
 - OneToMany Post
 
#### Post
 - ManyToOne User
 - OneToMany Comment
 
#### Comment
 - ManyToOne Post
 - ManyToOne User
 
---

#### Expliquer ce qu'est le fichier .env. Expliquer pourquoi il faut changer le connecteur à la base de données.

Le fichier env permet de configurer les variables de l'environnement. Il faut changer le connecteur car il est configuré à l'origine sur un SGBD MySQL.

---

#### Expliquer l'intérêt des migrations d'une base de données

Les migrations permettent de reprendre un projet et d'initialiser la base de donnée avec nos entités dans un ordre bien précis. Il est donc possible de reprendre n'importe quel projet avec des migrations et de les lancers. 

---

#### Travail préparatoire : Qu'est-ce que EasyAdmin ?

EasyAdmin est un bundle qui permet de créer un backoffice pour administrer nos Entity.

---

#### Pourquoi doit-on implémenter des méthodes to string dans nos entités?

---

#### Qu'est-ce que le ParamResolver ?

---

#### Qu'est-ce qu'un formulaire Symfony ?

Les formulaires Symfony sont des formulaires automatiquement générés pour notre controller grâce à la méthode `createFormBuilder`

---

#### Quels avantages offrent l'usage d'un formulaire ?

