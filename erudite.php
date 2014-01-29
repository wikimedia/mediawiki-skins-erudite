<?php
/**
 * Erudite MW skin
 *
 * @file
 * @ingroup Skins
 * @author Nick White
 * @author Matt Wiebe
 * @author Colin Andrew Ferm
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) die( 'This is an extension to the MediaWiki package and cannot be run standalone.' );

$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Erudite',
	'url' => 'https://www.mediawiki.org/wiki/Skin:Erudite',
	'author' => array( 'Nick White', 'Matt Wiebe', 'Colin Andrew Ferm' ),
	'version' => '1.8',
	'descriptionmsg' => 'erudite-desc',
);

$wgValidSkinNames['erudite'] = 'Erudite';
$wgAutoloadClasses['SkinErudite'] = dirname(__FILE__) . '/Erudite.skin.php';
$wgExtensionMessagesFiles['Erudite'] = dirname(__FILE__) . '/Erudite.i18n.php';

$wgResourceModules['skins.erudite'] = array(
	'styles' => array(
		'erudite/assets/cssreset.css' => array( 'media' => 'screen' ),
		'erudite/assets/erudite.css' => array( 'media' => 'screen' ),
		'erudite/assets/erudite66em.css' => array( 'media' => 'screen and (max-width: 66em)' ),
		'erudite/assets/erudite60em.css' => array( 'media' => 'screen and (max-width: 60em)' ),
		'erudite/assets/erudite55em.css' => array( 'media' => 'screen and (max-width: 55em)' ),
		'erudite/assets/erudite40em.css' => array( 'media' => 'screen and (max-width: 40em)' ),
		'erudite/assets/erudite20em.css' => array( 'media' => 'screen and (max-width: 20em)' ),
		'erudite/assets/print.css' => array( 'media' => 'print' ),
	),
	'remoteBasePath' => &$GLOBALS['wgStylePath'],
	'localBasePath' => &$GLOBALS['wgStyleDirectory'],
);
