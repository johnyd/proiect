<?php

class MenuController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $config = Zend_Registry::get('globalPath');
        $this->view->assign('globalPath',$config);
        $this->view->assign('globalProjectPath', Zend_Registry::get('globalProjectPath'));
    }


}

