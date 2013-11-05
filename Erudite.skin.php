<?php
/**
 * Erudite skin
 *
 * @file
 * @ingroup Skins
 */

class SkinErudite extends SkinTemplate {

	var $skinname = 'erudite', $stylename = 'erudite',
		$template = 'EruditeTemplate', $useHeadElement = true;

	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		/* Assures mobile devices that the site doesn't assume traditional
		 * desktop dimensions, so they won't downscale and will instead respect
		 * things like CSS's @media rules */
		$out->addHeadItem( 'viewport',
			'<meta name="viewport" content="width=device-width, initial-scale=1">'
		);
	}

	/**
	 * @param $out OutputPage object
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles( 'skins.erudite' );
	}
}

class EruditeTemplate extends BaseTemplate {
	/**
	 * Like msgWiki() but it ensures edit section links are never shown.
	 *
	 * Needed for Mediawiki 1.19 & 1.20 due to bug 36975:
	 * https://bugzilla.wikimedia.org/show_bug.cgi?id=36975
	 *
	 * @param $message Name of wikitext message to return
	 */
	function msgWikiNoEdit( $message ) {
		global $wgOut;
		global $wgParser;

		$popts = new ParserOptions();
		$popts->setEditSection( false );
		$text = wfMessage( $message )->text();
		return $wgParser->parse( $text, $wgOut->getTitle(), $popts )->getText();
	}

	/**
	 * Template filter callback for this skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 */
	public function execute() {
		$this->html( 'headelement' );

		if ( !isset( $this->data['sitename'] ) ) {
			global $wgSitename;
			$this->set( 'sitename', $wgSitename );
		}

		?>

		<?php if( $this->data['showjumplinks'] ) { ?>
		<div class="mw-jump">
			<a href="#content"><?php $this->msg( 'erudite-skiptocontent' ) ?></a><?php $this->msg( 'comma-separator' ) ?>
			<a href="#search"><?php $this->msg( 'erudite-skiptosearch' ) ?></a>
		</div>
		<?php } ?>
		<div id="wrapper" class="hfeed">

		<!-- header -->
		<div id="header-wrap">

		<div id="header" role="banner">
			<h1 id="siteTitle"><a href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ?>" title="<?php $this->text( 'sitename' ); ?>" rel="home"><?php $this->text( 'sitename' ); ?></a></h1>
			<div id="tagline"><?php $this->msg( 'tagline' ) ?></div>
		</div>

		<div id="access" role="navigation">
			<div id="menu">
			<ul id="menu-urs" class="menu">
			<?php
				foreach( $this->data['sidebar']['navigation'] as $key => $val ) {
					printf( '<li id="menu-item-%s" class="menu-item">', Sanitizer::escapeId( $val['id'] ) );
					printf( '<a href="%s">%s</a>', htmlspecialchars( $val['href'] ), htmlspecialchars( $val['text'] ) );
					echo "</li>\n";
				}
			?>
			</ul>
			</div>
		</div>
		</div>
		<!-- /header -->

		<div id="mw-js-message"></div>
		<?php
			foreach( array( 'newtalk', 'sitenotice', 'undelete' ) as $msg ) {
				if( $this->data[$msg] ) {
					echo "<div id='$msg' class='message'><p>";
					$this->html( $msg );
					echo '</p></div>';
				}
			}
		?>

		<!-- content -->
		<div id="container">
		<div id="content" class="mw-body" role="main">
			<div id="content-container">
				<h1 class="entry-title"><?php $this->html( 'title' ); ?></h1>
				<?php if ( $this->data['subtitle'] ) { ?>
					<div class="subtitle"><?php $this->html( 'subtitle' ) ?></div>
				<?php } ?>

				<div class="entry-meta">
				<?php
					foreach ( $this->data['content_actions'] as $key => $tab ) {
						echo $this->makeListItem( $key, $tab, array( 'tag' => 'span' ) );
						echo '<span class="meta-sep">|</span>';
					}
				?>
				</div>

				<div id="bodyContent" class="entry-content">

				<?php $this->html( 'bodytext' ) ?>
				<?php $this->html( 'dataAfterContent' ); ?>

				</div>
			</div>

			<div id="footer">
				<?php
					foreach ( $this->getFooterLinks() as $category => $links ) {
						if ( $category === 'info' ) {
							foreach ( $links as $key ) {
								echo '<p>';
								$this->html( $key );
								echo '</p>';
							}
						} else {
							echo '<ul>';
							foreach ( $links as $key ) {
								echo '<li>';
								$this->html( $key );
								echo '</li>';
							}
							echo '</ul>';
						}
					}
				?>
			</div>

			<?php $this->html( 'catlinks' ); ?>

		</div>
		</div>
		<!-- /content -->

		<!-- footer -->
		<div id="footer-wrap">
		<div id="footer-wrap-inner">

		<div id="primary" class="footer">
			<ul>

			<li id="search" class="widget">
				<h3><?php $this->msg( 'search' ) ?></h3>
				<form action="<?php $this->text( 'wgScript' ); ?>" id="searchform">
					<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>" />
					<div>
						<?php echo $this->makeSearchInput( array( 'type' => 'text', 'id' => 's' ) ); ?>
						<?php echo $this->makeSearchButton( 'go', array(
							'value' => $this->translator->translate( 'searchbutton' ),
							'class' => "searchButton",
							'id'    => "searchsubmit",
						) ); ?>
					</div>
				</form>
			</li>

			<?php if( $this->data['language_urls'] ) { ?>
				<li>
					<h3><?php $this->msg( 'otherlanguages' ) ?></h3>
					<ul>
					<?php
						foreach( $this->data['language_urls'] as $key => $langlink ) {
							echo $this->makeListItem( $key, $langlink );
						}
					?>
					</ul>
				</li>
			<?php } ?>

			<?php if( $this->getPersonalTools() ) { ?>
			<li class="widget">
				<h3><?php $this->msg( 'personaltools' ) ?></h3>
				<div>
					<ul>
					<?php
						foreach ( $this->getPersonalTools() as $key => $item ) {
							echo $this->makeListItem( $key, $item );
						}
					?>
					</ul>
				</div>
			</li>
			<?php } ?>

			<li class="widget">
				<?php echo $this->msgWikiNoEdit( 'erudite-extracontent-column1' ); ?>
			</li>

			</ul>
		</div>

		<div id="secondary" class="footer">
			<ul>

			<li id="toolbox" class="widget">
				<h3><?php $this->msg( 'toolbox' ) ?></h3>
				<ul>
				<?php
					foreach ( $this->getToolbox() as $key => $tbitem ) {
						echo $this->makeListItem( $key, $tbitem );
					}
					wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this ) );
				?>
				</ul>
			</li>

			<li class="widget">
				<?php echo $this->msgWikiNoEdit( 'erudite-extracontent-column2' ); ?>
			</li>

			</ul>
		</div>

		<div id="ternary" class="footer">
			<ul>

			<li class="widget">
				<?php echo Html::element( 'img', array( 'id' => 'logo', 'src' => $this->data['logopath'], 'alt' => '' ) ); ?>
			</li>

			<li class="widget">
				<?php echo $this->msgWikiNoEdit( 'erudite-extracontent-column3' ); ?>
			</li>

			</ul>
		</div>
		<div class="visualClear"></div>

		</div>
		</div>
		<!-- /footer -->

		</div>
		<?php $this->printTrail(); ?>
		</body>
		</html>
		<?php
	}
}
