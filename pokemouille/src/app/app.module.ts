import {FormsModule} from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { ApolloModule, Apollo, APOLLO_OPTIONS } from 'apollo-angular';
import { HttpLinkModule, HttpLink } from 'apollo-angular-link-http';
import { InMemoryCache } from 'apollo-cache-inmemory';

import { AppRoutingModule } from './app-routing.module';

import { AppComponent } from './component/app.component';
import { ErrorComponent } from './component/error/error.component';
import { PokedexComponent } from './component/pokedex/pokedex.component';
import { PokemonComponent } from './component/pokemon/pokemon.component';
import { PokeTileComponent } from './component/poke-tile/poke-tile.component';

import { PokeService } from './service/poke/poke.service';
import { HttpClientModule } from '@angular/common/http';


export function createApollo(httpLink: HttpLink) {
  return {
    link: httpLink.create({ uri: 'https://graphql-pokemon.now.sh'}),
    cache: new InMemoryCache()
  };
}

@NgModule({
  declarations: [
    AppComponent,
    ErrorComponent,
    PokedexComponent,
    PokemonComponent,
    PokeTileComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpClientModule,
    AppRoutingModule,
    ApolloModule,
    HttpLinkModule
  ],
  providers: [
    PokeService,
    {
      provide: APOLLO_OPTIONS,
      useFactory: createApollo,
      deps: [HttpLink]
    }
  ],
  bootstrap: [AppComponent]
})
export class AppModule {}
