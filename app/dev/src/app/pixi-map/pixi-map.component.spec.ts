import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PixiMapComponent } from './pixi-map.component';

describe('PixiMapComponent', () => {
  let component: PixiMapComponent;
  let fixture: ComponentFixture<PixiMapComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PixiMapComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PixiMapComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
