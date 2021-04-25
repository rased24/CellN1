<?php

class Pages extends Controller
{
	protected $playerModel;
	protected $cellModel;

	public function __construct ()
	{
		$this->playerModel = $this->model( 'Player' );
		$this->cellModel   = $this->model( 'Cell' );
	}

	public function index ()
	{
		$data = $this->cellModel->getAllCells();
		$loop_data = [];

		foreach ( $data as $key => $cell )
		{
			$cell = ( array ) $cell;
			$loop_data[ $cell[ 'id' ] ] = $cell;
		}
		$data = $loop_data;

		$this->view( 'includes/head' );
		$this->view( 'includes/navigation' );
		$this->view( 'pages/index', $data );
		$this->view( 'includes/modals' );
		$this->view( 'includes/foot' );
	}
}