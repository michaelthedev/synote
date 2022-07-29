<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://www.logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 17 Jul, 2022 11:01AM
// +------------------------------------------------------------------------+
// | Copyright (c) 2022 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../backend/sources/slim/autoload.php';
require __DIR__ . '/../backend/sources/psr-7/autoload.php';
require __DIR__ . '/../backend/inc/autoload.php';

header('Access-Control-Allow-Origin: *');

// Instantiate App
$api = AppFactory::create();

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($scriptDir == "/") $scriptDir = "";
$api->setBasePath($scriptDir);

// Add body parsing
$api->addBodyParsingMiddleware();
// Add error middleware
$api->addErrorMiddleware(true, true, true);

// Add routes
$api->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Synote API");
    return $response;
});

// Scan to login
$api->post('/initScanToLogin', function (Request $request, Response $response) {
	$request_data = $request->getParsedBody();
	$post_data = cleanPostData($request_data);

	if (empty($post_data['UA'])) {
		$response_data = array();
		$response_data['error'] = true;
		$response_data['message'] = "UserAgent is required";
		$response->getBody()->write(json_encode($response_data));
		return $response
			->withHeader('Content-type', 'application/json')
			->withStatus(200);
	}

	$result = Auth::initScanToLogin($post_data['UA']);
	$response_data = array();
	$response_data['message'] = $result['message'];
	if ($result['status'] === true) {
		$response_data['error'] = false;
		$response_data['sessionID'] = $result['sessionID'];
	} else {
		$response_data['error'] = true;
	}
	$response->getBody()->write(json_encode($response_data));
	return $response
		->withHeader('Content-type', 'application/json')
		->withStatus(200);
});

