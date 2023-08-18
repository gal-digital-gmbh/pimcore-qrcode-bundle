<?php declare(strict_types = 1);

namespace GalDigitalGmbh\PimcoreQrcodeBundle\Controller\Admin;

use Endroid\QrCode\Builder\Builder;
use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;
use Pimcore\Controller\Traits\JsonHelperTrait;
use Pimcore\Controller\UserAwareController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class QrCodeController extends UserAwareController
{
    use JsonHelperTrait;

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function getItem(Request $request): JsonResponse
    {
        $this->checkPermission('qr_codes');

        $code    = QrCode::getByName($request->get('name'));
        $success = (bool) $code;

        return $this->jsonResponse([
            'success' => $success,
            'code'    => $code,
        ]);
    }

    public function addItem(Request $request): JsonResponse
    {
        $this->checkPermission('qr_codes');

        $code    = QrCode::getByName($request->get('name'));
        $success = false;

        if (!$code) {
            $code = new QrCode();
            $code
                ->setName($request->get('name'))
                ->save();

            $success = true;
        }

        return $this->jsonResponse([
            'success' => $success,
            'id'      => $code->getName(),
        ]);
    }

    public function updateItem(Request $request): JsonResponse
    {
        $this->checkPermission('qr_codes');

        $code    = QrCode::getByName($request->get('name'));
        $success = false;

        if ($code) {
            $data = $this->decodeJson($request->get('configuration'));

            foreach ($data as $key => $value) {
                $setter = 'set' . ucfirst($key);

                if (method_exists($code, $setter)) {
                    $code->$setter($value);
                }
            }

            $code->save();
            $success = true;
        }

        return $this->jsonResponse([
            'success' => $success,
        ]);
    }

    public function deleteItem(Request $request): JsonResponse
    {
        $this->checkPermission('qr_codes');

        $code    = QrCode::getByName($request->get('name'));
        $success = false;

        if ($code) {
            $code->delete();
            $success = true;
        }

        return $this->jsonResponse([
            'success' => $success,
        ]);
    }

    public function listItems(): JsonResponse
    {
        $this->checkPermission('qr_codes');

        $list = new QrCode\Listing();

        $codes = array_map(function ($code) {
            return [
                'id'   => $code->getName(),
                'text' => $code->getName(),
                'writeable' => $code->isWriteable(),
            ];
        }, $list->getCodes());

        return $this->jsonResponse([
            'codes' => $codes,
        ]);
    }

    public function code(Request $request): Response
    {
        $this->checkPermission('qr_codes');

        $file = PIMCORE_PRIVATE_VAR . '/qr-code-' . uniqid() . '.png';

        $this->generateCode($request, $file);

        return $this->getCodeResponse($request, $file);
    }

    private function generateCode(Request $request, string $outputFile): void
    {
        Builder::create()
            ->data($this->getCodeUrl($request->get('name', '')))
            ->size($request->get('download') ? 4000 : 500)
            ->build()
            ->saveToFile($outputFile);
    }

    private function getCodeUrl(string $name): string
    {
        return $this->urlGenerator->generate('galdigital_qrcode_frontend_code', [
            'name' => $name,
        ], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    private function getCodeResponse(Request $request, string $outputFile): Response
    {
        $response = new BinaryFileResponse($outputFile);

        if ($request->get('download')) {
            $response->setContentDisposition('attachment', 'qrcode-' . $request->get('name', 'preview') . '.png');
        }

        $response->deleteFileAfterSend(true);
        $response->headers->set('Content-Type', 'image/png');

        return $response;
    }
}
