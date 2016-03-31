<?php

/*
 * This file is part of the ACME PHP library.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AcmePhp\Ssl\Formatter;

use AcmePhp\Ssl\CertificateResponse;

/**
 * Format the chain of certificate from the issuer's certificate to the root certificate.
 *
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
class IssuerChainFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format(CertificateResponse $certificateResponse)
    {
        $issuerCertificate = $certificateResponse->getCertificate()->getIssuerCertificate();
        $PEMs = [];
        while (null !== $issuerCertificate) {
            $PEMs[] = trim($issuerCertificate->getPEM());
            $issuerCertificate = $issuerCertificate->getIssuerCertificate();
        }

        return implode(self::SEPARATOR, $PEMs).self::SEPARATOR;
    }
}
