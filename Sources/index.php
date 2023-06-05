<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css"/>
    <title>Damage Calculator</title>
</head>
<body>
<?php include 'php/calculation.php';
$First_Option = "Select";
$Liste_Pokemon = GetAllPokemonName();
$Pokemon_Movepool = GetAllMoveName();?>
<header>
    <select>
        <option>Génération 1</option>
    </select>
</header>
<div class="first-block">
    <section class="main-block">
        <form method="POST" action="">
            <article class="first-pokemon">
                <div>
                    <p>Choisissez le pokémon qui attaque</p>
                    <select name="damaging">
                        <?php
                        echo "<option value='' disabled selected>$First_Option</option>";
                        for ($i = 0; $i < count($Liste_Pokemon); ++$i)
                        {
                            echo '<option value=' . $Liste_Pokemon[$i]["name"] . '>' . $Liste_Pokemon[$i]["name"] . "</option>";
                        }
                        ?>
                    </select>
                    <div>
                        <section>
                            <label> HP : </label>
                            <?php
                            if (ISSET($_POST["damaging"]))
                            {
                                echo GetStat($_POST["damaging"],"HP");
                            }
                            ?>
                            <label for="IV_HP_OFF" class="EV"> IV :</label>
                            <input name="IV_HP_OFF" type="number" id="IV_HP_OFF" class="EV_Input" min="0" max="252" value=0>
                            <label for="EV_HP_OFF" class="EV"> EV :</label>
                            <input name="EV_HP_OFF" type="number" id="EV_HP_OFF" class="EV_Input" min="0" max="252" value=0>
                        </section>
                        <section>
                            <label> Attack : </label>
                            <?php

                            ?>
                            <label for="IV_Att_OFF" class="EV"> IV :</label>
                            <input name="IV_Att_OFF" type="number" id="IV_Att_OFF" class="EV_Input" min="0" max="252" value=0>
                            <label for="EV_Att_OFF" class="EV"> EV :</label>
                            <input name="EV_Att_OFF" type="number" id="EV_Att_OFF" class="EV_Input" min="0" max="252" value=0>
                        </section>
                        <section>
                            <label> Defense : </label>
                            <?php
                            if (ISSET($_POST["damaging"]))
                            {
                                $HP_Damaging = GetStat($_POST["damaging"],"Defense");
                                echo $HP_Damaging;
                            }
                            ?>
                            <label for="IV_Def_OFF" class="EV"> IV :</label>
                            <input name="IV_Def_OFF" type="number" id="IV_Def_OFF" class="EV_Input" min="0" max="252" value=0>
                            <label for="EV_Def_OFF" class="EV"> EV :</label>
                            <input name="EV_Def_OFF" type="number" id="EV_Def_OFF" class="EV_Input" min="0" max="252" value=0>
                        </section>
                        <section>
                            <label> Special : </label>
                            <?php
                            if (ISSET($_POST["damaging"]))
                            {
                                echo GetStat($_POST["damaging"],"Special");
                            }
                            ?>
                            <label for="IV_Spec_OFF" class="EV"> IV :</label>
                            <input name="IV_Spec_OFF" type="number" id="IV_Spec_OFF" class="EV_Input" min="0" max="252" value=0>
                            <label for="EV_Spec_OFF" class="EV"> EV :</label>
                            <input name="EV_Spec_OFF" type="number" id="EV_Spec_OFF" class="EV_Input" min="0" max="252" value=0>
                        </section>
                        <section>
                            <label> Speed : </label>
                            <?php
                            if (ISSET($_POST["damaging"]))
                            {
                                echo GetStat($_POST["damaging"],"Speed");
                            }
                            ?>
                            <label for="IV_Spe_OFF" class="EV"> IV :</label>
                            <input name="IV_Spe_OFF" type="number" id="IV_Spe_OFF" class="EV_Input" min="0" max="252" value=0>
                            <label for="EV_Spe_OFF" class="EV"> EV :</label>
                            <input name="EV_Spe_OFF" type="number" id="EV_Spe_OFF" class="EV_Input" min="0" max="252" value=0>
                        </section>
                        <section>
                            <br/>
                            <label for="niv">Niveau: </label>
                            <input type ="number" id="niv" name="Level_Attacker" min="1" max="100" value=1>
                            <br/>
                            <br/>
                            <label> Attaque à utiliser : </label>
                            <select name="move">
                                <?php
                                for ($k = 0; $k < count($Pokemon_Movepool); ++$k)
                                {
                                    echo '<option value=' . $Pokemon_Movepool[$k]["name"] . '>' . $Pokemon_Movepool[$k]["name"] . "</option>";
                                }
                                ?>
                            </select>
                        </section>
                    </div>
                </div>
            </article>
            <article class="second-pokemon">
                <div>
                    <p>Choisissez le pokémon qui subit</p>
                    <select name="target">
                        <?php
                        echo "<option value='' disabled selected>$First_Option</option>";
                        for ($j = 0; $j < count($Liste_Pokemon); ++$j)
                        {
                            echo '<option value=' . $Liste_Pokemon[$j]["name"] . '>' . $Liste_Pokemon[$j]["name"] . "</option>";
                        }
                        ?>
                    </select>
                    <div>
                        <section>
                            <label> HP : </label>
                            <?php
                            if (ISSET($_POST["target"]))
                            {
                                echo GetStat($_POST["target"],"HP");
                            }
                            ?>
                            <label for="IV_HP_SUB" class="EV"> IV :</label>
                            <input name="IV_HP_SUB" type="number" id="IV_HP_SUB" class="EV_Input" min="0" max="252" value=0>
                            <label for="EV_HP_SUB" class="EV"> EV :</label>
                            <input name="EV_HP_SUB" type="number" id="EV_HP_SUB" class="EV_Input" min="0" max="252" value=0>
                        </section>
                        <section>
                            <label> Attack : </label>
                            <?php
                            if (ISSET($_POST["target"]))
                            {
                                echo GetStat($_POST["target"],"Attack");
                            }
                            ?>
                            <label for="IV_Att_SUB" class="EV"> IV :</label>
                            <input name="IV_Att_SUB" type="number" id="IV_Att_SUB" class="EV_Input" min="0" max="252" value=0>
                            <label for="EV_Att_OFF" class="EV"> EV :</label>
                            <input name="EV_Att_SUB" type="number" id="EV_Att_SUB" class="EV_Input" min="0" max="252" value=0>
                        </section>
                        <section>
                            <label> Defense : </label>
                            <?php
                            if (ISSET($_POST["target"]))
                            {
                                echo GetStat($_POST["target"],"Defense");
                            }
                            ?>
                            <label for="IV_Def_SUB" class="IV"> EV :</label>
                            <input name="IV_Def_SUB" type="number" id="IV_Def_SUB" class="EV_Input" min="0" max="252" value=0>
                            <label for="EV_Def_SUB" class="EV"> EV :</label>
                            <input name="EV_Def_SUB" type="number" id="EV_Def_SUB" class="EV_Input" min="0" max="252" value=0>
                        </section>
                        <section>
                            <label> Special : </label>
                            <?php
                            if (ISSET($_POST["target"]))
                            {
                                echo GetStat($_POST["target"],"Special");
                            }
                            ?>
                            <label for="IV_Spec_SUB" class="EV"> IV :</label>
                            <input name="IV_Spec_SUB" type="number" id="IV_Spec_SUB" class="EV_Input" min="0" max="252" value=0>
                            <label for="EV_Spec_SUB" class="EV"> EV :</label>
                            <input name="EV_Spec_SUB" type="number" id="EV_Spec_SUB" class="EV_Input" min="0" max="252" value=0>
                        </section>
                        <section>
                            <label> Speed : </label>
                            <?php
                            if (ISSET($_POST["target"]))
                            {
                                echo GetStat($_POST["target"],"Speed");
                            }
                            ?>
                            <label for="IV_Spe_SUB" class="EV"> IV :</label>
                            <input name="IV_Spe_SUB" type="number" id="IV_Spe_SUB" class="EV_Input" min="0" max="252" value=0>
                            <label for="EV_Spe_SUB" class="EV"> EV :</label>
                            <input name="EV_Spe_SUB" type="number" id="EV_Spe_SUB" class="EV_Input" min="0" max="252" value=0>
                        </section>
                    </div>
                    <section>
                        <br/>
                        <label for="NivTarget">Niveau: </label>
                        <input type ="number"  name="NivTarget" id="NivTarget" min="1" max="100" value=1>
                        <br/>
                        <input type="submit">
                        <label> Dégats de l'attaque: </label>
                        <?php
                        if (ISSET($_POST["damaging"]) && ISSET($_POST["target"]))
                        {
                            $Move_Typing = GetMoveTyping($_POST["move"]);
                            if ($Move_Typing == "Spe")
                            {
                                $MoveAttStat = "Special";
                                $MoveDefStat = "Special";
                                $AttIv = $_POST["IV_Spec_OFF"];
                                $AttEv = $_POST["EV_Spec_OFF"];
                                $DefIv = $_POST["IV_Spec_SUB"];
                                $DefEv = $_POST["EV_Spec_SUB"];
                            }
                            elseif ($Move_Typing == "Phy")
                            {
                                $MoveAttStat = "Attack";
                                $MoveDefStat = "Defense";
                                $AttIv = $_POST["IV_Att_OFF"];
                                $AttEv = $_POST["EV_Att_OFF"];
                                $DefIv = $_POST["IV_Def_SUB"];
                                $DefEv = $_POST["EV_Def_SUB"];
                            }
                            else
                            {
                                $MoveAttStat = 0;
                            }
                            echo "Min: " . CalculateDamage($_POST["damaging"], $_POST["Level_Attacker"], $_POST["move"],False, $MoveAttStat, $AttEv, $AttIv, $_POST["target"],$_POST["NivTarget"],$MoveDefStat,$DefEv,$DefIv,0.8);
                            echo "Max: " . CalculateDamage($_POST["damaging"], $_POST["Level_Attacker"], $_POST["move"],False, $MoveAttStat, $AttEv, $AttIv, $_POST["target"],$_POST["NivTarget"],$MoveDefStat,$DefEv,$DefIv,1);
                        }
                        ?>
                    </section>
                </div>
            </article>
            <div>

            </div>
        </form>
    </section>
</div>
</body>
</html>