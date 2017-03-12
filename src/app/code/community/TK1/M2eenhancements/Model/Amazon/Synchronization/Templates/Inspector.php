<?php

 /*
 * Change behavior when revising 'cause of qty change:
 * allow revise when store qty is daviation larger then marketplace qty, e.g. when stock is largely raised in store
 */

class TK1_M2eenhancements_Model_Amazon_Synchronization_Templates_Inspector
    extends Ess_M2ePro_Model_Amazon_Synchronization_Templates_Inspector
{
    

    /**
     * @param Ess_M2ePro_Model_Listing_Product $listingProduct
     * @return bool
     * @throws Ess_M2ePro_Model_Exception_Logic
     */
    public function isMeetReviseQtyRequirements(Ess_M2ePro_Model_Listing_Product $listingProduct)
    {

        if (!$this->isMeetReviseGeneralRequirements($listingProduct)) {
            return false;
        }

        /** @var Ess_M2ePro_Model_Amazon_Listing_Product $amazonListingProduct */
        $amazonListingProduct = $listingProduct->getChildObject();

        $amazonSynchronizationTemplate = $amazonListingProduct->getAmazonSynchronizationTemplate();

        if (!$amazonSynchronizationTemplate->isReviseWhenChangeQty() || $amazonListingProduct->isAfnChannel()) {
            return false;
        }

        $isMaxAppliedValueModeOn = $amazonSynchronizationTemplate->isReviseUpdateQtyMaxAppliedValueModeOn();
        $maxAppliedValue = $amazonSynchronizationTemplate->getReviseUpdateQtyMaxAppliedValue();

        $productQty = $amazonListingProduct->getQty();
        $channelQty = $amazonListingProduct->getOnlineQty();
		// added by TK1 - calculate the ratio
		$ratio = $productQty / (float)$channelQty;

		// changed by TK1 - if ratio is greater than 1.5, qty on channel should be updated (this is implicite knowledge for an stock update in store)
		// amazon likes larger stock, so this should be updated if stock is raised in store
        if ($isMaxAppliedValueModeOn && $productQty > $maxAppliedValue && $channelQty > $maxAppliedValue && $ratio < 1.5) {
            return false;
        }

        if ($productQty > 0 && $productQty != $channelQty) {
            return true;
        }

        return false;
    }


    //########################################
}