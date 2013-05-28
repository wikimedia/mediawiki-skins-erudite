<?php
/**
 * Erudite MW skin
 *
 * @file
 * @ingroup Skins
 * @author Matt Wiebe
 * @author Colin Andrew Ferm
 * @author Nick White
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Erudite',
	'url' => "https://www.mediawiki.org/wiki/Skin:Erudite",
	'author' => array( 'Matt Wiebe', 'Colin Andrew Ferm', 'Nick White' ),
	'descriptionmsg' => 'erudite-desc',
);

$wgValidSkinNames['erudite'] = 'Erudite';
$wgAutoloadClasses['SkinErudite'] = dirname(__FILE__).'/Erudite.skin.php';
$wgExtensionMessagesFiles['Erudite'] = dirname(__FILE__).'/Erudite.i18n.php';

$wgResourceModules['skins.erudite'] = array(
	'styles' => array(
		'erudite/assets/erudite.css' => array( 'media' => 'screen' ),
		'erudite/assets/print.css' => array( 'media' => 'print' ),
	),
	'remoteBasePath' => &$GLOBALS['wgStylePath'],
	'localBasePath' => &$GLOBALS['wgStyleDirectory'],
);
