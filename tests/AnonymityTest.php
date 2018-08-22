<?php

namespace geertw\IpAnonymizer\Tests;

use geertw\IpAnonymizer\IpAnonymizer;
use PHPUnit\Framework\TestCase;

class AnonymityTest extends TestCase
{
    public function testIPAnonymity()
    {
        $a = new IpAnonymizer();
        $checks = [
            '12.34.56.78' => '12.34.56.0',
            '127.0.0.1' => '127.0.0.0',
            '192.168.178.123' => '192.168.178.0',
            '8.8.8.8' => '8.8.8.0',
            '::1' => '::',
            '::127.0.0.1' => '::',
            '::ffff:127.0.0.1' => '::',
            '2a03:2880:2110:df07:face:b00c::1' => '2a03:2880:2110:df07::',
            '1234:5678:90ab:cdef:fedc:ba09:8765:4321' => '1234:5678:90ab:cdef::',
            '2610:28:3090:3001:dead:beef:cafe:fed3' => '2610:28:3090:3001::',
        ];

        foreach ($checks as $input => $expected) {
            $this->assertEquals($expected, $a->anonymize($input));
        }
    }

    public function testIpAnonymityCustomMask()
    {
        $a = new IpAnonymizer();
        $a->ipv4NetMask = '255.255.0.0';

        $this->assertEquals('192.168.0.0', $a->anonymize('192.168.178.123'));
    }
}