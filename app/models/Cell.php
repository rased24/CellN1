<?php

class Cell
{
	private $db;

	public function __construct ()
	{
		$this->db = new Database();

		if ( isset( $_SESSION[ 'token' ] ) )
		{
			Store::$playersCells = $this->getPlayersCells( Store::$player->id );
			Store::$cells        = $this->getAllCells();
		}
	}

	public function getAllCells ()
	{
		$this->db->query( 'SELECT * FROM cells' );

		return $this->db->allResults();
	}

	public function getPlayersCells ( $owner_id )
	{
		$this->db->query( 'SELECT * FROM cells WHERE owner_id = :owner_id' );

		$this->db->bind( ':owner_id', $owner_id );

		return $this->db->allResults();
	}

	public function getCell ( $id )
	{
		$this->db->query( 'SELECT * FROM cells WHERE id= :id' );

		$this->db->bind( ':id', $id );
		$this->db->execute();

		$res = $this->db->single();

		if ( $res )
		{
			return $res;
		}
		else
		{
			return FALSE;
		}
	}

	public function addCell( $id, $type, $owner_id )
	{
		$this->db->query( 'INSERT INTO cells (id, type, owner_id) VALUES (:id, :type, :owner_id)' );

		$this->db->bind( ':id', $id );
		$this->db->bind( ':type', $type );
		$this->db->bind( ':owner_id', $owner_id );

		if ( $this->db->execute() )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}