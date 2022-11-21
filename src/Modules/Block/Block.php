<?php
/**
 * Register custom block
 *
 * @package CountryCard
 */

namespace XWP\CountryCard\Modules\Block;

use \XWP\CountryCard\Interfaces\Module;
use const \XWP\CountryCard\MAIN_DIR;

/**
 * Block module
 */
final class Block implements Module {
	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public static function register(): void {
		add_action( 'init', [ get_class(), 'register_block' ] );
		add_filter( 'render_block', [ get_class(), 'display_cities_summary' ], 10, 2 );
	}

	/**
	 * Register block
	 */
	public static function register_block(): void {
		register_block_type( MAIN_DIR . '/build/Modules/Block' );
	}

	/**
	 * Parse block content to find the country name and code
	 *
	 * @param string $block_content The block content.
	 *
	 * @return array{countryName: string, countryCode: string} Array of country name and code.
	 */
	private static function find_country_data( string $block_content ): array {
		$attribute          = 'data-country-name';
		$attribute_position = strpos( $block_content, 'data-country-name' );
		$substring          = substr( $block_content, $attribute_position + strlen( $attribute ) + 2 );
		$substring          = substr( $substring, 0, strpos( $substring, '<' ) );
		$data               = explode( '">', $substring );

		return [
			'countryCode' => $data[1],
			'countryName' => $data[0],
		];
	}

	/**
	 * Count cities in a given country
	 *
	 * @param string $country_code Country code.
	 * @param string $country_name Country name.
	 *
	 * @return array{total: int, large: int} Cities stats array.
	 */
	private static function count_country_cities( string $country_code, string $country_name ) {
		global $wpdb;

		$stats = [
			'total' => 0,
			'large' => 0,
		];

		/**
		 * Find all city posts assigned to a given country
		 */
		$country_tag = get_term_by( 'name', $country_name, 'post_tag' );

		if ( $country_tag instanceof \WP_Term ) {
			$stats['total'] = $country_tag->count;
		}

		/**
		 * Find all large cities in a given country
		 */
		$query = new \WP_Query(
			[
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'tags_query'     => [
					'taxonomy' => 'post_tag',
					'field'    => 'name',
					'terms'    => $country_name,
				],
				'meta_query'     => [
					'relation' => 'AND',
					[
						'key'   => 'country_code',
						'value' => $country_code,
					],
					[
						'key'   => 'population_range',
						'value' => '1m+',
					],
				],
			]
		);

		if ( $query->have_posts() ) {
			$stats['large'] = $query->post_count;
			wp_reset_postdata();
		}

		return [
			'total' => isset( $stats['total'] ) ? (int) $stats['total'] : 0,
			'large' => isset( $stats['large'] ) ? (int) $stats['large'] : 0,
		];
	}

	/**
	 * Display summary of cities in a given country
	 *
	 * @param string $block_content The block content about to be appended.
	 * @param array  $block         The full block, including name and attributes.
	 *
	 * @return string Updated block content.
	 */
	public static function display_cities_summary( string $block_content, array $block ): string {
		if ( 'xwp/country-card' !== $block['blockName'] ) {
			return $block_content;
		}

		$country = self::find_country_data( $block_content );

		if ( empty( $country['countryCode'] ) || empty( $country['countryName'] ) ) {
			return $block_content;
		}

		$stats         = self::count_country_cities( $country['countryCode'], $country['countryName'] );
		$stats_content = sprintf(
			'%1$s and %2$s.',
			sprintf(
				// Translators: %1$d Cities count, %2$s Country name.
				__(
					'There are %1$d cities in %2$s with a population over 100k',
					'xwp-country-card',
				),
				$stats['total'],
				$country['countryName'],
			),
			sprintf(
				// Translators: %d Cities count.
				__(
					'%d cities with population over 1m',
					'xwp-country-card',
				),
				$stats['large'],
			),
		);

		return sprintf(
			'%1$s<p><em>%2$s</em></p>',
			$block_content,
			$stats_content,
		);
	}
}
