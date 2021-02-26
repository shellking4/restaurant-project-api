<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Utils\Constants;
use Illuminate\Http\Request;
use App\Utils\StringResponse;

class FoodController extends Controller
{
    /*public function getAllFoods(): bool
    {
        $stringResponse = new StringResponse();
        $foods = Food::all();
        if (!empty($foods)) {
            echo json_encode($foods);
            return true;
        }
        $content = Constants::$ON_EMPTY_RETRIEVAL;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return false;
    }*/

    public function getAllFoods() {
        $foods = Food::all();
        echo json_encode($foods);
    }

    public function getFood(int $id): bool
    {
        $stringResponse = new StringResponse();
        $food = Food::all()->find($id);
        if ($food != null) {
            echo json_encode($food);
            return true;
        }
        $content = Constants::$ON_NULL_FETCHED;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return false;
    }

    public function addFood(Request $request): bool {
        $stringResponse = new StringResponse();
        $food = new Food();
        $food->name = $request->input('name');
        $food->description = $request->input('description');
        $food->image = $request->input('image');
        $food->price = $request->input('price');
        $foods = Food::all();
        foreach ($foods as $foodItem) {
            if ($food->name === $foodItem->name) {
                $content = Constants::$ADD_FAILURE_RESPONSE;
                $stringResponse->content = $content;
                echo json_encode($stringResponse);
                return false;
            }
        }
        $food->save();
        $content = Constants::$ADD_SUCCESS_RESPONSE;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return true;
    }

    public function deleteFood(int $id): bool {
        $stringResponse = new StringResponse();
        $food = Food::all()->find($id);
        if ($food != null) {
            $food->delete();
            $content = Constants::$DELETE_SUCCESS_RESPONSE;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
            return true;
        }
        $content = Constants::$DELETE_FAILURE_RESPONSE;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return false;
    }

    public function updateFood(int $id, Request $request): bool {
        $stringResponse = new StringResponse();
        $food = Food::find($id);
        if ($food != null) {
            $food->name = $request->input('name');
            $food->description = $request->input('description');
            $food->image = $request->input('image');
            $food->price = $request->input('price');
            $food->save();
            $content = Constants::$UPDATE_SUCCESS_RESPONSE;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
            return true;
        }
        $content = Constants::$UPDATE_FAILURE_RESPONSE;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return false;
    }

}
