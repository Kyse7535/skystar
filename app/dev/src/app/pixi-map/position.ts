export class Position {
  // Variable de base
  private _magnitude: number = 10;
  private _magnitudeMax: number = 20;
  private _magnitudeMin: number = 0;

  private _deca: number = 1;
  private _decaMax: number = 90;
  private _decaMin: number = -90;

  private _ra: number = 1;
  private _raMax: number = 360;
  private _raMin: number = 0;

  private _decaRange: number = 2;
  private _decaRangeMax: number = 20;
  private _decaRangeMin: number = 2;

  private _raRange: number = 2;
  private _raRangeMax: number = 20;
  private _raRangeMin: number = 2;

  static raRangeDefault: number = 2;
  static decaRangeDefault: number = 2; 

  private _minX: number = 0;
  private _maxX!: number;

  private _minY: number = 0;
  private _maxY!: number;

  constructor(maxX: number, maxY: number) {
    this._maxX = maxX;
    this._maxY = maxY;
  }

  public set magnitude(newMagnitude: number) {
    if(newMagnitude <= this._magnitudeMax && newMagnitude >= this._magnitudeMin)
      this._magnitude = newMagnitude
  }

  public get magnitude(): number {
    return this._magnitude
  }

  public set ra(newRa: number) {
    if(newRa <= this._raMax && newRa >= this._raMin)
      this._ra = newRa
  }

  public get ra(): number {
    return this._ra
  }

  public set deca(newDeca: number) {
    if(newDeca <= this._decaMax && newDeca >= this._decaMin)
      this._deca = newDeca
  }

  public get deca(): number {
    return this._deca
  }

  public set raRange(newRaRange: number) {
    if(newRaRange <= this._raRangeMax && newRaRange >= this._raRangeMin)
      this._raRange = newRaRange
  }

  public get raRange(): number {
    return this._raRange
  }

  public get raRangeMin(): number {
    return this._raRangeMin
  }

  public get raRangeMax(): number {
    return this._raRangeMax
  }


  public get decaRangeMin(): number {
    return this._decaRangeMin
  }

  public get decaRangeMax(): number {
    return this._decaRangeMax
  }


  public set decaRange(newDecaRange: number) {
    if(newDecaRange <= this._decaRangeMax && newDecaRange >= this._decaRangeMin)
      this._decaRange = newDecaRange
  }

  public get decaRange(): number {
    return this._decaRange
  }

  public set minX(x: number) {
    this._minX = x
  }

  public get minX(): number {
    return this._minX;
  }

  public set minY(y: number) {
    this._minY = y
  }

  public get minY(): number {
    return this._minY;
  }

  public set maxX(x: number) {
    this._maxX = x
  }

  public get maxX(): number {
    return this._maxX;
  }

  public set maxY(y: number) {
    this._maxY = y
  }

  public get maxY(): number {
    return this._maxY;
  }
}