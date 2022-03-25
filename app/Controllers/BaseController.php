<?php

namespace App\Controllers;

use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 * 		class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
*/
class BaseController extends \CodeIgniter\Controller
{
  /**
   * Instance of the main Request object.
   *
   * @var IncomingRequest|CLIRequest
  */
  protected $request;

  /**
   * An array of helpers to be loaded automatically upon
   * class instantiation. These helpers will be available
   * to all other controllers that extend BaseController.
   *
   * @var array
  */
  protected $helpers = [];

  /**
   * Constructor.
   *
   * @param RequestInterface  $request
   * @param ResponseInterface $response
   * @param LoggerInterface   $logger
  */
  public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
  {
    // Do Not Edit This Line
    parent::initController($request, $response, $logger);

    //--------------------------------------------------------------------
    // Preload any models, libraries, etc, here.
    //--------------------------------------------------------------------
    // E.g.: $this->session = \Config\Services::session();
  }
}