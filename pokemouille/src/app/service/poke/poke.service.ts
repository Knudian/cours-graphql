import { Injectable } from '@angular/core';
import { Apollo } from 'apollo-angular';
import gql from 'graphql-tag';


@Injectable()
export class PokeService {
  private apollo: Apollo;

  constructor(apollo: Apollo) {
    this.apollo = apollo;
  }

  hello() {
    this.apollo.query({
      query: gql`{ hello }`
    })
    .subscribe(console.log);
  }

  list() {
    return this.apollo.query({
      query: gql`{ pokemons(first: 1000) {
        id
        number
        name
      } }`
    });
  }
}
