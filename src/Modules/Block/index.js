/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import edit from './edit';
import save from './save';

/**
 * Style dependencies
 */
import './style.scss';

registerBlockType( 'wp/country-card', {
	edit,
	save,
} );
