<?php

/**
 * Erudite skin
 *
 * @file
 * @ingroup Skins
 */

use MediaWiki\MediaWikiServices;

class SkinErudite extends SkinTemplate {
	/** @var string */
	public $skinname = 'erudite';
	/** @var string */
	public $stylename = 'erudite';
	/** @var string */
	public $template = 'EruditeTemplate';

	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		// Add a responsive meta tag to ensure proper scaling on mobile devices.
		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1' );
	}
}

class EruditeTemplate extends BaseTemplate {
	/**
	 * Template filter callback for this skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 */
	public function execute() {
		$this->html( 'headelement' );
		?>

		<div class="mw-jump">
			<a href="#bodyContent"><?php $this->msg( 'erudite-skiptocontent' ); ?></a><?php $this->msg( 'comma-separator' ); ?>
			<a href="#search"><?php $this->msg( 'erudite-skiptosearch' ); ?></a>
		</div>

		<div id="top-wrap" role="banner">
			<h1>
				<a href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ); ?>"
				   title="<?php $this->text( 'sitename' ); ?>" rel="home">
					<?php $this->text( 'sitename' ); ?>
				</a>
			</h1>
			<div id="tagline"><?php $this->msg( 'tagline' ); ?></div>

			<a id="menubutton" href="#menu">Menu</a>
			<div id="nav" role="navigation">
				<?php
				if ( !empty( $this->data['sidebar']['navigation'] ) ) {
					echo "<ul id='menu'>\n";
					foreach ( $this->data['sidebar']['navigation'] as $item ) {
						printf(
							'<li id="menu-item-%s"><a href="%s">%s</a></li>',
							Sanitizer::escapeIdForAttribute( $item['id'] ),
							htmlspecialchars( $item['href'] ),
							htmlspecialchars( $item['text'] )
						);
					}
					echo "</ul>\n";
				}
				?>
			</div>
		</div>

		<div id="mw-js-message"></div>
		<?php foreach ( [ 'newtalk', 'sitenotice', 'undelete' ] as $msg ) {
			if ( $this->data[$msg] ) {
				echo "<div id='$msg' class='message'><p>";
				$this->html( $msg );
				echo '</p></div>';
			}
		} ?>

		<div id="main" role="main">
			<div id="nav-meta">
				<?php
				foreach ( $this->data['content_actions'] as $key => $tab ) {
					echo $this->makeListItem( $key, $tab, [ 'tag' => 'span' ] );
					echo '<span class="meta-sep">|</span>';
				}
				?>
			</div>

			<div id="bodyContent">
				<h1><?php $this->html( 'title' ); ?></h1>
				<?php if ( !empty( $this->data['subtitle'] ) ) { ?>
					<div class="subtitle"><?php $this->html( 'subtitle' ); ?></div>
				<?php } ?>

				<?php $this->html( 'bodytext' ); ?>
				<?php $this->html( 'dataAfterContent' ); ?>
			</div>

			<div id="footer">
				<?php foreach ( $this->getFooterLinks() as $category => $links ) {
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
				} ?>
			</div>

			<?php $this->html( 'catlinks' ); ?>
		</div>

		<div id="bottom-wrap">
			<div id="footer-wrap-inner">
				<div id="primary" class="footer">
					<ul>
						<li id="search" class="widget">
							<h3><?php $this->msg( 'search' ); ?></h3>
							<form action="<?php $this->text( 'wgScript' ); ?>" id="searchform">
								<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ); ?>" />
								<div>
									<?php echo $this->makeSearchInput( [ 'type' => 'text', 'id' => 's' ] ); ?>
									<?php echo $this->makeSearchButton( 'go', [
										'value' => $this->msg( 'searchbutton' ),
										'class' => 'searchButton',
										'id'    => 'searchsubmit',
									] ); ?>
								</div>
							</form>
						</li>

						<?php if ( !empty( $this->data['language_urls'] ) ) { ?>
							<li>
								<h3><?php $this->msg( 'otherlanguages' ); ?></h3>
								<ul>
									<?php
									foreach ( $this->data['language_urls'] as $key => $langlink ) {
										echo $this->makeListItem( $key, $langlink );
									}
									?>
								</ul>
							</li>
						<?php } ?>

						<?php if ( !empty( $this->getPersonalTools() ) ) { ?>
							<li class="widget">
								<h3><?php $this->msg( 'personaltools' ); ?></h3>
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
					</ul>
				</div>

				<div id="secondary" class="footer">
					<ul>
						<li id="toolbox" class="widget">
							<h3><?php $this->msg( 'toolbox' ); ?></h3>
							<ul>
								<?php
								$toolbox = $this->get( 'sidebar' )['TOOLBOX'];
								foreach ( $toolbox as $key => $tbitem ) {
									echo $this->makeListItem( $key, $tbitem );
								}
								$skin = $this;
								MediaWikiServices::getInstance()->getHookContainer()->run( 'SkinTemplateToolboxEnd', [ &$skin ] );
								?>
							</ul>
						</li>
					</ul>
				</div>

				<div id="ternary" class="footer">
					<ul>
						<li class="widget">
							<?php echo Html::element( 'img', [ 'id' => 'logo', 'src' => $this->data['logopath'], 'alt' => '' ] ); ?>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<?php
		$this->printTrail();
	}
}
