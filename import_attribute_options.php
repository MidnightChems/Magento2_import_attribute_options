<?php
/**
 * ***********************************************
 * Description:
 * -----------------------------------------------
 * This code snippet takes a magento attribute code ($attributeCode) and
 * attempts to create new attribute values in a loop ($newOptions)
 * 
 * Author: Guy Orazem
 * Date: April 2023
 * 
 * Additional Comments:
 * - Useful for attribute types like dropdown where the value must be present for the import to work
 * - The script has error handling for if the value exists already 
 * - The script has error handling for if the code supplied in the $attributeCode value is not valid
 * - Should add area for user input instead of editing and running script 
 * - Should be placed in root/scripts if not you'll need to move location of bootstrap.php dependeancy to be correct
 * ***********************************************
 */


use Magento\Framework\App\Bootstrap;
use Magento\Eav\Model\Config;
use Magento\Catalog\Model\ResourceModel\Eav\AttributeFactory;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

//attributeCode is the attribute code from Magento that you want to add options to
//newOptions are the attribute values you are adding

$attributeCode = 'color_test'; // Replace with the correct attribute code
$newOptions = ['dark-blue', 'light-blue', 'navy-blue', 'Red'];

// Retrieve the attribute model
$eavConfig = $objectManager->get(Config::class);
$attribute = $eavConfig->getAttribute('catalog_product', $attributeCode);

//error check if attributeCode is valid
if (!$attribute || !$attribute->getId()) {
    echo "Attribute with code '$attributeCode' does not exist.\n";
    exit;
}

// Add new options
//error check if the option already exists
$options = [];
foreach ($newOptions as $optionLabel) {
    $existingOption = $attribute->getSource()->getOptionId($optionLabel);
    if ($existingOption) {
        echo "Option '$optionLabel' already exists for attribute '$attributeCode'. Skipping...\n";
        continue;
    }

    $options['value'][$optionLabel][0] = $optionLabel;
}

if (!empty($options)) {
    $attribute->setData('option', $options)->save();
    echo "Attribute options have been imported successfully.\n";
} else {
    echo "No new attribute options to import.\n";
}
