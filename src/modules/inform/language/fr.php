<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$lang_translator['author'] = 'VINADES.,JSC <contact@vinades.vn>';
$lang_translator['createdate'] = '20/07/2023, 07:15';
$lang_translator['copyright'] = '@Copyright (C) 2010 VINADES.,JSC. All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';

$lang_module['main_title'] = 'Notification';
$lang_module['mark_as_viewed'] = 'Marquer comme vu';
$lang_module['mark_as_unviewed'] = 'Marquer comme non consulté';
$lang_module['mark_as_favorite'] = 'Marquer comme favori';
$lang_module['mark_as_unfavorite'] = 'Démarquer comme favori';
$lang_module['hidden'] = 'Cacher';
$lang_module['show'] = 'Show';
$lang_module['filter_all'] = 'Tout';
$lang_module['filter_unviewed'] = 'Inédit';
$lang_module['filter_favorite'] = 'Favori';
$lang_module['filter_hidden'] = 'Caché';
$lang_module['no_notifications'] = 'Aucune notification';
$lang_module['filter_by_criteria'] = 'Filtrer par critères';
$lang_module['notification_title'] = 'Notification %s';
$lang_module['from_group'] = 'du groupe &laquo;%s&raquo;';
$lang_module['from_admin'] = 'de l\'administrateur &laquo;%s&raquo;';
$lang_module['from_system'] = 'de %s';
$lang_module['details'] = 'Accéder au lien de notification';
$lang_module['view_more'] = 'Voir plus';
$lang_module['inform_add'] = 'Ajouter une notification';
$lang_module['inform_edit'] = 'Modifier la notification';
$lang_module['receiver'] = 'Destinataire';
$lang_module['content'] = 'Contenu';
$lang_module['add_time'] = 'Heure de début';
$lang_module['exp_time'] = 'Temps expiré';
$lang_module['inform_link'] = 'Lien de notification';
$lang_module['to_group_all'] = 'À tous les membres du groupe';
$lang_module['id'] = 'ID';
$lang_module['username'] = 'Nom d\'utilisateur';
$lang_module['fullname'] = 'Nom et prénom';
$lang_module['unlimited'] = 'Illimité';
$lang_module['empty_is_unlimited'] = 'Le vide est illimité';
$lang_module['please_enter_content'] = 'Puisque vous avez sélectionné le message en %1$s par défaut, il ne peut pas être laissé vide. Veuillez saisir le message en 1$s';
$lang_module['please_enter_valid_link'] = 'Veuillez entrer un lien valide';
$lang_module['please_enter_default_link'] = 'Veuillez ne pas laisser le lien vide dans la langue par défaut';
$lang_module['please_enter_valid_add_time'] = 'Veuillez entrer une heure de début valide';
$lang_module['please_enter_valid_exp_time'] = 'Veuillez le laisser vide ou entrer une heure de fin valide';
$lang_module['status'] = 'Statut';
$lang_module['waiting'] = 'Attendre';
$lang_module['active'] = 'Actif';
$lang_module['expired'] = 'Expiré';
$lang_module['after_1_day'] = 'Après 1 jour';
$lang_module['after_2_days'] = 'Après 2 jours';
$lang_module['after_7_days'] = 'Après 7 jours';
$lang_module['after_10_days'] = 'Après 10 jours';
$lang_module['after_15_days'] = 'Après 15 jours';
$lang_module['after_30_days'] = 'Après 30 jours';
$lang_module['to_be_removed'] = 'À retirer le';
$lang_module['delete_confirm'] = 'Voulez-vous vraiment supprimer?';
$lang_module['views'] = 'Vues';
$lang_module['notification_not_exist'] = 'La notification n\'existe pas';
$lang_module['unknown_new_status'] = 'Nouveau statut inconnu';
$lang_module['group_not_defined'] = 'Groupe non défini';
$lang_module['not_group_manager'] = 'Vous n\'êtes pas le responsable du groupe';
$lang_module['unspecified_action'] = 'Action non spécifiée';
$lang_module['api_error_hash'] = 'Code de hachage invalide';
$lang_module['default'] = 'Défaut';
$lang_module['default_help'] = 'Le contenu par défaut remplacera le contenu vide des autres langues';
$lang_module['configs'] = 'Configuration';
$lang_module['inform_from_generaladmin'] = 'Notifications envoyées par le système, les groupes d\'utilisateurs ou les administrateurs de site';
$lang_module['inform_from_moduleadmin'] = 'Notifications envoyées par vous';
$lang_module['filter_system'] = 'Notifications du système';
$lang_module['filter_group'] = 'Notifications des groupes d\'utilisateurs';
$lang_module['filter_admins'] = 'Notifications des administrateurs';
$lang_module['filter_admin'] = 'Notifications de ma part';
$lang_module['add_inform'] = 'Créer une notification';
$lang_module['sender'] = 'Expéditeur';
$lang_module['admin_from_group'] = 'Notification du groupe';
$lang_module['admin_from_admin'] = 'Notification de l\'administrateur';
$lang_module['admin_from_system'] = 'Notification du système';
$lang_module['to_group'] = 'Au groupe';
$lang_module['to_groups'] = 'Aux groupes';
$lang_module['to_users'] = 'À des utilisateurs';
$lang_module['to_members'] = 'À tous les membres';
$lang_module['to_all'] = 'À tous les utilisateurs';
$lang_module['select_group'] = 'Sélectionnez le groupe';
$lang_module['select_admin'] = 'Sélectionnez l\'administrateur';
$lang_module['type_some_letters'] = 'Tapez quelques lettres pour rechercher des utilisateurs';
$lang_module['please_enter'] = 'Veuillez entrer au moins 3 caractères';
$lang_module['please_select_group'] = 'Veuillez sélectionner un groupe comme expéditeur de la notification';
$lang_module['please_select_admin'] = 'Veuillez sélectionner un administrateur comme expéditeur de la notification';
$lang_module['please_select_receiver_group'] = 'Veuillez sélectionner un groupe comme destinataire de la notification';
$lang_module['please_enter_user'] = 'Veuillez spécifier l\'identifiant du membre';
$lang_module['user_not_exist'] = 'Le membre n\'existe pas';
$lang_module['inform_active'] = 'Activer les notifications';
$lang_module['inform_default_exp'] = 'Durée de vie par défaut des notifications (en jours)';
$lang_module['inform_exp_del'] = 'Temps d\'attente pour supprimer les notifications expirées (en jours)';
$lang_module['inform_refresh_time'] = 'Temps d\'attente pour mettre à jour le nouveau nombre de notifications (en secondes)';
$lang_module['inform_max_characters'] = 'Nombre de caractères de notification raccourcie';
$lang_module['inform_numrows'] = 'Nombre maximum de notifications par impression';
$lang_module['field_required'] = 'Ce champ est requis';
