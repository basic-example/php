<?php

use PHPUnit\Framework\TestCase;

class JWT_Test extends TestCase
{
    public function testExample()
    {
        $pem = file_get_contents(__DIR__.'/fixture/id_rsa');
        $key = new SimpleJWT\Keys\RSAKey($pem, 'pem');
        $set = new SimpleJWT\Keys\KeySet();
        $set->add($key);
        $headers = ['alg' => 'RS256', 'typ' => 'JWT'];
        $claims = ['iss' => 'me', 'exp' => 1234567890123];
        $jwt = new SimpleJWT\JWT($headers, $claims);
        $encoded = $jwt->encode($set);
        $this->assertTrue(!!$encoded);

        $pem = file_get_contents(__DIR__.'/fixture/id_rsa.pub');
        $key = new SimpleJWT\Keys\RSAKey($pem, 'pem');
        $set = new SimpleJWT\Keys\KeySet();
        $set->add($key);
        $jwt = SimpleJWT\JWT::decode($encoded, $set, 'RS256');
        $this->assertEquals('JWT', $jwt->getHeader('typ'));
        $this->assertEquals('me', $jwt->getClaim('iss'));
    }
}
