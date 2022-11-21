<?php
/**
 * Disable emojis
 *
 * @package CountryCard
 */

namespace XWP\CountryCard\Modules;

use \XWP\CountryCard\Interfaces\Module;

/**
 * Emojis module
 */
final class Emojis implements Module {
	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public static function register(): void {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		add_filter( 'wp_resource_hints', [ get_class(), 'remove_emoji_dns_prefetch' ], 10, 2 );
	}

	/**
	 * Remove emoji CDN hostname from DNS prefetching hints.
	 *
	 * @param string[] $urls         URLs to print for resource hints.
	 * @param string   $relation_type The relation type the URLs are printed for.
	 *
	 * @return string[] Difference between the two arrays.
	 */
	public static function remove_emoji_dns_prefetch( array $urls, string $relation_type ): array {
		if ( 'dns-prefetch' === $relation_type ) {
			/** This filter is documented in wp-includes/formatting.php */
			$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

			$urls = array_diff( $urls, [ $emoji_svg_url ] );
		}

		return $urls;
	}
}
