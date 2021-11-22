<?php
/**
 * Language pack
 *
 * @author l34t@github
 * @date 2021/11/22
 * @time 14:50
 */

return [
    'exception_msg' => [
        '34520001' => 'Unconfigured freenom account(.env)',
        '34520002' => 'Error logging in to freenom. Error message: %s',
        '34520003' => 'Domain name data match failed. Maybe no domains on renewal page or new revision made regex invalid. Please update/contact the developer.',
        '34520004' => 'Token match failed. Maybe new revision made regex invalid. Please update/contact the developer.',
        '34520005' => 'putenv() disabled. Program fail to operate normally, please enable putenv()',
        '34520006' => sprintf('Versions below php7 are not supported, the current version is %s, please upgrade to php7 or above', PHP_VERSION),
        '34520007' => sprintf('The .env configuration file has been generated in the %s directory. Modify content of the file to your own', ROOT_PATH),
        '34520008' => sprintf('Please copy the .env.example file in the %s directory to the .env file, and modify the contents of the .env file to your own', ROOT_PATH),
        '34520009' => 'Error in obtaining domain name status page. Maybe not logged in or failed to log in.',
        '34520010' => 'Unavailable curl module, unable to send request. Check your php environment and bring curl module back',
        '34520012' => 'Unconfigured receiving email address. Unable to send notification emails. Please change the value of TO in the .env file to your most commonly used email address for receiving domain-related emails from the robot mailbox',
        '34520013' => 'Error getting domain name status page, error message: %s',
    ],
    'error_msg' => [
        '100001' => 'The cookie value named WHMCSZH5eHTGhfvzP could not be obtained, so this login is invalid. Please check whether your account or password is correct.',
        '100002' => 'Sending empty content emails is not allowed',
        '100003' => 'Illegal message type',
    ],
];
