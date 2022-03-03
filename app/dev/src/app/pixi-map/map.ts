import * as PIXI from "pixi.js"
import { Position } from "./position";

export class Map extends PIXI.Container {
  private pos!: Position;

  constructor(
    pos: Position 
  ) {
    super()

    this.pos = pos

    // Init
    this.init()
  }

  init(): void {
    this.width = this.pos.maxX;
    this.height = this.pos.maxY;
  }

  clear(): void {
    this.removeChildren()
  }

  draw(children: PIXI.Container[]): void {
    this.clear()
    children.map(child => this.addChild(child))
  }
}