/**
 * Todo
 * 1. Fix lint problems
 * 2. Translates and retrieves the singular or plural form based on the related post number.
 * 3. add domain name for translation string.
 * 4. we can separate components for country flag, greeting Heading, and related post preview
 * 5. Apply semantic html markup on div to article.
 */
/**
 * Internal dependencies
 */
import CountryFlag from './Components/country-flag';
import CountryHeading from './Components/country-heading';
import CountryRelatedPosts from './Components/country-related-post';

export default function Preview( { countryCode, relatedPosts } ) {
	if ( ! countryCode ) {
		return null;
	}

	return (
		<article className="wp-country-card">
			<CountryFlag countryCode={ countryCode } />
			<CountryHeading countryCode={ countryCode } />
			<CountryRelatedPosts relatedPosts={ relatedPosts } />
		</article>
	);
}
