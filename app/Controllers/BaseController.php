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

        // Load Website Settings to Global Variables
        $webModel = new \App\Models\TblWebModel();
        $webData = $webModel->first();

        \Config\Services::renderer()->setVar('app_alias', $webData['app_alias'] ?? 'PPDB');
        \Config\Services::renderer()->setVar('web_logo', $webData['logo_sekolah'] ?? null);

        // Load SEO Settings to Global Variables
        $seoModel = new \App\Models\SeoModel();
        $seoData = $seoModel->find(1);
        \Config\Services::renderer()->setVar('seo_global', $seoData ?? []);
    }
}
