
interface Objet {
  "@id": string;
  "@type": string;
  ra: number;
  deca: number;
  magnitude: number;
}

interface ObjetDistant extends Objet {
  "@id": string;
  "@type": string;
  idObjetDistant: string;
  type: string;
  ra: number;
  raRadians: number;
  decRadians: number;
  deca: number;
  magnitude: number;
  created: string;
  updated: string;
}

interface ObjetProche extends Objet {
  "@id": string;
  "@type": string;
  idObjetProche: string;
  nom: string;
  type: string;
  ra: number;
  deca: number;
  magnitude: number;
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