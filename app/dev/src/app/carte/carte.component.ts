import { Component, OnInit, ViewChild } from '@angular/core';
import { PixiMapComponent } from '../pixi-map/pixi-map.component';
import { ActivatedRoute } from "@angular/router";
import { PositionStrategy } from '@angular/cdk/overlay';
import { Position } from '../pixi-map/position';

@Component({
  selector: 'app-carte',
  templateUrl: './carte.component.html',
  styleUrls: ['./carte.component.scss']
})
export class CarteComponent implements OnInit {
  

  ra: string = '';
  dec: string = '';
  magnitude: string = '';
  //constel: string = '' ; 
  //filter: string = '';
  
 
  @ViewChild(PixiMapComponent) pixiMap!: PixiMapComponent;
  constructor(private activatedRoute: ActivatedRoute) { }

  ngOnInit(): void {
    
  }

  formatLabel(value: number): string | number  {
    if (value >= 1000) {
      return Math.round(value / 1000) + 'k';
    }

    return value;

  }



  ngAfterViewInit(): void {
    const queryParams = this.activatedRoute.snapshot.queryParams
    const ra = Number(queryParams?.['ra'])
    const deca = Number(queryParams?.['deca'])
    const magnitude = Number(queryParams?.['magnitude'])

    if(ra !== NaN && deca !== NaN && magnitude !== NaN) 
      this.pixiMap.updatePosition(ra, deca, magnitude)
    
  }

  getPos( pos: Position) : void  {
    console.log(pos)
  }

}
