<?php

    function ConnectToDatabase()
    {
        $connect_db = pg_connect("host=localhost dbname=dbpokemon user=pokemon_data_check password=123456")
        or die ('Impossible de se connecter :' . pg_last_error());
        return $connect_db;
    }

    function GetAllPokemonName()
    {
        $con = ConnectToDatabase();
        $query = "SELECT Name FROM Pokemon";
        $result = pg_query_params($con, $query, array()) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_all($result);
    }

    function GetStat($Pokemon_Name,$Stat_Name)
    {
        $con = ConnectToDatabase();
        switch ($Stat_Name) {
            case "HP":
                $query = "SELECT HP FROM Pokemon WHERE Name = $1";
                break;

            case "Attack":
                $query = "SELECT Attack FROM Pokemon WHERE Name = $1";
                break;

            case "Defense":
                $query = "SELECT Defense FROM Pokemon WHERE Name = $1";
                break;

            case "Special":
                $query = "SELECT Special FROM Pokemon WHERE Name = $1";
                break;

            case "Speed":
                $query = "SELECT Speed FROM Pokemon WHERE Name = $1";
                break;

            default:
                $query = "";
                break;
            }
        $result = pg_query_params($con, $query, array($Pokemon_Name)) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_result($result, 0, 0);
    }

    function GetPokemonTypes($Pokemon_Name)
    {
        $con = ConnectToDatabase();
        $query = "SELECT py.Type FROM Pokemon po, PokemonType pt WHERE po.Pokemon = po.ID AND po.Name = $2";
        $result = pg_query_params($con, $query, array($Pokemon_Name)) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_array($result);
    }

    function GetPokemonMovePool($Pokemon_Name,$Pokemon_Level)
    {
        $con = ConnectToDatabase();
        $query = "SELECT mo.Name 
                  FROM Move mo, PokemonMove pm, Pokemon po
                  WHERE mo.id = pm.move
                    AND pm.pokemon = po.id
                    AND po.Name = $1
                    AND pm.Learning_Level <= $2";
        $result = pg_query_params($con, $query, array($Pokemon_Name,$Pokemon_Level)) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_array($result);
    }

    function GetMoveType($Move_Name)
    {
        $con = ConnectToDatabase();
        $query = "SELECT Type FROM Move WHERE Name = $1";
        $result = pg_query_params($con, $query, array($Move_Name)) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_result($result, 0, 0);
    }

    function GetTypeTyping($Type_Name)
    {
        $con = ConnectToDatabase();
        $query = "SELECT Typing FROM Type WHERE Name = $1";
        $result = pg_query_params($con, $query, array($Type_Name)) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_result($result, 0 ,0);
    }

    function GetMoveTyping($Move_Name): false|string|null
    {
        return GetTypeTyping(GetMoveType($Move_Name));
    }

    function GetTypeEfficiency($Type_Name,$Efficiency)
    {
        $con = ConnectToDatabase();
        switch ($Efficiency)
        {
            case "Weak":
                $query = "SELECT damaging_type FROM TypeEfficiency WHERE targeted_type = $1 AND damage_factor = 200";
                break;

            case "Basic":
                $query = "SELECT damaging_type FROM TypeEfficiency WHERE targeted_type = $1 AND damage_factor = 100";
                break;

            case "Resistant":
                $query = "SELECT damaging_type FROM TypeEfficiency WHERE targeted_type = $1 AND damage_factor = 50";
                break;

            case "Ineffective":
                $query = "SELECT damaging_type FROM TypeEfficiency WHERE targeted_type = $1 AND damage_factor = 0";
                break;

            default:
                $query = "";
                break;

        }
        $result = pg_query_params($con, $query, array($Type_Name)) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_array($result);
    }

    function GetMovePower($Move_Name)
    {
        $con = ConnectToDatabase();
        $query = "SELECT Power FROM Move WHERE Name = $1";
        $result = pg_query_params($con, $query, array($Move_Name)) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_result($result, 0, 0);
    }

    function GetTypeEfficiencyWithSecondType($TypeAtt, $TypeReceiver)
    {
        $con = ConnectToDatabase();
        $query = "SELECT damage_factor FROM TypeEfficiency WHERE damaging_type = $1 AND targeted_type = $2";
        $result = pg_query_params($con, $query, array($TypeAtt,$TypeReceiver));
        return pg_fetch_result($result, 0, 0);
    }