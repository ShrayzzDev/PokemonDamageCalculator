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
        $result = pg_query($con, $query) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_all($result);
    }

    function GetStat(string & $Pokemon_Name, string $Stat_Name)
    {
        $con = ConnectToDatabase();
        $query = match ($Stat_Name) {
            "HP" => "SELECT HP FROM Pokemon WHERE Name = $1",
            "Attack" => "SELECT Attack FROM Pokemon WHERE Name = $1",
            "Defense" => "SELECT Defense FROM Pokemon WHERE Name = $1",
            "Special" => "SELECT Special FROM Pokemon WHERE Name = $1",
            "Speed" => "SELECT Speed FROM Pokemon WHERE Name = $1",
            default => "",
        };
        $result = pg_query_params($con, $query, array($Pokemon_Name)) or die('échec de la requête: ' . pg_last_error());
        return pg_fetch_result($result, 0, 0);
    }

    function GetPokemonTypes(string & $Pokemon_Name)
    {
        $con = ConnectToDatabase();
        $query = "SELECT pt.Type type FROM Pokemon po, PokemonType pt WHERE pt.Pokemon = po.ID AND po.Name = $1";
        $result = pg_query_params($con, $query, array($Pokemon_Name)) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_all($result);
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
        return pg_fetch_all($result);
    }

    function GetMoveType(string & $Move_Name)
    {
        $con = ConnectToDatabase();
        $query = "SELECT Type FROM Move WHERE Name = $1";
        $result = pg_query_params($con, $query, array($Move_Name)) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_result($result,0,0);
    }

    // NOTE : Should handle typing with enums
    function GetTypeTyping(string & $Type_Name)
    {
        $con = ConnectToDatabase();
        $query = "SELECT Typing FROM Type WHERE Name = $1";
        $result = pg_query_params($con, $query, array($Type_Name)) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_result($result,0,0);
    }

    function GetMoveTyping(string & $Move_Name): false|string|null
    {
        $Move_Type = GetMoveType($Move_Name);
        return GetTypeTyping($Move_Type);
    }

    function GetTypeEfficiency(string & $Type_Name, string & $Efficiency)
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

    function GetMovePower(string & $Move_Name)
    {
        $con = ConnectToDatabase();
        $query = "SELECT Power FROM Move WHERE Name = $1";
        $result = pg_query_params($con, $query, array($Move_Name)) or die('échec de la requête:' . pg_last_error());
        return pg_fetch_result($result, 0, 0);
    }

    function GetTypeEfficiencyWithSecondType(string & $TypeAtt, string & $TypeReceiver)
    {
        $con = ConnectToDatabase();
        $query = "SELECT damage_factor FROM TypeEfficiency WHERE damaging_type = $1 AND targeted_type = $2";
        $result = pg_query_params($con, $query, array($TypeAtt,$TypeReceiver));
        return pg_fetch_result($result, 0, 0);
    }

    function GetAllMoveName()
    {
        $con = ConnectToDatabase();
        $query = "SELECT Name FROM Move";
        $result = pg_query($con, $query)  or die('échec de la requête:' . pg_last_error());
        return pg_fetch_all($result);
    }
