<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\Author;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

 


class AuthorFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Author $author) {
            $author->profile()->save(Profile::factory()->make());
        });
    }
}
