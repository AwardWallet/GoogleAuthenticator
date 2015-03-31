<?php

namespace Google\Authenticator\Tests;

use Google\Authenticator\GoogleAuthenticator;

class HandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Google\Authenticator\GoogleAuthenticator
     */
    protected $helper;

    public function setUp()
    {
        $this->helper = new GoogleAuthenticator();
    }

    public function testGenerateSecret()
    {
        $secret = $this->helper->generateSecret();

        $this->assertEquals(16, strlen($secret));
    }

    public function testGetCode()
    {
        $code = $this->helper->getCode('3DHTQX4GCRKHGS55CJ', strtotime('17/03/2012 22:17'));

        $this->assertTrue($this->helper->checkCode('3DHTQX4GCRKHGS55CJ', $code));
    }

    public function testGetUrl()
    {
        $url = $this->helper->getUrl('AcmeIssuer', 'foo', 'foobar.org', '3DHTQX4GCRKHGS55CJ');

        $expected = "https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2FAcmeIssuer%3Afoo%40foobar.org%3Fsecret%3D3DHTQX4GCRKHGS55CJ%26issuer%3DAcmeIssuer";

        $this->assertEquals($expected, $url);
    }

    public function testGetOtpUrl()
    {
        $otpUrl = $this->helper->getOtpUrl('AcmeCorp', 'foo', 'foobar.org', '3DHTQX4GCRKHGS55CJ');

        $expected = 'otpauth://totp/AcmeCorp:foo@foobar.org?secret=3DHTQX4GCRKHGS55CJ&issuer=AcmeCorp';

        $this->assertEquals($expected, $otpUrl);
    }
}
