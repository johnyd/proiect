<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDoctype()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('XHTML1_STRICT');
		
		$globalPath = $this->getOption('globalPath');
		Zend_Registry::set('globalPath', $globalPath);
		$globalProjectPath = $this->getOption('globalProjectPath');
		Zend_Registry::set('globalProjectPath', $globalProjectPath);
		
		$config = new Zend_Config_Ini('../application/configs/application.ini','production');
		try {
			$db = Zend_Db::factory($config->database);
			$db->getConnection();
		} catch (Zend_Db_Adapter_Exception $e) {
			echo $e->getMessage();
			//perhaps a failed login credential, or perhaps the RDBMS is not running
		} catch (Zend_Exception $e) {
			echo $e->getMessage();
			//perhaps factory() failed to load the specified Adapter class
		}
		Zend_Registry::set('db', $db);
	}
}

