<?php

use PHPUnit\Framework\TestCase;

class JWE_Test extends TestCase
{
    public function testExample()
    {
        $pem = file_get_contents(__DIR__.'/fixture/id_rsa.pub');
        $key = new SimpleJWT\Keys\RSAKey($pem, 'pem');
        $set = new SimpleJWT\Keys\KeySet();
        $set->add($key);
        $headers = ["alg" => "RSA1_5","enc" => "A128CBC-HS256"];
        $plaintext = 'This is the plaintext I want to encrypt.';
        $jwe = new SimpleJWT\JWE($headers, $plaintext);
        $encrypted = $jwe->encrypt($set);
        $this->assertTrue(!!$encrypted);

        $pem = file_get_contents(__DIR__.'/fixture/id_rsa');
        $key = new SimpleJWT\Keys\RSAKey($pem, 'pem');
        $set = new SimpleJWT\Keys\KeySet();
        $set->add($key);
        $jwe = SimpleJWT\JWE::decrypt($encrypted, $set, 'RSA1_5');
        $this->assertEquals('A128CBC-HS256', $jwe->getHeader('enc'));
        $this->assertEquals($plaintext, $jwe->getPlaintext());
    }
}
