import { TestBed } from '@angular/core/testing';

import { AstroguessrService } from './astroguessr.service';

describe('AstroguessrService', () => {
  let service: AstroguessrService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AstroguessrService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
