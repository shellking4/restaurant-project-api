<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Utils\Constants;
use App\Utils\StringResponse;

class CustomerController extends Controller
{
    public function getAllCustomers()
    {
        $customers = Customer::all();
        /*$stringResponse = new StringResponse();
        if (!empty($customers)) {*/
            echo json_encode($customers);
            //return true;
        /*}
        $content = Constants::$ON_EMPTY_RETRIEVAL;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return false;*/
    }

    public function getCustomer(int $id): bool
    {
        $stringResponse = new StringResponse();
        $customer = Customer::all()->find($id);
        if ($customer != null) {
            echo json_encode($customer);
            return true;
        }
        $content = Constants::$ON_NULL_FETCHED;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return false;
    }

    public function addCustomer(Request $request): bool
    {
        $stringResponse = new StringResponse();
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->table_number = $request->input('table_number');
        $customers = Customer::all();
        foreach ($customers as $customerOject) {
            if ($customer->name === $customerOject->name) {
                $content = Constants::$ADD_FAILURE_RESPONSE;
                $stringResponse->content = $content;
                echo json_encode($stringResponse);
                return false;
            }
        }
        $customer->save();
        $content = Constants::$ADD_SUCCESS_RESPONSE;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return true;
    }

    public function deleteCustomer(int $id): bool
    {
        $stringResponse = new StringResponse();
        $food = Customer::all()->find($id);
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
        $customer = Customer::find($id);
        if ($customer != null) {
            $customer->name = $request->input('name');
            $customer->description = $request->input('table_number');
            $customer->save();
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
