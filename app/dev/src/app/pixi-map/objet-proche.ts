import { ObjetProche as ObjetProcheInterface } from "../objet/objet.interface";
import { Objet } from "./objet";
import { Position } from "./position";
import { percentBetweenRange } from "./util";
import { Text, TextStyle } from "pixi.js"

export class ObjetProche extends Objet implements ObjetProcheInterface {
  // ObjetProche implements
  idObjetProche!: string;
  nom!: string;
  type!: string;
  dateApprobation!: string;
  ra!: string | number;
  deca!: string | number;
  magnitude!: string | number;

    // Objet Position existe déjà dans PIXI.Graphics, alors on le nomme pos
    pos!: Position;

  constructor(opi: ObjetProcheInterface, p: Position) {
    super();

    this.pos = p;

    this.interactive = true
    // this.buttonMode = true
    this.on("click", (event) => {
      console.log("click", event)
    })
    this.on("mouseover", (event) => {
      console.log("mouseover", event)
    })
    this.init(opi)

    this.draw()
  }

  // Le cast en TypeScript ne permet pas d'instancier les objets avec leur constructeurs,
  // Ainsi, il faut caster a la main :) <@!é&%$*>
  // const t = T: <Y> y; n'utilise pas les constructeurs de T mais ceux de Y, voir docs.
  init(opi: ObjetProcheInterface): void {
    this.idObjetProche = opi.idObjetProche
    this.nom = opi.nom
    this.type = opi.type
    this.dateApprobation = opi.dateApprobation
    this.ra = opi.ra
    this.deca = opi.deca
    this.magnitude = opi.magnitude
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
    const raPercent = percentBetweenRange(
      this.pos.ra - range, 
      this.pos.ra + range, 
      Number(this.ra))

    return ((100 - raPercent) * this.pos.maxY) / 100;
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

    return (decPercent * this.pos.maxX) / 100;
  }

  /**
   * 
   * @returns l'objet PIXI.Text avec le nom de l'objet proche
   */
  getPixiNom(): Text {
    const style = new TextStyle({
      fontFamily: 'Arial',
      fontSize: 36,
      fontStyle: 'italic',
      fontWeight: 'bold',
      fill: ['#ffffff', '#00ff99'], // gradient
      stroke: '#4a1850',
      strokeThickness: 5,
      dropShadow: true,
      dropShadowColor: '#000000',
      dropShadowBlur: 4,
      dropShadowAngle: Math.PI / 6,
      dropShadowDistance: 6,
      wordWrap: true,
      wordWrapWidth: 440,
      lineJoin: 'round',
    });
    const basicText = new Text(this.nom, style)
    basicText.x = this.posX - (basicText.width / 2)
    basicText.y = this.posY + this.size

    return basicText;
  }
}