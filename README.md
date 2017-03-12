# M2eProExpansion
Some fixes and enhancements we needed for our projects or considered valuable

1) Transmitting Carrier Code
When using "2-Tages-Premium-Versand" on amazon.de (may be available in other countries too) Amazon requires the seller to use a certain carrier (DHL, DPD, UPS, Hermes).
The carrier is only valid when an allowed value is transmitted via the carrier_code field. M2e by default leaves the carrier_code field empty which will be mapped to "Others" and just fills the carrier_name and shipping_name field.
Amazon won't accept this and rejects the "2-Tages-Premium-Versand" option for the seller. With this extension, the carrier_code is filled correctly with allowed values, the carrier_name field is cleared. 
This extension makes a stripos for "dhl", "dpd", "hermes", "ups", "fedex", "deutsche post" and maps it to the correct allowed values. This way Amazon accepts our shipping details now.

2) Amazon likes large stock
As recommended by M2e we just change stock on amazon, when it's below a certain limit. This saves resources. When we fill our stock in Magento again, however, this is not reflected on Amazon and hence we miss the opportunity to tell magento out stock has increased.
Example: Amazon stock change limit is set to 8. Stock on Amazon is 30. Magento stock is 28. We get a delivery of 1000 new products. Magento stock now is 1020, but Amazon still has 30 products until it reached the limit of 8.
We change this behavior by updating Amazon stock when Magento Stock / Amazon Stock > 1.5 (the ratio is hardcoded at the momemt)
This allows us to automatically update Amazon stock when we get a new delivery while keeping the recommended behavior by M2e to not update Amazon stock on every purchase in the Magento store.

