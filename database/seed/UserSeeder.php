<?php

use Phinx\Seed\AbstractSeed;
use Shared\Model\Domain\User\PasswordHash;
use Shared\Model\Domain\User\Role;
use Shared\Model\Domain\User\Status;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data[] = [
            'role' => Role::ADMINISTRATOR,
            'status' => Status::ACTIVE,
            'firstname' => $faker->firstName,
            'lastname' => $faker->lastName,
            'displayName' => $faker->userName,
            'email' => 'test@test.fr',
            'password' => PasswordHash::fromRawPassword('12345678'),
            'creationDate' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            'lastUpdateDate' => null,
        ];

        for ($i = 0; $i < 3; $i++) {
            $data[] = [
                'role' => Role::USER,
                'status' => Status::ACTIVE,
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'displayName' => $faker->userName,
                'email' => $faker->email,
                'password' => PasswordHash::fromRawPassword('12345678'),
                'creationDate' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
                'lastUpdateDate' => null,
            ];
        }

        $this->insert('User', $data);
    }
}
