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

class PaypalIpn_Driver_Curl extends \PaypalIpn_Driver
{

	/**
	 * @return	bool	success boolean
	 */
	protected function _execute()
	{
		// FuelPHP curl method does not yet work.. not sure why, need more testing
		// needed this to work sooner so temporary workaround is simple curl request

		/*$curl_options = array(
			'RETURNTRANSFER' => 1,
			'FOLLOWLOCATION' => 1,
			'SSL_VERIFYPEER' => 1,
			'SSL_VERIFYHOST' => 2,
			'HEADER' => 0,
			'HTTPHEADER' => array("Host: www.sandbox.paypal.com"),
		);

		$post = array_merge(array('cmd' => '_notify-validate'), $post);

        foreach ($post as $key => $value)
        {
            $post[$key] = urlencode(stripslashes($value));
        }

		$response = \Request::forge('https://www.sandbox.paypal.com/cgi-bin/webscr', 'curl')
			->set_options($curl_options)
			->set_method('POST')->set_params($post)
			->execute();

		if (empty($response) or ! $return = $response->response()->body)
		{
			logger('Error', 'PaypalIPN failed to get content.');
			return false;
		}

		if (strcmp ($return, "VERIFIED") == 0)
		{
			// valid
		}
		else
		{
			// invalid
		}*/

		// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST...
//		$post = $this->post;
//		// we add this to validate the response
//		$req = 'cmd=' . urlencode('_notify-validate');
//		foreach ($post as $key => $value)
//		{
//			$req .= "&$key=$value";
//		}

		// Instead, read raw POST data from the input stream...
		$raw_post_data = file_get_contents('php://input');
		$req = 'cmd=_notify-validate&' . $raw_post_data;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->config['url']);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: '.$this->config['host']));
		$res = curl_exec($ch);
		curl_close($ch);

		if (strcmp ($res, "VERIFIED") == 0)
		{
			return $this->post;
		}

		return false;
	}

}
