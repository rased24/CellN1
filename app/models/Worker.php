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
}