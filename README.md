#FuelPHP PayPal IPN package

Currently package has cURL driver only

TODO: fsockopen driver

Usage example:

    \Package::load('paypalipn');

    $array = array(
        'payment_status' => 'Completed', // there are many statuses out there, just check them out
        'mc_gross_1' => 9.34,
        'mc_currency' => 'EUR',
    );

    // validates the given array from post with some required key > values array
    $response = \PaypalIpn::forge()->validate($array);

    // shortcut to validate amount and currency
    // so this:
    $response = \PaypalIpn::forge()->validate(9.34, 'usd');
    // is equal to this:
    $array = array(
        'mc_gross_1' => 9.34,
        'mc_currency' => 'USD',
    );
    $response = \PaypalIpn::forge()->validate($array);

    // pass custom array (or edited $post?) to validate
    $response = \PaypalIpn::forge($custom_array)->validate();

    // change the driver
    $response = \PaypalIpn::forge(null, 'curl')->validate($array);
    $response = \PaypalIpn::forge()->driver('curl')->validate($array);

    // $response holds the array of valid post, or false if not validated
    if ($response !== false)
    {
        logger('PayPal IPN Validate', 'Success');
        logger('PayPal IPN Validate', json_encode($response));
    }
    else
    {
        logger('PayPal IPN Validate', 'FAILED');
    }


To make life easier, here is the example of the rest controller:
// access it via http://yoursite.com/securedipn


    class Controller_SecuredIpn extends \Controller_Rest
    {

        public function post_index()
        {
            \Package::load('paypalipn');

            $response = \PaypalIpn::forge()->validate(9.34, 'usd');

            if ($response !== false)
            {
                logger('PayPal IPN Validate', 'Success');
                logger('PayPal IPN Validate', json_encode($response));
                // We can do some DB inserts here etc...
            }
            else
            {
                // Log for further investigation
                logger('PayPal IPN Validate', 'FAILED');
            }
        }
    }

Now try to make some tests from sandbox to your controller, and check the logs, there
should be some data!


Good luck!
