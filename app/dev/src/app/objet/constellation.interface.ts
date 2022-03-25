interface ConstelalltionApi {
  '@id': string;
  '@type': string;
}

interface Constellation extends ConstelalltionApi {
  idConstellation: number;
  latinName: string;
}

export { ConstelalltionApi, Constellation }