/**
 * External dependencies
 */
import DOMPurify from 'dompurify';

/**
 * WordPress dependencies
 */
import { __, _n, sprintf } from '@wordpress/i18n';

/**
 * Country Related Posts component.
 *
 * @param {Object} props Props
 */
export default function CountryRelatedPosts( props ) {
	const { relatedPosts } = props;
	const hasRelatedPosts = relatedPosts?.length > 0;
	const purify = DOMPurify( window );

	return (
		<div className="wp-country-card__related-posts">
			<h3 className="wp-country-card__related-posts__heading">
				{ hasRelatedPosts
					? sprintf(
						// translators: %d: number of related posts.
						_n(
							'There is %d related post:',
							'There are %d related posts:',
							relatedPosts.length
						),
						relatedPosts.length
					)
					: __( 'There are no related posts.', 'wp-country-card' ) }
			</h3>
			{ hasRelatedPosts && (
				<ul className="wp-country-card__related-posts-list">
					{ relatedPosts.map( ( relatedPost, index ) => (
						<li key={ index } className="related-post">
							<a
								className="link"
								href={ relatedPost.link }
								data-post-id={ relatedPost.id }
							>
								<h3 className="title">{ relatedPost.title }</h3>
								{ relatedPost.excerpt && (
									<p
										className="excerpt"
										dangerouslySetInnerHTML={ { __html: purify.sanitize( relatedPost.excerpt.replace( /(<([^>]+)>)/ig, '' ) ) } }
									/>
								) }
							</a>
						</li>
					) ) }
				</ul>
			) }
		</div>
	);
}
