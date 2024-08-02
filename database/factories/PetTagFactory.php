<?php
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pet;
use App\Models\Tag;
class PetTagFactory extends Factory
{
    protected $model = Pet::class;

    public function definition()
    {
        return [
            'pet_id' => Pet::all()->random()->id,
            'tag_id' => Tag::all()->random()->id,
        ];
    }
}
