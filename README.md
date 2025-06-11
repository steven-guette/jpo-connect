# 🎓 JPO Connect – Projet Démo La Plateforme

Bienvenue sur le dépôt **JPO Connect**.
Ce projet a été développé à vocation pédagogique pour présenter une maquette fonctionnelle d'un site de gestion des Journées Portes Ouvertes.

---

## 🧐 Objectifs

* Développer un front en React
* Créer un backend PHP natif en MVC avec routes REST
* Faire communiquer le tout et stocker les données en base SQL

---

## ⚙️ Installation (localhost)

### 1. 📦 Cloner le dépôt

```bash
git clone https://github.com/steven-guette/jpo-connect.git
```

---

### 2. 🗃️ Importer la base de données

Le fichier suivant est prêt à être importé dans votre SGBD :

```bash
install/jpo_connect.sql
```

> Ce fichier crée la structure des tables et insère des données de démonstration. Aucun script à exécuter : il s'agit d'un **fichier SQL standard** à importer via phpMyAdmin

---

### 3. 🔧 Configurer l'accès à la base de données

Modifiez le fichier `.env` du backend pour l'adapter à votre environnement :

```
jpo-connect/api/.env
```

```env
DB_HOST=localhost
DB_NAME=jpo_connect
DB_USER=WhiteCat
DB_PASS=***************
```

---

### 4. 🛠️ Générer le build du frontend React

Deux scripts (Linux/Windows) sont fournis pour générer et déplacer automatiquement le build dans le dossier principal du projet.

#### Pour les utilisateurs Linux :

```bash
./install/build.sh
```

#### Pour les utilisateurs Windows (Des groupes de soutien doivent exister...) :

```cmd
install\build.cmd
```

Ces scripts :

* Exécutent `npm run build` dans le dossier `frontend`
* Copient les fichiers de production dans la racine (`jpo-connect/`)
* Suppriment `frontend/dist` une fois l’opération terminée

> Le frontend est déjà buildé. Ces scripts sont uniquement utiles si vous modifiez le code source.

---

## 👨‍🏫 À vocation pédagogique

Ce projet a été conçu comme **une démonstration** de ce qu'il est possible de réaliser dans les délais imposés aux étudiants.

Il a pour objectif de :

* Illustrer concrètement ce qu’un développeur peut produire dans un temps limité
* Offrir un exemple clair d’architecture front React + back PHP en MVC
* Servir de référence pour les accompagnateurs lors de leurs présentations

> Ce projet n’est pas destiné à être directement modifié ou distribué aux étudiants, mais à leur montrer un niveau d’attente réaliste, accessible, et structuré.

---

## 🧭 Organisation des dossiers

```
jpo-connect/
├── api/            ← Backend PHP natif
├── frontend/       ← Code source React 
├── install/        ← Fichiers d’installation (SQL + scripts de build)
├── index.html      ← Entrée du build React (copié ici par le script)
```

---

## 📌 Remarques

* Backend compatible PHP 8.x avec Apache
* CORS ouvert par défaut pour le local dans `api/config/bootstrap.php`
* Le projet peut être étendu librement pour des TP, démos ou protos internes
