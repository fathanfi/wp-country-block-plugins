/**
 * Internal dependencies
 */
import countries from '../../../assets/countries.json';

/**
 * Get emoji flag based on country code
 *
 * @param {string} countryCode Country Code
 * @return {string} Return content with escaped character.
 */
export function getEmojiFlag( countryCode ) {
	return String.fromCodePoint(
		...countryCode
			.toUpperCase()
			.split( '' )
			.map( ( char ) => 127397 + char.charCodeAt() )
	);
}

/**
 * Get dropdown country options.
 *
 * @return {Array} The dropdown options.
 */
export function getCountryDropdowns() {
	return Object.keys( countries ).map( ( code ) => ( {
		value: code,
		label: getEmojiFlag( code ) + '  ' + countries[ code ] + ' — ' + code,
	} ) );
}
