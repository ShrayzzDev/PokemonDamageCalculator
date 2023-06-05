#!/usr/bin/env python3

import pandas as pd
import psycopg2 as psy


def returnTypeStringFromId(type_id):
	match type_id:
		case 1:
			return "normal"
		case 2:
			return "fighting"
		case 3:
			return "flying"
		case 4:
			return "poison"
		case 5:
			return "ground"
		case 6:
			return "rock"
		case 7:
			return "bug"
		case 8:
			return "ghost"
		case 9:
			return "empty" # Steel doesn't exist in gen 1
		case 10:
			return "fire"
		case 11:
			return "water"	
		case 12:
			return "grass"
		case 13:
			return "electric"
		case 14:
			return "psychic"
		case 15:
			return "ice"
		case 16:
			return "dragon"
		case 17:
			return "empty" #Dark pokemon don't exist in gen 1
		case 18: 
			return "normal" #Fairy pokemon, supposed to be normal in gen 1

df_pokemon = pd.read_csv(r'data/pokemon.csv')

df_pokemon = df_pokemon[["id","identifier"]].iloc[:151]

df_pokemon_stat = pd.read_csv(r'./data/pokemon_stats.csv')

df_pokemon_stat = df_pokemon_stat.iloc[:906]

list_hp = []
list_attaque = []
list_defense = []
list_att_spe = []
list_def_spe = []
list_vitesse = []

for row in df_pokemon_stat.itertuples():
	match row.stat_id:
		case 1:
			list_hp.append(row.base_stat)
		case 2:
			list_attaque.append(row.base_stat)
		case 3:
			list_defense.append(row.base_stat)
		case 4:
			list_att_spe.append(row.base_stat)
		case 5:
			list_def_spe.append(row.base_stat)
		case 6:
			list_vitesse.append(row.base_stat)

df_pokemon['HP'] = list_hp
df_pokemon['Attaque'] = list_attaque
df_pokemon['Defense'] = list_defense
df_pokemon['Att_Spe'] = list_att_spe
df_pokemon['Def_Spe'] = list_def_spe
df_pokemon['Vitesse'] = list_vitesse

# List of special stats of pokemon in gen 1, ordered by pokedex number
list_special = [65,80,100,50,65,85,50,65,85,20,
				25,80,20,25,45,35,50,70,25,50,
				31,61,40,65,50,90,30,55,40,55,
				75,40,55,75,60,85,65,100,25,50,
				40,75,75,85,100,55,80,40,90,45,
				70,40,65,50,80,35,60,50,80,40,
				50,70,105,120,135,35,50,65,70,85,
				100,100,120,30,45,55,65,80,40,80,
				95,120,58,35,60,70,95,40,65,45,
				85,100,115,130,30,90,115,25,50,55,
				80,60,125,40,50,35,35,60,60,85,
				30,45,105,100,40,70,98,50,80,70,
				100,100,55,95,85,85,55,70,20,100,
				95,48,65,110,110,110,75,90,115,45,
				70,60,65,125,125,125,80,70,100,154,100]

df_pokemon['Special'] = list_special

df_types_pokemon = pd.read_csv(r'./data/pokemon_types.csv')

df_types_pokemon = df_types_pokemon.iloc[:218]

last_slot = 0
type_slot_one = []
type_slot_two = []

for row in df_types_pokemon.itertuples():
	if last_slot == row.slot: #For pokemon with only one type
		type_slot_two.append("empty")
	if row.slot == 1:
		type_slot_one.append(returnTypeStringFromId(row.type_id))
		last_slot = 1
	else :
		type_slot_two.append(returnTypeStringFromId(row.type_id))
		last_slot = 2
type_slot_two.append("empty") # For mew, mew only has one type but last, so finished to
							  # Parse the df before it could put an empty

df_pokemon['Type_1'] = type_slot_one
df_pokemon['Type_2'] = type_slot_two

types = {"fire" : "Spe",
		 "water" : "Spe",
		 "grass" : "Spe",
		 "electric" : "Spe",
		 "psychic" : "Spe",
		 "ice" : "Spe",
		 "dragon" : "Spe",
		 "normal" : "Phy",
		 "flying" : "Phy",
		 "fighting" : "Phy",
		 "rock" : "Phy",
		 "poison" : "Phy",
		 "ground" : "Phy",
		 "bug" : "Phy",
		 "ghost" : "Phy"}

df_type_efficiency = pd.read_csv(r'data/type_efficacy.csv')

df_moves = pd.read_csv(r'data/moves.csv')

df_moves = df_moves.fillna(0)

df_movepool = pd.read_csv(r'data/pokemon_moves.csv')

print("Enter password: ")
password = input()

co = None
try: 
	co = psy.connect(host = 'localhost',
			database = 'dbpokemon',
			user = 'postgres',
			password = password)

	curs = co.cursor()

	for type_act,typing_act in types.items():
		curs.execute(''' INSERT INTO Type VALUES (%s,%s)''',
			(type_act,typing_act))

	for row in df_type_efficiency.itertuples():
		if row.damage_type_id != 18 and row.target_type_id != 18:
			damaging_type = returnTypeStringFromId(row.damage_type_id)
			targeted_type = returnTypeStringFromId(row.target_type_id)
			if damaging_type != "empty" and targeted_type != "empty":
				curs.execute(''' INSERT INTO TypeEfficiency VALUES (%s,%s,%s)''',
					(damaging_type,targeted_type,row.damage_factor))

	for row in df_moves.itertuples():
		move_type = returnTypeStringFromId(row.type_id)
		if move_type == "empty":
			move_type = "normal"
		if row.generation_id == 1:
			curs.execute(''' INSERT INTO Move VALUES (%s,%s,%s,%s,%s,%s)''',
				(row.id,row.identifier,move_type,row.power,row.pp,row.accuracy))

	for row in df_pokemon.itertuples():
		curs.execute(''' INSERT INTO Pokemon (ID, Name, HP, Attack, Defense,  SP_Attack, SP_Defense, Special, Speed)
						VALUES (%s, %s,%s,%s,%s,%s,%s,%s,%s);''',
						(row.id, row.identifier, row.HP, row.Attaque, row.Defense, row.Att_Spe, row.Def_Spe, row.Special, row.Vitesse))
		curs.execute(''' INSERT INTO PokemonType VALUES (%s,%s);''',
						(row.id,row.Type_1))
		if row.Type_2 != "empty":
			curs.execute(''' INSERT INTO PokemonType VALUES (%s,%s);''',
						(row.id,row.Type_2))

	for row in df_movepool.itertuples():
		if row.version_group_id == 1:
			curs.execute(''' INSERT INTO PokemonMove VALUES (%s,%s,%s)''',
				(row.pokemon_id,row.move_id,row.level))


	co.commit ()
	curs.close ()
except (Exception, psy.DatabaseError ) as error :
	print ( error )


finally :
	if co is not None:
		co. close ()
