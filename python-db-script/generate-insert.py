#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import json
import sqlalchemy
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy import Numeric, Column, Integer, String, Table, ForeignKey
from sqlalchemy.orm import relationship
import datetime
import os

USERNAME = os.getenv("DB_USER", "user")
PASSWORD = os.getenv("DB_PASSWORD", "pswd")
DATABASE = os.getenv("DB_DATABASE", "skystar")

engine = sqlalchemy.create_engine("postgresql+pg8000://"+USERNAME+":"+PASSWORD+"@db/"+DATABASE,
    execution_options={
        "isolation_level": "REPEATABLE READ"
    })

Base = declarative_base()

constellations = []
objetdistants = []
objetproches = []

Session = sqlalchemy.orm.sessionmaker()
Session.configure(bind=engine)
session = Session()

class Determiner(Base):
    __tablename__ = "determiner"
    id_objet_proche = Column(Integer, ForeignKey('objet_proche.id_objet_proche'), primary_key=True)
    id_constellation = Column(Integer, ForeignKey('constellation.id_constellation'), primary_key=True)

class Grouper(Base):
    __tablename__ = "grouper"
    id_objet_distant = Column(Integer, ForeignKey('objet_distant.id_objet_distant'), primary_key=True)
    id_constellation = Column(Integer, ForeignKey('constellation.id_constellation'), primary_key=True)

class Objetdistant(Base):
    __tablename__ = "objet_distant"
    id_objet_distant = Column(Integer, primary_key=True)
    ra = Column(Numeric)
    deca = Column(Numeric)
    magnitude = Column(Numeric)
    ra_radians = Column(Numeric)
    dec_radians = Column(Numeric)
    type = Column(String[50])
    created = Column(sqlalchemy.DateTime)
    updated = Column(sqlalchemy.DateTime)
    constellations = relationship("Constellation", secondary='grouper')

class Objetproche(Base):
    __tablename__ = "objet_proche"
    id_objet_proche = Column(Integer, primary_key=True)
    nom = Column(String[32])
    magnitude = Column(Numeric)
    ra = Column(Numeric)
    deca = Column(Numeric)
    type = Column(String[32])
    date_approbation = Column(String[32])
    constellations = relationship("Constellation", secondary='determiner')

class Constellation(Base):
    __tablename__ = "constellation"
    id_constellation = Column(Integer, primary_key=True)
    latin_name = Column(String[50])
    observation_saison = Column(String[50])
    etoile_principale = Column(String[40])
    ra = Column(Numeric)
    deca = Column(Numeric)
    taille = Column(Numeric)
    created = Column(sqlalchemy.DateTime)
    updated = Column(sqlalchemy.DateTime)
    objet_proches = relationship(Objetproche, secondary='determiner', back_populates="constellations")
    objet_distants = relationship(Objetdistant, secondary='grouper', back_populates="constellations")

def filter_objetdistants(iau_code):
    oas = []
    for value in objetdistants:
        if value[1] == iau_code:
            oas.append(value[0])
    return oas

def filter_objetproches(const):
    ops = []
    for value in objetproches:
        if value[1] == const:
            ops.append(value[0])
    return ops

def hours_to_degree(ra):
    return ra * 15

def hms_dms_dd(ra, dec, delimiter=" "):
    """Convert from HMS; DMS to DD.
    
    Examples:
    >>> ra, dec = hms_dms_dd("00h59m59.3s", "-00d00m01.01s")
    >>> ra, dec
    (14.997083333333332, -0.00028055555555555554)
    >>> ra, dec = hms_dms_dd("23 59 59", "+56 00 00")
    >>> ra, dec
    (359.99583333333334, 56.0)
    >>> ra, dec = hms_dms_dd("24:30:00", "+90:00:00")
    >>> ra, dec
    (7.5, 90.0)
    
    """

    ra  = ra.replace(":", " ").replace(",", " ")
    dec = dec.replace("° ", " ").replace(",", " ").replace("'", "")

    ra, dec = ra.split(delimiter), dec.split(delimiter)

    # RA:
    ra_hours_dd = float(ra[0]) * 15.
    ra_minutes_dd = float(ra[1]) * 15. / 60.
    ra_seconds_dd = float(ra[2]) * 15. / 3600.
    ra_dd = ra_hours_dd + ra_minutes_dd + ra_seconds_dd
    if ra_dd >= 360.:
        ra_dd = abs(ra_dd  - 360.)

    # DEC:
    if "-" in dec[0]:
        dec_dd = float(dec[0]) - (float(dec[1]) / 60.) - (float(dec[2]) / 3600.)
    else:
        dec_dd = float(dec[0]) + (float(dec[1]) / 60.) + (float(dec[2]) / 3600.)


    return ra_dd, dec_dd

