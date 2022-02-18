import { TestBed } from '@angular/core/testing';

import { ObjetDistantService } from './objet-distants.service';
import { ObjetProcheService } from './objet-proches.service';

describe('ObjetDistantService', () => {
  let service: ObjetDistantService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ObjetDistantService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});

describe('ObjetProcheService', () => {
  let service: ObjetProcheService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ObjetProcheService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
