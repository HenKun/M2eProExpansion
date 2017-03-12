<?php

/*
 * @author Henning TK1
 */

// must be extended, since m2e uses the requester class and just changes request to response at the end. 
// so it looks for an tk1 variant of the responder, we have to offer this
class TK1_M2eenhancements_Model_Connector_Amazon_Orders_Update_ItemsResponser
    extends Ess_M2ePro_Model_Connector_Amazon_Orders_Update_ItemsResponser
{
   
}