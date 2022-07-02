<?php
namespace App\Modules\Website\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Libraries\Template;
use App\Libraries\Blockchain_lib;
use App\Modules\Website\Models\Web_model;
use App\Modules\Website\Models\Common_model;  
use App\Libraries\UploadImage; 

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'url','lang_helper'];
   
	/**
	 * Constructor.
	 */

    protected  $web_model;
    protected  $userId;
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
                
        //Creating Libraries object 
        $this->pager         		= \Config\Services::pager();
        $this->db            		= db_connect();
        $this->validation    		=  \Config\Services::validation();
        $this->session 		 		= \Config\Services::session();
        $this->imagelibrary  		= new UploadImage();
		$this->uri           		= service('uri','<?php echo base_url(); ?>');
		$this->templte_name  		= $this->db->table('themes')->select('name')->where('status',1)->get()->getRow();
        
        //Creating Model object
        $this->template             = new Template();
        $this->blockchain           = new Blockchain_lib();
        $this->web_model            = new Web_model();
        $this->common_model         = new Common_model(); 

        /* Assign User ID*/
        $this->userId = $this->session->get('user_id');
        $this->isUser = $this->session->get('isUser');

	}

}
