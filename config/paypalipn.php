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

return array(

	/**
	 * Default settings
	 */

	/**
	 * Default paypalipn communication driver
	 */
	'default_driver'        =>	'curl',

	/*
	 * Is it a sandbox (test) application?
	 * */
	'sandbox'               => true,

	/*
	 * Whenever to use ssl connection
	 * */
	'ssl'                   => true,
	'port'                  => 443,

	'host_paypal'           => 'www.paypal.com',
	'host_paypal_sandbox'   => 'www.sandbox.paypal.com',

	/*
	 * Sets timeout for cURL request
	 * */
	'timeout' => 30,

	/*
	 * Drivers default config
	 * */
	'drivers' => array(
		'curl',
		// TODO
		//'fsockopen',
	),

);
