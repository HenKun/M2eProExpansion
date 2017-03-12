<?php

/*
 * @author  Henning TK1
 */
 
// Cares for setting the fixed carrier_coder for amazon. If this is not one of the possible values, "Other" is chosen and hence premium shipping does not work
class TK1_M2eenhancements_Model_Connector_Amazon_Orders_Update_ItemsRequester
    extends Ess_M2ePro_Model_Connector_Amazon_Orders_Update_ItemsRequester
{
    protected function getRequestData()
    {
		$array = parent::getRequestData();
	    foreach($array["items"] as $key => $order)
		{
			if (!isset($order['carrier_name']))
				continue;
			
			$carrier = $order['carrier_name'];
			Mage::log("getRequestData carrier before: " . $carrier);
			if (stripos($carrier,"dhl") !== false)
				$array["items"][$key]['carrier_code'] = "DHL";
			elseif (stripos($carrier,"dpd") !== false)
				$array["items"][$key]['carrier_code'] = "DPD";
			elseif (stripos($carrier,"ups") !== false)
				$array["items"][$key]['carrier_code'] = "UPS";
			elseif (stripos($carrier,"fedex") !== false)
				$array["items"][$key]['carrier_code'] = "FedEx";
			elseif (stripos($carrier,"hermes") !== false)
				$array["items"][$key]['carrier_code'] = "Hermes Logistik Gruppe";
			elseif (stripos($carrier,"deutsche post") !== false)
				$array["items"][$key]['carrier_code'] = "Deutsche Post";
				
			// carrier name should only be populated when carrier code is null or "Other"	
			if (isset($array["items"][$key]['carrier_code']))
				unset($array["items"][$key]['carrier_name']);
		}		
		return $array;
    }
}