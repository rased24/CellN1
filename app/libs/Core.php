<?php

class Core
{
	protected $currentController = 'Pages';
	protected $currentMethod     = 'index';
	protected $params            = [];

	public function __construct ()
	{
		$url = $this->getUrl();

		//Every file in controllers folder are capitalized
		if ( isset( $url[ 0 ] ) && file_exists( '../app/controllers/' . ucwords( $url[ 0 ] ) . '.php' ) )
		{
			$this->currentController = ucwords( $url[ 0 ] );
			unset( $url[ 0 ] );
		}

		//Require new controller and define it to $currentController
		require_once '../app/controllers/' . $this->currentController . '.php';
		$this->currentController = new $this->currentController;

		//Check if method exists in currentController
		if ( isset( $url[ 1 ] ) && method_exists( $this->currentController, $url[ 1 ] ) )
		{
			$this->currentMethod = $url[ 1 ];
			unset( $url[ 1 ] );
		}

		//Check for params return params or NULL array
		$this->params = $url ? array_values( $url ) : [];

		//Call a callback function
		call_user_func_array( [ $this->currentController, $this->currentMethod ], $this->params );
	}

	public function getUrl ()
	{
		if ( isset( $_GET[ 'url' ] ) )
		{
			$url = rtrim( $_GET[ 'url' ], '/' );
			$url = filter_var( $url, FILTER_SANITIZE_URL );
			$url = explode( '/', $url );

			return $url;
		}
		else
		{
			return NULL;
		}
	}
}