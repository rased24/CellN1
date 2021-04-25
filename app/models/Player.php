<?php

class Player
{
	private $db;

	public function __construct ()
	{
		$this->db = new Database();

		if ( isset( $_SESSION[ 'token' ] ) )
		{
			Store::$player = $this->getPlayerBy( 'token', $_SESSION[ 'token' ] );
		}
	}

	public function getPlayerBy ( $row, $data )
	{
		$this->db->query( 'SELECT * FROM players WHERE ' . $row . '= :' . $row );

		$this->db->bind( ':' . $row, $data );

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

	public function register ( $data )
	{
		$this->db->query( 'INSERT INTO players (username, email, password, token) VALUES (:username, :email, :password, :token)' );

		$this->db->bind( ':username', $data[ 'username' ] );
		$this->db->bind( ':email', $data[ 'email' ] );
		$this->db->bind( ':password', $data[ 'password' ] );
		$this->db->bind( ':token', $data[ 'token' ] );

		if ( $this->db->execute() )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function login ( $data )
	{
		$this->db->query( 'SELECT * FROM players WHERE email = :email' );

		$this->db->bind( ':email', $data[ 'email' ] );

		$res = $this->db->single();

		if ( $res )
		{
			$hashed_password = $res->password;

			if ( password_verify( $data[ 'password' ], $hashed_password ) )
			{
				return $res;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}

	public function updateToken( $token, $id )
	{
		$this->db->query( 'UPDATE players SET token = :token WHERE  id = :id' );

		$this->db->bind( ':id', $id );
		$this->db->bind( ':token', $token );

		if ( $this->db->execute() )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function removeToken ( $token )
	{
		$this->db->query( 'UPDATE players SET token = null WHERE token = :token' );

		$this->db->bind( ':token', $token );

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