<?php include 'database_handling.php';

    function CalculateStat(string & $Pokemon_Name,int $Level,int $EV, int $IV, string & $Stat_Name): int
    {
        $Base = ((((GetStat($Pokemon_Name,$Stat_Name) + $IV) * 2 + (sqrt($EV)/4)) * $Level) / 100 );
        return (int) match ($Stat_Name) {
            "HP" => $Base + $Level + 10,
            default => $Base + 5,
        };
    }

    function CalculateDamage(string & $Attacker_Name, int $Attacker_Level, string & $Used_Move_Name, bool $IsCritical, string $AttTyping, int $AttEv, int $AttIv, string & $Receiver_Name, int $Receiver_Level, string & $DefTyping, int $DefEV, int $DefIV, float $RollCoef): int
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
            $Move_Type = GetMoveType($Used_Move_Name);
            $EffiencyCoef *= GetTypeEfficiencyWithSecondType($Move_Type,$Type["type"])/100;
        }
        if ($IsCritical)
        {
            $CritCoef *= 2;
        }
        $CoeffMult = $STAB * $EffiencyCoef * $RollCoef;
        error_reporting(E_ALL ^ E_DEPRECATED);
        return (int) (((($Attacker_Level*$CritCoef*0.4 + 2)*$AttStat * GetMovePower($Used_Move_Name)) / $TargetDefStat / 50) + 2) * $CoeffMult;
    }
