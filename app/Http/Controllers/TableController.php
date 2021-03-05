<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Constants;
use App\Utils\StringResponse;
use App\Models\Table;

class TableController extends Controller
{
    public function getAllTables()
    {
        $stringResponse = new StringResponse();
        $tables = Table::all();
        if (!empty($tables)) {
            echo json_encode($tables);
        } else {
            $content = Constants::$ON_EMPTY_RETRIEVAL;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        }
    }

    public function getTable(int $id)
    {
        $stringResponse = new StringResponse();
        $table = Table::all()->find($id);
        if ($table != null) {
            echo json_encode($table);
        } else {
            $content = Constants::$ON_NULL_FETCHED;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        }
    }

    public function addTable(Request $request): bool
    {
        $stringResponse = new StringResponse();
        $table = new Table();
        $table->table_number = $request->input('table_number');
        $table->isTaken = $request->input('isTaken');
        $tables = Table::all();
        foreach ($tables as $tableItem) {
            if ($table->table_number === $tableItem->table_number) {
                $content = Constants::$ADD_FAILURE_RESPONSE;
                $stringResponse->content = $content;
                echo json_encode($stringResponse);
                return false;
            }
        }
        $table->save();
        $content = Constants::$ADD_SUCCESS_RESPONSE;
        $stringResponse->content = $content;
        echo json_encode($stringResponse);
        return true;
    }

    public function deleteTable(int $id)
    {
        $stringResponse = new StringResponse();
        $table = Table::all()->find($id);
        if ($table != null) {
            $table->delete();
            $content = Constants::$DELETE_SUCCESS_RESPONSE;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        } else {
            $content = Constants::$DELETE_FAILURE_RESPONSE;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        }
    }

    public function updateTable(int $id, Request $request)
    {
        $stringResponse = new StringResponse();
        $table = Table::find($id);
        if ($table != null) {
            $table->table_number = $request->input('table_number');
            $table->isTaken = $request->input('isTaken');
            $table->save();
            $content = Constants::$UPDATE_SUCCESS_RESPONSE;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        } else {
            $content = Constants::$UPDATE_FAILURE_RESPONSE;
            $stringResponse->content = $content;
            echo json_encode($stringResponse);
        }
    }

}
