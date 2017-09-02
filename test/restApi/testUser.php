<?php 
	require_once 'PHPUnit/Autoload.php';
	use GuzzleHttp\Client;
	//require '../../app/controllers/User.php';
	
	
	/**
	* 
	*/
	class UserTest extends PHPUnit_Framework_TestCase{


		public function testPOST(){
			$client = new GuzzleHttp\Client();
			echo "test";
	    	/*// create our http client (Guzzle)
	    	$client = new Client('http://localhost:8000/', 
	    						array('request.options' => array('exceptions' => false,)
	    				));

		    $username = 'ObjectOrienter'.rand(0, 999);
		    $data = array(
		        'user_name' => 'new_user',
		        'password' => 'new_pass'
		    );

		    $request = $client->post('/api/programmers', null, json_encode($data));
		    $response = $request->send();

		    $this->assertEquals(201, $response->getStatusCode());
		    $this->assertTrue($response->hasHeader('Location'));
		    $data = json_decode($response->getBody(true), true);
		    $this->assertArrayHasKey('nickname', $data);*/
		}

	}
?>