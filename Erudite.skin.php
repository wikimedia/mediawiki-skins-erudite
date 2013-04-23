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
	private function newpages() {
		$tables = array('recentchanges');
		$fields = array('rc_title');
		$conds  = array('rc_type' => RC_NEW, 'rc_namespace' => 0);
		$options = array('ORDER BY' => 'rc_timestamp DESC', 'LIMIT' => 5);
		$join_conds = array();

		$mDb = wfGetDB(DB_SLAVE);

		$res = $mDb->select($tables, $fields, $conds, __METHOD__, $options, $join_conds);

		$pgs = array();
		foreach($res->result as $i) {
			$name = str_replace('_', ' ', $i['rc_title']);
			$url = $this->getSkin()->makeUrl($i['rc_title']);
			$pgs[] = array('name' => $name, 'url' => $url);
		}

		return $pgs;
	}

	/**
	 * Template filter callback for this skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 */
	public function execute() {
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
	<a href="#p-search"><?php $this->msg( 'erudite-skiptosearch' ) ?></a>
</div>
<?php } ?>
<div id="wrapper" class="hfeed">
	
	<div id="header-wrap">
		<div id="header" role="banner">
			<?php echo Html::element( 'img', array( 'id' => "logo", 'src' => $this->data['logopath'], 'alt' => "" ) ); ?>
			<h1 id="blog-title"><span><a href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ?>" title="<?php $this->text( 'sitename' ); ?>" rel="home"><?php $this->text( 'sitename' ); ?></a></span></h1>
			<div id="blog-description"><?php $this->msg('tagline') ?></div>
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
				<div id="bodyContent" class="entry-content">

				<!-- INSERT WIKI STUFF HERE -->
				<?php $this->html('bodytext') ?>
				<?php $this->html('dataAfterContent'); ?>
				

				<br/><br/>
				</div>
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
			</div><!-- .post -->

			<div id="nav-below" class="navigation">
				<?php $this->html('catlinks'); ?>
			</div>

		</div><!-- #content -->
	</div><!-- #container -->


	<div id="footer-wrap">
		<div id="footer-wrap-inner">

		<div id="primary" class="footer">
			<ul class="xoxo">

			<li id="rss-just-better-3" class="widget rssjustbetter">
				<h3 class="widgettitle"><?php $this->msg('newpages'); ?></h3>
				<ul id="newestPages">
				<?php foreach($this->newpages() as $i) {
					printf('<li><a href="%s">%s</a></li>', htmlspecialchars($i['url']), htmlspecialchars($i['name']));
				} ?>
				</ul>
			</li>

			</ul>
		</div><!-- #primary .sidebar -->

		<div id="secondary" class="footer">
			<ul class="xoxo">

			<?php if($this->data['language_urls']) { ?>
				<li class="widget widget_meta">
					<h3 class="widgettitle"><?php $this->msg('otherlanguages') ?></h3>
					<ul>
<?php
					foreach( $this->data['language_urls'] as $key => $langlink ) {
						echo $this->makeListItem( $key, $langlink );
					} ?>
					</ul>
				</li>
			<?php } ?>

			<li id="meta-2" class="widget widget_meta">
				<h3 class="widgettitle"><?php $this->msg('toolbox') ?></h3>
				<ul>
<?php
				foreach ( $this->getToolbox() as $key => $tbitem ) {
					echo $this->makeListItem( $key, $tbitem );
				}
				wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this ) ); ?>
				</ul>
			</li>

			</ul>
		</div><!-- #secondary .sidebar -->

		<div id="ternary" class="footer">
			<ul class="xoxo">

			<li id="p-search" class="widget widget_search">
				<h3 class="widgettitle"><?php $this->msg('search') ?></h3>
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

			<li id="nav_menu-3" class="widget widget_nav_menu">
				<h3 class="widgettitle"><?php $this->msg('personaltools') ?></h3>

				<div class="menu-bottom-menu-container">
					<ul id="menu-bottom-menu" class="menu">
<?php
					foreach ( $this->getPersonalTools() as $key => $item ) {
						echo $this->makeListItem( $key, $item );
					} ?>
					</ul>
				</div>
			</li>

			</ul>
		</div><!-- #ternary .sidebar -->

		<div id="footer">
<?php
			foreach ( $this->getFooterLinks() as $category => $links ) {
				if ( $category === 'info' ) {
					foreach ( $links as $key ) { ?>
						<p><?php $this->html( $key ); ?></p>

<?php
					}
				} else {
					echo '<ul>';
					foreach ( $links as $key ) { ?>
						<li><?php $this->html( $key ); ?></li>

<?php
					}
					echo '</ul>';
				}
			} ?>
		</div><!-- #footer -->

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
