#!/usr/bin/env python3

import pandas as pd
import psycopg2 as psy

print("Enter password: ")
password = input()

co = None
try: 
	co = psy.connect(host = 'localhost',
			database = 'dbpokemon',
			user = 'postgres',
			password = password)

	curs = co.cursor()

	curs.execute('''DROP TABLE IF EXISTS PokemonMove''')
	curs.execute('''DROP TABLE IF EXISTS Move''')
	curs.execute('''DROP TABLE IF EXISTS TypeEfficiency;''')
	curs.execute('''DROP TABLE IF EXISTS PokemonType;''')
	curs.execute('''DROP TABLE IF EXISTS Type;''')
	curs.execute('''DROP TABLE IF EXISTS Pokemon;''')
	
	curs.execute('''CREATE TABLE Pokemon(
					ID numeric(3,0) PRIMARY KEY,
					Name varchar(30) NOT NULL,
					HP numeric(3,0) NOT NULL,
					Attack numeric(3,0) NOT NULL,
					Defense numeric(3,0) NOT NULL,
					SP_Attack numeric(3,0) NOT NULL,
					SP_Defense numeric(3,0) NOT NULL,
					Special numeric(3,0), -- ONLY FOR GEN 1 POKEMON --
					Speed numeric(3,0) NOT NULL
					);''')

	curs.execute('''CREATE TABLE Type(
					Name varchar(20) PRIMARY KEY,
					Typing varchar(4) CHECK ( Typing IN ('Phy','Spe','Null')) -- Used for gen 1,2,3. Null will be used only for fairy type, when implmented later --
					);''')

	curs.execute('''CREATE TABLE PokemonType(
					Pokemon numeric(3,0) REFERENCES Pokemon,
					Type varchar(30) REFERENCES Type
					);''')

	curs.execute('''CREATE TABLE TypeEfficiency(
					damaging_type varchar(20) REFERENCES Type,
					targeted_type varchar(20) REFERENCES Type,
					damage_factor numeric(3) NOT NULL,
					CHECK (damage_factor = 200 OR damage_factor = 50 OR damage_factor = 0 OR damage_factor = 100)
					);''')

	curs.execute('''CREATE TABLE Move(
					ID numeric(3,0) PRIMARY KEY,
					Name varchar(30) NOT NULL,
					Type varchar(30) REFERENCES Type,
					Power numeric(3,0) NOT NULL,
					PP numeric(3,0) NOT NULL,
					Accuracy numeric(3,0) NOT NULL
					);''')

	curs.execute('''CREATE TABLE PokemonMove(
					Pokemon numeric(3,0) REFERENCES Pokemon,
					Move numeric(3,0) REFERENCES Move,
					Learning_Level numeric(3,0) NOT NULL
					);''')

	co.commit ()
	curs.close ()
except (Exception, psy.DatabaseError ) as error :
	print ( error )


finally :
	if co is not None:
		co. close ()