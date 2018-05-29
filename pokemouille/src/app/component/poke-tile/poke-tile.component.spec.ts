import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PokeTileComponent } from './poke-tile.component';

describe('PokeTileComponent', () => {
  let component: PokeTileComponent;
  let fixture: ComponentFixture<PokeTileComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PokeTileComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PokeTileComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
