<?php

namespace GalDigitalGmbh\PimcoreQrcodeBundle\Controller;

use GalDigitalGmbh\PimcoreQrcodeBundle\Exception\QrCodeNotFoundException;
use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QrCodeController extends FrontendController
{
    public function code(Request $request): Response
    {
        $name = $request->get('name');
        $code = QrCode::getByName($name);

        if (!$code) {
            throw new QrCodeNotFoundException(sprintf('QR code with name "%s" not found', $name));
        }

        return $this->redirect($code->getUrl());
    }
}
