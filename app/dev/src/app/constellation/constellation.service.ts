import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { catchError, Observable, of, tap } from 'rxjs';
import { Constellation, ConstellationApi } from './contellation.interface';

@Injectable({
  providedIn: 'root'
})
export class ConstellationService {

  /**
   * Handle Http operation that failed.
   * Let the app continue.
   *
   * @param operation - name of the operation that failed
   * @param result - optional value to return as the observable result
   */
  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.log(this.apiUrl)
      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }

  private apiUrl = `http://localhost:8050/api/constellations`;  // URL to web api

  constructor(
    private http: HttpClient) { }

  getConstellations(): Observable<ConstellationApi> {
    return this.http.get<ConstellationApi>(this.apiUrl)
      .pipe(
        tap(_ => console.log('fetched constellations')),
        catchError(this.handleError<ConstellationApi>('getConstellations'))
      );
  }

  getConstellation(id: number): Observable<Constellation> {
    return this.http.get<Constellation>(this.apiUrl+"/"+id)
      .pipe(
        tap(_ => console.log('fetched constellation')),
        catchError(this.handleError<Constellation>('getConstellation'))
      );
  }
}
