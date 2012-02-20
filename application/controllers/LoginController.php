<?php

class LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$config = Zend_Registry::get('globalProjectPath');
    	$this->config = $config;
    	 
    	$this->db = Zend_Registry::get('db');
    }

    public function getForm() //create form and elements
    {
    	$form = new Zend_Form;
    	$form->setAction($this->config . 'public/login/process')
    	->setMethod('post');
    	$form->setAttrib('id', 'login');
    
    	$username = new Zend_Form_Element_Text('username');
    	$username->setRequired(true);
    	//$username->addValidator(array(
        //        'Alpha',
        //        array('StringLength', false, array(3, 20)),
        //    ));
    	$username->setDecorators(array(
    			'ViewHelper',
    			'Description',
    			'Errors',
    			array(array('data'=>'HtmlTag'), array('tag' => 'td')),
    			array('Label', array('tag' => 'td', 'class' => 'login')),
    			array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
    	));
    	//$username->setAttrib('class','login');
    	$username->setLabel('Username:');
    	$form->addElement($username, 'username');
    	
    	$password = new Zend_Form_Element_Password('password');
    	$password->setRequired(true);
    	//$password->addValidator(array(
    	//		'Alpha',
    	//		array('StringLength', false, array(3, 20)),
    	//));
    	$password->setDecorators(array(
    			'ViewHelper',
    			'Description',
    			'Errors',
    			array(array('data'=>'HtmlTag'), array('tag' => 'td')),
    			array('Label', array('tag' => 'td','class' => 'login')),
    			array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
    	));
    	//$password->setAttrib('class','login');
    	$password->setLabel('Password:');
    	$form->addElement($password, 'password');
    	     	 
    	$submit = new Zend_Form_Element_Submit('Login');
    	$submit->setDecorators(array(
    			'ViewHelper',
    			'Description',
    			array(array('data'=>'HtmlTag'), array('tag' => 'th', 'colspan' => '2')),
    			array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
    	));
    	$submit->setAttrib('class','buttonlogin');
    	$form->addElement($submit, 'Login');

    	$form->setDecorators(array(
    			'FormElements',
    			array(array('data'=>'HtmlTag'),array('tag'=>'table', 'class' => 'logintable', 'align' => 'right', 'spacing' => '0')),
    			'Form'
    	));
    	 
    	return $form;
    }
    
    public function preDispatch()
    {
    	if (Zend_Auth::getInstance()->hasIdentity()) {
    		// If the user is logged in, we don't want to show the login form;
    		// however, the logout action should still be available
    		if ('logout' != $this->getRequest()->getActionName()) {
    			$this->view->assign('logged', 1);
    		}
    	} else {
    		// If they aren't, they can't logout, so that action should
    		// redirect to the login form
    		if ('logout' == $this->getRequest()->getActionName()) {
    			$this->_helper->redirector('index');
    		}
    	}
    }
    
    public function processAction()
    {
    	$request = $this->getRequest();
    
    	// Check if we have a POST request
    	if (!$request->isPost()) {
    		return $this->_helper->redirector('index');
    	}
    
    	// Get our form and validate it
    	$form = $this->getForm();
    	if (!$form->isValid($request->getPost())) {
    		// Invalid entries
    		$this->view->form = $form;
    		return $this->render('index'); // re-render the login form
    	}
    
    	// Get our authentication adapter and check credentials
    	$adapter = $this->_getAuthAdapter($form->getValues());
    	$auth    = Zend_Auth::getInstance();
    	$result  = $auth->authenticate($adapter);
    	if (!$result->isValid()) {
    		// Invalid credentials
    		$form->setDescription('Invalid credentials provided');
    		$this->view->form = $form;
    		return $this->render('index'); // re-render the login form
    	}
    
    	// We're authenticated! Redirect to the home page
    	$this->_helper->redirector('index', 'index');
    }
    
    public function logoutAction()
    {
    	Zend_Auth::getInstance()->clearIdentity();
    	$this->_helper->redirector('index'); // back to login page
    }
    
    public function indexAction()
    {
    	$form = $this->getForm();
        $this->view->assign('form', $form);
    }
    
    protected function _getAuthAdapter($values){
    	$authAdapter = new Zend_Auth_Adapter_DbTable(
    			$this->db,
    			'mpuser', 
    			'mpusername',
    			'mpuserpwd' 
    	);
    	$authAdapter->setIdentity($values['username'])->setCredential(md5($values['password']));
    	return $authAdapter;
    }


}

