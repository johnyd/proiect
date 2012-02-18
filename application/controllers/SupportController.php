<?php

class SupportController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$config = Zend_Registry::get('globalProjectPath');
    	$this->config = $config;
    	
    	$this->db = Zend_Registry::get('db');
    	
    }
    
    public function getForm()
    {    	 
    	$form = new Zend_Form;
    	$form->setAction($this->config . 'public/support/submit')
    	->setMethod('post');
    	$form->setAttrib('id', 'support');
    	 
    	$message = new Zend_Form_Element_Textarea('message');
    	$message->setRequired(true);
    	$form->addElement($message, 'message');
    	 
    	$submit = new Zend_Form_Element_Submit('submit');
    	$form->addElement('submit', 'submit');
    	
		$captchaImage = new Zend_Captcha_Image();
		//$captchaImage->setStartImage('f:/server/zf/proiect/css/images/capcha2.png');
		$captchaImage->setFont('../css/arial.ttf');
		$captchaImage->setFontSize(30);
		$captchaImage->setWordlen(4);
		$captchaImage->setLineNoiseLevel(0);
		$captchaImage->setDotNoiseLevel(0);
		$captchaImage->setImgDir('../css/captcha/');
		$captchaImage->setImgUrl('../css/captcha/');
		$captchaImage->setName('captcha');
		        
		$captcha = new Zend_Form_Element_Captcha(
		'captcha', array('captcha' => $captchaImage)
		);
		$form->addElement($captcha);
    	    	
    	return $form;
    }

    public function indexAction()
    {
        // action body
        $params = $this->_request->getParams();
        if($params['sent']) $message = "Your message has been sent <br />";
        else if($params['error']) $message = $params['error'];
        else $message = "";
        
        $this->view->assign('feedbacks',$this->db->fetchAll('SELECT * FROM mpfeedback'));
        
        $this->view->assign('message',$message);
    	$this->view->assign('form',$this->getForm());
    }
    
    public function submitAction()
    {
    	if (!$this->getRequest()->isPost()) {
    		return $this->_forward('index');
    	}
    	$form = $this->getForm();
    	if (!$form->isValid($_POST)) {
    		$errors = $form->getMessages();
    		$this->_forward('index','support',array(),array('sent' => false, 'error' => $errors["message"]["isEmpty"]));
    	}
    	else{
	    	$values = $form->getValues();
	    	$insertArr = array(
	    				'idmpuser'		=>	1,
	    				'mpfeedback'	=>	$values['message'],
	    				'mpanswer'		=> null,
	    				'mpstatus'		=> 0
	    			);
	    	$this->db->insert('mpfeedback',$insertArr);
	    	$this->_forward('index','support',array(),array('sent' => true));
    	}
    }


}

