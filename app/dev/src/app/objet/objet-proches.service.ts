import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { catchError, Observable, of, tap } from 'rxjs';
import { ObjetApi, ObjetProche } from './objet.interface';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class ObjetProcheService {
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

  private apiUrl = `${environment.apiUrl}/api/objet_proches`; // URL to web api

  constructor(private http: HttpClient) {}

  getObjetProches(params?: HttpParams): Observable<ObjetApi> {
    return this.http.get<ObjetApi>(this.apiUrl, { params }).pipe(
      tap((_) => console.log('fetched objet proches')),
      catchError(this.handleError<ObjetApi>('getObjetProches'))
    );
  }

  getObjetProche(id: number): Observable<ObjetProche> {
    return this.http.get<ObjetProche>(this.apiUrl + '/' + id).pipe(
      tap((_) => console.log('fetched objet proches ' + id)),
      catchError(this.handleError<ObjetProche>('getObjetProche'))
    );
  }

  getAttributes(ra: number, deca: number, magnitude: number): Observable<ObjetProche[]> {
    return this.http.get<ObjetProche[]>(`${environment.apiUrl}/api/map/objet_proches`, {params: {ra, deca, magnitude}}).pipe(
      tap((_) => console.log('fetched objet proche platform')),
      catchError(this.handleError<ObjetProche[]>('getObjetProchePlatform'))
    )
  }
}
