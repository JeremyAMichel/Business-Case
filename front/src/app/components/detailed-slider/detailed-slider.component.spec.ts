import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailedSliderComponent } from './detailed-slider.component';

describe('DetailedSliderComponent', () => {
  let component: DetailedSliderComponent;
  let fixture: ComponentFixture<DetailedSliderComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DetailedSliderComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DetailedSliderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
