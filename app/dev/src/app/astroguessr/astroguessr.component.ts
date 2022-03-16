import { Component, OnInit, ViewChild } from '@angular/core';
import Swal from 'sweetalert2';
import { PixiMapComponent } from '../pixi-map/pixi-map.component';
import { Position } from '../pixi-map/position';
import { AstroguessrService } from './astroguessr.service';
import { Auth } from './auth.interface';
import { ApiJeuStart } from './jeu.interface';

@Component({
  selector: 'app-astroguessr',
  templateUrl: './astroguessr.component.html',
  styleUrls: ['./astroguessr.component.scss']
})
export class AstroguessrComponent implements OnInit {
  user: Auth = {pseudo: "", key: ""};
  jeuStart!: ApiJeuStart;
  gameStarted: boolean = false;

  @ViewChild(PixiMapComponent) pixiMap!: PixiMapComponent;
  constructor(private astroguessrService: AstroguessrService) { }

  ngOnInit(): void {
  }

  isBlank(value: string): Boolean {
    if(value.length === 0)
      return true;
    return false;
  }

  // Vérification de l'utilisateur connecté
  shouldBeConnected(): Promise<void> {
    return new Promise((resolve, reject) => {
      // S'il est bien connecté
    if(!this.isBlank(this.user.key)){
      resolve()
    }else {
      console.error("start app", "user should be connected")
      reject()
    }
    })
  }

  /**
   * Connecte l'utilisateur (anonymement)
   */
  login(): void {
    if(this.isBlank(this.user.pseudo))
      Swal.fire({
        title: "Erreur",
        text: "Le pseudo ne peut pas être vide",
        icon: "error"
      })
    else
      this.astroguessrService.login(this.user.pseudo)
        .subscribe(r => {
          this.user.key = r.key
          this.startApp()
        })
  }

  /**
   * Authentifie l'app
   * L'utilisateur doit être connecté
   */
  startApp(): void {
    this.shouldBeConnected().then(() => {
      this.astroguessrService.start(this.user.key)
        .subscribe(r => {
          this.jeuStart = r
          this.gameStarted = true
          setTimeout(() => {
            this.pixiMap.updatePosition(
              Number(this.jeuStart.first_point.ra), 
              Number(this.jeuStart.first_point.deca), 
              Number(this.jeuStart.first_point.magnitude), 
              Position.raRangeDefault, 
              Position.decaRangeDefault)
          }, 0)
        })
    })
  }

  /**
   * Ajouter un parcour à chaque déplacement
   */
  addParcour(ra: number, deca: number, magnitude: number): void {
    this.shouldBeConnected().then(() => {
      this.astroguessrService.add_parcour(
        this.user.key, this.jeuStart.id_jeu, ra, deca, magnitude)
        .subscribe()
    })
  }

  /**
   * Proposer une solution
   */
  trouver(ra: number, deca: number): void {
    this.shouldBeConnected().then(() => {
      this.astroguessrService.trouver(
        this.user.key, this.jeuStart.id_jeu, ra, deca
      )
    })
  }

  moveLeft(): void {
    this.pixiMap.moveLeft()
    const p = this.pixiMap.getPosition()
    this.addParcour(p.ra, p.deca, p.magnitude)
  }

  moveRight(): void {
    this.pixiMap.moveRight()
    const p = this.pixiMap.getPosition()
    this.addParcour(p.ra, p.deca, p.magnitude)
  }

  moveBottom(): void {
    this.pixiMap.moveBottom()
    const p = this.pixiMap.getPosition()
    this.addParcour(p.ra, p.deca, p.magnitude)
  }

  moveTop(): void {
    this.pixiMap.moveTop()
    const p = this.pixiMap.getPosition()
    this.addParcour(p.ra, p.deca, p.magnitude)
  }
}
