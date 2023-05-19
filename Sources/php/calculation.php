<?php include 'database_handling.php';

    function CalculateStat($Pokemon_Name,$Level,$EV,$IV,$Stat_Name): int
    {
        $Base = ((((GetStat($Pokemon_Name,$Stat_Name) + $IV) * 2 + (sqrt($EV)/4)) * $Level) / 100 );
        switch($Stat_Name)
        {
            case "HP":
                $Stat_Value = $Base + $Level + 10;
                break;

            default:
                $Stat_Value = $Base + 5;
        }
        return $Stat_Value;
    }

    function CalculateDamage($Attacker_Name, $Attacker_Level, $Used_Move_Name, $IsCritical, $AttEv, $AttIv, $Receiver_Name, $Receiver_Level, $DefEV, $DefIV, $RollCoef): float
    {
        $Receiver_Types = GetPokemonTypes($Receiver_Name);
        $STAB = 1;
        $EffiencyCoef = 1;
        $CritCoef = 1;
        foreach (GetPokemonTypes($Attacker_Name) as $Type)
        {
            if (GetMoveType($Used_Move_Name) == $Type)
            {
                $STAB = 1.5;
                break;
            }
        }
        foreach (GetPokemonTypes($Receiver_Name) as $Type)
        {
            $EffiencyCoef *= GetTypeEfficiencyWithSecondType(GetMoveType($Used_Move_Name),$Type);
        }
        if ($IsCritical)
        {
            $CritCoef *= 2;
        }
        $CoeffMult = $STAB * $EffiencyCoef * $RollCoef;
        return (((($Attacker_Level*$CritCoef*0.4 + 2)*CalculateStat($Attacker_Name,$Attacker_Level,$AttEv,$AttIv,"Attack") * GetMovePower($Used_Move_Name)
            / CalculateStat($Receiver_Name,$Receiver_Level,$DefEV,$DefIV,"Defense")) / 50) + 2) * $CoeffMult;
    }
