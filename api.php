<?php
    namespace Omni;

    class Api
    {
		
        private $url="https://api.omnilance.com";
	private $apikey;
	private $data;
		
	public function __construct($apikey,$url=null)
	{
	    $this->apikey = $apikey;
	    if (!empty($url))
	        $this->url = $url;
	}

	private function Request()
	{
	    $this->data["apikey"] =$this->apikey;		
	    $defaults = Array(
	        CURLOPT_URL => $this->url,
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER=>0,
		CURLOPT_SSL_VERIFYHOST=>0,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_POST=>true,
		CURLOPT_POSTFIELDS=>json_encode($this->data),	
	    );
	    $ch = curl_init();	
	    curl_setopt_array($ch,$defaults);
	    if (!$result = curl_exec($ch)) {
		trigger_error(curl_error($ch));
	    }
	    curl_close($ch);
	    $res = json_decode($result);
	    return $res;
	}
		
	public function CustomerAdd($customer)
	{
	    $this->data = Array(
		"type" => "customer",
		"comand" => "customer_add",
		"data" => $customer	
	    );
	    $response = $this->Request();
	    return $response;
	}

        public function CustomerUpdate($customer)
	{
	    $this->data = Array(
	        "type" => "customer",
		"comand" => "customer_update",
		"data" => $customer	
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function CustomerInfo($customer_id)
	{
	    $this->data = Array(
	        "type" => "customer",
		"comand" => "customer_info",
		"data" => $customer	
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function CustomerDelete($customer_id)
	{
	    $this->data = Array(
	        "type" => "customer",
		"comand" => "customer_delete",
		"data" => Array(
		    "id" => $customer_id
		),	
	    );
	    $response = $this->Request();
	    return $response;
	}
	
	public function DomainCheck($domainListForCheck)
	{
	    $this->data = Array(
		"type" => "domain",
		"comand" => "domain_check",
		"data" => $domainListForCheck
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function DomainAdd($domain)
	{
	    $this->data = Array(
		"type" => "domain",
		"comand" => "domain_add",
		"data" => Array($domain),
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function DomainUpdate($domain)
	{
	    $this->data = Array(
	    	"type" => "domain",
	    	"comand" => "domain_update",
	    	"data" => $domain,
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function DomainInfo($domainNameArray)
	{
	    $this->data = Array(
		"type" => "domain",
		"comand" => "domain_info",
		"data" => $domainNameArray,
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function DomainRenew($domainInfo)
	{
	    $this->data = Array(
		"type" => "domain",
		"comand" => "domain_renew",
		"data" => Array($domainInfo),
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function DomainTransferRequest($domainInfo)
	{
	    $this->data = Array(
		"type" => "domain",
		"comand" => "domain_transfer_request",
		"data" => $domainInfo
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function DomainTransferQuery($domainInfo)
	{
	    $this->data = Array(
		"type" => "domain",
		"comand" => "domain_transfer_query",
		"data" => $domainInfo
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function DomainTransferCancel($domainInfo)
	{
	   $this->data = Array(
		"type" => "domain",
		"comand" => "domain_transfer_cancel",
		"data" => $domainInfo
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function DomainTransferApprove($domainInfo)
	{
	    $this->data = Array(
		"type" => "domain",
		"comand" => "domain_transfer_approve",
		"data" => $domainInfo
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function DomainTransferReject($domainInfo)
	{
	    $this->data = Array(
		"type" => "domain",
		"comand" => "domain_transfer_reject",
		"data" => $domainInfo
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function DomainRestore($domainName)
	{
	    $this->data = Array(
		"type" => "domain",
		"comand" => "domain_restore",
		"data" => Array(
		    "name" => $domainName
		)
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function DomainDelete($domainName)
	{
	    $this->data = Array(
		"type" => "domain",
		"comand" => "domain_delete",
		"data" => Array(
		    "name" => $domainName
		)
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function ContactCheck($contact_id)
	{
	    $this->data = Array(
		"type" => "contact",
		"comand" => "contact_check",
		"data" => Array(
		    "contact_id" => $contact_id
		),
	     );
	    $response = $this->Request();
	    return $response;
	}

	public function ContactAdd($contact)
	{
	    $this->data = Array(
		"type" => "contact",
		"comand" => "contact_add",
		"data" => $contact
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function ContactInfo($contactIdList)
	{
	    $this->data=  Array(
		"type" => "contact",
		"comand" => "contact_info",
		    "data"=>$contactNameList
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function ContactUpdate($contactInfo)
	{
	    $this->data = Array(
		"type" => "contact",
		"comand" => "contact_update",
		"data" => $contactInfo
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function ContactDelete($contactId)
	{
	     $this->data = Array(
		"type" => "contact",
		"comand" => "contact_delete",
		"data" => Array(
		    "contact_id" => $contactName
		),
	     );
	     $response = $this->Request();
	     return $response;
	}

	public function HostCheck($hostNameArray,$domainZone)
	{
	     $this->data = Array(
		"type" => "host",
		"comand" => "host_check",
		"data" => Array(
		    "host" => $hostNameArray,
		     "zone"=>$domainZone,
		)
	     );
	     $response = $this->Request();
	     return $response;
	}
		
	public function HostAdd($hostInfo,$domain)
	{
	     $this->data = Array(
	 	"type" => "host",
		"comand" => "host_add",
		"data" => Array(
		    "host" => $hostInfo,
		    "domain" => $domain
		)
	     );
	     $response = $this->Request();
	     return $response;
	}

	public function HostInfo($hostName,$domainName)
	{
	    $this->data = Array(
		"type" => "host",
		"comand" => "host_info",
		"data" => Array(
		     "host" => $hostName,
		     "domain" => $domainName
		)
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function HostDelete($hostName,$domainName)
	{
	    $this->data = Array(
		"type" => "host",
		"comand" => "host_delete",
		"data" => Array(
		    "host" => $hostName,
		    "domain" => $domainName,
		),
	    );
	    $response = $this->Request();
	    return $response;
	}

	public function HostUpdate($hostInfo, $domainName)
	{
	     $this->data = Array(
		"type" => "host",
		"comand" => "host_update",
		"data" => Array(
		     "host" => $hostInfo,
		     "domain" => $domainName
		),
	     );
	     $response = $this->Request();
	     return $response;
	}
}
