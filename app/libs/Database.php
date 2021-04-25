<?php

class Database
{
	private $db_host = DB_HOST;
	private $db_user = DB_USER;
	private $db_pass = DB_PASS;
	private $db_name = DB_NAME;
	private $db_handler;
	private $statement;
	private $errors;

	public function __construct ()
	{
		$conn    = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;
		$options = [
			PDO::ATTR_PERSISTENT => TRUE,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		];

		try
		{
			$this->db_handler = new PDO( $conn, $this->db_user, $this->db_pass, $options );
		}
		catch ( PDOException $e )
		{
			$this->errors = $e->getMessage();
			echo $this->errors;
		}
	}

	public function query( $sql )
	{
		$this->statement = $this->db_handler->prepare( $sql );
	}

	public function bind( $parameter, $value, $type = NULL )
	{
		switch ( is_null( $type ) )
		{
			case is_null( $value ):
				$type = PDO::PARAM_NULL;
				break;
			case is_bool( $value ):
				$type = PDO::PARAM_BOOL;
				break;
			case is_int( $value ):
				$type = PDO::PARAM_INT;
				break;
			default:
				$type = PDO::PARAM_STR;
		}

		$this->statement->bindValue( $parameter, $value, $type );
	}

	public function execute()
	{
		return $this->statement->execute();
	}

	public  function allResults()
	{
		$this->execute();

		return $this->statement->fetchAll( PDO::FETCH_OBJ );
	}

	public function single()
	{
		$this->execute();

		return $this->statement->fetch( PDO::FETCH_OBJ );
	}
}