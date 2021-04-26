<?php

class Cells extends Controller
{
	protected $playerModel;
	protected $cellModel;
	protected $countryModel;
	protected $workerModel;

	public function __construct ()
	{
		$this->playerModel  = $this->model( 'Player' );
		$this->cellModel    = $this->model( 'Cell' );
		$this->countryModel = $this->model( 'Country' );
		$this->workerModel  = $this->model( 'Worker' );
	}

	public function createCountry ()
	{
		$data = [
			'id'        => '',
			'idError'   => '',
			'name'      => '',
			'nameError' => '',
			'message'   => '',
			'type'      => ''
		];

		if ( isset( Store::$player->id ) )
		{
			if ( isset( $_POST[ 'id' ] ) )
			{
				$data[ 'id' ] =  $_POST[ 'id' ];
				$data[ 'name' ] = strip_tags( trim( $_POST[ 'name' ] ) );

				//Create Cell
				$this->cellModel->addCell( $data[ 'id' ], 'base', Store::$player->id );
				$this->cellModel->addCell( $data[ 'id' ] + 1, 'lab', Store::$player->id );
				$this->cellModel->addCell( $data[ 'id' ] - 1, 'cave', Store::$player->id );
				$this->cellModel->addCell( $data[ 'id' ] + 100, 'army', Store::$player->id );
				$this->cellModel->addCell( $data[ 'id' ] - 100, 'forest', Store::$player->id );
				$this->countryModel->createCountry( Store::$player->id, $data[ 'name' ] );

				echo json_encode( $data );
			}
		}
	}

	public function get_cell_info ()
	{
		$data = [
			'id'           => '',
			'is_sea'       => TRUE,
			'is_owner'     => FALSE,
			'has_property' => FALSE,
			'can_own'      => TRUE,
			'type'         => '',
			'html'         => '<p></p>'
		];

		if ( isset( Store::$player->id ) )
		{
			if ( isset( $_POST[ 'id' ] ) )
			{
				$data[ 'id' ] = $_POST[ 'id' ];

				//Check if cell is not sea or you are able to get cell, check it's type, check if user is the owner of cell.
				if ( $cell = $this->cellModel->getCell( $data[ 'id' ] ) )
				{
					$data[ 'is_sea' ] = FALSE;
					$data[ 'type' ]   = $cell->type;
					/*
					 * (  $this->cellModel->getCell( $data[ 'id' ] + 2 ) ||
				                $this->cellModel->getCell( $data[ 'id' ] - 2 ) ||
				                $this->cellModel->getCell( $data[ 'id' ] + 101 ) ||
				                $this->cellModel->getCell( $data[ 'id' ] + 99 ) ||
				                $this->cellModel->getCell( $data[ 'id' ] - 101 ) ||
				                $this->cellModel->getCell( $data[ 'id' ] - 99 )  )
					 */


					if ( $cell->owner_id === Store::$player->id )
					{
						$data[ 'is_owner' ] = TRUE;
					}
				}
				elseif ( $this->cellModel->getCell( $data[ 'id' ] - 1 ) ||
				          $this->cellModel->getCell( $data[ 'id' ] + 1 ) ||
				          $this->cellModel->getCell( $data[ 'id' ] - 100 ) ||
				          $this->cellModel->getCell( $data[ 'id' ] + 100 ) )
				{
					$data[ 'can_own' ] = FALSE;
				}

				//Check if user has any property
				if( $this->cellModel->getPlayersCells( Store::$player->id ) )
				{
					$data[ 'has_property' ] = TRUE;
				}

				//select modal context
				if( $data[ 'has_property' ] )
				{
					if (  $data[ 'is_sea' ] )
					{
						$data[ 'html' ] = '<p>You can\'t own this property!</p>';
					}
					else
					{
						if ( $data[ 'is_owner' ] )
						{
							$data[ 'html' ] = '<p>This is your ' . $cell->type . '!</p>';
						}
						else
						{
							$data[ 'html' ] = '<p>You aren\'t the owner of this property!</p>';
						}
					}
				}
				else
				{
					if ( $data[ 'is_sea' ] )
					{
						if ( $data[ 'can_own' ] )
						{
							if ( $data[ 'id' ] - 100 > 0 && $data[ 'id' ] + 100 < 9999 && ! ( ( $data[ 'id' ] + 1 ) % 100 === 0 || $data[ 'id' ] % 100 === 0 ) )
							{
								$data[ 'html' ] = '<label for="country-name">Choose Name For Your Country</label>
											<input type="hidden" id="cell-id" value="' . $data[ 'id' ] . '">
											<input type="text" class="input-class" id="country-name" placeholder="your country name*"> 
										   <button class="button-class" id="save-country">Ok</button>';
							}
							else
							{
								$data[ 'html' ] = '<p>You can\'t own this property!</p>';
							}
						}
						else
						{
							$data[ 'html' ] = '<p>You can\'t own this property!</p>';
						}
					}
					else
					{
						$data[ 'html' ] = '<p>You aren\'t the owner of this property!</p>';
					}
				}
			}
		}
		echo json_encode( $data );
	}
}