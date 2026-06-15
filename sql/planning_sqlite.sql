-- SOPlanning SQLite schema + default config seed (fresh install)
-- SECURE_KEY and API key are left empty and filled in PHP at install (CSPRNG).

CREATE TABLE `planning_audit` (
  `audit_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `date_modif` TEXT,
  `user_modif` TEXT,
  `type` TEXT,
  `user_id` TEXT,
  `projet_id` TEXT,
  `periode_id` TEXT,
  `lieu_id` TEXT,
  `ressource_id` TEXT,
  `statut_id` TEXT,
  `equipe_id` TEXT,
  `groupe_id` TEXT,
  `anciennes_valeurs` TEXT,
  `nouvelles_valeurs` TEXT,
  `nbmodifs` INTEGER,
  `informations` TEXT
);
CREATE TABLE `planning_cohort` (
  `cohort_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `libelle` TEXT,
  `annee` TEXT,
  `population` TEXT
);
CREATE TABLE `planning_config` (
  `cle` TEXT,
  `valeur` TEXT,
  `commentaire` TEXT,
  PRIMARY KEY (`cle`)
);
CREATE TABLE `planning_ferie` (
  `date_ferie` TEXT,
  `libelle` TEXT,
  `couleur` TEXT,
  PRIMARY KEY (`date_ferie`)
);
CREATE TABLE `planning_filtre_perso` (
  `filtre_perso_id` INTEGER,
  `filtre_perso_nom` TEXT,
  `filtre_perso_contenu` TEXT,
  `module` TEXT,
  `user_id` TEXT,
  `date_creation` TEXT,
  `date_modif` TEXT,
  PRIMARY KEY (`filtre_perso_id`)
);
CREATE TABLE `planning_groupe` (
  `groupe_id` INTEGER,
  `nom` TEXT,
  `ordre` INTEGER,
  PRIMARY KEY (`groupe_id`)
);
CREATE TABLE `planning_lieu` (
  `lieu_id` TEXT,
  `nom` TEXT,
  `commentaire` TEXT,
  `exclusif` INTEGER,
  `couleur` TEXT,
  PRIMARY KEY (`lieu_id`)
);
CREATE TABLE `planning_loan` (
  `loan_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `resource_id` TEXT,
  `user_id` TEXT,
  `borrower_name` TEXT,
  `date_out` TEXT,
  `date_due` TEXT,
  `date_in` TEXT,
  `statut` TEXT,
  `note` TEXT,
  `reminded_at` TEXT
);
CREATE TABLE `planning_loan_hold` (
  `hold_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `resource_id` TEXT,
  `user_id` TEXT,
  `borrower_name` TEXT,
  `requested_at` TEXT,
  `statut` TEXT
);
CREATE TABLE `planning_periode` (
  `periode_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `parent_id` INTEGER,
  `projet_id` TEXT,
  `user_id` TEXT,
  `link_id` TEXT,
  `date_debut` TEXT,
  `date_fin` TEXT,
  `duree` TEXT,
  `duree_details` TEXT,
  `titre` TEXT,
  `notes` TEXT,
  `lien` TEXT,
  `statut_tache` TEXT,
  `livrable` TEXT,
  `lieu_id` TEXT,
  `ressource_id` TEXT,
  `fichiers` TEXT,
  `createur_id` TEXT,
  `date_creation` TEXT,
  `modifier_id` TEXT,
  `date_modif` TEXT,
  `custom` TEXT,
  `pause` TEXT,
  `duree_reelle` REAL,
  `notif_standard_destinataires` TEXT,
  `notif_avant_actif` TEXT,
  `notif_avant_destinataires` TEXT,
  `notif_avant_delai_type` TEXT,
  `notif_avant_delai_nb` INTEGER,
  `notif_avant_date_envoyee` TEXT,
  `notif_apres_actif` TEXT,
  `notif_apres_destinataires` TEXT,
  `notif_apres_delai_type` TEXT,
  `notif_apres_delai_nb` INTEGER,
  `notif_apres_statuts_requis` TEXT,
  `notif_apres_date_envoyee` TEXT
);
CREATE TABLE `planning_projet` (
  `projet_id` TEXT,
  `nom` TEXT,
  `iteration` TEXT,
  `couleur` TEXT,
  `livraison` TEXT,
  `lien` TEXT,
  `statut` TEXT,
  `groupe_id` INTEGER,
  `createur_id` TEXT,
  `budget_montant` REAL,
  `budget_temps` REAL,
  `montant_consomme` REAL,
  `temps_consomme` REAL,
  `montant_restant` REAL,
  `temps_restant` REAL,
  PRIMARY KEY (`projet_id`)
);
CREATE TABLE `planning_projet_user_tarif` (
  `projet_user_tarif_id` INTEGER,
  `user_id` TEXT,
  `projet_id` TEXT,
  `tarif_horaire` REAL,
  PRIMARY KEY (`projet_user_tarif_id`)
);
CREATE TABLE `planning_requirement` (
  `requirement_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `cohort_id` INTEGER,
  `libelle` TEXT,
  `response_type` TEXT,
  `ordre` INTEGER,
  `actif` TEXT,
  `cible` INTEGER
);
CREATE TABLE `planning_requirement_completion` (
  `requirement_id` INTEGER,
  `subject_type` TEXT,
  `subject_id` TEXT,
  `valeur` TEXT,
  `fichier` TEXT,
  `date_completion` TEXT,
  `completed_by` TEXT,
  PRIMARY KEY (`requirement_id`,`subject_type`,`subject_id`)
);
CREATE TABLE `planning_ressource` (
  `ressource_id` TEXT,
  `nom` TEXT,
  `commentaire` TEXT,
  `exclusif` INTEGER,
  `couleur` TEXT,
  PRIMARY KEY (`ressource_id`)
);
CREATE TABLE `planning_right_on_projet` (
  `right_id` INTEGER,
  `owner_id` TEXT,
  `allowed_id` TEXT,
  PRIMARY KEY (`right_id`)
);
CREATE TABLE `planning_right_on_user` (
  `right_id` INTEGER,
  `owner_id` TEXT,
  `allowed_id` TEXT,
  PRIMARY KEY (`right_id`)
);
CREATE TABLE `planning_status` (
  `status_id` TEXT,
  `nom` TEXT,
  `commentaire` TEXT,
  `affichage` TEXT,
  `barre` TEXT,
  `gras` TEXT,
  `italique` TEXT,
  `souligne` TEXT,
  `defaut` TEXT,
  `affichage_liste` TEXT,
  `pourcentage` INTEGER,
  `couleur` TEXT,
  `priorite` INTEGER,
  `inclure_dans_calcul` TEXT,
  PRIMARY KEY (`status_id`)
);
CREATE TABLE `planning_supervision` (
  `sup_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `trainee_id` TEXT,
  `fonction` TEXT,
  `supervisor_ref` TEXT,
  `date_debut` TEXT,
  `date_fin` TEXT,
  `jour_semaine` INTEGER,
  `heure_debut` TEXT,
  `heure_fin` TEXT,
  `actif` TEXT
);
CREATE TABLE `planning_supervision_coverage` (
  `cov_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `trainee_id` TEXT,
  `fonction` TEXT,
  `covering_ref` TEXT,
  `date_debut` TEXT,
  `date_fin` TEXT,
  `note` TEXT
);
CREATE TABLE `planning_user` (
  `user_id` TEXT,
  `user_groupe_id` INTEGER,
  `nom` TEXT,
  `login` TEXT,
  `password` TEXT,
  `email` TEXT,
  `visible_planning` TEXT,
  `couleur` TEXT,
  `droits` TEXT,
  `cle` TEXT,
  `notifications` TEXT,
  `adresse` TEXT,
  `telephone` TEXT,
  `mobile` TEXT,
  `metier` TEXT,
  `commentaire` TEXT,
  `date_dernier_login` TEXT,
  `preferences` TEXT,
  `login_actif` TEXT,
  `google_2fa` TEXT,
  `date_creation` TEXT,
  `date_modif` TEXT,
  `tutoriel` TEXT,
  `tarif_horaire_defaut` REAL,
  `langue` TEXT,
  `cohort_id` INTEGER,
  PRIMARY KEY (`user_id`)
);
CREATE TABLE `planning_user_groupe` (
  `user_groupe_id` INTEGER,
  `nom` TEXT,
  PRIMARY KEY (`user_groupe_id`)
);
CREATE INDEX `planning_audit_idx_type` ON `planning_audit` (`type`);
CREATE INDEX `planning_audit_projet_id` ON `planning_audit` (`projet_id`);
CREATE INDEX `planning_audit_user_id` ON `planning_audit` (`user_id`);
CREATE INDEX `planning_filtre_perso_idx_user_id` ON `planning_filtre_perso` (`user_id`);
CREATE INDEX `planning_groupe_idx_ordre` ON `planning_groupe` (`ordre`);
CREATE INDEX `planning_loan_idx_loan_resource` ON `planning_loan` (`resource_id`);
CREATE INDEX `planning_loan_idx_loan_statut` ON `planning_loan` (`statut`);
CREATE INDEX `planning_loan_idx_loan_user` ON `planning_loan` (`user_id`);
CREATE INDEX `planning_loan_hold_fk_hold_user` ON `planning_loan_hold` (`user_id`);
CREATE INDEX `planning_loan_hold_idx_hold_resource` ON `planning_loan_hold` (`resource_id`);
CREATE INDEX `planning_periode_idx_createur_id` ON `planning_periode` (`createur_id`);
CREATE INDEX `planning_periode_idx_date_debut` ON `planning_periode` (`date_debut`);
CREATE INDEX `planning_periode_idx_date_fin` ON `planning_periode` (`date_fin`);
CREATE INDEX `planning_periode_idx_lieu_id` ON `planning_periode` (`lieu_id`);
CREATE INDEX `planning_periode_idx_link_id` ON `planning_periode` (`link_id`);
CREATE INDEX `planning_periode_idx_parent_date_debut` ON `planning_periode` (`parent_id`,`date_debut`);
CREATE INDEX `planning_periode_idx_projet_date_debut` ON `planning_periode` (`projet_id`,`date_debut`);
CREATE INDEX `planning_periode_idx_ressource_id` ON `planning_periode` (`ressource_id`);
CREATE INDEX `planning_periode_idx_statut_tache` ON `planning_periode` (`statut_tache`);
CREATE INDEX `planning_periode_idx_user_date_debut` ON `planning_periode` (`user_id`,`date_debut`);
CREATE INDEX `planning_periode_parent_id` ON `planning_periode` (`parent_id`);
CREATE INDEX `planning_periode_projet_id` ON `planning_periode` (`projet_id`);
CREATE INDEX `planning_periode_user_id` ON `planning_periode` (`user_id`);
CREATE INDEX `planning_projet_groupe_id` ON `planning_projet` (`groupe_id`);
CREATE INDEX `planning_projet_idx_createur_id` ON `planning_projet` (`createur_id`);
CREATE INDEX `planning_projet_idx_statut` ON `planning_projet` (`statut`);
CREATE INDEX `planning_projet_user_tarif_put_projet_id` ON `planning_projet_user_tarif` (`projet_id`);
CREATE INDEX `planning_projet_user_tarif_put_user_id` ON `planning_projet_user_tarif` (`user_id`);
CREATE INDEX `planning_requirement_idx_req_cohort` ON `planning_requirement` (`cohort_id`);
CREATE INDEX `planning_right_on_projet_allowed_id` ON `planning_right_on_projet` (`allowed_id`);
CREATE INDEX `planning_right_on_projet_idx_owner_allowed` ON `planning_right_on_projet` (`owner_id`,`allowed_id`);
CREATE INDEX `planning_right_on_projet_owner_id` ON `planning_right_on_projet` (`owner_id`);
CREATE INDEX `planning_right_on_user_allowed_id` ON `planning_right_on_user` (`allowed_id`);
CREATE INDEX `planning_right_on_user_idx_owner_allowed` ON `planning_right_on_user` (`owner_id`,`allowed_id`);
CREATE INDEX `planning_right_on_user_owner_id` ON `planning_right_on_user` (`owner_id`);
CREATE INDEX `planning_supervision_fk_sup_supervisor` ON `planning_supervision` (`supervisor_ref`);
CREATE INDEX `planning_supervision_idx_sup_fonction` ON `planning_supervision` (`fonction`);
CREATE INDEX `planning_supervision_idx_sup_trainee` ON `planning_supervision` (`trainee_id`);
CREATE INDEX `planning_supervision_coverage_fk_cov_supervisor` ON `planning_supervision_coverage` (`covering_ref`);
CREATE INDEX `planning_supervision_coverage_idx_cov_trainee` ON `planning_supervision_coverage` (`trainee_id`);
CREATE INDEX `planning_user_idx_visible_planning` ON `planning_user` (`visible_planning`);
CREATE INDEX `planning_user_user_groupe_id` ON `planning_user` (`user_groupe_id`);

