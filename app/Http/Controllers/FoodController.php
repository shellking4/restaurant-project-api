<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use App\Utils\StringResponse;

class FoodController extends Controller
{
    public function getAllFoods() {
        echo json_encode(Food::all());
    }

    public function getFood(int $id) {
        echo json_encode(Food::all()->find($id));
    }

    public function addFood(Request $request) {
        $stringResponse = new StringResponse();
        $food = new Food();
        $food->name = $request->input('name');
        $food->description = $request->input('description');
        $food->image = $request->input('image');
        $food->price = $request->input('price');
        $foods = Food::all();
        foreach ($foods as $foodItem) {
            if ($food === $foodItem) {
                $content = "CANNOT ADD ! OBJECT ALREADY EXISTS !";
                $stringResponse->content = $content;
                echo json_encode($stringResponse);
                break;
            } else {
                $food->save();
                $content = "DONE ADDING ELEMENT !";
                $stringResponse->content = $content;
                echo json_encode($stringResponse);
            }
        }
        $content = "FATAL UNEXPETED ERROR !";
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
    }

    public function deleteFood(int $id) {
        $stringResponse = new StringResponse();
        $food = Food::all()->find($id);
        if ($food != null) {
            $food->delete();
            $content = "FOOD OBJECT SUCCESSFULLY DELETED";
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        } else {
            $content = "FOOD OBJECT NOT FOUND !";
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        }
    }

    public function updateFood(int $id, string $name="", string $description="", float $price=0) {
        $food = Food::find($id);
        if ($name == "") {
            $food->name = $food->name;
        } else {
            $food->name = $name;
        }
        if ($description == "") {
            $food->description = $food->description;
        } else {
            $food->description = $description;
        }
        if ($price == 0) {
            $food->price = $food->price;
        } else {
            $food->price = $price;
        }
        $food->save();
        echo json_encode("{ELEMENT SUCCESSFULLY UPDATED}");
    }

}
