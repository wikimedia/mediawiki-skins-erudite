<?php
/**
 * Erudite skin
 * Based off The Erudite skin for Wordpress.
 *
 * @file
 * @ingroup Skins
 */

class SkinErudite extends SkinTemplate {

	var $skinname = 'erudite', $stylename = 'erudite',
		$template = 'EruditeTemplate', $useHeadElement = true;

	/**
	 * @param $out OutputPage object
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles( "skins.erudite" );
		/* some versions of ie need css workarounds */
		$out->addStyle( 'erudite/assets/ie6.css', 'screen', 'IE 6' );
		$out->addStyle( 'erudite/assets/ie7.css', 'screen', 'IE 7' );
		$out->addStyle( 'erudite/assets/ie8.css', 'screen', 'IE 8' );
	}
}

class EruditeTemplate extends BaseTemplate {
	/**
	 * Like msgWiki() but it ensures edit section links are never shown.
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
		global $wgEruditeBannerImg;

		// suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

		$this->html( 'headelement' );

		if ( !isset($this->data['sitename']) ) {
			global $wgSitename;
			$this->set( 'sitename', $wgSitename );
		}

		?>
<?php if($this->data['showjumplinks']) { ?>
<div class="mw-jump">
	<a href="#content"><?php $this->msg( 'erudite-skiptocontent' ) ?></a><?php $this->msg( 'comma-separator' ) ?>
	<a href="#search"><?php $this->msg( 'erudite-skiptosearch' ) ?></a>
</div>
<?php } ?>
<div id="wrapper" class="hfeed">
	
	<?php
		if ( isset( $wgEruditeBannerImg ) ) {
			echo '<div id="header-wrap" style="background-image: url(' . $wgEruditeBannerImg . ')">';
		} else {
			echo '<div id="header-wrap">';
		}
	?>
		<div id="header" role="banner">
			<h1 id="siteTitle"><span><a href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ?>" title="<?php $this->text( 'sitename' ); ?>" rel="home"><?php $this->text( 'sitename' ); ?></a></span></h1>
			<div id="siteSubtitle"><?php $this->msg('tagline') ?></div>
		</div><!-- #header -->

		<div id="access" role="navigation">
			<div id="menu">
			<ul id="menu-urs" class="menu">
				<?php foreach( $this->data['sidebar']['navigation'] as $key => $val ) { ?>
					<li id="menu-item-<?php echo Sanitizer::escapeId( $val['id'] ) ?>" class="menu-item menu-item-type-post_type menu-item">
						<a href="<?php echo htmlspecialchars( $val['href'] ) ?>"><?php echo htmlspecialchars( $val['text'] ) ?></a>
					</li>
				<?php } ?>
			</ul>
		</div>
		</div><!-- #access -->

	</div><!-- #header-wrap -->

	<!-- MESSAGES -->
	<div id="mw-js-message" style="display:none;"></div>
	<?php
		foreach(array('newtalk','sitenotice','subtitle','undelete') as $msg) {
			if($this->data[$msg]) {
				echo '<div id="' .$msg. '" class="message">';
				$this->html($msg);
				echo '</div>';
			}
		}
	?>
				
	<div id="container">
		<div id="content" class="mw-body" role="main">
			<div id="content-container" class="post type-post category-submissions">
				<h2 class="entry-title"><?php $this->html('title'); ?></h2>
				<?php if ($this->data['subtitle']) { ?>
					<span class="entry-sub-title"><?php $this->html('subtitle') ?></span><br/><br/>
				<?php } ?>
				<!-- META -->
				<div class="entry-meta">
				<?php
					foreach ( $this->data['content_actions'] as $key => $tab ) {
						echo $this->makeListItem( $key, $tab, array( 'tag' => 'span' ) );
						echo '<span class="meta-sep">|</span>';
					}
				?>
				</div>
				<!-- END META -->
				<div id="bodyContent" class="entry-content">

				<!-- INSERT WIKI STUFF HERE -->
				<?php $this->html('bodytext') ?>
				<?php $this->html('dataAfterContent'); ?>

				</div>
			</div><!-- .post -->

			<div id="footer">
				<?php foreach ( $this->getFooterLinks() as $category => $links ) {
					if ( $category === 'info' ) {
						foreach ( $links as $key ) {
							printf( "<p>%s</p>\n", $this->html( $key ) );
						}
					} else {
						echo '<ul>';
						foreach ( $links as $key ) {
							printf( "<li>%s</li>\n", $this->html( $key ) );
						}
						echo '</ul>';
					}
				} ?>
			</div>

			<div id="nav-below" class="navigation">
				<?php $this->html('catlinks'); ?>
			</div>

		</div><!-- #content -->
	</div><!-- #container -->


	<div id="footer-wrap">
		<div id="footer-wrap-inner">

		<div id="primary" class="footer">
			<ul>

			<li id="search" class="widget">
				<h3><?php $this->msg('search') ?></h3>
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

			<?php if($this->data['language_urls']) { ?>
				<li>
					<h3><?php $this->msg('otherlanguages') ?></h3>
					<ul>
					<?php
					foreach( $this->data['language_urls'] as $key => $langlink ) {
						echo $this->makeListItem( $key, $langlink );
					} ?>
					</ul>
				</li>
			<?php } ?>

			<?php if( $this->getPersonalTools() != array() ) { ?>
			<li class="widget">
				<h3><?php $this->msg('personaltools') ?></h3>

				<div>
					<ul>
					<?php
					foreach ( $this->getPersonalTools() as $key => $item ) {
						echo $this->makeListItem( $key, $item );
					} ?>
					</ul>
				</div>
			</li>
			<?php } ?>

			<li class="widget">
				<?php echo $this->msgWikiNoEdit( 'erudite-extracontent-column1' ); ?>
			</li>

			</ul>
		</div><!-- #primary .sidebar -->

		<div id="secondary" class="footer">
			<ul>

			<li id="toolbox" class="widget">
				<h3><?php $this->msg('toolbox') ?></h3>
				<ul>
				<?php
				foreach ( $this->getToolbox() as $key => $tbitem ) {
					echo $this->makeListItem( $key, $tbitem );
				}
				wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this ) ); ?>
				</ul>
			</li>

			<li class="widget">
				<?php echo $this->msgWikiNoEdit( 'erudite-extracontent-column2' ); ?>
			</li>

			</ul>
		</div><!-- #secondary .sidebar -->

		<div id="ternary" class="footer">
			<ul>

			<li class="widget">
				<?php echo Html::element( 'img', array( 'id' => "logo", 'src' => $this->data['logopath'], 'alt' => "" ) ); ?>
			</li>

			<li class="widget">
				<?php echo $this->msgWikiNoEdit( 'erudite-extracontent-column3' ); ?>
			</li>

			</ul>
		</div><!-- #ternary .sidebar -->
		<div class="visualClear"></div>

		</div><!-- #footer-wrap-inner -->
	</div><!-- #footer-wrap -->

</div><!-- #wrapper .hfeed -->
<?php $this->printTrail(); ?>
</body>
</html>
		<?php
		wfRestoreWarnings();
	}
}
