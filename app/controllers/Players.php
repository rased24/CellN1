<?php

class Players extends Controller
{
	protected $playerModel;

	public function __construct ()
	{
		$this->playerModel = $this->model( 'Player' );
	}

	public function register ()
	{
		$data = [
			'username'             => '',
			'email'                => '',
			'password'             => '',
			'confirmPassword'      => '',
			'usernameError'        => '',
			'emailError'           => '',
			'passwordError'        => '',
			'confirmPasswordError' => ''
		];

		if ( isset( $_POST[ 'username' ] ) )
		{
			$_POST = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

			$data = [
				'username'             => strip_tags( trim( $_POST[ 'username' ] ) ),
				'email'                => strip_tags( trim( $_POST[ 'email' ] ) ),
				'password'             => strip_tags( trim( $_POST[ 'password' ] ) ),
				'confirmPassword'      => strip_tags( trim( $_POST[ 'confirmPassword' ] ) ),
				'usernameError'        => '',
				'emailError'           => '',
				'passwordError'        => '',
				'confirmPasswordError' => ''
			];

			$nameValidation     = "/^[a-zA-Z0-9]*$/";
			$passwordValidation = "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[\d])\S*$/";

			//Validate Username
			if ( empty( $data[ 'username' ] ) )
			{
				$data[ 'usernameError' ] = 'Username can\'t be empty.';
			}
			else if ( $this->playerModel->getPlayerBy( 'username', $data[ 'username' ] ) )
			{
				$data[ 'usernameError' ] = 'This username already taken.';
			}
			else if ( ! preg_match( $nameValidation, $data[ 'username' ] ) )
			{
				$data[ 'usernameError' ] = 'Please use only valid characters.';
			}

			//Validate Email
			if ( empty( $data[ 'email' ] ) )
			{
				$data[ 'emailError' ] = 'Email can\'t be empty.';
			}
			else if ( ! filter_var( $data[ 'email' ], FILTER_VALIDATE_EMAIL ) )
			{
				$data[ 'emailError' ] = 'Please enter valid email.';
			}
			else if ( $this->playerModel->getPlayerBy( 'email', $data[ 'email' ] ) )
			{
				$data[ 'emailError' ] = 'This email already in use.';
			}

			//Validate Password
			if ( empty( $data[ 'password' ] ) )
			{
				$data[ 'passwordError' ] = 'Password can\'t be empty.';
			}
			else if ( ! preg_match( $passwordValidation, $data[ 'password' ] ) )
			{
				$data[ 'passwordError' ] = 'Please enter valid password.';
			}
			else if ( strlen( $data[ 'password' ] ) < 6 )
			{
				$data[ 'passwordError' ] = 'Password must contain at least 6 characters';
			}

			//Validate confirmPassword
			if ( empty( $data[ 'confirmPassword' ] ) )
			{
				$data[ 'confirmPasswordError' ] = 'Please re-enter your password.';
			}
			else if ( $data[ 'confirmPassword' ] !== $data[ 'password' ] )
			{
				$data[ 'confirmPasswordError' ] = 'Passwords did not match. Please try again.';
			}

			//Check if all errors are empty
			if ( empty( $data[ 'usernameError' ] ) && empty( $data[ 'emailError' ] ) && empty( $data[ 'passwordError' ] ) && empty( $data[ 'confirmPasswordError' ] ) )
			{

				$login_pass = $data[ 'password' ];
				//Hashing password
				$data[ 'password' ] = password_hash( $data[ 'password' ], PASSWORD_DEFAULT );
				$data[ 'token' ]    = md5( time() );


				if ( $this->playerModel->register( $data ) )
				{
					$data[ 'password' ] = $login_pass;

					$this->playerModel->login( $data );
					$this->createUserSession( $data[ 'token' ] );

					header( 'location:' . URLROOT );
				}
				else
				{
					die( 'Something went wrong.' );
				}
			}
		}

		$this->view( 'includes/head' );
		$this->view( 'includes/navigation' );
		$this->view( 'pages/register', $data );
		$this->view( 'includes/foot' );
	}

	public function login ()
	{
		$data = [
			'email'      => '',
			'emailError'      => '',
			'usernameError' => '',
			'passwordError' => ''
		];

		if ( isset( $_POST[ 'email' ] ) )
		{
			$data = [
				'email' => strip_tags( trim( $_POST[ 'email' ] ) ),
				'password' => strip_tags( trim( $_POST[ 'password' ] ) ),
				'emailError' => '',
				'passwordError' => ''
			];
			//Validate username
			if ( empty( $data[ 'email' ] ) )
			{
				$data[ 'emailError' ] = 'Please enter your email.';
			}

			//Validate password
			if ( empty( $data[ 'password' ] ) )
			{
				$data[ 'passwordError' ] = 'Please enter your password';
			}

			//Check if all errors are empty
			if ( empty( $data[ 'emailError' ]  ) && empty( $data[ 'passwordError' ] ) )
			{
				$data[ 'token' ]    = md5( time() );


				if ( $logged_in_player = $this->playerModel->login( $data ) )
				{
					$this->playerModel->updateToken( $data[ 'token' ], $logged_in_player->id );
					$this->createUserSession( $data[ 'token' ] );

					header( 'location:' . URLROOT );
				}
				else
				{
					$data[ 'passwordError' ] = 'Password or username is incorrect.';
				}
			}
		}
		$this->view( 'includes/head' );
		$this->view( 'includes/navigation' );
		$this->view( 'pages/login', $data );
		$this->view( 'includes/foot' );
	}

	public function createUserSession ( $token )
	{
		$_SESSION[ 'token' ] = $token;
	}

	public function logout ()
	{
		//Will be updated soon( remove fricking token)
		$this->playerModel->removeToken( $_SESSION[ 'token' ] );
		unset( $_SESSION[ 'token' ] );
		header( 'location:' . URLROOT );
	}
}