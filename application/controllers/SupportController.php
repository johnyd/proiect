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
    
    public function getForm() //create form and elements
    {    	 
    	$form = new Zend_Form;
    	$form->setAction($this->config . 'public/support/index')
    	->setMethod('post');
    	$form->setAttrib('id', 'support');
    	 
    	$message = new Zend_Form_Element_Textarea('message');
    	$message->setRequired(true);
    	$message->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
    	$message->setAttribs(array(
    				'rows' 	=>	10,
    				'cols'	=>	75,
    			));
    	$message->setLabel('Please send us your feedback:');
    	$form->addElement($message, 'message');
    	
    	$captchaImage = new Zend_Captcha_Image();
    	$captchaImage->setHeight(60);
    	$captchaImage->setWidth(100);
    	$captchaImage->setFont('../css/arial.ttf');
    	$captchaImage->setFontSize(25);
    	$captchaImage->setWordlen(5);
    	$captchaImage->setLineNoiseLevel(5);
    	$captchaImage->setDotNoiseLevel(5);
    	$captchaImage->setImgDir('../css/captcha/');
    	$captchaImage->setImgUrl('../../css/captcha/');
    	$captchaImage->setName('captcha');
    	$captchaImage->setTimeout(300);
    	$captchaImage->setExpiration(300);
    	
    	$captcha = new Zend_Form_Element_Captcha(
    			'captcha', array('captcha' => $captchaImage)
    	);
    	$captcha->setDecorators(array(
    			'Description',
    			'Errors',
    			array(array('data'=>'HtmlTag'), array('tag' => 'td')),
    			array('Label', array('tag' => 'td')),
    			array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
    	));
    	$captcha->setLabel('Please enter text from image:');
    	$form->addElement($captcha);
    	
    	$submit = new Zend_Form_Element_Submit('Send');
    	$submit->setDecorators(array(
               	'ViewHelper',
               	'Description',
    		   	array(array('data'=>'HtmlTag'), array('tag' => 'td')),
    			array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
       	));
    	$form->addElement($submit, 'Send');
    	
    	$form->setDecorators(array(
    			'FormElements',
    			array(array('data'=>'HtmlTag'),array('tag'=>'table')),
    			'Form'
    	));
    	
    	return $form;
    }

    public function indexAction()
    {
        // action body    

        $form = $this->getForm();
        if (!$this->getRequest()->isPost()) {
        	$this->view->assign('form',$form);
        }
        else if (!$form->isValid($_POST)) {
        	$this->view->assign('form',$form);
        }
        else{
        	
        	$values = $form->getValues();
        	$insertArr = array(
        			'idmpuser'		=>	1,
        			//get logged user for idmpuser
        			'mpfeedback'	=>	$values['message'],
        			'mpanswer'		=> null,
        			'mpstatus'		=> 0
        	);
        	$this->db->insert('mpfeedback',$insertArr);
        	$this->view->assign('form',$form);
        } 
    }


}