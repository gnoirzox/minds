<?php

    $return = array(
	'status' => 0,
	'system_messages' => array('error' => array(), 'success' => array()),
	'output' => ''
    );

    try {
	if ($user = elgg_get_logged_in_user_entity()) {
	
	   if (!$wallet = minds\plugin\bitcoin\bitcoin()->getWallet($user)) {
	       $wallet_guid = minds\plugin\bitcoin\bitcoin ()->createWallet($user);
	       $wallet = get_entity($wallet_guid);
	   }
	   
	    if (!$wallet)
		throw new Exception ("Wallet could not be created...");
	    
	    system_message("New wallet created!");
	    $return['output'] = $wallet->wallet_address;
	    
	} else 
	    throw new Exception ("Could not get user...");
	
    } catch (Exception $ex) {
	
	$return['status'] = -1;
	$return['system_messages']['error'][] = $ex->getMessage();
	
    }
    
    header('Content-Type: application/json');
    echo json_encode($return); exit;