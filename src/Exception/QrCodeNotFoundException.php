<?php declare(strict_types = 1);

namespace GalDigitalGmbh\PimcoreQrcodeBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class QrCodeNotFoundException extends NotFoundHttpException
{
}
