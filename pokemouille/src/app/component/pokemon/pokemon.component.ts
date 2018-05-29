import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import {Apollo} from 'apollo-angular';

@Component({
  selector: 'app-pokemon',
  templateUrl: './pokemon.component.html',
  styleUrls: ['./pokemon.component.css']
})
export class PokemonComponent implements OnInit {
  private loading: boolean;
  private pokemon: any;

  public pkmnName: string;

  constructor(router: ActivatedRoute, private apollo: Apollo) {
    router.params.subscribe(params => {
      this.pkmnName = params['pkmnName'];
    });
  }

  ngOnInit() {
    this.querySubscription = this.apollo.query({ query: Pokemon })
      .subscribe(({data, loading}) => {
        this.loading = loading;
        this.pokemon = data['pokemon'];
      });
  }

}
