<?php

/*
 * @author  Henning TK1
 */

class TK1_M2eenhancements_Model_Connector_Amazon_Dispatcher extends Ess_M2ePro_Model_Connector_Amazon_Dispatcher
{
    /**
     * @throws Exception
     * @param string $entity
     * @param string $type
     * @param string $name
     * @param array $params
     * @param null|int|Ess_M2ePro_Model_Account $account
     * @param null|string $ormPrefixToConnector
     * @return Ess_M2ePro_Model_Connector_Amazon_Requester|Ess_M2ePro_Model_Connector_Amazon_Abstract
     */
    public function getConnector($entity, $type, $name,
                                 array $params = array(),
                                 $account = NULL,
                                 $ormPrefixToConnector = NULL)
    {
        $className = empty($ormPrefixToConnector) ? 'Ess_M2ePro_Model_Connector_Amazon' : $ormPrefixToConnector;
		// Change TK1 - User getModel to be able to override ItemRequester
		$className = str_replace("Ess_M2ePro_Model_", "", $className);
        $entity = uc_words(trim($entity));
        $type   = uc_words(trim($type));
        $name   = uc_words(trim($name));

        $entity != '' && $className .= '_'.$entity;
        $type   != '' && $className .= '_'.$type;
        $name   != '' && $className .= '_'.$name;
        if (is_int($account) || is_string($account)) {
            $account = Mage::helper('M2ePro/Component_Amazon')->getCachedObject('Account',(int)$account);
        }
	
		// Change TK1 - User getModel to be able to override ItemRequester	    
		// doesnt work, we need to pass two parameters, magento only allows one
		// $object = Mage::getModel('M2ePro/'.$className, array('params' => $params, 'account' => $account));
		// Mage::getModel('core/config')->getModelClassName does also not work, probably the xml in this is not loaded correcttly.
		// so we get a dummy instance by getModel, and use the class name to create the real object with 2 constructor parameters
		$dummyInstance = Mage::getModel('M2ePro/'.$className);
		$className = get_class($dummyInstance);
		$object = new $className($params, $account);
        return $object;
    }
}