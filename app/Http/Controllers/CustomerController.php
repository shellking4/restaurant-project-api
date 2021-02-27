<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Utils\Constants;
use App\Utils\StringResponse;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function getAllCustomers()
    {
        $customers = Customer::all();
        $stringResponse = new StringResponse();
        if (!empty($customers)) {
            echo json_encode($customers);
            return true;
        }
        $content = Constants::$ON_EMPTY_RETRIEVAL;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return false;
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

    public function register(Request $request): bool
    {
        $stringResponse = new StringResponse();
        $customer = new Customer();
        $customer->name = $request->input('email');
        $password = Hash::make($request->input('password'));
        $customer->password = $password;
        $customer->table_number = $request->input('table_number');
        $customers = Customer::all();
        foreach ($customers as $customerOject) {
            if ($customer->email === $customerOject->email) {
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

    public function updateCustomer(int $id, Request $request)
    {
        $stringResponse = new StringResponse();
        $customer = Customer::find($id);
        if ($customer != null) {
            $customer->email = $request->input('email');
            $customer->password = $request->input('password');
            $customer->table_number = $request->input('table_number');
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

    public function login(Request $request): bool {
        $stringResponse = new StringResponse();
        $customer = new Customer();
        $customer->name = $request->input('email');
        $password = Hash::make($request->input('password'));
        $customer->password = $password;
        $customer->table_number = $request->input('table_number');
        $customers = Customer::all();
        foreach ($customers as $customerOject) {
            if ($customer->email === $customerOject->email && $customer->password === $customerOject->password) {
                $content = Constants::$ON_LOGIN_SUCCESSFUL;
                $stringResponse->content = $content;
                echo json_encode($stringResponse);
                return true;
            }
        }
        $content = Constants::$ON_LOGIN_UNSUCCESSFUL;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return true;
    }
}
