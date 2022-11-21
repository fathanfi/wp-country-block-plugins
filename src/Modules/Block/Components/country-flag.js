/**
 * Internal dependencies
 */
import { getEmojiFlag } from '../utils';

/**
 * Country flag component
 *
 * @param {string} countryCode Country Code.
 */
export default function CountryFlag( { countryCode } ) {
	const emojiFlag = getEmojiFlag( countryCode );
	return (
		<div className="xwp-country-card__media" data-emoji-flag={ emojiFlag }>
			<div className="xwp-country-card-flag">{ emojiFlag }</div>
		</div>
	);
}
