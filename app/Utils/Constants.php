<?php

namespace App\Utils;

class Constants
{
    public static string $ADD_SUCCESS_RESPONSE = "DONE ADDING OBJECT !";
    public static string $ADD_FAILURE_RESPONSE = "CANNOT ADD ! OBJECT ALREADY EXISTS !";
    public static string $DELETE_SUCCESS_RESPONSE = "OBJECT SUCCESSFULLY DELETED";
    public static string $DELETE_FAILURE_RESPONSE = "OBJECT YOU WANNA DELETE DOESN'T EXIST";
    public static string $UPDATE_SUCCESS_RESPONSE = "OBJECT SUCCESSFULLY UPDATED";
    public static string $UPDATE_FAILURE_RESPONSE = "FATAL ERROR, IT SEEMS THE OJECT YOU WANT TO UPDATE DOESN'T EXIST !";
    public static string $ON_EMPTY_RETRIEVAL = "NO OBJECTS FOUND, RETRIEVED EMPTY LIST";
    public static string $ON_NULL_FETCHED = "OBJECT NOT FOUND";
    public static String $ON_LOGIN_SUCCESSFUL = "SUCCESSFULLY LOGGED IN";
    public static String $ON_LOGIN_UNSUCCESSFUL = "NOT LOGGED IN";
}
