<?php

namespace Potaka\IpAnonymizer;

class IpAnonymizer
{
    /**
     * @var string IPv4 netmask used to anonymize IPv4 address.
     */
    public $ipv4NetMask = "255.255.255.0";

    /**
     * @var string IPv6 netmask used to anonymize IPv6 address.
     */
    public $ipv6NetMask = "ffff:ffff:ffff:ffff:0000:0000:0000:0000";

    /**
     * Anonymize an IPv4 or IPv6 address.
     *
     * @param $address string IP address that must be anonymized
     * @return string The anonymized IP address
     */
    public function anonymize(string $address): string
    {
        // we don't want notices, error is handled below by InvalidArgumentException
        $packedAddress = @inet_pton($address);

        if (strlen($packedAddress) === 4) {
            return $this->anonymizeIPv4($address);
        } elseif (strlen($packedAddress) === 16) {
            return $this->anonymizeIPv6($address);
        } else {
            throw new \InvalidArgumentException("Can\'t anonymiza {$address}");
        }
    }

    /**
     * Anonymize an IPv4 address
     * @param $address string IPv4 address
     * @return string Anonymized address
     */
    public function anonymizeIPv4(string $address): string
    {
        return inet_ntop(inet_pton($address) & inet_pton($this->ipv4NetMask));
    }

    /**
     * Anonymize an IPv6 address
     * @param $address string IPv6 address
     * @return string Anonymized address
     */
    public function anonymizeIPv6(string $address): string
    {
        return inet_ntop(inet_pton($address) & inet_pton($this->ipv6NetMask));
    }
}
