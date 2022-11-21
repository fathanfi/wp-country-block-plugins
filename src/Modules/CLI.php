<?php
/**
 * CLI script to insert posts with Gutenberg blocks
 *
 * @package CountryCard
 */

namespace XWP\CountryCard\Modules;

use \XWP\CountryCard\Interfaces\Module;
use const \XWP\CountryCard\MAIN_DIR;

/**
 * CLI module
 */
final class CLI implements Module {
	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public static function register(): void {
		if ( class_exists( '\WP_CLI' ) ) {
			\WP_CLI::add_command( 'xwp-country-card insert-posts', [ get_class(), 'handle_cli_request' ] );
		}
	}

	/**
	 * Insert posts with Gutenberg blocks
	 *
	 * ## EXAMPLES
	 *
	 *     # Insert posts.
	 *     $ wp xwp-country-card insert-posts
	 *
	 * @throws \Exception Exception thrown if getting cities data fails.
	 *
	 * @return void
	 */
	public static function handle_cli_request(): void {
		/** @var null|array<array{countryCode?: string, countryName?: string, cities?: array<array{name?: string, population?: int}>}> $data */
		$data = wp_json_file_decode( MAIN_DIR . '/assets/cities.json', [ 'associative' => true ] );

		if ( null === $data ) {
			\WP_CLI::error( 'Couldn\'t parse cities.json file.' );
			return;
		}

		$category_id = get_cat_ID( __( 'Cities', 'xwp-country-card' ) );

		if ( 0 === $category_id ) {
			$category_id = wp_insert_category( [ 'cat_name' => __( 'Cities', 'xwp-country-card' ) ], true );

			if ( is_wp_error( $category_id ) ) {
				\WP_CLI::error(
					sprintf(
						'Couldn\'t insert "cities" category, reason: %s',
						$category_id->get_error_message()
					)
				);

				return;
			}
		}

		/** @var array{countryCode?: string, countryName?: string, cities?: array<array{name?: string, population?: int}>} $country */
		foreach ( $data as $country ) {
			if ( ! isset( $country['cities'] ) || empty( $country['countryCode'] ) || empty( $country['countryName'] ) ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				continue;
			}

			\WP_CLI::log(
				sprintf( 'Inserting %s\'s cities', $country['countryName'] ) // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			);

			foreach ( $country['cities'] as $city ) {
				$population_range = $city['population'] >= 1000000 ? '1m+' : '100k+';
				$meta_tags        = [
					'country_name'                               => $country['countryName'], // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					'country_code'                               => $country['countryCode'], // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					'population_range'                           => $population_range,
					'combined_country_code_and_population_range' => sprintf( '%s_%s', $country['countryCode'], $population_range ), // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				];

				$content = [
					'population'   => sprintf(
						// Translators: %1$s city name, %2$s city population.
						__( 'Population of %1$s: %2$s', 'xwp-country-card' ),
						$city['name'],
						isset( $city['population'] ) ? (string) $city['population'] : __( 'unknown', 'xwp-country-card' ),
					),
					'other_cities' => sprintf(
						// Translators: %s country name.
						__( 'See <a href="/tag/%s">other cities in this country</a>.', 'xwp-country-card' ),
						sanitize_title( $country['countryName'] ), // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					),
				];

				wp_insert_post(
					[
						'post_title'    => $city['name'],
						'post_status'   => 'publish',
						'post_excerpt'  => $content['population'],
						'post_content'  => sprintf(
							'<p>%1$s</p><p>%2$s</p>',
							$content['population'],
							$content['other_cities'],
						),
						'post_category' => [ $category_id ],
						'meta_input'    => $meta_tags,
						'tags_input'    => [
							$country['countryName'], // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
						],
					]
				);
			}
		}
	}
}
