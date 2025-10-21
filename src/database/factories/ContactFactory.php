<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;
use App\Models\Category;
class ContactFactory extends Factory
{
    protected $model = Contact::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category_id = Category::pluck('id')->random();
        return [
         'category_id' => $category_id,
         'first_name' => $this->faker->firstName(),
         'last_name' => $this->faker->lastName(),
         'gender' => $this->faker->numberBetween(1,3),
         'email' => $this->faker->safeEmail(),
         'tel' => $this->faker->regexify('^0[0-9]{10,11}$'),
         'address' => $this->faker->streetAddress(),
         'building' => $this->faker->optional(0.5)->secondaryAddress(),
         'detail' => $this->faker->text(200),
        ];
    }
}
