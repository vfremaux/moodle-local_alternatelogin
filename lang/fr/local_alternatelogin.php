<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Page de connexion alternative';
$string['privacy:metadata'] = 'Ce plugin ne détient aucune donnée personnelle.';

$string['appearance'] = 'Apparence';
$string['accountcreated'] = 'Le compte a été créé';
$string['alternatelogin'] = 'Page de connexion alternative';
$string['alternatelogin_help'] = '<a href="{$a}">Voir la page de connexion</a>';
$string['arialabel'] = 'Icone de site';
$string['captchainstr'] = 'Copiez tous les nombres que vous voyez (dans l\'ordre)';
$string['close'] = 'Fermer';
$string['configaccepteddomains'] = 'Domaines autorisés';
$string['configaccepteddomains_desc'] = 'Si non vide, donne la liste des domaines de courriels autorisés pour l\'auto-inscription';
$string['configenabled'] = 'Activé';
$string['configenabled_desc'] = 'Si désactivé, les pages accessibles de ce plugin ne fonctionneront pas.';
$string['configextracss'] = 'CSS supplémentaire';
$string['configextracss_desc'] = 'Régles CSS supplémentaires spécifiques à la page de connexion';
$string['configloginusesmail'] = 'Le login utilise l\'adresse courriel';
$string['configloginusesmail_desc'] = 'Ajoute un signal de courriel explicite sur le champ d\identifiant';
$string['configmodalinfo'] = 'Info modale additionnelle';
$string['configmodalinfo_desc'] = 'If enabled, will add a modal popup openable with a link having href="#alternate-login-info" and rel="modal:open" ';
$string['configmodaltitle'] = 'Titre de la fenêtre modale';
$string['configmodaltitle_desc'] = 'Titre de la fenêtre modale';
$string['confignofooter'] = 'Sans pied de page';
$string['confignofooter_desc'] = 'Si actif, n\'imprime pas le pied de page';
$string['confignoheader'] = 'Sans en-tête';
$string['confignoheader_desc'] = 'Si actif, n\'imprime pas le haut de page';
$string['configprofilefield'] = 'Champ de profil';
$string['configneedsconfirm'] = 'Confirmation nécessaire';
$string['configneedsconfirm_desc'] = 'Si activé, les comptes sont créés "non confirmés"';
$string['confignotifyusers'] = 'Utilisateurs à notifier';
$string['confignotifyusers_desc'] = 'Si une liste d\' id numériques ou d\'identifiants d\'utilisateurs est donnée, envoie un message de notification de creation de compte à ces utilisateurs.';
$string['configprofilefield_desc'] = 'Nom court du champ de profil pour les options du deuxième panneau d\'enregistrement';
$string['configrendererimages'] = 'Images pour la mise en page';
$string['configrendererimages_desc'] = 'Une collection d\'images qui peuvent être appelées dans les CSS supplémentaires, avec des balises {{#pluginfile}}<nomfichier>{{/pluginfile}}';
$string['configresultingauthmethod'] = 'Authentification résultante';
$string['configresultingauthmethod_desc'] = 'Tous les comptes créés à travers la page de login alternative seront créés pour cette méthode d\'authentification';
$string['configsignuptext'] = 'Text du signup';
$string['configsignuptext_desc'] = 'If enabled, will add a signup text.';
$string['configstylesheets'] = 'Feuilles de style';
$string['configstylesheets_desc'] = 'La liste (à virgules) de feuilles de style du theme principal à appeler lorsque l\'en-tête est omise.';
$string['configwelcometext'] = 'Texte de bienvenue';
$string['configwelcometext_desc'] = 'Texte éventuel affiché en dessous des formulaires.';
$string['configsignupcode'] = 'Code d\'inscription';
$string['configsignupcode_desc'] = 'si défini, ajoute un champ de saisie d\'une clef d\'autorisation pour la création de profils.';
$string['configwithcapcha'] = 'Activer le capcha';
$string['configwithcapcha_desc'] = 'Si activé, ajoute un capcha de sécurité à la fin du formulaire.';
$string['configwithcountry'] = 'Afficher le pays';
$string['configwithcountry_desc'] = 'Si activé, permet de choisir le pays du profil.';
$string['configcivilityfield'] = 'Champ de civilité';
$string['configcivilityfield_desc'] = 'Un champ de profil personnalisé qui enregistre la civilité. La civilité n\'est pas présentée sinon.';
$string['confirmpassword'] = 'Mot de passe (confirmation)';
$string['defaultlogin'] = 'max.imum@gmail.com';
$string['dologin'] = 'Identifiez-vous';
$string['emailconfirm'] = 'Adresse de courriel (confirmation)';
$string['email'] = 'Courriel';
$string['errorcapchacheck'] = 'Le capcha n\'a pas pu être vérifié.';
$string['errorempty'] = 'Ce champ nécessite une valeur';
$string['errornotinvaliddomains'] = 'Votre adresse de courriel doit être dans un des domaines acceptés';
$string['errorexists'] = 'Un compte existe déjà pour cette adresse.';
$string['errorexistsinternal'] = 'Cette adresse de courriel est déjà utilisée pour un compte interne.';
$string['errormalformed'] = 'L\'adresse de courriel est malformée.';
$string['errornomatch'] = 'Les valeurs ne correspondent pas';
$string['errorpasswordpolicy'] = 'Le mot de passe ne respecte pas les règles de sécurité demandées.';
$string['erroremptysignupcode'] = 'Un code d\'autorisation est requis pour s\'inscrire.';
$string['errorwrongsignupcode'] = 'Le code d\'autorisation n\est pas correct.';
$string['login'] = 'Identifiant';
$string['loginerror1'] = '<span data-error=\"{$a->error}\">Les cookies ne sont pas autorisés.</span>';
$string['loginerror2'] = '<span data-error=\"{$a->error}\">L\'identifiant n\'est pas conforme aux règles locales de sécurité.</span>';
$string['loginerror3'] = '<span data-error=\"{$a->error}\">Le mot de passe n\'a pas pu être vérifié pour ce compte.</span>';
$string['loginerror4'] = '<span data-error=\"{$a->error}\">Ce compte est verrouilé.</span>';
$string['loginerror5'] = '<span data-error=\"{$a->error}\">Ce compte n\'est pas autorisé.</span>';
$string['loginerror6'] = '<span data-error=\"{$a->error}\">Cet identifiant n\'est pas connu.</span>';
$string['loginerror99'] = '<span data-error=\"{$a->error}\">Erreur non répertoriée pour ce compte (ID \'{$a->error}\').</span>';
$string['loginoremail'] = 'Identifiant (ou courriel)';
$string['mr'] = 'M.';
$string['mrs'] = 'Mme';
$string['mydashboard'] = 'Mon tableau de bord';
$string['newaccount'] = 'Nouveau compte';
$string['newuser'] = 'Nouvel utilisateur';
$string['nopaste'] = 'Le copier/coller est interdit sur ces champs.';
$string['notifications'] = 'Notifications';
$string['send'] = 'Créer le compte';
$string['signin'] = 'Se connecter';
$string['signup'] = 'S\'inscrire';
$string['signupcode'] = 'Entrez le code d\'autorisation';
$string['sitealternatename'] = 'Plate-forme pédagogique';
$string['tosignin'] = 'Passer à Se connecter';
$string['tosignup'] = 'Passer à Créer un compte';
$string['unset'] = '-- Non défini --';

$string['emailconfirmationsubject'] = '{$a} - Confirmez votre compte';
$string['confirminstructions'] = '
<p>Votre compte a été créé et est maintenant en état <b>non confirmé</b>.
<p>Vous allez recevoir un courriel de confirmation
dans les prochaines minutes sur l\'adresse de courriel <b>{$a}</b>. Cliquez sur le lien de confirmation pour activer votre compte
et rejoindre votre tableau de bord.</p>
';

$string['emailconfirmation'] = '
Vous avez un compte en attente de confirmation.

Pour confirmer votre compte, Rendez vous sur le lien suivant et suivez les instructions : {$a->link}
';

$string['emailnotificationsubject'] = '[{$a->sitename}] - Compte utilisateur créé';
$string['emailnotification'] = '
[{$a->sitename}] - Compte utilisateur créé

Créé par {$a->name}
Identifiant : {$a->username}
courriel : $a->email
{$a->extradata}
';
