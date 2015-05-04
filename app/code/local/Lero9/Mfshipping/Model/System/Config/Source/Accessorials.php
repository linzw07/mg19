<?php
class Lero9_Mfshipping_Model_System_Config_Source_Accessorials
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => "AfterHoursDelivery", 'label'=>Mage::helper('adminhtml')->__('After Hours Delivery')),
            array('value' => "AMDelivery", 'label'=>Mage::helper('adminhtml')->__('AM Delivery')),
            array('value' => "AppointmentDelivery", 'label'=>Mage::helper('adminhtml')->__('Appointment Delivery')),
            array('value' => "AppointmentPickup", 'label'=>Mage::helper('adminhtml')->__('Appointment Pickup')),
            array('value' => "BillOfLadingCorrectionFee", 'label'=>Mage::helper('adminhtml')->__('Bill Of Lading Correction Fee')),
            array('value' => "CfsStationFee", 'label'=>Mage::helper('adminhtml')->__('Cfs Station Fee')),
            array('value' => "ConventionHotelDelivery", 'label'=>Mage::helper('adminhtml')->__('Convention Hotel Delivery')),
            array('value' => "ConventionHotelPickup", 'label'=>Mage::helper('adminhtml')->__('Convention Hotel Pickup')),
            array('value' => "CrossBorderFee", 'label'=>Mage::helper('adminhtml')->__('Cross Border Fee')),
            array('value' => "CodFee", 'label'=>Mage::helper('adminhtml')->__('Cod Fee')),
            array('value' => "DebrisRemoval", 'label'=>Mage::helper('adminhtml')->__('Debris Removal')),
            array('value' => "GuaranteedDeliveryStandard", 'label'=>Mage::helper('adminhtml')->__('Guaranteed Delivery Standard')),
            array('value' => "HazardousShipment", 'label'=>Mage::helper('adminhtml')->__('Hazardous Shipment')),
            array('value' => "HolidayDelivery", 'label'=>Mage::helper('adminhtml')->__('Holiday Delivery')),
            array('value' => "InBondFee", 'label'=>Mage::helper('adminhtml')->__('In Bond Fee')),
            array('value' => "InsideDelivery", 'label'=>Mage::helper('adminhtml')->__('Inside  Delivery')),
            array('value' => "InsidePickup", 'label'=>Mage::helper('adminhtml')->__('Inside Pickup')),
            array('value' => "LiftgateDelivery", 'label'=>Mage::helper('adminhtml')->__('Lift gate Delivery')),
            array('value' => "LiftgatePickup", 'label'=>Mage::helper('adminhtml')->__('Lift gate Pickup')),
            array('value' => "LimitedAccessDelivery", 'label'=>Mage::helper('adminhtml')->__('Limited Access Delivery')),
            array('value' => "LimitedAccessPickup", 'label'=>Mage::helper('adminhtml')->__('Limited Access Pickup')),
            array('value' => "MilitaryDelivery", 'label'=>Mage::helper('adminhtml')->__('Military Delivery')),
            array('value' => "MilitaryPickup", 'label'=>Mage::helper('adminhtml')->__('Military Pickup')),
            array('value' => "OverLengthShipment", 'label'=>Mage::helper('adminhtml')->__('Over Length Shipment')),
            array('value' => "Packing", 'label'=>Mage::helper('adminhtml')->__('Packing')),
            array('value' => "PalletJack", 'label'=>Mage::helper('adminhtml')->__('PalletJack')),
            array('value' => "ProtectFromFreeze", 'label'=>Mage::helper('adminhtml')->__('Protect From Freeze')),
            array('value' => "ResidentialDelivery", 'label'=>Mage::helper('adminhtml')->__('Residential Delivery')),
            array('value' => "ResidentialPickup", 'label'=>Mage::helper('adminhtml')->__('Residential Pickup')),
            array('value' => "ResidentialInsideDelivery", 'label'=>Mage::helper('adminhtml')->__('Residential Inside Delivery')),
            array('value' => "ResidentialInsidePickup", 'label'=>Mage::helper('adminhtml')->__('Residential Inside Pickup')),
            array('value' => "SaturdayDelivery", 'label'=>Mage::helper('adminhtml')->__('Saturday Delivery')),
            array('value' => "SchoolDelivery", 'label'=>Mage::helper('adminhtml')->__('School Delivery')),
            array('value' => "SchoolPickup", 'label'=>Mage::helper('adminhtml')->__('School Pickup')),
            array('value' => "SortAndSegregationFee", 'label'=>Mage::helper('adminhtml')->__('Sort And Segregation Fee')),
            array('value' => "SundayDelivery", 'label'=>Mage::helper('adminhtml')->__('Sunday Delivery')),
            array('value' => "TimeSpecificDelivery", 'label'=>Mage::helper('adminhtml')->__('Time Specific Delivery')),
            array('value' => "TimeSpecificPickup", 'label'=>Mage::helper('adminhtml')->__('Time Specific Pickup')),
            array('value' => "TwoManDelivery", 'label'=>Mage::helper('adminhtml')->__('Two Man Delivery')),
            array('value' => "TwoManPickup", 'label'=>Mage::helper('adminhtml')->__('Two Man Pickup')),
            array('value' => "Unpacking", 'label'=>Mage::helper('adminhtml')->__('Unpacking'))
            );
    }

}
