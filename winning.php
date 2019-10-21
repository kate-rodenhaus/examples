<?php
require_once '/var/web/core/vendor/fzaninotto/faker/src/autoload.php';
require_once '/var/web/core/vendor/autoload.php';

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();

$member_dao = new Test\Dao\Member();
$team_dao = new Test\Dao\Team();

$count_members = 0;

while (!is_numeric($count_members) || $count_members == 0) {
    echo "How many members should we make? ";
    $count_members = rtrim(fgets(STDIN));
}

// Create X test members
echo "Creation of members beginning." . PHP_EOL;
for ($i=0; $i < 50; $i++) {
    $main_number = $faker->numberBetween(1000, 5000);
    $even = ($main_number % 2 == 0 ? true : false);
    $member_id = "TEST-" . $main_number . strtoupper($faker->randomLetter());
    $member_team = ($main_number ? "Blue" : "Red");

    // Create the member
    try {
        $member_guid = $member_dao->createMember([
            'member_id'   => $member_id,
            'first_name'  => $faker->firstName(),
            'middle_name' => ($even ? strtoupper($faker->randomLetter()) : ""),
            'last_name'   => $faker->lastName(),
            'birth_date'  => $faker->dateTimeBetween('-100 years')->format('U'),
            'gender'      => ($even ? "male" : "female"),
            'address_1'   => $faker->streetAddress(),
            'address_2'   => "",
            'city'        => $faker->city(),
            'state'       => $faker->stateAbbr(),
            'zip_code'    => substr($faker->postcode(), 0, 5),
            'phone'       => "555" . $faker->numberBetween(1000000,9999999),
            'email'       => $faker->safeEmail()
        ]);
    } catch (\Exception $e) {
        echo "Member Creation Failed for {$member_id}: " . $e->getMessage() . PHP_EOL;
        continue;
    }

    // Find the team, or create it
    try {
        $team_id = $member_team_dao->getTeamByName($member_team);

        if (empty($team_id)) {
            $team_id = $member_team_dao->createTeam([
                'team_name' => $member_team
            ]);
        }
    } catch (\Exception $e) {
        echo "Team Creation/Location Failed for {$team_id}: " $e-getMessage() . PHP_EOL;
        continue;
    }

    // Create the link to the team from the member
    try {
        $member_to_team = $member_team_dao->createMemberInTeam([
            'member_id' => $member_id,
            'team_id'  => $team_id
        ]);
    } catch (\Exception $e) {
        echo "Member-Team Association Failed for {$member_id}-{$team_id}: " . $e->getMessage() . PHP_EOL;
        continue;
    }
}
echo "Creation of members complete" . PHP_EOL;

// Find the winning teams
$winning_team = "";
while (!in_array(strtolower($winning_team), ['red', 'blue'])) {
    echo "Which team should win?  (RED or BLUE) ";
    $winning_team = rtrim(fgets(STDIN));
}

try {
    $winning_team = $team_dao->getMembersOnTeam($winning_team);

    if (empty($winning_team)) {
        throw new Exception("No members on team {$winning_team}");
    } else {
        $random_index = rand(0, count($winning_team));
        $winner = $winning_team[$random_index];
        $winner = $member_dao->getMemberByGuid($winner['member_guid']);
        echo "{$winning_member['first_name']} {$winning_member['last_name']} on {$winning_team} wins!";
    }
} catch (\Exception $e) {
    echo "Getting winning member failed: " . $e->getMessage() . PHP_EOL;
}