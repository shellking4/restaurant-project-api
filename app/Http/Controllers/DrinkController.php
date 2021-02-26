<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use Illuminate\Http\Request;
use App\Utils\Constants;
use App\Utils\StringResponse;

class DrinkController extends Controller
{

    public function getAllDrinks(): bool
    {
        $stringResponse = new StringResponse();
        $drinks = Drink::all();
        if (!empty($drinks)) {
            echo json_encode($drinks);
            return true;
        }
        $content = Constants::$ON_EMPTY_RETRIEVAL;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return false;
    }

    public function getDrink(int $id): bool
    {
        $stringResponse = new StringResponse();
        $drink = Drink::all()->find($id);
        if ($drink != null) {
            echo json_encode($drink);
            return true;
        }
        $content = Constants::$ON_NULL_FETCHED;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return false;
    }

    public function addDrink(Request $request): bool
    {
        $stringResponse = new StringResponse();
        $drink = new Drink();
        $drink->name = $request->input('name');
        $drink->description = $request->input('description');
        $drink->image = $request->input('image');
        $drink->price = $request->input('price');
        $drinks = Drink::all();
        foreach ($drinks as $drinkItem) {
            if ($drink->name === $drinkItem->name) {
                $content = Constants::$ADD_FAILURE_RESPONSE;
                $stringResponse->content = $content;
                echo json_encode($stringResponse);
                return false;
            }
        }
        $drink->save();
        $content = Constants::$ADD_SUCCESS_RESPONSE;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return true;
    }

    public function deleteDrink(int $id): bool
    {
        $stringResponse = new StringResponse();
        $food = Drink::all()->find($id);
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

    public function updatDrink(int $id, Request $request)
    {
        $stringResponse = new StringResponse();
        $drink = Drink::find($id);
        if ($drink != null) {
            $drink->name = $request->input('name');
            $drink->description = $request->input('description');
            $drink->image = $request->input('image');
            $drink->price = $request->input('price');
            $drink->save();
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
