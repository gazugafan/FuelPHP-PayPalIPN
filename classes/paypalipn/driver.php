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

namespace PaypalIpn;

abstract class PaypalIpn_Driver
{
	/**
	 * Driver config
	 */
	protected $config = array();

	/*
	 * $_POST array from PayPal
	 * */
	protected $post = array();

	/**
	 * Driver constructor
	 *
	 * @param	array	$config		driver config
	 */
	public function __construct(array $config, $post = null)
	{
		$this->config = $config;

		is_array($post) ? $this->post = $post : $this->post = \Input::post(null, array());

		$this->config['sandbox']    = $this->get_config('sandbox', true);
		$this->config['ssl']        = $this->get_config('ssl', true);

		$url = ($this->config['sandbox']) ? $this->get_config('host_paypal_sandbox', 'www.sandbox.paypal.com') : $this->get_config('host_paypal', 'www.paypal.com');

		$this->config['host'] = $url;

		if ($this->config['ssl'])
		{
			$url = 'https://'.$url;
		}
		else
		{
			$url = 'http://'.$url;
		}

		// maybe try removing double slashes here?
		$url .= '/cgi-bin/webscr';

		$this->config['url'] = $url;
	}

	/**
	 * Get a driver config setting.
	 *
	 * @param	string		$key		the config key
	 * @return	mixed					the config setting value
	 */
	public function get_config($key, $default = null)
	{
		return \Arr::get($this->config, $key, $default);
	}

	/**
	 * Set a driver config setting.
	 *
	 * @param	string		$key		the config key
	 * @param	mixed		$value		the new config value
	 * @return	object					$this
	 */
	public function set_config($key, $value)
	{
		\Arr::set($this->config, $key, $value);

		return $this;
	}

	/**
	 * Sets the driver
	 *
	 * @param	string		$driver			the message body
	 * @return	object		$this
	 */
	public function driver($driver)
	{
		$this->driver = (string) $driver;

		return $this;
	}

	/*
	 * validates the IPN request. returns the $post array if valid
	 * */
	public function validate($amount = null, $currency = null)
	{
		// TODO implement some auto upped case for known values like: address_country_code etc...

		$response = $this->_execute();

		if (is_array($amount))
		{
			foreach ($amount as $k => $v)
			{
				/*
				 * We we require some key and it was not available = validation failed
				 * */
				if ( ! isset($response[$k]))
				{
					return false;
				}

				if ($response[$k] != $v)
				{
					return false;
				}
			}
		}
		elseif ($amount !== null and $currency !== null)
		{
			if ( ! isset($response['mc_gross_1']) or ! $response['mc_gross_1'] or $response['mc_gross_1'] != $amount)
			{
				return false;
			}

			if ( ! isset($response['mc_currency']) or ! $response['mc_currency'] or $response['mc_currency'] != strtoupper($currency))
			{
				return false;
			}
		}

		return $response;
	}

	abstract protected function _execute();
}
