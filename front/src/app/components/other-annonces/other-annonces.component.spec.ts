import { ComponentFixture, TestBed } from '@angular/core/testing';

import { OtherAnnoncesComponent } from './other-annonces.component';

describe('OtherAnnoncesComponent', () => {
  let component: OtherAnnoncesComponent;
  let fixture: ComponentFixture<OtherAnnoncesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ OtherAnnoncesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(OtherAnnoncesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
