import { Component, OnInit, ViewChild } from '@angular/core';
import { PixiMapComponent } from '../pixi-map/pixi-map.component';
import { ActivatedRoute } from "@angular/router";
import { Position } from '../pixi-map/position';

@Component({
  selector: 'app-carte',
  templateUrl: './carte.component.html',
  styleUrls: ['./carte.component.scss']
})
export class CarteComponent implements OnInit {
  ra!: number;
  dec!: number;
  magnitude!: number;
  raRangemin !: number; 
  raRangemax !: number; 
  decaRangemin !: number;
  decaRangemax !: number;
  raRange !: number;
  decaRange !: number; 

  //constel: string = '' ; 
  //filter: string = '';
 
  @ViewChild(PixiMapComponent) pixiMap!: PixiMapComponent;
  constructor(private activatedRoute: ActivatedRoute) { }

  ngOnInit(): void {

  }

  
  ngAfterViewInit(): void {
    const queryParams = this.activatedRoute.snapshot.queryParams
    const ra = Number(queryParams?.['ra'])
    const deca = Number(queryParams?.['deca'])
    const magnitude = Number(queryParams?.['magnitude'])

    if(ra !== NaN && deca !== NaN && magnitude !== NaN) 
      this.pixiMap.updatePosition(ra, deca, magnitude, Position.raRangeDefault, Position.decaRangeDefault)
  }

  onFiltrer() {
    this.pixiMap.updatePosition(this.ra, this.dec, this.magnitude, this.raRange, this.decaRange)
  }

  
  getPos( pos: Position) : void  {
    // setTimeout : Why ?
    // watch that : https://angular.io/errors/NG0100
    setTimeout(() => {
      this.ra = pos.ra
      this.dec = pos.deca
      this.magnitude = pos.magnitude
      this.raRange = pos.raRange
      this.raRangemin = pos.raRangeMin
      this.raRangemax = pos.raRangeMax
      this.decaRange = pos.decaRange
      this.decaRangemin = pos.decaRangeMin
      this.decaRangemax = pos.decaRangeMax
    }, 0)
  }

}
