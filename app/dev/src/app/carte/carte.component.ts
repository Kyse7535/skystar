import { Component, OnInit, ViewChild } from '@angular/core';
import { PixiMapComponent } from '../pixi-map/pixi-map.component';
import { ActivatedRoute } from "@angular/router";

@Component({
  selector: 'app-carte',
  templateUrl: './carte.component.html',
  styleUrls: ['./carte.component.scss']
})
export class CarteComponent implements OnInit {
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
      this.pixiMap.updatePosition(ra, deca, magnitude)
  }

}
