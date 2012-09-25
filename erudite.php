<?php
/**
 * Erudite MW skin
 *
 * @file
 * @ingroup Skins
 * @author Matt Wiebe, Colin Andrew Ferm, Nick White
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Erudite',
	'url' => "http://www.unifiedrepublicofstars.com/reference/The_Unified_Republic_of_Stars:Skin",
	'author' => 'Colin Andrew Ferm',
	'descriptionmsg' => 'Based on The Erudite theme for Wordpress by Matt Wiebe.',
);

$wgValidSkinNames['erudite'] = 'Erudite';
$wgAutoloadClasses['SkinErudite'] = dirname(__FILE__).'/Erudite.skin.php';
$wgExtensionMessagesFiles['Erudite'] = dirname(__FILE__).'/Erudite.i18n.php';

$wgResourceModules['skins.erudite'] = array(
	'styles' => array(
		'erudite/assets/erudite.css' => array( 'media' => 'screen' ),
		'erudite/assets/wiki-style.css' => array( 'media' => 'screen' ),
		'erudite/assets/print.css' => array( 'media' => 'print' ),
	),
	'remoteBasePath' => &$GLOBALS['wgStylePath'],
	'localBasePath' => &$GLOBALS['wgStyleDirectory'],
);
