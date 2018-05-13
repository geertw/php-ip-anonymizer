<?php

use PHPUnit\Framework\TestCase;
use Potaka\IpAnonymizer\IpAnonymizer;

/**
 * @author po_taka <angel.koilov@gmail.com>
 */
class IpAnonymizerTest extends TestCase
{
    public function ipV4TestCases()
    {
        return [
            [
                '192.168.0.5',
                '192.168.0.0',
            ],
        ];
    }

    public function ipV6TestCases()
    {
        return [
            [
                '2610:28:3090:3001:dead:beef:cafe:fed3',
                '2610:28:3090:3001::',
            ],
        ];
    }

    /**
     * @dataProvider ipV4TestCases
     */
    public function testIpV4Anonymization($ipv4, $expectedAnonymizedIp)
    {
        $anonymizer = new IpAnonymizer();
        $anonymized = $anonymizer->anonymize($ipv4);
        $this->assertSame($anonymized, $expectedAnonymizedIp);
    }

    /**
     * @dataProvider ipV6TestCases
     */
    public function testIpV6Anonymization($ipv6, $expedtedAnonymizedIp)
    {
        $anonymizer = new IpAnonymizer();
        $anonymized = $anonymizer->anonymize($ipv6);
        $this->assertSame($anonymized, $expedtedAnonymizedIp);
    }

    public function testAnonumizationWithInvalidIp()
    {
        $this->expectException(\InvalidArgumentException::class);

        $anonymizer = new IpAnonymizer();
        $anonymizer->anonymize('192.ggg.666');
    }
}
