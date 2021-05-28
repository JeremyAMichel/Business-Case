import { TestBed } from '@angular/core/testing';

import { BCAPIService } from './bc-api.service';

describe('BCAPIService', () => {
  let service: BCAPIService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(BCAPIService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
