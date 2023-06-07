<?php include 'database_handling.php';

    function CalculateStat($Pokemon_Name,$Level,$EV,$IV,$Stat_Name): int
    {
        $Base = ((((GetStat($Pokemon_Name,$Stat_Name) + $IV) * 2 + (sqrt($EV)/4)) * $Level) / 100 );
        return (int) match ($Stat_Name) {
            "HP" => $Base + $Level + 10,
            default => $Base + 5,
        };
    }

    function CalculateDamage($Attacker_Name, $Attacker_Level, $Used_Move_Name, $IsCritical, $AttTyping, $AttEv, $AttIv, $Receiver_Name, $Receiver_Level, $DefTyping, $DefEV, $DefIV, $RollCoef): int
    {
        $AttStat = CalculateStat($Attacker_Name, $Attacker_Level,$AttEv,$AttIv,$AttTyping);
        $TargetDefStat = CalculateStat($Receiver_Name,$Receiver_Level,$DefEV,$DefIV,$DefTyping);
        $Receiver_Types = GetPokemonTypes($Receiver_Name);
        $STAB = 1;
        $EffiencyCoef = 1;
        $CritCoef = 1;
        foreach (GetPokemonTypes($Attacker_Name) as $Type)
        {
            if (GetMoveType($Used_Move_Name) == $Type["type"])
            {
                $STAB = 1.5;
                break;
            }
        }
        foreach ($Receiver_Types as $Type)
        {
            $EffiencyCoef *= GetTypeEfficiencyWithSecondType(GetMoveType($Used_Move_Name),$Type["type"])/100;
        }
        if ($IsCritical)
        {
            $CritCoef *= 2;
        }
        $CoeffMult = $STAB * $EffiencyCoef * $RollCoef;
        echo "CoefMult: " . $CoeffMult . "<br/>";
        echo "Stab: " . $STAB . "<br/>";
        error_reporting(E_ALL ^ E_DEPRECATED);
        return (int) (((($Attacker_Level*$CritCoef*0.4 + 2)*$AttStat * GetMovePower($Used_Move_Name)) / $TargetDefStat / 50) + 2) * $CoeffMult;
    }
