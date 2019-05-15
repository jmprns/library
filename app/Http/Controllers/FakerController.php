<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Faker\Factory as Faker;

use App\Book;

class FakerController extends Controller
{
    public function fake()
    {
    	// $faker = Faker::create();

  //   	for ($i = 0; $i < 200; $i++) {
  // 			Book::create([
  // 				'name' => $faker->company,
  // 				'author' => $faker->name,
  // 				'isbn' => $faker->isbn10,
  // 				'cat_id' => 1,
  // 				'sub_id' => 1,
  // 				'stocks' => $faker->numberBetween(1, 12),
  // 				'img' => $faker->imageUrl(125, 200, 'abstract')
  // 			]);
		// }

       // echo url()->current();

      $date = '2019-12-14';

      $real = explode('-', $date);

      $real2 = $real[2]."-".$real[1]."-".$real[0];

      // print_r($real2);


      echo strtotime($real2);

    	
    }
}
