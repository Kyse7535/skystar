interface Constellation {
  "@id": string;
  "@type": string;
  idConstellation: number;
  latinName: string;
  observationSaison: string;
  ra: number;
  deca: number;
  taille: number;
  created: string;
  updated: string;
  etoilePrincipale: string;
}

interface ConstellationApi {
  '@context': string,
  '@id': string,
  '@type': string,
  'hydra:member': Constellation[],
  'hydra:totalItems': number
}

export { ConstellationApi, Constellation }