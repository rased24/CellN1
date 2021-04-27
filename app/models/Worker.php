<?php

class Worker
{
	protected $db;

	public function __construct ()
	{
		$this->db = new Database();
	}

	public function getWorker ( $cell_id )
	{
		$this->db->query( 'SELECT * FROM workers WHERE cell_id = :cell_id' );

		$this->db->bind( ':cell_id', $cell_id );
		$this->db->execute();

		if ( $res = $this->db->single() )
		{
			return $res;
		}
		else
		{
			return FALSE;
		}
	}

	public function createWorker ( $owner_id, $cell_id, $character_id )
	{
		$this->db->query( 'INSERT INTO workers (owner_id, cell_id, character_id) VALUES (:owner_id, :cell_id, :character_id)' );

		$this->db->bind( ':owner_id', $owner_id );
		$this->db->bind( ':cell_id', $cell_id );
		$this->db->bind( ':character_id', $character_id );

		if ( $this->db->execute() )
		{
			return TRUE;
		}
		else
		{
			return  FALSE;
		}
	}
}