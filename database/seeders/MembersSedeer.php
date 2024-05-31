<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembersSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mock = [
            [
                "code" => "M001",
                "name" => "Angga",
            ],
            [
                "code" => "M002",
                "name" => "Ferry",
            ],
            [
                "code" => "M003",
                "name" => "Putri",
            ],
        ];

        foreach ($mock as $value) {
            Member::create([
                "code" => $value['code'],
                "name" => $value['name'],
            ]);
        }
    }
}
