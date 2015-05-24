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
	'version' => '1.9',
	'descriptionmsg' => 'erudite-desc',
);

$wgValidSkinNames['erudite'] = 'Erudite';
$wgAutoloadClasses['SkinErudite'] = __DIR__ . '/Erudite.skin.php';
$wgMessagesDirs['Erudite'] = __DIR__ . '/i18n';
$wgResourceModules['skins.erudite'] = array(
	'styles' => array(
		'assets/cssreset.css' => array( 'media' => 'screen' ),
		'assets/erudite.css' => array( 'media' => 'screen' ),
		'assets/erudite66em.css' => array( 'media' => 'screen and (max-width: 66em)' ),
		'assets/erudite60em.css' => array( 'media' => 'screen and (max-width: 60em)' ),
		'assets/erudite55em.css' => array( 'media' => 'screen and (max-width: 55em)' ),
		'assets/erudite40em.css' => array( 'media' => 'screen and (max-width: 40em)' ),
		'assets/erudite20em.css' => array( 'media' => 'screen and (max-width: 20em)' ),
		'assets/print.css' => array( 'media' => 'print' ),
	),
	'remoteSkinPath' => 'erudite',
	'localBasePath' => __DIR__,
);
