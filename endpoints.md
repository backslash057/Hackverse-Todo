## API Endpoints pour la Todo App

### 1. Récupérer toutes les tâches
```
GET /api/tasks?userId={userId}
```
**Requête**
- Paramètres de requête (Query) :
  - `userId` (integer, obligatoire)

**Réponse succès (200 OK)**
```json
[  
  {
    "id": 1,
    "title": "Faire les courses",
    "status": "pending",
    "user_id": 42,
    "created_at": "2025-04-22T10:15:30Z",
    "updated_at": "2025-04-22T10:15:30Z"
  },
  ...
]
```
**Réponse échec**
- 400 Bad Request :
```json
{ "error": "Paramètre userId manquant" }
```
- 500 Internal Server Error :
```json
{ "error": "Erreur serveur" }
```

---

### 2. Récupérer une tâche spécifique
```
GET /api/tasks/{id}?userId={userId}
```
**Requête**
- Paramètre de chemin (Path) :
  - `id` (integer, obligatoire)
- Paramètre de requête :
  - `userId` (integer, obligatoire)

**Réponse succès (200 OK)**
```json
{
  "id": 1,
  "title": "Faire les courses",
  "status": "pending",
  "user_id": 42,
  "created_at": "2025-04-22T10:15:30Z",
  "updated_at": "2025-04-22T10:15:30Z"
}
```
**Réponse échec**
- 400 Bad Request :
```json
{ "error": "Paramètres manquants" }
```
- 404 Not Found :
```json
{ "error": "Tâche non trouvée" }
```
- 500 Internal Server Error :
```json
{ "error": "Erreur serveur" }
```

---

### 3. Créer une nouvelle tâche
```
POST /api/tasks
```
**Requête** (Content-Type: application/json)
```json
{
  "title": "Titre de la tâche",
  "userId": 42
}
```
**Réponse succès (201 Created)**
```json
{
  "id": 5,
  "title": "Titre de la tâche",
  "status": "pending",
  "user_id": 42,
  "created_at": "2025-04-23T09:00:00Z",
  "updated_at": "2025-04-23T09:00:00Z"
}
```
**Réponse échec**
- 400 Bad Request :
```json
{ "error": "Titre ou userId manquant" }
```
- 500 Internal Server Error :
```json
{ "error": "Erreur serveur" }
```

---

### 4. Mettre à jour le statut d'une tâche
```
PUT /api/tasks/{id}
```
**Requête** (Content-Type: application/json)
```json
{
  "status": "completed",
  "userId": 42
}
```
- Paramètre de chemin :
  - `id` (integer, obligatoire)

**Réponse succès (200 OK)**
```json
{ "message": "Statut mis à jour" }
```
**Réponse échec**
- 400 Bad Request :
```json
{ "error": "Paramètres manquants" }
```
- 403 Forbidden :
```json
{ "error": "Accès refusé" }
```
- 404 Not Found :
```json
{ "error": "Tâche non trouvée" }
```
- 500 Internal Server Error :
```json
{ "error": "Erreur serveur" }
```

---

### 5. Supprimer une tâche
```
DELETE /api/tasks/{id}
```
**Requête**
- Paramètre de chemin :
  - `id` (integer, obligatoire)
- Paramètre de requête :
  - `userId` (integer, obligatoire)

**Réponse succès (200 OK)**
```json
{ "message": "Tâche supprimée" }
```
**Réponse échec**
- 400 Bad Request :
```json
{ "error": "Paramètres manquants" }
```
- 403 Forbidden :
```json
{ "error": "Accès refusé" }
```
- 404 Not Found :
```json
{ "error": "Tâche non trouvée" }
```
- 500 Internal Server Error :
```json
{ "error": "Erreur serveur" }
```

