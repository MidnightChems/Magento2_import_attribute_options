# Magento2_import_attribute_options

 * This code snippet takes a magento attribute code ($attributeCode) and attempts to create new attribute values in a loop ($newOptions)
 
 * Author: Guy Orazem
 * Date: April 2023
 
 Additional Comments:
 - Useful for attribute types like dropdown where the value must be present for the import to work
 - The script has error handling for if the value exists already 
 - The script has error handling for if the code supplied in the $attributeCode value is not valid
 - Should add area for user input instead of editing and running script 
 - Should be placed in root/scripts if not you'll need to move location of bootstrap.php dependeancy to be correct