// Login
$api->post('/validate-userID', function (Request $request, Response $response) {
    $request_data = $request->getParsedBody();
    $post_data = cleanPostData($request_data);

	if (empty($post_data['userID'])) {
		$response_data = array();
		$response_data['error'] = true;
		$response_data['message'] = "UserID is required";
		$response->getBody()->write(json_encode($response_data));
		return $response
		    ->withHeader('Content-type', 'application/json')
		    ->withStatus(200);
	}

	// Validate user id
	$account = Account::validateUserID($post_data['userID']);
	if (empty($account)) {
		$response_data = array();
		$response_data['error'] = true;
		$response_data['message'] = "Invalid userID";
		$response->getBody()->write(json_encode($response_data));
	} else {
		$response_data = array();
		$response_data['error'] = false;
		$response_data['message'] = "Validation successful";
		$response->getBody()->write(json_encode($response_data));
	}

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

// Login
$api->post('/login', function (Request $request, Response $response) {
    $request_data = $request->getParsedBody();
    $post_data = cleanPostData($request_data);

	if (empty($post_data['username'])) {
		$response_data = array();
		$response_data['error'] = true;
		$response_data['message'] = "Username is required";
		$response->getBody()->write(json_encode($response_data));
		return $response
		    ->withHeader('Content-type', 'application/json')
		    ->withStatus(200);
	}

	if (empty($post_data['password'])) {
		$response_data = array();
		$response_data['error'] = true;
		$response_data['message'] = "Password is required";
		$response->getBody()->write(json_encode($response_data));
		return $response
		    ->withHeader('Content-type', 'application/json')
		    ->withStatus(200);
	}
    
    $result = Auth::login($post_data['username'], $post_data['password']);
    if ($result['status'] === true) {
        $response_data = array();
        $response_data['error'] = false;
        $response_data['message'] = $result['message'];
        $response_data['userID'] = $result['userID'];
        $response->getBody()->write(json_encode($response_data));
    }
    else {
        $response_data = array();
        $response_data['error'] = true;
        $response_data['message'] = $result['message'];
        $response->getBody()->write(json_encode($response_data));
    }

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

// Register
$api->post('/register', function (Request $request, Response $response) {
    $request_data = $request->getParsedBody();
    $post_data = cleanPostData($request_data);

	if (empty($post_data['username'])) {
		$response_data = array();
		$response_data['error'] = true;
		$response_data['message'] = "Username is required";
		$response->getBody()->write(json_encode($response_data));
		return $response
		    ->withHeader('Content-type', 'application/json')
		    ->withStatus(200);
	}

	if (empty($post_data['password'])) {
		$response_data = array();
		$response_data['error'] = true;
		$response_data['message'] = "Password is required";
		$response->getBody()->write(json_encode($response_data));
		return $response
		    ->withHeader('Content-type', 'application/json')
		    ->withStatus(200);
	}
    
    $result = Auth::register($post_data);
    if ($result['status'] === true) {
        $response_data = array();
        $response_data['error'] = false;
        $response_data['message'] = $result['message'];
        $response_data['userID'] = $result['userID'];
        $response->getBody()->write(json_encode($response_data));
    }
    else {
        $response_data = array();
        $response_data['error'] = true;
        $response_data['message'] = $result['message'];
        $response->getBody()->write(json_encode($response_data));
    }

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

// Add Note
$api->post('/new-note', function (Request $request, Response $response) {
    $request_data = $request->getParsedBody();
    $post_data = cleanPostData($request_data);

    if (empty($post_data['userID'])) {
    	$response_data = array();
    	$response_data['error'] = true;
    	$response_data['message'] = "UserID is required";
    	$response->getBody()->write(json_encode($response_data));
    	return $response
    	    ->withHeader('Content-type', 'application/json')
    	    ->withStatus(200);
    }

	if (empty($post_data['content']) && empty($post_data['title'])) {
		$response_data = array();
		$response_data['error'] = true;
		$response_data['message'] = "Can't create an empty note";
		$response->getBody()->write(json_encode($response_data));
		return $response
		    ->withHeader('Content-type', 'application/json')
		    ->withStatus(200);
	}
    
    $result = Notes::addNew($post_data);
    if ($result['status'] === true) {
        $response_data = array();
        $response_data['error'] = false;
        $response_data['message'] = $result['message'];
        $response->getBody()->write(json_encode($response_data));
    }
    else {
        $response_data = array();
        $response_data['error'] = true;
        $response_data['message'] = $result['message'];
        $response->getBody()->write(json_encode($response_data));
    }

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

// Edit Note
$api->post('/edit-note', function (Request $request, Response $response) {
    $request_data = $request->getParsedBody();
    $post_data = cleanPostData($request_data);

    if (empty($post_data['userID'])) {
    	$response_data = array();
    	$response_data['error'] = true;
    	$response_data['message'] = "UserID is required";
    	$response->getBody()->write(json_encode($response_data));
    	return $response
    	    ->withHeader('Content-type', 'application/json')
    	    ->withStatus(200);
    }

    if (empty($post_data['noteID'])) {
    	$response_data = array();
    	$response_data['error'] = true;
    	$response_data['message'] = "NoteID is required";
    	$response->getBody()->write(json_encode($response_data));
    	return $response
    	    ->withHeader('Content-type', 'application/json')
    	    ->withStatus(200);
    }
    
    $result = Notes::editNote($post_data);
    if ($result['status'] === true) {
        $response_data = array();
        $response_data['error'] = false;
        $response_data['message'] = $result['message'];
        $response->getBody()->write(json_encode($response_data));
    }
    else {
        $response_data = array();
        $response_data['error'] = true;
        $response_data['message'] = $result['message'];
        $response->getBody()->write(json_encode($response_data));
    }

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

// Delete Note
$api->post('/delete-note', function (Request $request, Response $response) {
    $request_data = $request->getParsedBody();
    $post_data = cleanPostData($request_data);

    if (empty($post_data['userID'])) {
    	$response_data = array();
    	$response_data['error'] = true;
    	$response_data['message'] = "UserID is required";
    	$response->getBody()->write(json_encode($response_data));
    	return $response
    	    ->withHeader('Content-type', 'application/json')
    	    ->withStatus(200);
    }

    if (empty($post_data['noteID'])) {
    	$response_data = array();
    	$response_data['error'] = true;
    	$response_data['message'] = "NoteID is required";
    	$response->getBody()->write(json_encode($response_data));
    	return $response
    	    ->withHeader('Content-type', 'application/json')
    	    ->withStatus(200);
    }
    
    $result = Notes::deleteNote($post_data);
    if ($result['status'] === true) {
        $response_data = array();
        $response_data['error'] = false;
        $response_data['message'] = $result['message'];
        $response->getBody()->write(json_encode($response_data));
    }
    else {
        $response_data = array();
        $response_data['error'] = true;
        $response_data['message'] = $result['message'];
        $response->getBody()->write(json_encode($response_data));
    }

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

// Get notes
$api->post('/get-notes', function (Request $request, Response $response) {
    $request_data = $request->getParsedBody();
   	$post_data = cleanPostData($request_data);

   	if (empty($post_data['userID'])) {
   		$response_data = array();
   		$response_data['error'] = true;
   		$response_data['message'] = "User id is required";
   		$response->getBody()->write(json_encode($response_data));
   		return $response
   		    ->withHeader('Content-type', 'application/json')
   		    ->withStatus(200);
   	}

   	// Validate user id
   	$account = Account::validateUserID($post_data['userID']);
   	if (empty($account)) {
   		$response_data = array();
   		$response_data['error'] = true;
   		$response_data['message'] = "Invalid userID";
   		$response->getBody()->write(json_encode($response_data));
   		return $response
   		    ->withHeader('Content-type', 'application/json')
   		    ->withStatus(200);
   	}

   	$userNotes = Notes::byUser($account->id);
    $response_data = array();
    $response_data['error'] = false;
    $response_data['message'] = "success";
    $response_data['data'] = $userNotes;
	$response->getBody()->write(json_encode($response_data));
	return $response
	    ->withHeader('Content-type', 'application/json')
	    ->withStatus(200);
});



// Connect device
$api->post('/connect-device', function (Request $request, Response $response) {
    $request_data = $request->getParsedBody();
   	$post_data = cleanPostData($request_data);

   	if (empty($post_data['userID'])) {
   		$response_data = array();
   		$response_data['error'] = true;
   		$response_data['message'] = "User id is required";
   		$response->getBody()->write(json_encode($response_data));
   		return $response
   		    ->withHeader('Content-type', 'application/json')
   		    ->withStatus(200);
   	}

   	$result = Auth::connectDevice($post_data);
   	if ($result['status'] === true) {
   	    $response_data = array();
   	    $response_data['error'] = false;
   	    $response_data['message'] = $result['message'];
   	    $response->getBody()->write(json_encode($response_data));
   	}
   	else {
   	    $response_data = array();
   	    $response_data['error'] = true;
   	    $response_data['message'] = $result['message'];
   	    $response->getBody()->write(json_encode($response_data));
   	}

	return $response
	    ->withHeader('Content-type', 'application/json')
	    ->withStatus(200);
});

// Scan status
$api->post('/check-scan-status', function (Request $request, Response $response) {
	$request_data = $request->getParsedBody();
	$post_data = cleanPostData($request_data);

	if (empty($post_data['sessionID'])) {
		$response_data = array();
		$response_data['error'] = true;
		$response_data['message'] = "Session id is required";
		$response->getBody()->write(json_encode($response_data));
		return $response
		    ->withHeader('Content-type', 'application/json')
		    ->withStatus(200);
	}

    $response_data = array();
	$response_data['loginSuccessful'] = false;
    $response_data['userID'] = null;
	
	$result = Auth::checkScanStatus($post_data['sessionID']);
   	if ($result['status'] === true) {
   	    $response_data['loginSuccessful'] = true;
   	    $response_data['userID'] = $result['userID'];
   	}
    
    $response_data['error'] = false;
    $response_data['message'] = $result['message'];
    $response->getBody()->write(json_encode($response_data));

	return $response
	    ->withHeader('Content-type', 'application/json')
	    ->withStatus(200);
});


function cleanPostData($post_data) {
	foreach ($post_data as $key => $value) {
		$post[$key] = App::clean($value);
	}
	return $post;
}

$api->run();