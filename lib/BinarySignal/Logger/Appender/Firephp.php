<?php
/* Zend_Wildfire_Plugin_FirePhp */
require_once 'Zend/Wildfire/Plugin/FirePhp.php';

class Binarysignal_Logger_Appender_Firephp extends LoggerAppender {

	public function __construct($name = '') {
		parent::__construct($name);
		$this->requiresLayout = false;
	}
	
	public function __destruct() {
       $this->close();
   	}
	
	public function activateOptions() {
		$this->closed = false;
	}

	public function close() {
		$this->closed = true;
	}

	public function append($event) {
			$level = $event->getLevel();
			$tl = strtolower($level->toString());
			switch($tl) {
				case 'debug':
					$log_level = Zend_Wildfire_Plugin_FirePhp::LOG;
					break;
				case 'info':
					$log_level = Zend_Wildfire_Plugin_FirePhp::INFO;
					break;
				case 'warn':
					$log_level = Zend_Wildfire_Plugin_FirePhp::WARN;
					break;
				case 'error':
					$log_level = Zend_Wildfire_Plugin_FirePhp::ERROR;
					break;
				case 'fatal':
					$log_level = Zend_Wildfire_Plugin_FirePhp::ERROR;
					break;
				default:
					$log_level = Zend_Wildfire_Plugin_FirePhp::INFO;
			}
	        Zend_Wildfire_Plugin_FirePhp::getInstance()->send('[' . $level->toString() . '] - ' . $event->getRenderedMessage(),
	                                                          null,
	                                                          $log_level,
	                                                          array('traceOffset'=>6));
	}
}
