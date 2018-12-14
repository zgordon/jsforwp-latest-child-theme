<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Latest
 */
?>

	</div><!-- #content -->
</div><!-- #page -->

<?php do_action( 'latest_after_page' ); ?>

<footer id="colophon" class="site-footer">
	<div class="container">

		<?php if ( is_active_sidebar( 'footer' ) ) : ?>
			<div class="footer-widgets">
				<?php do_action( 'latest_above_footer_widgets' );
				dynamic_sidebar( 'footer' );
				do_action( 'latest_below_footer_widgets' ); ?>
			</div>
		<?php endif; ?>

		<div class="footer-bottom">
			<?php if ( has_nav_menu( 'footer' ) ) { ?>
				<nav class="footer-navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'footer',
						'depth'          => 1,
						'fallback_cb'    => false
					) );?>
				</nav><!-- .footer-navigation -->
			<?php } ?>

			<div class="footer-tagline">
				<div class="site-info">
					<?php echo latest_filter_footer_text(); ?>
				</div>
			</div><!-- .footer-tagline -->
		</div><!-- .footer-bottom -->
	</div><!-- .container -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

<?php global $current_user;
get_currentuserinfo();
$user_email = $current_user->user_email;
?>
<script type="text/javascript">
var useremail = <?php echo json_encode($user_email) ?> ;
</script>

<script type="text/javascript">
    adroll_adv_id = "DTR2CXS43ZDBJHU6RACNBP";
    adroll_pix_id = "V65ZAZKS5JHBLITOK72FI6";
    /* OPTIONAL: provide email to improve user identification */
	if( useremail ) adroll_email = useremail;
    (function () {
        var _onload = function(){
            if (document.readyState && !/loaded|complete/.test(document.readyState)){setTimeout(_onload, 10);return}
            if (!window.__adroll_loaded){__adroll_loaded=true;setTimeout(_onload, 50);return}
            var scr = document.createElement("script");
            var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
            scr.setAttribute('async', 'true');
            scr.type = "text/javascript";
            scr.src = host + "/j/roundtrip.js";
            ((document.getElementsByTagName('head') || [null])[0] ||
                document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
        };
        if (window.addEventListener) {window.addEventListener('load', _onload, false);}
        else {window.attachEvent('onload', _onload)}
    }());
</script>
</body>
</html>
