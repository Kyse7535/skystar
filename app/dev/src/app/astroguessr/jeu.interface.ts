import { ObjetDistant } from "../objet/objet.interface";
import { Parcour } from "./parcour.interface";

export interface ApiJeuStart {
  id_jeu: number;
  objet_distant: ObjetDistant;
  first_point: Parcour;
}

export interface Jeu {
  idJeu: number;
  pseudo: string;
  trouver: number;
  duree: string;
  dateCreation: string;
  created: string;
  updated: string;
  idObjetDistant: ObjetDistant;
  point: string;
}

export interface ApiJeuTrouver {
  jeu: Jeu;
  message: string;
  response: "VALID" | "INVALID"
}