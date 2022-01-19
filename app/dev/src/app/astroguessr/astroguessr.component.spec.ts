import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AstroguessrComponent } from './astroguessr.component';

describe('AstroguessrComponent', () => {
  let component: AstroguessrComponent;
  let fixture: ComponentFixture<AstroguessrComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AstroguessrComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AstroguessrComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
