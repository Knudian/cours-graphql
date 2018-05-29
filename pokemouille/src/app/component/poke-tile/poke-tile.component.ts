import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-poke-tile',
  templateUrl: './poke-tile.component.html',
  styleUrls: ['./poke-tile.component.css']
})
export class PokeTileComponent implements OnInit {
  private _pkmn: any;
  @Input() set pkmn(pkmn: any) {
    this._pkmn = pkmn;
    this.imgSrc = 'assets/svg/' + (+this._pkmn.number) + '.svg';
  }
  get pkmn() { return this._pkmn; }

  public imgSrc: string;

  constructor() { }

  ngOnInit() {
    const pkId = +this.pkmn.number;
  }

}
