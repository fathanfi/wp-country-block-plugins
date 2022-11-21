/**
 * Todo
 * 1. Add semantic markup. Change h3 to h2 heading for proper interpretation. Also aligned with SEO standard.
 */

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import countries from '../../../../assets/countries.json';
import continentNames from '../../../../assets/continent-names.json';
import continents from '../../../../assets/continents.json';

/**
 * Country heading component. Show Country Name, Continent Name ex. Indonesia (ID), Asia!.
 *
 * @param {string} countryCode Country Code.
 */
export default function CountryHeading( { countryCode } ) {
	return (
		<h2 className="xwp-country-card__heading">
			{ __( 'Hello from', 'xwp-country-card' ) }{ ' ' }
			<strong>{ countries[ countryCode ] }</strong> (
			<span
				className="xwp-country-card__country-code"
				data-country-name={ countries[ countryCode ] }
			>
				{ countryCode }
			</span>
			), { continentNames[ continents[ countryCode ] ] }!
		</h2>
	);
}
