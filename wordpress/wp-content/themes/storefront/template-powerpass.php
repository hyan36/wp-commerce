<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Powerpass
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/**
			 * Functions hooked in to homepage action
			 *
			 * @hooked storefront_homepage_content      - 10
			 * @hooked storefront_product_categories    - 20
			 * @hooked storefront_recent_products       - 30
			 * @hooked storefront_featured_products     - 40
			 * @hooked storefront_popular_products      - 50
			 * @hooked storefront_on_sale_products      - 60
			 * @hooked storefront_best_selling_products - 70
			 */
			//do_action( 'homepage' );
			
			$user = wp_get_current_user();
			if (isset($_POST['submit'])) {
				if(isset($_POST['account_id']) && $_POST['account_id']) {
					$account_id = $_POST['account_id'];	
					$url = "https://bunningspowerpasshackday.azurewebsites.net/powerpass/" . $account_id;
					
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);					
					$output = curl_exec($ch);					
					$result = json_decode($output);
					if (!curl_errno($ch) && array_key_exists('name', $result)) {
						$user->add_role('powerpass');
						echo "<h1>Thank You,  {$result->name}</h1> <p> we've validated your ID. </p>";
					} else {
						echo "<h1>Invalid PowerPass Info </h1>";
					}
					curl_close($ch);

				} else {
					$user->remove_role('powerpass');
					echo "<h1>Removed</h1>";
				}				
			}
            		if (!is_user_logged_in()) {
				echo "<h1>Please login to use this function</h1>";
			} else {
			?>
			<form id="powerpass" action="" method="POST">
				<input type="text" name="account_id" value="" />
				<input type="submit" name="submit" value="submit" />
			</form>
			<?php } ?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
