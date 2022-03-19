import { Component, OnInit, ViewChild } from '@angular/core';
import { catchError } from 'rxjs';
import Swal from 'sweetalert2';
import { Find } from '../pixi-map/find';
import { PixiMapComponent } from '../pixi-map/pixi-map.component';
import { Position } from '../pixi-map/position';
import { AstroguessrService } from './astroguessr.service';
import { Auth } from './auth.interface';
import { ApiJeuStart, Jeu } from './jeu.interface';

@Component({
  selector: 'app-astroguessr',
  templateUrl: './astroguessr.component.html',
  styleUrls: ['./astroguessr.component.scss']
})
export class AstroguessrComponent implements OnInit {
  cheatMode: boolean = false;
  findLoading: boolean = false;
  isFinding: boolean = false;
  user: Auth = {pseudo: "", key: ""};
  jeuStart!: ApiJeuStart;
  gameStarted: boolean = false;
  
  // Table best 10 players
  bestJeu: Jeu[] = [];
  displayedColumns: string[] = ['pseudo', 'point'];
  bestLoading: boolean = false;

  @ViewChild('pixiMap') pixiMap!: PixiMapComponent;
  @ViewChild('pixiMapTrouver') pixiMapTrouver!: PixiMapComponent;
  constructor(private astroguessrService: AstroguessrService) { }

  ngOnInit(): void {
    this.loadingBestPlayers()
  }

  loadingBestPlayers(): void {
    this.bestLoading = true;
    this.astroguessrService.top10().subscribe((bj) => {
      this.bestLoading = false;
      this.bestJeu = bj
    })
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
            this.pixiMapTrouver.updatePosition(
              Number(this.jeuStart.objet_distant.ra),
              Number(this.jeuStart.objet_distant.deca),
              Number(this.jeuStart.objet_distant.magnitude) - 5,
              Position.raRangeDefault,
              Position.decaRangeDefault
            )
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
  trouver(find: Find): void {
    this.shouldBeConnected().then(() => {
      this.findLoading = true
      try {
        const ra: number = this.cheatMode ? Number(this.jeuStart.objet_distant.ra) : find.ra;
        const deca: number = this.cheatMode ? Number(this.jeuStart.objet_distant.deca) : find.deca;
        this.astroguessrService.trouver(
          this.user.key, this.jeuStart.id_jeu, ra, deca
        )
        .subscribe((c) => {
          this.findLoading = false
          if(c.response == "INVALID") {
            Swal.fire({
              title: "Erreur",
              text: "Vous vous êtes tromper ! Continuer !",
              icon: "error"
            })
          } else if (c.response == "VALID") {
            Swal.fire({
              title: "Congrats !",
              text: "Vous avez réussi",
              icon: "success",
            }).then(() => {
              this.gameStarted = false;
              this.user = {key: "", pseudo: ""}
              this.isFinding = false;
              this.cheatMode = false;
              this.loadingBestPlayers()
            })
          }
        })
      } catch (e) {
        this.findLoading = false
        console.error(e)
        Swal.fire({
          title: "Erreur",
          text: "Vous vous êtes tromper ! Continuer !",
          icon: "error"
        })
      }
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
