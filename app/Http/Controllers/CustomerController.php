<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Drink;
use App\Models\Food;
use App\Models\Order;
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
        } else {
            $content = Constants::$ON_EMPTY_RETRIEVAL;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        }
    }

    public function getCustomer(Request $request)
    {
        $stringResponse = new StringResponse();
        $customer = new Customer();
        $customer->email = $request->input('email');
        $customers = Customer::all();
        if (!empty($customers)) {
            foreach ($customers as $customerOject) {
                if ($customer->email == $customerOject->email) {
                    echo json_encode($customerOject);
                    return true;
                }
            }
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
        $customer->email = $request->input('email');
        $password = $request->input('password');
        $hashedPassword = Hash::make($password);
        $customer->password = $hashedPassword;
        $customers = Customer::all();
        if (!empty($customers)) {
            foreach ($customers as $customerOject) {
                if ($customer->email === $customerOject->email) {
                    $content = Constants::$ADD_FAILURE_RESPONSE;
                    $stringResponse->content = $content;
                    echo json_encode($stringResponse);
                    return false;
                }
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
        $customer = Customer::find($id);
        if ($customer != null) {
            $customer->delete();
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
        } else {
            $content = Constants::$UPDATE_FAILURE_RESPONSE;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        }
    }

    public function login(Request $request): bool {
        $stringResponse = new StringResponse();
        $email = $request->input('email');
        $password = $request->input('password');
        $customers = Customer::all();
        if (!empty($customers)) {
            foreach ($customers as $customerOject) {
                if ($email == $customerOject->email && Hash::check($password, $customerOject->password)) {
                    $content = Constants::$ON_LOGIN_SUCCESSFUL;
                    $stringResponse->content = $content;
                    echo json_encode($stringResponse);
                    return true;
                }
            }
        }
        $content = Constants::$ON_LOGIN_UNSUCCESSFUL;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return false;
    }

    public function getCustomerOrders(int $id) {
        $stringResponse = new StringResponse();
        $customer = Customer::find($id);
        if ($customer != null) {
            $orders = $customer->orders;
            if (!empty($orders)) {
                echo json_encode($orders);
            } else {
                $content = Constants::$ON_EMPTY_RETRIEVAL;
                $stringResponse->content = $content;
                echo json_encode($stringResponse);
            }
        } else {
            $content = Constants::$ON_NULL_FETCHED;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        }
    }

    public function getOrders() {
        $orders = Order::all();
        $stringResponse = new StringResponse();
        if (!empty($orders)) {
            echo json_encode($orders);
        } else {
            $content = Constants::$ON_EMPTY_RETRIEVAL;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        }
    }

    public function getCustomerOrder(int $customerId, \DateTime $orderDate) {
        $stringResponse = new StringResponse();
        $customer = Customer::find($customerId);
        if ($customer != null) {
            $orders = $customer->orders;
            if (!empty($orders)) {
                foreach ($orders as $order) {
                    if ($order->orderDate === $orderDate) {
                        echo json_encode($order);
                        return true;
                    }
                }
                $content = Constants::$ON_NULL_FETCHED;
                $stringResponse->content = $content;
                echo json_encode($stringResponse);
                return false;
            } else {
                $content = Constants::$ON_EMPTY_RETRIEVAL;
                $stringResponse->content = $content;
                echo json_encode($stringResponse);
                return false;
            }
        } else {
            $content = Constants::$ON_NULL_FETCHED;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        }
    }

    public function getOrder(\DateTime $orderDate) {
        $orders = Order::all();
        $stringResponse = new StringResponse();
        if (!empty($orders)) {
            foreach ($orders as $order) {
                if ($order->orderDate === $orderDate) {
                    echo json_encode($orders);
                    return true;
                }
            }
            $content = Constants::$ON_NULL_FETCHED;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        } else {
            $content = Constants::$ON_NULL_FETCHED;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        }
    }

    public function addOrder(int $id, Request $request) {
        $stringResponse = new StringResponse();
        $order = new Order();
        $customer = Customer::find($id);
        $order->orderDate = $request->input('orderDate');
        $foodIds = $request->input('foods');
        $drinkIds = $request->input('drinks');
        $orders = $customer->orders;
        foreach ($orders as $orderItem) {
            if ($order->orderDate === $orderItem->orderDate) {
                $content = Constants::$ADD_FAILURE_RESPONSE;
                $stringResponse->content = $content;
                echo json_encode($stringResponse);
                return false;
            }
        }
        if (!empty($foodIds)) {
            foreach ($foodIds as $foodId) {
                $id = (int)$foodId;
                $food = Food::find($id);
                $order->foods[] = $food;
            }
            foreach ($drinkIds as $drinkId) {
                $id = (int)$drinkId;
                $drink = Drink::find($id);
                $order->drinks[] = $drink;
            }
            return true;
        }
        $customer->orders()->save($order);
        $content = Constants::$ADD_SUCCESS_RESPONSE;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return true;
    }
}
