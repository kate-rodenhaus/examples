<?php

namespace Test\Dao;

class Team extends Test\Dao
{

	/**
	 * @var $table The table name
	 */
	public static $table = "teams";

	/**
	 * @var $_fields The field list for the table `teams`
	 */
	protected $_fields = [
		'team_id',
        'name'
    ];

	/**
	 * @var $table The table name
	 */
	public static $team_member_table = "team_members";

	/**
	 * @var $_fields The field list for the table `team_members`
	 */
	protected $_team_member_fields = [
		'team_id',
        'member_guid'
    ];

	/**
	 * Create a team given the details
	 *
	 * @param array $values Member demographic details
	 *
	 * @throws Exception If fields aren't in the provided list, throw exception for unexpected input
	 * @return string Member GUID created
	 */
	protected function createTeam($values)
	{
		foreach (array_keys($values) as $field) {
			if (!in_array($field, $this->$_fields)) {
				throw new Exception("Field not found {$field}");
			}
		}

		$this->insert(static::$table, $this->$_fields, $values);
	}

	/**
	 * Get a team by name
	 *
	 * @param string $name The name of the team
	 *
	 * @return array Teams that have the given name
	 */
	protected function getTeamByName($name)
	{
		$this->get(static::$table, ['where' => ['name' => $name]]);
	}

	/**
	 * Put a member on a team
	 *
	 * @param string $team_id     The team ID
	 * @param string $member_guid The member's GUID
	 *
	 * @return int Insert ID
	 */
	protected function putMemberOnTeam($team_id, $member_guid)
	{
		$this->insert(static::$table, $this->$_team_member_fields, ['team_id' => $team_id, 'member_guid' => $member_guid]);
	}

	/**
	 * Get all members from a team
	 *
	 * @param string $team_id The team ID
	 *
	 * @return array List of member's GUIDs
	 */
	protected function getMembersOnTeam($team_id)
	{
		$this->get(static::$team_member_table, ['where' => ['team_id' => $team_id]]);
	}
}