def objet_distant_parsing():
    with open("data/deep-sky-objects.json", "r") as read_file:
        emps = json.load(read_file)
        for emp in emps:
            for key, value in emp.items():
                # print(key, ":", value)
                if(key == "fields" and "mag" in value):
                    # print(value)
                    # print(value["ra"])
                    # print(hours_to_degree(value["ra"]))
                    # print(value["dec"])
                    x = datetime.datetime.now()
                    newObjetDistant = Objetdistant(
                            ra=round(hours_to_degree(value["ra"]),5),
                            deca=round(value["dec"],5),
                            magnitude=value["mag"],
                            ra_radians=value["rarad"],
                            dec_radians=value["decrad"],
                            type=value["type"],
                            created=x.strftime("%x")+" "+x.strftime("%X"),
                            updated=x.strftime("%x")+" "+x.strftime("%X"),
                        )
                    session.add(newObjetDistant)
                    session.flush()
                    session.refresh(newObjetDistant)
                    objetdistants.append([newObjetDistant, value["const"]])

def constellation_parsing():
    with open("data/88-constellations.json", "r") as read_file:
        emps = json.load(read_file)
        for emp in emps:
            for key, value in emp.items():
                if(key == "fields"):
                    ra = value["test"]
                    dec = value["dec_declinaison"]
                    (ra, dec) = hms_dms_dd(ra, dec)
                    x = datetime.datetime.now()
                    newConstellation = Constellation(
                        taille=value["constellation_area_in_degrees_etendue_de_la_constellation_en_degres_2"],
                        etoile_principale=value["principal_star_etoile_principale"],
                        observation_saison=value["season_saison"],
                        latin_name=value["latin_name_nom_latin"],
                        ra=round(ra,5),
                        deca=round(dec,5),
                        created=x.strftime("%x")+" "+x.strftime("%X"),
                        updated=x.strftime("%x")+" "+x.strftime("%X"))
                    session.add(newConstellation)
                    session.flush()
                    session.refresh(newConstellation)
                    constellations.append([newConstellation, value["iau_code"]])

def objet_proche_parsing():
    with open("data/stars.json", "r") as read_file:
        emps = json.load(read_file)
        for emp in emps:
            for key, value in emp.items():
                # print(key, ":", value)
                if(key == "fields" and "vmag" in value):
                    newObjetProche = Objetproche(
                            nom=value["iau_name"],
                            ra=round(value["ra_j2000"],5),
                            deca=round(value["dec_j2000"],5),
                            magnitude=value["vmag"],
                            date_approbation=value["approval_date"],
                            type="étoile"
                        )
                    session.add(newObjetProche)
                    session.flush()
                    session.refresh(newObjetProche)
                    objetproches.append([newObjetProche, value["constellation"]])

def determiner_parsing():
    for value in constellations:
        ops = filter_objetproches(value[1])
        for op in ops:
            newDeterminer = Determiner(
                id_objet_proche = op.id_objet_proche,
                id_constellation = value[0].id_constellation
            )
            session.add(newDeterminer)
            session.flush()
            session.refresh(newDeterminer)

def grouper_parsing():
    for value in constellations:
        ops = filter_objetdistants(value[1])
        for op in ops:
            newGrouper = Grouper(
                id_objet_distant = op.id_objet_distant,
                id_constellation = value[0].id_constellation
            )
            session.add(newGrouper)
            session.flush()
            session.refresh(newGrouper)

def run():
    objet_proche_parsing()
    objet_distant_parsing()
    constellation_parsing()
    determiner_parsing()
    grouper_parsing()
    session.commit()

if __name__ == '__main__':
    run()