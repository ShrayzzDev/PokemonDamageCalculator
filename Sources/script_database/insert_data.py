#!/usr/bin/env python3

import pandas as pd
import psycopg2 as psy


def returnTypeStringFromId(type_id):
	match type_id:
		case 1:
			return "Normal"
		case 2:
			return "Fighting"
		case 3:
			return "Flying"
		case 4:
			return "Poison"
		case 5:
			return "Ground"
		case 6:
			return "Rock"
		case 7:
			return "Bug"
		case 8:
			return "Ghost"
		case 9:
			return "Empty" # Steel doesn't exist in gen 1
		case 10:
			return "Fire"
		case 11:
			return "Water"	
		case 12:
			return "Grass"
		case 13:
			return "Electric"
		case 14:
			return "Psychic"
		case 15:
			return "Ice"
		case 16:
			return "Dragon"
		case 17:
			return "Empty" #Dark pokemon don't exist in gen 1
		case 18: 
			return "Normal" #Fairy pokemon, supposed to be normal in gen 1

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

df_types_pokemon = pd.read_csv(r'./data/pokemon_types.csv')

df_types_pokemon = df_types_pokemon.iloc[:218]

last_slot = 0
type_slot_one = []
type_slot_two = []

for row in df_types_pokemon.itertuples():
	if last_slot == row.slot: #For pokemon with only one type
		type_slot_two.append("Empty")
	if row.slot == 1:
		type_slot_one.append(returnTypeStringFromId(row.type_id))
		last_slot = 1
	else :
		type_slot_two.append(returnTypeStringFromId(row.type_id))
		last_slot = 2
type_slot_two.append("Empty") # For mew, mew only has one type but last, so finished to
							  # Parse the df before it could put an empty

df_pokemon['Type_1'] = type_slot_one
df_pokemon['Type_2'] = type_slot_two

types = {"Fire" : "Spe",
		 "Water" : "Spe",
		 "Grass" : "Spe",
		 "Electric" : "Spe",
		 "Psychic" : "Spe",
		 "Ice" : "Spe",
		 "Dragon" : "Spe",
		 "Normal" : "Phy",
		 "Flying" : "Phy",
		 "Fighting" : "Phy",
		 "Rock" : "Phy",
		 "Poison" : "Phy",
		 "Ground" : "Phy",
		 "Bug" : "Phy",
		 "Ghost" : "Phy"}

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
			if damaging_type != "Empty" and targeted_type != "Empty":
				curs.execute(''' INSERT INTO TypeEfficiency VALUES (%s,%s,%s)''',
					(damaging_type,targeted_type,row.damage_factor))

	for row in df_moves.itertuples():
		move_type = returnTypeStringFromId(row.type_id)
		if move_type == "Empty":
			move_type = "Normal"
		if row.generation_id == 1:
			curs.execute(''' INSERT INTO Move VALUES (%s,%s,%s,%s,%s,%s)''',
				(row.id,row.identifier,move_type,row.power,row.pp,row.accuracy))

	for row in df_pokemon.itertuples():
		curs.execute(''' INSERT INTO Pokemon (ID, Name, HP, Attack, Defense,  SP_Attack, SP_Defense, Speed)
						VALUES (%s, %s,%s,%s,%s,%s,%s,%s);''',
						(row.id, row.identifier, row.HP, row.Attaque, row.Defense, row.Att_Spe, row.Def_Spe, row.Vitesse))
		curs.execute(''' INSERT INTO PokemonType VALUES (%s,%s);''',
						(row.id,row.Type_1))
		if row.Type_2 != "Empty":
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
