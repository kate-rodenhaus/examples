<?php

namespace Test\Dao;

class Member extends Test\Dao
{

	/**
	 * @var $table The table name
	 */
	public static $table = "members";

	/**
	 * @var $_fields The field list for the table `members`
	 */
	protected $_fields = [
		'member_guid',
        'member_id',
        'first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'gender',
        'address_1',
        'address_2',
        'city',
        'state',
        'zip_code',
        'phone',
        'email',
	];

	/**
	 * Create a member given the details
	 *
	 * @param array $values Member demographic details
	 *
	 * @throws Exception If fields aren't in the provided list, throw exception for unexpected input
	 * @return string Member GUID created
	 */
	protected function createMember($values)
	{
		foreach (array_keys($values) as $field) {
			if (!in_array($field, $this->$_fields)) {
				throw new Exception("Field not found {$field}");
			}
		}

		$this->insert(static::$table, $this->$_fields, $values);
	}

	/**
	 * Get a single member by GUID
	 *
	 * @param string $member_guids The member GUID to search for
	 *
	 * @return array Single member details
	 */
	protected function getMemberByGuid($member_guid)
	{
		$this->get(static::$table, ['where' => ['member_guid' => $member_guid]])[0];
	}
}