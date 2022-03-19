import {
  Component,
  DoCheck,
  ElementRef,
  Input,
  OnChanges,
  OnDestroy,
  OnInit,
  Renderer2,
  SimpleChanges,
  ViewChild,
} from '@angular/core';
import * as PIXI from 'pixi.js';
import { forkJoin, Observable, Subscription } from 'rxjs';
import { ObjetDistant } from './objet-distant';
import { ObjetDistantService } from '../objet/objet-distants.service';
import { ObjetProcheService } from '../objet/objet-proches.service';
import { ObjetProche } from './objet-proche';
import { Position } from './position';
import { Output, EventEmitter } from '@angular/core';

import {
  ObjetDistant as ODInterface,
  ObjetProche as OPInterface,
} from '../objet/objet.interface';
import { Map } from './map';
import { Find } from './find';
import { percentBetweenRange } from './util';

@Component({
  selector: 'app-pixi-map',
  templateUrl: './pixi-map.component.html',
})
export class PixiMapComponent implements OnInit, OnDestroy, OnChanges {
  @Input() isFinding: boolean = false;
  @Input() width: number = 600;
  @Input() height: number = 600;
  @Output() eventPosition = new EventEmitter<Position>()
  @Output() eventFind = new EventEmitter<Find>()

  private position: Position = new Position(this.width, this.height);

  private map: Map = new Map(this.position);
  private app: PIXI.Application = new PIXI.Application({
    width: this.width,
    height: this.height
  });

  private subscribeResearch!: Subscription;

  constructor(
    private objetDistantService: ObjetDistantService,
    private objetProcheService: ObjetProcheService,
    private renderer2: Renderer2,
    private el: ElementRef
  ) {}

  ngOnChanges(changes: SimpleChanges): void {
    if(changes["width"] || changes["height"]){
      // Réinstentiation
      this.position.maxX = this.width
      this.position.maxY = this.height
      this.app.view.width = this.width
      this.app.view.height = this.height
    }

    if(changes['isFinding']){
      this.app.view.style.cursor = this.isFinding ? "crosshair" : "initial";
    }
  }

  /**
   *
   * @returns ForkJoin de rxjs permet de faire les deux requêtes simultanéments
   */
  makeResearch(): Observable<[ODInterface[], OPInterface[]]> {
    return forkJoin([
      this.objetDistantService.getAttributes(
        this.position.ra,
        this.position.deca,
        this.position.magnitude,
        this.position.raRange,
        this.position.decaRange
      ),
      this.objetProcheService.getAttributes(
        this.position.ra,
        this.position.deca,
        this.position.magnitude,
        this.position.raRange,
        this.position.decaRange
      ),
    ]);
  }

  /**
   * On charge les données
   */
  loadData(): void {
    // A chaque fois que les datas sont chargés, ça veut dire que la position a été modifié, alors on envoie les datas
    this.eventPosition.emit(this.position);

    // Si on a pas finit de charger les datas précédents, on cancel la requête pour en faire une nouvelle
    if (this.subscribeResearch){
      // console.log(this.subscribeResearch)
      // console.log(this.position)
      this.subscribeResearch.unsubscribe(); 
    }

    this.subscribeResearch = this.makeResearch().subscribe((d) => {
      let containers: PIXI.Container[] = [];

      // Ajouts des objets distants
      d[0].map((od) => containers.push(new ObjetDistant(od, this.position)));

      // Ajouts des objets proches
      d[1].map((op) => {
        let o = new ObjetProche(op, this.position);
        containers.push(o, o.getPixiNom());
      });

      this.map.draw(containers);
    });
  }

  zoomIn(): void {
    this.position.magnitude = this.position.magnitude += 1;
    this.loadData();
  }

  zoomOut(): void {
    this.position.magnitude = this.position.magnitude -= 1;
    this.loadData();
  }

  moveLeft(): void {
    this.position.deca = this.position.deca -= 1;
    this.loadData();
  }

  moveRight(): void {
    this.position.deca = this.position.deca += 1;
    this.loadData();
  }

  moveTop(): void {
    this.position.ra = this.position.ra += 1;
    this.loadData();
  }

  moveBottom(): void {
    this.position.ra = this.position.ra -= 1;
    this.loadData();
  }

  getPosition(): Position {
    return this.position
  }

  ngAfterViewInit(): void {
    this.renderer2.appendChild(this.el.nativeElement, this.app.view);
  }

  ngOnInit(): void {
    this.app.stage.addChild(this.map);
    this.app.view.onclick = (ev) => this.onClickFinding(ev)
    this.loadData();
  }

  onClickFinding(event: MouseEvent) {
    if(this.isFinding){
      // RA
      const raPercent = percentBetweenRange(0, this.height, event.clientY)
      const raMin = this.position.ra - (this.position.raRange / 2)
      const raFind = raMin + ((raPercent / 100) * this.position.raRange)

      // DECA
      const decaPercent = percentBetweenRange(0, this.width, event.clientX)
      const decaMin = this.position.deca - (this.position.decaRange / 2)
      const decaFind = decaMin + ((decaPercent / 100) * this.position.decaRange)

      const find: Find = {ra: raFind, deca: decaFind}
      this.eventFind.emit(find);
    }
  }

  ngOnDestroy(): void {
    this.app.destroy();
  }

  updatePosition(ra: number, deca: number, magnitude: number, raRange: number, decaRange:number): void {
    this.position.ra = ra;
    this.position.deca = deca;
    this.position.magnitude = magnitude;
    this.position.raRange = raRange;
    this.position.decaRange = decaRange;
    this.loadData()
  }
}
