
interface Objet {
  // "@id": string | undefined | null;
  // "@type": string | undefined | null;
  ra: number | string;
  deca: number | string;
  magnitude: number | string;
}

interface ObjetDistant extends Objet {
  idObjetDistant: string | number;
  type: string;
  raRadians: string | number;
  decRadians: string | number;
  created: string;
  updated: string;
}

interface ObjetProche extends Objet {
  idObjetProche: string;
  nom: string;
  type: string;
  dateApprobation: string;
}

interface ObjetApi {
  '@context': string;
  '@id': string;
  '@type': string;
  'hydra:member': ObjetDistant[] | ObjetProche[];
  'hydra:totalItems': number;
  'hydra:search': {
    '@type': string;
    'hydra:mapping': [];
    'hydra:template': string;
    'hydra:variableRepresentation': string;
  };
  'hydra:view': {
    '@id': string;
    '@type': string;
  }
}

export { Objet, ObjetApi, ObjetDistant, ObjetProche }