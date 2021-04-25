<?php

class Country
{
	protected $db;

	public function __construct ()
	{
		$this->db = new Database();
	}

	public function getCountries ()
	{
		$this->db->query( 'SELECT * FROM countries' );

		return $this->db->allResults();
	}

	public function getCountry( $owner_id )
	{
		$this->db->query( 'SELECT * FROM countries WHERE owner_id = :owner_id' );

		$this->db->bind( ':owner_id', $owner_id );
		$this->db->execute();

		if ( $res  = $this->db->single() )
		{
			return $res;
		}
		else
		{
			return FALSE;
		}
	}

	public function createCountry ( $owner_id, $name )
	{
		$this->db->query( 'INSERT INTO countries (owner_id, name) VALUES  ( :owner_id, :name)' );

		$this->db->bind( ':owner_id', $owner_id );
		$this->db->bind( ':name', $name );

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