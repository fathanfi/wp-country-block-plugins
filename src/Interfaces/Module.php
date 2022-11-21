<?php
/**
 * Interface dedicated for Modules
 *
 * @package CountryCard
 */

namespace XWP\CountryCard\Interfaces;

/**
 * Module interface
 */
interface Module {
	/**
	 * Register module hooks and filters
	 *
	 * @return void
	 */
	public static function register(): void;
}
