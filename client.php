<?php
    include_once "api.php"; 
    include_once "apiconfig.php"; 

    use Omni\Api; 

    $api = new Api($apiconfig["apikey"],"https://test-api.omnilance.com/v1/"); 
    $domainListForReg=Array("domaintestrx.net","domaintestrx.pw","domaintest@.com", "test.net");//List domain for registration
    $responseDomainCheck = $api->DomainCheck($domainListForReg);//Checking domain availability 

    foreach ($responseDomainCheck as $key=>$domainCheck) { 
        if (!empty($domainCheck->error)) {//An error occurred while checking domain
	    ErrorReport($domainCheck->error);//Print error
	    unset($domainListForReg[array_search($domainCheck->domain,$domainListForReg)]);//Delete domain from list
	    continue; 
	} elseif ($domainCheck->avail ==0) {//The domain is not available for registration
	    unset($domainListForReg[array_search($domainCheck->domain,$domainListForReg)]);//Delete domain from list
	    continue; 
	}
    }

    //Information about contact
    $contact = Array(
	"name" => "Name contact", 
	"company" => "Name company", 
	"address" => "Address contact", 
	"city" => "City contact", 
	"region" => "Region contact", 
	"zip" => 50000, 
	"country" => "UA", 
	"phone" => "380.630000000", 
	"fax" => "380.630000000", 
	"mail" => "email@example.com", 
	"id" => "rx.test" 
    );
	
    $responseContactCheck = $api->ContactCheck($contact["id"]);//Check contact availability
    if (!empty($responseContactCheck->error)) {
		ErrorReport($responseContactCheck->error); 
    } else { 
	if ($responseContactCheck->avail == 1) {//The contact is available to create  
	    $responseContactAdd=$api->ContactAdd($contact);//Create contact
	    if (!empty($responseContactAdd->error)) 
		    ErrorReport($responseContactAdd->error);
	}
	foreach ($domainListForReg as $domain) {
	    $domainInfo = Array(
	        "name" => $domain, 
		"period" => 1, 
		"ns" => Array( 
		    "ns1.rx-name.ua", 
		    "ns2.rx-name.ua", 
		    "ns3.rx-name.ua" 
		), 
		"contact_registrant" => $contact["id"], 
		"contact_admin" => $contact["id"], 
		"contact_tech" => $contact["id"], 
		"contact_billing" => $contact["id"], 
	    );
	    $responseDomainAdd = $api->DomainAdd($domainInfo);
	    if(!empty($responseDomainAdd->error)) ErrorReport($responseDomainAdd->error);
	} 
    } 

    function ErrorReport($error)
    { 
        print "Error: code={$error->code}, message={$error->msg}\n";
    }
?>
