import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { catchError, Observable, of, tap } from 'rxjs';
import { environment } from 'src/environments/environment';
import { ApiAuth, Auth } from './auth.interface';
import { ApiJeuStart, ApiJeuTrouver, Jeu } from './jeu.interface';
import { Parcour } from './parcour.interface';

@Injectable({
  providedIn: 'root'
})
export class AstroguessrService {
  /**
   * Handle Http operation that failed.
   * Let the app continue.
   *
   * @param operation - name of the operation that failed
   * @param result - optional value to return as the observable result
   */
  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.log(this.apiUrl);
      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }

  private apiUrl = `${environment.apiUrl}/api`; // URL to web api
  
  constructor(private http: HttpClient) { }

  /**
   * Connecte un joueur anonymement
   * @param pseudo Pseudo du joueur a connecter de manière anonyme
   * @returns 
   */
  login(pseudo: String): Observable<ApiAuth> {
    return this.http.post<ApiAuth>(this.apiUrl+"/auth/login", { pseudo }).pipe(
      tap((_) => console.log('anonym auth')),
      catchError(this.handleError<ApiAuth>('anonym auth'))
    );
  }

  /**
   * Démarre la partie
   * @param key User JWT Token key for authentication
   */
  start(key: string): Observable<ApiJeuStart> {
    const httpHeaders = new HttpHeaders().append('Authorization', 'Bearer ' + key)
    return this.http.post<ApiJeuStart>(this.apiUrl+"/jeu/start", {}, {headers: httpHeaders}).pipe(
      tap((_) => console.log('démarrer la partie')),
      catchError(this.handleError<ApiJeuStart>('démarrer la partie'))
    );
  }

  add_parcour(key: string, id_jeu: number, ra: number, deca: number, magnitude: number): Observable<Parcour> {
    const httpHeaders = new HttpHeaders().append('Authorization', 'Bearer ' + key)
    return this.http.post<Parcour>(this.apiUrl+"/jeu/"+id_jeu+"/add_parcour", {ra, deca, magnitude}, {headers: httpHeaders}).pipe(
      tap((_) => console.log('ajouter un changement de page dans la bd')),
      catchError(this.handleError<Parcour>('ajouter un changement de page dans la bd'))
    );
  }

  trouver(key: string, id_jeu: number, ra: number, deca: number): Observable<ApiJeuTrouver> {
    const httpHeaders = new HttpHeaders().append('Authorization', 'Bearer ' + key)
    return this.http.post<ApiJeuTrouver>(this.apiUrl+"/jeu/"+id_jeu+"/trouver", {ra, deca}, {headers: httpHeaders}).pipe(
      tap((_) => console.log('vérifier si on a trouver')),
      catchError(this.handleError<ApiJeuTrouver>('vérifier si on a trouver'))
    );
  }

  top10(): Observable<Jeu[]> {
    return this.http.get<Jeu[]>(this.apiUrl+"/jeu/best_10").pipe(
      tap((_) => console.log('récupérer les 10 meilleurs')),
      catchError(this.handleError<Jeu[]>('récupérer les 10 meilleurs'))
    );
  }
}
