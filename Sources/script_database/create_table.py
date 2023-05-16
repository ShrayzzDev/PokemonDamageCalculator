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
	curs.execute('''DROP TABLE IF EXISTS TypeResistance;''')
	curs.execute('''DROP TABLE IF EXISTS TypeWeakness;''')
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
					Speed numeric(3,0)
					);''')

	curs.execute('''CREATE TABLE Type(
					Name varchar(20) PRIMARY KEY
					);''')

	curs.execute('''CREATE TABLE PokemonType(
					Pokemon numeric(3,0) REFERENCES Pokemon,
					Type varchar(30) REFERENCES Type
					);''')

	curs.execute('''CREATE TABLE TypeWeakness(
					TypeSuperEffective varchar(20) REFERENCES Type, -- Attack type --
					TypeWeak varchar(20) REFERENCES Type -- Type that recieves, is weak to Type 1 --
					);''')

	curs.execute('''CREATE TABLE TypeResistance(
					TypeNotVeryEffective varchar(20) REFERENCES Type, -- Attack Type -- 
					TypeResistant varchar(10) REFERENCES Type -- Type that revieces, is resistant to Type 1 --
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
					Move numeric(3,0) REFERENCES Move
					);''')

	co.commit ()
	curs.close ()
except (Exception, psy.DatabaseError ) as error :
	print ( error )


finally :
	if co is not None:
		co. close ()