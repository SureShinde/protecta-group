<?php
namespace Digital\CustomAPI\Model;

class SubAccountPermission implements \Digital\CustomAPI\Api\SubAccountPermissionInterface
{	
	/**
      * setsubaccountpermission function
      *
      * @api
      * @param mixed $param
      * @return array
     */
    
    public function setsubaccountpermission($param)
    {				
		$result = array();
		$sub_account_id = '';

		if(isset($param['sub_account_id']))
		{
			$sub_account_id = trim($param['sub_account_id']);
		}
		

		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

		if($sub_account_id > 0)
		{
			$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
			$connection = $resource->getConnection();
			$tableName = $resource->getTableName('cminds_multiuseraccounts_subaccount');
				
			//Update permission and additional_information into table...		
			//$update_sql = "UPDATE `cminds_multiuseraccounts_subaccount` SET `permission` = '8183' WHERE `cminds_multiuseraccounts_subaccount`.`customer_id` = '$sub_account_id'";
			$update_sql = "UPDATE `cminds_multiuseraccounts_subaccount` SET `permission` = '7671' WHERE `cminds_multiuseraccounts_subaccount`.`customer_id` = '$sub_account_id'";
			$connection->query($update_sql);		
			$result['status'] = 'success';
		}
		else
		{
			$result['status'] = 'error';			
		}								
		return $result;	
    }	
}