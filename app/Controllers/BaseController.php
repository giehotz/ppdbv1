<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        $this->helpers = ['form', 'url', 'log', 'qr', 'pembiayaan'];
        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');

        // Load Website & SEO Settings — cache 30 menit agar tidak query DB setiap request
        $cache   = \Config\Services::cache();
        $appData = $cache->get('app_settings');
        if ($appData === null) {
            $webModel  = new \App\Models\TblWebModel();
            $seoModel  = new \App\Models\SeoModel();
            $appData   = [
                'web' => $webModel->first() ?? [],
                'seo' => $seoModel->find(1) ?? [],
            ];
            $cache->save('app_settings', $appData, 1800); // 30 menit
        }

        $webData = $appData['web'];
        $seoData = $appData['seo'];

        \Config\Services::renderer()->setVar('app_alias', $webData['app_alias'] ?? 'PPDB');
        \Config\Services::renderer()->setVar('web_logo', $webData['logo_sekolah'] ?? null);
        \Config\Services::renderer()->setVar('seo_global', $seoData);
    }
}
