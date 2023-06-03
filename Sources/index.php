<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css"/>
    <title>Damage Calculator</title>
</head>
<body>
<?php include 'php/database_handling.php';
$Liste_Pokemon = GetAllPokemonName();?>
<header>
    <select>
        <option>Génération 1</option>
    </select>
</header>
<div class="first-block">
    <section class="main-block">
        <article class="first-pokemon">
            <div>
                <p>Choisissez le pokémon qui attaque</p>
                <form method="POST" action="">
                    <select name="damaging" onchange="this.form.submit()">
                        <?php
                        $First_Option_Damaging = "Select";
                        if (ISSET($_POST["damaging"]))
                        {
                            $First_Option_Damaging = $_POST["damaging"];
                        }
                        echo "<option value='' disabled selected>$First_Option_Damaging</option>";
                        for ($i = 0; $i < count($Liste_Pokemon); ++$i)
                        {
                            echo '<option value=' . $Liste_Pokemon[$i]["name"] . '>' . $Liste_Pokemon[$i]["name"] . "</option>";
                        }
                        ?>
                </form>
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
                        <input type="number" id="IV_HP_OFF" class="EV_Input" min="0" max="252">
                        <label for="EV_HP_OFF" class="EV"> EV :</label>
                        <input type="number" id="EV_HP_OFF" class="EV_Input" min="0" max="252">
                    </section>
                    <section>
                        <label> Attack : </label>
                        <?php
                        if (ISSET($_POST["damaging"]))
                        {
                            echo GetStat($_POST["damaging"],"Attack");
                        }
                        ?>
                        <label for="IV_Att_OFF" class="EV"> IV :</label>
                        <input type="number" id="IV_Att_OFF" class="EV_Input" min="0" max="252">
                        <label for="EV_Att_OFF" class="EV"> EV :</label>
                        <input type="number" id="EV_Att_OFF" class="EV_Input" min="0" max="252">
                    </section>
                    <section>
                        <label> Defense : </label>
                        <?php
                        if (ISSET($_POST["damaging"]))
                        {
                            echo GetStat($_POST["damaging"],"Defense");
                        }
                        ?>
                        <label for="IV_Def_OFF" class="EV"> IV :</label>
                        <input type="number" id="IV_Def_OFF" class="EV_Input" min="0" max="252">
                        <label for="EV_Def_OFF" class="EV"> EV :</label>
                        <input type="number" id="EV_Def_OFF" class="EV_Input" min="0" max="252">
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
                        <input type="number" id="IV_Spec_OFF" class="EV_Input" min="0" max="252">
                        <label for="EV_Spec_OFF" class="EV"> EV :</label>
                        <input type="number" id="EV_Spec_OFF" class="EV_Input" min="0" max="252">
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
                        <input type="number" id="IV_Spe_OFF" class="EV_Input" min="0" max="252">
                        <label for="EV_Spe_OFF" class="EV"> EV :</label>
                        <input type="number" id="EV_Spe_OFF" class="EV_Input" min="0" max="252">
                    </section>
                    <section>
                        <br/>
                        <label for="niv">Niveau: </label>
                        <input type ="number" id="niv" name="Level_Attacker" min="1" max="100">
                        <label> Attaque à utiliser : </label>
                        <form method="POST" action="">
                            <Select name="attack" onchange="this.form.submit()">
                                <?php
                                $Pokemon_Movepool = GetPokemonMovePool($First_Option_Damaging,$_POST["Level_Attacker"]);
                                $First_Attack = "Select";
                                if (ISSET($_POST["attack"]))
                                {
                                    $First_Attack = $_POST["attack"];
                                }
                                echo "<option value='' disabled selected>$First_Attack</option>";
                                for ($i = 0; $i < count($Pokemon_Movepool); ++$i)
                                {
                                    echo '<option value=' . $Pokemon_Movepool[$i]["name"] . '>' . $Pokemon_Movepool[$i]["name"] . "</option>";
                                }
                                ?>
                            </select>
                        </form>
                        <br/>
                        <br/>
                        <label> Puissance de l'attaque : </label>
                        <label> 100 </label>
                        <br/>
                        <br/>
                        <label> PP de l'attaque : </label>
                        <label> 100 </label>
                        <br/>
                        <br/>
                        <label> Précision de l'attaque : </label>
                        <label> 100 </label>
                    </section>
                </div>
            </div>
        </article>
        <article class="second-pokemon">
            <div>
                <p>Choisissez le pokémon qui subit</p>
                <form method="POST" action="">
                    <select name="target" onchange="this.form.submit()">
                        <?php
                        $First_Option_Target = "Select";
                        if (ISSET($_POST["target"]))
                        {
                            $First_Option_Target = $_POST["target"];
                        }
                        echo "<option value='' disabled selected>$First_Option_Target</option>";
                        for ($i = 0; $i < count($Liste_Pokemon); ++$i)
                        {
                            echo '<option value=' . $Liste_Pokemon[$i]["name"] . '>' . $Liste_Pokemon[$i]["name"] . "</option>";
                        }
                        ?>
                    </select>
                </form>
                <div>
                    <section>
                        <label> HP : </label>
                        <label> 100 </label>
                        <label for="EV_HP_SUB" class="EV"> EV :</label>
                        <input type="number" id="EV_HP_SUB" class="EV_Input" min="0" max="252">
                    </section>
                    <section>
                        <label> Attack : </label>
                        <label> 100</label>
                        <label for="EV_Att_OFF" class="EV"> EV :</label>
                        <input type="number" id="EV_Att_SUB" class="EV_Input" min="0" max="252">
                    </section>
                    <section>
                        <label> Defense : </label>
                        <label> 100</label>
                        <label for="EV_Def_OFF" class="EV"> EV :</label>
                        <input type="number" id="EV_Def_SUB" class="EV_Input" min="0" max="252">
                    </section>
                    <section>
                        <label> Special : </label>
                        <label> 100</label>
                        <label for="EV_Spec_OFF" class="EV"> EV :</label>
                        <input type="number" id="EV_Spec_SUB" class="EV_Input" min="0" max="252">
                    </section>
                    <section>
                        <label> Speed : </label>
                        <label> 100</label>
                        <label for="EV_Spe_OFF" class="EV"> EV :</label>
                        <input type="number" id="EV_Spe_SUB" class="EV_Input" min="0" max="252">
                    </section>
                </div>
                <section>
                    <br/>
                    <label for="NivTarget">Niveau: </label>
                    <input type ="number"  id="NivTarget" min="1" max="100">
                </section>
            </div>
        </article>
        <div>
            <label> Dégats de l'attaque: </label>
            <label> 100 HP</label>
        </div>
    </section>
</div>
</body>
</html>