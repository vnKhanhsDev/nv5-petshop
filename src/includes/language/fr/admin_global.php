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

$lang_translator['author'] = 'Phạm Chí Quang';
$lang_translator['createdate'] = '21/6/2010, 19:30';
$lang_translator['copyright'] = '@Copyright (C) 2009-2021 VINADES.,JSC. Tous droits réservés';
$lang_translator['info'] = 'Langue française pour NukeViet 4';
$lang_translator['langtype'] = 'lang_global';

$lang_global['mod_authors'] = 'Administrateurs';
$lang_global['mod_groups'] = 'Groupe';
$lang_global['mod_database'] = 'Base de données';
$lang_global['mod_settings'] = 'Configuration';
$lang_global['mod_cronjobs'] = 'Procès automatiques';
$lang_global['mod_modules'] = 'Gestion des Modules';
$lang_global['mod_themes'] = 'Gestion de l\'inteface';
$lang_global['mod_siteinfo'] = 'Info';
$lang_global['mod_language'] = 'Langues, Région';
$lang_global['mod_upload'] = 'Médias';
$lang_global['mod_webtools'] = 'Utilitaire Web';
$lang_global['mod_seotools'] = 'Outils SEO';
$lang_global['mod_subsite'] = 'Gestion du site fils';
$lang_global['mod_extensions'] = 'Extension';
$lang_global['mod_zalo'] = 'Zalo';
$lang_global['mod_emailtemplates'] = 'Modèles d\'email';
$lang_global['go_clientsector'] = 'Page d\'Accueil';
$lang_global['go_clientmod'] = 'Prévisualiser';
$lang_global['go_instrucion'] = 'Document de guide';
$lang_global['please_select'] = 'Sélectionnez';
$lang_global['admin_password_empty'] = 'Manque de Mot de passe';
$lang_global['adminpassincorrect'] = 'Mot de passe &ldquo;<strong>%s</strong>&rdquo; incorrect. Essayez de nouveau';
$lang_global['admin_password'] = 'Votre mot de passe';
$lang_global['admin_no_allow_func'] = 'Vous n\'êtes pas authorisé d\'accéder à cette fonction';
$lang_global['admin_suspend'] = 'Est suspendu';
$lang_global['block_modules'] = 'Blocks de modules';
$lang_global['hello_admin1'] = 'Vous vous êtes connecté pour la dernière fois à votre compte administrateur à %1$s via l\'adresse IP %2$s';
$lang_global['hello_admin2'] = 'Vous vous êtes connecté à votre compte administrateur à %1$s via l\'adresse IP %2$s';
$lang_global['ftp_error_account'] = 'Erreur: Impossible de se connecter au serveur FTP, merci de vérifier la configuration de FTP';
$lang_global['ftp_error_path'] = 'Erreur: Chemin d\'accès incorrect';
$lang_global['login_error_account'] = 'Erreur: Compte d\'Administrateur manquant ou invalide (pas moins de %1$s caractères, ni plus de  %2$s caractères. Utilisez uniquement les lettres latines, chiffres et tiret)';
$lang_global['login_error_password'] = 'Erreur: Mot de passe manquant ou invalide! (pas moins de %1$s caractères, ni plus de %2$s caractères combinés de lettres latines et chiffres)';
$lang_global['login_error_security'] = 'Erreur: Code de sécurité manquant ou invalide! (il faut %1$s caractères combinés de lettres latines et chiffres)';
$lang_global['error_zlib_support'] = 'Erreur: votre serveur ne supporte pas l\'extension zlib, veuillez demander votre hébergeur de l\'activer pour utiliser cette fonction.';
$lang_global['error_zip_extension'] = 'Erreur: votre serveur ne supporte pas l\'extension ZIP, veuillez demander votre hébergeur de l\'activer pour utiliser cette fonction.';
$lang_global['length_characters'] = 'Nombre de caractères';
$lang_global['length_suggest_max'] = 'Nombre de caractères à saisir';
$lang_global['phone_note_title'] = 'Règle de déclarer le numéro de téléphone';
$lang_global['phone_note_content'] = 'Le numéro de téléphone est divisé en 2 parties. La première partie est obligée et est utilisée pour l\'affichage sur le site, la deuxième est facultative et est utilisée pour faire les appels un fois qu\'on clique au dessus.La première partie est écrite librement sans utiliser le crochet. La deuxième partie est mise entre les crochets juste après la première partie et ne contient que les caractères suivants: chiffre, étoile, dièse, virgule, point, point-virgule et plus ([0-9\*\#\.\,\;\+]).Par exemple, si vous utiliser <strong>0438211725 (ext 601)</strong>, alors le numéro <strong>0438211725 (ext 601)</strong> sera affiché simplement sur le site. Si vous déclarez <strong>0438211725 (ext 601)[+84438211725,601]</strong>, alors le système va afficher <strong>0438211725 (ext 601)</strong> sur le site et l\'url quand vous cliquer sur ce dernier sera <strong>tel:+84438211725,601</strong>Vous pouvez déclarer plusieurs numéros selon la règle au dessus. Il sont séparé par |.';
$lang_global['phone_note_content2'] = 'Le numéro de téléphone est divisé en 2 parties. La première partie est obligée et est utilisée pour l\'affichage sur le site, la deuxième est facultative et est utilisée pour faire les appels un fois qu\'on clique au dessus.La première partie est écrite librement sans utiliser le crochet. La deuxième partie est mise entre les crochets juste après la première partie et ne contient que les caractères suivants: chiffre, étoile, dièse, virgule, point, point-virgule et plus ([0-9\*\#\.\,\;\+]).Par exemple, si vous utiliser <strong>0438211725 (ext 601)</strong>, alors le numéro <strong>0438211725 (ext 601)</strong> sera affiché simplement sur le site. Si vous déclarez <strong>0438211725 (ext 601)[+84438211725,601]</strong>, alors le système va afficher <strong>0438211725 (ext 601)</strong> sur le site et l\'url quand vous cliquer sur ce dernier sera <strong>tel:+84438211725,601</strong>.';
$lang_global['multi_note'] = 'Pouvez déclarer plus qu\'une valeur. Les valeurs sont séparées par les point-virgule';
$lang_global['multi_email_note'] = 'Pouvez déclarer plus qu\'une valeur. Les valeurs sont séparées par les point-virgule. La première adresse email est considéré comme la principale et qui sera utilisée pour envoyer et recevoir des messages';
$lang_global['view_all'] = 'voir tous les';
$lang_global['email'] = 'E-mail';
$lang_global['phonenumber'] = 'Téléphone';
$lang_global['admin_pre_logout'] = 'Pas moi, déconnectez-vous';
$lang_global['admin_hello_2step'] = 'Hé! <strong class="admin-name">%s</strong>, veuillez vérifier votre compte';
$lang_global['admin_noopts_2step'] = 'Aucune méthode de vérification en deux étapes n\'a été accordée, vous ne pouvez pas vous connecter temporairement à l\'administrateur';
$lang_global['admin_mactive_2step'] = 'Vous ne pouvez pas vérifier car aucune méthode n\'a encore été activée';
$lang_global['admin_mactive_2step_choose0'] = 'Veuillez cliquer sur le bouton ci-dessous pour activer la méthode de vérification';
$lang_global['admin_mactive_2step_choose1'] = 'Veuillez sélectionner l\'une des méthodes de vérification ci-dessous';
$lang_global['admin_2step_opt_code'] = 'Étape 2 - Code de Vérification';
$lang_global['admin_2step_opt_facebook'] = 'Compte Facebook';
$lang_global['admin_2step_opt_google'] = 'Compte Google';
$lang_global['admin_2step_opt_zalo'] = 'Compte Zalo';
$lang_global['admin_2step_opt_key'] = 'Clé de sécurité ou clé de passe';
$lang_global['admin_setup_2fa_keycode'] = 'Application 2FA ou clé d\'accès';
$lang_global['admin_2step_other'] = 'Autres méthodes';
$lang_global['admin_oauth_error_getdata'] = 'Erreur: Le système n\'a pas reconnu les données de vérification. Échec de la vérification!';
$lang_global['admin_oauth_error_email'] = 'Erreur: L\'email de retour n\'est pas valide, vous ne pouvez pas vérifier';
$lang_global['admin_oauth_error_savenew'] = 'Erreur: Impossible d\'enregistrer les données de vérification';
$lang_global['admin_oauth_error'] = 'Erreur: La vérification n\'est pas valide, ce compte n\'a pas été autorisé à vérifier';
$lang_global['acp'] = 'Administration du site';
$lang_global['login_session_expire'] = 'Votre session de connexion expirera dans';
$lang_global['account_settings'] = 'Paramètres du compte';
$lang_global['your_admin_account'] = 'Votre compte administrateur';
$lang_global['login_name'] = 'Identifiant';
$lang_global['login_name_type_username'] = 'Nom d\'utilisateur';
$lang_global['login_name_type_email'] = 'Email';
$lang_global['login_name_type_email_username'] = 'Nom d\'utilisateur ou email';
$lang_global['interface_current_menu'] = 'Module actuel';
$lang_global['interface_other_menu'] = 'Autres modules';

$lang_global['merge_field_author_delete_time'] = 'Temps de suppression';
$lang_global['merge_field_author_delete_reason'] = 'Motif de la suppression';
$lang_global['merge_field_contact_link'] = 'Lien de contact';
$lang_global['merge_field_is_suspend'] = 'Suspendre (1) ou réactiver (0)';
$lang_global['merge_field_time'] = 'Temps d\'exécution';
$lang_global['merge_field_reason'] = 'Raison de la mise en œuvre';
$lang_global['merge_field_sys_siteurl'] = 'URL du site de base';
$lang_global['merge_field_sys_nv'] = 'Module var';
$lang_global['merge_field_sys_op'] = 'Op var';
$lang_global['merge_field_sys_langvar'] = 'Language var';
$lang_global['merge_field_sys_langdata'] = 'Lang data';
$lang_global['merge_field_sys_langinterface'] = 'Lang interface';
$lang_global['merge_field_sys_assetsdir'] = 'Thumb dir du système';
$lang_global['merge_field_sys_filesdir'] = 'Thumb dir du module';
