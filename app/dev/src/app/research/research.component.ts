import { Component, OnInit } from '@angular/core';
import { HttpParams } from '@angular/common/http';
import { ViewChild } from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { merge, Observable, Subscription } from 'rxjs';
import { map, startWith, switchMap } from 'rxjs/operators';
import { Constellation } from '../constellation/contellation.interface';
import { ConstellationService } from '../constellation/constellation.service';
import { Objet, ObjetApi } from '../objet/objet.interface';
import { ObjetProcheService } from '../objet/objet-proches.service';
import { ObjetDistantService } from '../objet/objet-distants.service';
import Swal from 'sweetalert2'
import { Router } from '@angular/router';

interface SimpleError {
  ra: Boolean,
  dec: Boolean,
  magnitude: Boolean
}

@Component({
  selector: 'app-research',
  templateUrl: './research.component.html',
  styleUrls: ['./research.component.scss'],
})
export class ResearchComponent implements OnInit {
  // Initialisation de variable
  isLoading = false;
  constellations: Constellation[] = [];
  errors: SimpleError = {
    ra: false,
    dec: false,
    magnitude: false
  }

  // Initialisation variable de formulaire
  ra: string = '';
  dec: string = '';
  magnitude: string = '';
  constellationsSelected: [] = [];
  filter: string = '';
  type_objet: string = 'proche';

  // Initialisation variable de résultat
  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort, { static: false }) sort!: MatSort;
  
  displayedColumns: string[] = [];
  data: Objet[] = [];
  merge?: Subscription;

  resultsLength = 0;

  constructor(
    private constellationService: ConstellationService,
    private objetProcheService: ObjetProcheService,
    private objetDistantService: ObjetDistantService,
    private router: Router
  ) {}

  ngOnInit(): void {
    // Au lancement on récupère les constellations
    this.constellationService.getConstellations()
      .subscribe(c => c ? this.constellations = c["hydra:member"]: null)

    this.onChangeTypeObjet()
  }

  onChangeTypeObjet(): void {
    if(this.type_objet === 'proche') {
      this.displayedColumns = ["idObjetProche", "ra", "deca", "magnitude", "nom", "type", "dateApprobation", "actions"];
    } 
    if(this.type_objet === 'distant') {
      this.displayedColumns = ["idObjetDistant", "ra", "deca", "magnitude", "type", "raRadians", "decRadians", "created", "updated", "actions"]
    }
  }

  // https://www.delftstack.com/howto/javascript/check-if-string-is-number-javascript/
  isNumeric(value: string): Boolean {
    return /^-?\d+$/.test(value);
  }

  // Vérification si RA, DEC et Magnitude sont renseigner, ou aucun.
  verifFilters(): Boolean {
    if(this.ra || this.dec || this.magnitude) 
      if(!this.isNumeric(this.ra) 
        || !this.isNumeric(this.dec) 
        || !this.isNumeric(this.magnitude))
        return false;
    return true;
  }

  // Afficher les erreurs dans le formulaire
  displayErrorFilters(): void {
    Swal.fire({
      title: "Tous les champs doivent être renseigner",
      text: "Dans le cas d'une recherche approfondi, RA, DEC et Magnitude doivent être renseigner.",
      icon: "error",
      confirmButtonColor: "red"
    })
  }

  getDatas(): Observable<ObjetApi | null> {
    // Création de la requête GET
    const params = new HttpParams({
      fromObject: {
        'constellation[]': this.constellationsSelected,
        ra: this.ra,
        dec: this.dec,
        magnitude: this.magnitude,
        filter: this.filter,
        sort: this.sort.active,
        direction: this.sort.direction,
        page: (this.paginator.pageIndex + 1)
      }
    })
    
    if(this.type_objet !== 'proche')
      return this.objetDistantService.getObjetDistants(params)
    else
      return this.objetProcheService.getObjetProches(params)
  }

  onSubmit() { 
    if(this.merge)
      this.merge.unsubscribe()
      
    // If the user changes the sort order, reset back to the first page.
    this.sort.sortChange.subscribe(() => (this.paginator.pageIndex = 0));

    // On applique un écouteur sur le trie et sur la pagination
    this.merge = merge(this.sort.sortChange, this.paginator.page)
      .pipe(
        startWith({}),
        // Récupération des données
        switchMap(() => {
          // Si tout les champs ne sont pas bon
          if(!this.verifFilters())
            this.displayErrorFilters()

          // On charge les données
          this.isLoading = true

          return this.getDatas()
        }),
        map((data) => {
          // On arrête de charger les données
          this.isLoading = false
          // Flip flag to show that loading has finished.

          if (data === null) {
            return [];
          }

          this.resultsLength = data['hydra:totalItems'];
          return data['hydra:member'];
        })
      ).subscribe((data) => {
        this.data = data;
        this.onChangeTypeObjet()
      });
  }

  displayObjetOnMap(obj: Objet): void {
    // this.router.navigate(["ra", obj.ra, "deca", obj.deca, "magnitude", obj.magnitude], {relativeTo: "/carte"})
  }
}