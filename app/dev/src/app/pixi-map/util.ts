
  /**
   * 
   * @param min 
   * @param max 
   * @param value 
   * @returns pourcentage entre deux valeurs
   * Exemple min: 2, max: 10, valeur: 6, renvoie 0.5, car 6 est a 50% entre 2 et 10.
   */
  export function percentBetweenRange(min: number, max: number, value: number): number {
    return ((value - min) / (max - min) * 100)
  }