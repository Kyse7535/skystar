import { Container, Text } from "pixi.js"
import { Position } from "./position";

export class Legend extends Container {
  pos!: Position;

  constructor(pos: Position) {
    super()

    this.pos = pos;
  }

  text(property: number): Text {
    const t = new Text(String(property))
    t.style.fill = "red";
    t.x = 350
    t.y = 0
    return t;
  }

  draw(): void {
    
  }
}