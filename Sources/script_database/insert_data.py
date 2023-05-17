#!/usr/bin/env python3

import pandas as pd
import psycopg2 as psy

df_pokemon = pd.read_csv(r'data/pokemon.csv')

df_pokemon = df_pokemon[["id","identifier"]].iloc[:151]

df_pokemon_stat = pd.read_csv(r'data/pokemon_stats.csv')

print(df_pokemon)

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

print(df_pokemon)

print("Enter password: ")
password = input()

types = [Fire,Water,Flying,Rock,Ground,Grass,Poison,Psychic,Ghost,Electric,Ice,Fighting]

co = None
try: 
	co = psy.connect(host = 'localhost',
			database = 'dbpokemon',
			user = 'postgres',
			password = password)

	curs = co.cursor()

	for row in df_pokemon.itertuples():
		print("J'insert",row.identifier)
		curs.execute(''' INSERT INTO Pokemon (ID, Name, HP, Attack, Defense,  SP_Attack, SP_Defense, Speed)
						VALUES (%s, %s,%s,%s,%s,%s,%s,%s);''',
						(row.id, row.identifier, row.HP, row.Attaque, row.Defense, row.Att_Spe, row.Def_Spe, row.Vitesse))
	for poke_type in types:
		curs.execute(''' INSERT INTO Type VALUES (%s)''',
			(poke_type,))

	co.commit ()
	curs.close ()
except (Exception, psy.DatabaseError ) as error :
	print ( error )


finally :
	if co is not None:
		co. close ()