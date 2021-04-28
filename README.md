# Todo
 Création du Todo pour l'application calendrier.

 ## Id correspondant au droit d'un user sur une tâche

 1 - ACHIEVED_UPDATE -> Modification du statut d'une tâche : réalisé ou non.
 2 - INFO_UPDATE -> Modification des informations d'une tâche : title, content, enddate.
 3 - CREATE -> Création d'une nouvelle tâche.
 4 - ARCHIVED -> Archivage d'une tâche : ne devient visible que pour le propriétaire.

 Error SQL

45000 - Le user n'existe pas.
45001 - L'attribut est inconnu.

45100 - La tâche n'existe pas.
45101 - Vous n'avez pas l'autorisation d'achever une tâche.
45102 - Vous n'avez pas l'autorisation d'archiver une tâche.
45103 - Vous n'avez pas l'autorisation de créer une tâche.
45104 - Vous n'avez pas l'autorisation de supprimer une tâche.
45105 - Vous n'avez pas l'autorisation de modifier une tâche.
45106 - La tâche n'est pas archivée.
45107 - La tâche est archivée.

45200 - La todo n'existe pas.

45300 - Le token n'est pas valide.
45301 - Le token a expiré.
45302 - Vous participez déjà à cette todo avec cette permission.
45303 - Vous êtes le propriétaire de cette todo.