import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { Apollo } from 'apollo-angular';
import gql from 'graphql-tag';

const PokeList = gql`{ pokemons(first: 1000) {
  id
  number
  name
} }`;

@Component({
  selector: 'app-pokedex',
  templateUrl: './pokedex.component.html',
  styleUrls: ['./pokedex.component.css']
})
export class PokedexComponent implements OnInit {
  private loading: boolean;
  private pokemonList = [];

  private querySubscription: Subscription;

  constructor(private apollo: Apollo) { }

  ngOnInit() {
    this.querySubscription = this.apollo.query({
      query: PokeList
    })
    .subscribe(({ data, loading }) => {
      this.loading = loading;
      this.pokemonList = data['pokemons'];
    });
  }

}