-- default configuration
INSERT INTO `planning_config` VALUES('CURRENT_VERSION', '1.57.00-hardened.1', 'Internal key for auto upgrade control');
INSERT INTO `planning_config` VALUES('PLANNING_PAGES', '1,5,10,20,50,100', 'rows per page in the planning');
INSERT INTO `planning_config` VALUES('PROJECT_COLORS_POSSIBLE', '', 'color choice limitation for planner (empty for no limit). Exemple :#ff0000,#aa8811,#446622');
INSERT INTO `planning_config` VALUES('DEFAULT_NB_MONTHS_DISPLAYED', '2', 'Default number of months displayed in the planning');
INSERT INTO `planning_config` VALUES('DEFAULT_NB_ROWS_DISPLAYED', '100', 'Default number of rows displayed in the planning');
INSERT INTO `planning_config` VALUES('REFRESH_TIMER', '600', 'refresh time for the planning page (time in second)');
INSERT INTO `planning_config` VALUES('LOGOUT_REDIRECT', '', 'Optional redirect url after logout (for exemple to return on your own intranet). ex : http://www.google.com');
INSERT INTO `planning_config` VALUES('DEFAULT_PERIOD_LINK', '', 'Default value for link in a period');
INSERT INTO `planning_config` VALUES('PLANNING_ONE_ASSIGNMENT_MAX_PER_DAY', '0', 'Option to display only one assignment/task per cell/day in the planning (put "1" to activite this option)');
INSERT INTO `planning_config` VALUES('PLANNING_LINE_HEIGHT', '', 'Default line height in the planning. If not specified, it fits the username height');
INSERT INTO `planning_config` VALUES('SOPLANNING_TITLE', 'SOPlanning', 'Change the title of Soplanning for integration in extranet');
INSERT INTO `planning_config` VALUES('SMTP_HOST', 'localhost', '');
INSERT INTO `planning_config` VALUES('SMTP_PORT', '', '');
INSERT INTO `planning_config` VALUES('SMTP_FROM', 'notification@yourdomain.com', '');
INSERT INTO `planning_config` VALUES('SMTP_LOGIN', '', '');
INSERT INTO `planning_config` VALUES('SMTP_PASSWORD', '', '');
INSERT INTO `planning_config` VALUES('SMTP_SECURE', '', '');
INSERT INTO `planning_config` VALUES('SOPLANNING_URL', '', 'Your SOPlanning instance url, to be able to send email with links');
INSERT INTO `planning_config` VALUES('SECURE_KEY', '', 'String used only for security matters');
INSERT INTO `planning_config` VALUES('PLANNING_REPEAT_HEADER', 0, 'If > 0, repeat header (days/months) in the planning each x lines');
INSERT INTO `planning_config` VALUES('DURATION_AM', '04:00', 'Morning duration when calculating worked hours');
INSERT INTO `planning_config` VALUES('DURATION_PM', '05:00', 'Afternoon duration when calculating worked hours');
INSERT INTO `planning_config` VALUES('DURATION_DAY', '09:00', 'Duration when only one day is selected');
INSERT INTO `planning_config` VALUES('CONTACT_FORM_DEACTIVATE', '', 'Put 1 to deactivate the display of the small button/popin (contact form)');
INSERT INTO `planning_config` VALUES('HOURS_DISPLAYED', '8,9,10,11,14,15,16,17', 'List of hours displayed in the day view');
INSERT INTO `planning_config` VALUES('DEFAULT_NB_DAYS_DISPLAYED', '2', 'Default number of days displayed in the planning view by day');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_LIEUX', '1', 'Location Option');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_RESSOURCES', '1', 'Ressource Option');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_TACHES', '1', 'Task Option');
INSERT INTO `planning_config` VALUES('PLANNING_DATE_FORMAT', '1', 'Date Format');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_ACCES', '0', 'Public access');
INSERT INTO `planning_config` VALUES('SOPLANNING_LOGO', '', 'Logo');
INSERT INTO `planning_config` VALUES('SOPLANNING_THEME', 'soplanning.css', 'Default theme');
INSERT INTO `planning_config` VALUES('PLANNING_COL_WIDTH', '25', 'Planning col width');
INSERT INTO `planning_config` VALUES('PLANNING_COL_WIDTH_LARGE', '130', 'Planning col width large mode');
INSERT INTO `planning_config` VALUES('PLANNING_CODE_WIDTH', '5', 'Code width');
INSERT INTO `planning_config` VALUES('PLANNING_CODE_WIDTH_LARGE', '5', 'Code width large mode');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_VISITEUR', '0', 'Visitor can add or update task');
INSERT INTO `planning_config` VALUES('PLANNING_HIDE_WEEKEND_TASK', '0', 'Hide weekend task');
INSERT INTO `planning_config` VALUES('PLANNING_AFFICHAGE_STATUS', 'aucun', 'Show status');
INSERT INTO `planning_config` VALUES('TIMEZONE', 'Europe/Paris', 'Timezone');
INSERT INTO `planning_config` VALUES('PLANNING_CELL_FONTSIZE', '0', 'Cell Font size');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_AUDIT', '1', 'Audit module');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_AUDIT_TACHES', '1', 'Audit tasks');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_AUDIT_PROJETS', '1', 'Audit project');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_AUDIT_GROUPES', '1', 'Audit project group');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_AUDIT_UTILISATEURS', '1', 'Audit users');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_AUDIT_EQUIPES', '1', 'Audit team');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_AUDIT_LIEUX', '1', 'Audit location');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_AUDIT_RESSOURCES', '1', 'Audit ressource');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_AUDIT_STATUTS', '1', 'Audit status');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_AUDIT_CONNEXIONS', '1', 'Audit connexion');
INSERT INTO `planning_config` VALUES('SOPLANNING_OPTION_AUDIT_RETENTION', '30', 'Audit retention');
INSERT INTO `planning_config` VALUES('PLANNING_DIFFERENCIE_TACHE_COMMENTAIRE', '0', 'Task comment');
INSERT INTO `planning_config` VALUES('PLANNING_DIFFERENCIE_TACHE_LIEN', '1', 'Task link');
INSERT INTO `planning_config` VALUES('PLANNING_DIFFERENCIE_TACHE_PARTIELLE', '1', 'Half Task ');
INSERT INTO `planning_config` VALUES('PLANNING_COULEUR_TACHE', '0', 'Task Color');
INSERT INTO `planning_config` VALUES('PLANNING_TEXTE_TACHES_PROJET', 'code_personne', 'Cell text project');
INSERT INTO `planning_config` VALUES('PLANNING_TEXTE_TACHES_PERSONNE', 'code_projet', 'Cell text user');
INSERT INTO `planning_config` VALUES('PLANNING_TEXTE_TACHES_LIEU', 'code_projet', 'Cell text location');
INSERT INTO `planning_config` VALUES('PLANNING_TEXTE_TACHES_RESSOURCE', 'code_projet', 'Cell text resource');
INSERT INTO `planning_config` VALUES('PLANNING_MASQUER_FERIES', '0', 'Hide holidays');
INSERT INTO `planning_config` VALUES('PLANNING_DUREE_CRENEAU_HORAIRE', '30', 'Time duration');
INSERT INTO `planning_config` VALUES('SOPLANNING_API_KEY_NAME', 'SOPLANNING-API', '');
INSERT INTO `planning_config` VALUES('SOPLANNING_API_KEY_VALUE', '','');
INSERT INTO `planning_config` VALUES('GOOGLE_OAUTH_CLIENT_ID', '', '');
INSERT INTO `planning_config` VALUES('GOOGLE_OAUTH_CLIENT_SECRET', '', '');
INSERT INTO `planning_config` VALUES('GOOGLE_OAUTH_ACTIVE', '0', '');
INSERT INTO `planning_config` VALUES('GOOGLE_2FA_ACTIVE', '0', '');
INSERT INTO `planning_config` VALUES('SEMAPHORE_ACTIVATED', '0', 'Activated in order to avoid periode_id crossing when creating a lot of tasks at the same time');
INSERT INTO `planning_config` VALUES ('NOTIFICATION_EMAIL_COCHE', '1', 'Default state for notification checkbox in task form');
INSERT INTO `planning_config` VALUES ('PLANNING_DAYS_OF_WEEK_DISPLAY', '{"1": {"inclus" : "1", "affiche" : "1", "grise" : "0"},"2": {"inclus" : "1", "affiche" : "1", "grise" : "0"},"3": {"inclus" : "1", "affiche" : "1", "grise" : "0"},"4": {"inclus" : "1", "affiche" : "1", "grise" : "0"},"5": {"inclus" : "1", "affiche" : "1", "grise" : "0"},"6": {"inclus" : "0", "affiche" : "1", "grise" : "1"},"7": {"inclus" : "0", "affiche" : "1", "grise" : "1"}}', 'Define how each day is display (normal, grey, hidden)');
INSERT INTO `planning_config`(`cle`, `valeur`, `commentaire`) VALUES ('WHITELIST_UPLOAD', 'pdf,docx,doc,xls,xlsx,png,jpg,jpeg,gif', 'File extension allowed for upload');
INSERT INTO `planning_config`(`cle`, `valeur`, `commentaire`) VALUES ('PASSWORD_COMPLEXITY', '0', '1 for CNIL rules');
INSERT INTO `planning_config`(`cle`, `valeur`, `commentaire`) VALUES ('AI_OLLAMA_MODEL', '', '');
INSERT INTO `planning_config`(`cle`, `valeur`, `commentaire`) VALUES ('AI_OLLAMA_URL', '', '');
