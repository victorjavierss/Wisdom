<?php
class Logger_Subject implements SplSubject{

	private $_log_status_stack;
	private $_observers = array();
	
	/**
	 * Agregamos un observador a la cola de observadores
	 *
	 * @param Spl_Observer $observer
	 */
	public function attach( SplObserver $observer )
	{
		$this->_observers[$observer->getId()] = $observer;
	}

	/**
	 * Eliminamos un observador de la cola de observadores
	 *
	 * @param Spl_Observer $observer
	 */
	public function detach( SplObserver $observer )
	{
		if ( in_array( $observer , $this->_observers ) ){
			unset( $this->_observers[ $observer->getId() ] );	
		} else {
			#
		}
	}

	/**
	 * Metodo que notifica la ejecucion de proceso de un sujeto
	 */
	public function notify()
	{
		foreach( $this->_observers as $observer ){
			$observer->update( $this );
		}
		
		//limpiamos los mensajes despues de que se les notificó a los observadores
		$this->_log_status_stack = NULL;
	}

	/**
	 * Agregamos datos informativos a la pila de $_log_status_stack
	 *
	 * @param string $log_data
	 */
	public function addLogStatus( $log_data )
	{
		$this->_log_status_stack	=	$log_data;
	}

	/**
	 * Accesor para $_log_status_stack
	 */
	public function getLogStatus()
	{
		return $this->_log_status_stack;
	}
}