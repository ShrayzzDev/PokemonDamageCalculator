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
                    <select name="damaging" ng-model="form.gender" onchange="this.form.submit()"">
                        <?php
                            $First_Option = "Select";
                            if (ISSET($_POST["damaging"]))
                            {
                                $First_Option = $_POST["damaging"];
                            }
                            echo "<option value='' disabled selected>$First_Option</option>";
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
                            <?php
                                if (ISSET($_POST["damaging"]))
                                {
                                    echo GetStat($_POST["damaging"],"HP");
                                }
                            ?>
                            <label for="IV_HP_OFF" class="EV"> IV :</label>
                            <input type="number" id="IV_HP_OFF" min="0" max="252">
                            <label for="EV_HP_OFF" class="EV"> EV :</label>
                            <input type="number" id="EV_HP_OFF" min="0" max="252">
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
                            <input type="number" id="IV_Att_OFF" min="0" max="252">
                            <label for="EV_Att_OFF" class="EV"> EV :</label>
                            <input type="number" id="EV_Att_OFF" min="0" max="252">
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
                            <input type="number" id="IV_Def_OFF" min="0" max="252">
                            <label for="EV_Def_OFF" class="EV"> EV :</label>
                            <input type="number" id="EV_Def_OFF" min="0" max="252">
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
                            <input type="number" id="IV_Spec_OFF" min="0" max="252">
                            <label for="EV_Spec_OFF" class="EV"> EV :</label>
                            <input type="number" id="EV_Spec_OFF" min="0" max="252">
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
                            <input type="number" id="IV_Spe_OFF" min="0" max="252">
                            <label for="EV_Spe_OFF" class="EV"> EV :</label>
                            <input type="number" id="EV_Spe_OFF" min="0" max="252">
                        </section>
                        <section>
                            <br/>
                            <label for="Niv">Niveau: </label>
                            <input type ="number"  id="niv" min="1" max="100">
                            <label> Attaque à utiliser : </label>
                            <Select>

                            </Select>
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
                    <select name=target >
                        <?php
                        $Liste_Pokemon = GetAllPokemonName();
                        for ($i = 0; $i < count($Liste_Pokemon); ++$i)
                        {
                            echo '<option value=' . $Liste_Pokemon[$i]["name"] . '>' . $Liste_Pokemon[$i]["name"] . "</option>";
                        }
                        ?>
                   </select>
                    <div>
                        <section>
                            <label> HP : </label>
                            <label> 100 </label>
                            <label for="EV_HP_SUB" class="EV"> EV :</label>
                            <input type="number" id="EV_HP_SUB" min="0" max="252">
                        </section>
                        <section>
                            <label> Attack : </label>
                            <label> 100</label>
                            <label for="EV_Att_OFF" class="EV"> EV :</label>
                            <input type="number" id="EV_Att_SUB" min="0" max="252">
                        </section>
                        <section>
                            <label> Defense : </label>
                            <label> 100</label>
                            <label for="EV_Def_OFF" class="EV"> EV :</label>
                            <input type="number" id="EV_Def_SUB" min="0" max="252">
                        </section>
                        <section>
                            <label> Special : </label>
                            <label> 100</label>
                            <label for="EV_Spec_OFF" class="EV"> EV :</label>
                            <input type="number" id="EV_Spec_SUB" min="0" max="252">
                        </section>
                        <section>
                            <label> Speed : </label>
                            <label> 100</label>
                            <label for="EV_Spe_OFF" class="EV"> EV :</label>
                            <input type="number" id="EV_Spe_SUB" min="0" max="252">
                        </section>
                    </div>
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