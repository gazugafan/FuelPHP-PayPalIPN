<?php
/**
 * PayPal IPN package for FuelPHP
 *
 * @package    PaypalIpn
 * @version    1.0
 * @author     Jaroslav Petrusevic (huglester)
 * @license    MIT License
 * @copyright  2012 Jaroslav Petrusevic (huglester)
 * @link       http://www.webas.lt
 */

Autoloader::add_core_namespace('PaypalIpn');

Autoloader::add_classes(array(
	/**
	 * Rates classes.
	 */
	'PaypalIpn\\PaypalIpn'                      => __DIR__.'/classes/paypalipn.php',
	'PaypalIpn\\PaypalIpn_Driver'               => __DIR__.'/classes/paypalipn/driver.php',
	'PaypalIpn\\PaypalIpn_Driver_Curl'	        => __DIR__.'/classes/paypalipn/driver/curl.php',
	//'PaypalIpn\\PaypalIpn_Driver_Fsockopen'	        => __DIR__.'/classes/paypalipn/driver/fsockopen.php',
));