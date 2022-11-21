/**
 * Todo
 * 1. Add block props to save as we added this to edit.js previously
 */
/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import Preview from './preview';

export default function Save( { attributes } ) {
	const blockProps = useBlockProps.save();
	return (
		<div { ...blockProps }>
			<Preview { ...attributes } />
		</div>
	);
}
