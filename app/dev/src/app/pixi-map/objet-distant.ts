import { ObjetDistant as ObjetDistantInterface } from "../objet/objet.interface";
import { Objet } from "./objet";
import { Position } from "./position";
import { percentBetweenRange } from "./util";

export class ObjetDistant extends Objet implements ObjetDistantInterface {
  // ObjetDistant implements
  idObjetDistant!: string | number;
  type!: string;
  raRadians!: string | number;
  decRadians!: string | number;
  created!: string;
  updated!: string;
  ra!: string | number;
  deca!: string | number;
  magnitude!: string | number;
  idConstellation!: [];

  // Objet Position existe déjà dans PIXI.Graphics, alors on le nomme pos
  pos!: Position;

  constructor(odi: ObjetDistantInterface, p: Position) {
    super();

    this.pos = p

    // Interaction
    this.interactive = true
    this.on("click", (event) => {
      console.log("click", event)
    })
    this.on("mouseover", (event) => {
      console.log("mouseover", event)
    })

    // Initialisation
    this.init(odi)

    // Dessin
    this.draw()
  }

  // Le cast en TypeScript ne permet pas d'instancier les objets avec leur constructeurs,
  // Ainsi, il faut caster a la main :) <@!é&%$*>
  // const t = T: <Y> y; n'utilise pas les constructeurs de T mais ceux de Y, voir docs.
  init(odi: ObjetDistantInterface): void {
    this.idObjetDistant = odi.idObjetDistant
    this.type = odi.type
    this.raRadians = odi.raRadians
    this.decRadians = odi.decRadians
    this.created = odi.created
    this.updated = odi.updated
    this.ra = odi.ra
    this.deca = odi.deca
    this.magnitude = odi.magnitude
  }

  override draw() {
    // code Hexadecimal
    // 0x + rgba Hexa ff ff ff => blanc
    this.beginFill(0xffffff);

    this.drawCircle(this.posX, this.posY, this.size);
    this.endFill();
  }

  /**
   * Renvoie la taille en pixel de l'objet dessiner
   */
  get size(): number {
    const magPercent = percentBetweenRange(
      this.pos.magnitude, 
      this.pos.magnitude + 7, 
      Number(this.magnitude))

    return (this.defaultSize * (100 - magPercent)) / 100;
  }

  /**
   * Renvoie la position X en pixel de l'objet dessiner sur le canvas
   */
  get posY(): number {
    const range = this.pos.raRange / 2

    // Position de RA en pourcentage
    const raPercent = percentBetweenRange(
      this.pos.ra - range, 
      this.pos.ra + range, 
      Number(this.ra))

    // La position pY relatif
    const pY = ((100 - raPercent) * this.pos.maxY) / 100;

    // La position pY relatif - l'anchor (moins la moitier de la taille de l'objet)
    return pY - (this.size / 2);
  }

  /**
   * Renvoie la position Y en pixel de l'objet dessiner sur le canvas
   */
  get posX(): number {
    const range = this.pos.decaRange / 2
    const decPercent = percentBetweenRange(
      this.pos.deca - range, 
      this.pos.deca + range, 
      Number(this.deca))

    const pX = (decPercent * this.pos.maxX) / 100;

    return pX - (this.size / 2);
  }
}