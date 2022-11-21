<?php
/**
 * Plugin Name:       Country Card Block
 * Description:       Block rendering a card with country information.
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Version:           1.0.0
 * Author:            Fathan Fisabilillah
 * Author URI:        https://github.com/fathanfi
 * Text Domain:       wp-country-card
 *
 * @package           CountryCard
 */

namespace WP\CountryCard;

const MAIN_FILE = __FILE__;
const MAIN_DIR  = __DIR__;

require MAIN_DIR . '/vendor/autoload.php';

/**
 * Initialize modules
 */
Modules\Block\Block::register();
Modules\CLI::register();
Modules\Emojis::register();
