import * as PIXI from "pixi.js"

export class Objet extends PIXI.Graphics {
  private _defaultSize: number = 15;

  get defaultSize(): number {
    return this._defaultSize;
  }

  draw() {
    
  }
}