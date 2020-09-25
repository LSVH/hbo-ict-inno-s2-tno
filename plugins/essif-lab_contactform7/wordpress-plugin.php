<?php
/**
 * @wordpress-plugin
 * Plugin Name: eSSIF-Lab-ContactForm7
 * Plugin URI: https://github.com/LSVH/hbo-ict-inno-s2-tno
 * Description: Subplugin to support ContactForm7 in the eSSIF-Lab plugin.
 * Version: 1.0
 * Author: Duur Klop, Luuk van Houdt, Ruben Sikkens, Ufuk Altinçöp en Weis Mateen
 * Text Domain: essif-lab_contactform7
 */

if (!defined('WPINC') || !defined('ABSPATH'))
{
	die;
}

$classAutoloader = __DIR__.'/vendor/autoload.php';
if (file_exists($classAutoloader))
{
	require_once($classAutoloader);
}

use TNO\ContactForm7\Applications\Contracts\Application;
use TNO\ContactForm7\Applications\Plugin;
use TNO\ContactForm7\Integrations\Contracts\Integration;
use TNO\ContactForm7\Integrations\WordPress;
use TNO\ContactForm7\Utilities\Contracts\Utility;
use TNO\ContactForm7\Utilities\Helpers\CF7Helper;
use TNO\ContactForm7\Utilities\WP;

$wpPluginApi = ABSPATH.'wp-admin/includes/plugin.php';
if (!function_exists('get_plugin_data') && file_exists($wpPluginApi))
{
	require_once($wpPluginApi);
}

$getApplication = function (): Application {
	$pluginData = get_plugin_data(__FILE__, false, false);

	$name = function () use ($pluginData): string {
		return array_key_exists('Name', $pluginData) ? $pluginData['Name'] : 'App';
	};

	$namespace = function () use ($pluginData): string {
		return array_key_exists('TextDomain', $pluginData) ? $pluginData['TextDomain'] : 'MyApp';
	};

	$appDir = function (): string {
		return plugin_dir_path(__FILE__);
	};

	return new Plugin($name(), $namespace(), $appDir());
};

$getCf7Helper = function (): CF7Helper {
	return new CF7Helper();
};

$getUtility = function () use ($getCf7Helper): Utility {
	return new WP($getCf7Helper());
};

$getIntegration = function () use ($getApplication, $getUtility) : Integration {
	return new WordPress($getApplication(), $getUtility());
};

$getIntegration()->install($getCf7Helper());
