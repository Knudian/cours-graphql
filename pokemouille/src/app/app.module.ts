import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';

import { AppComponent } from './component/app.component';
import { ErrorComponent } from './component/error/error.component';
import { PokedexComponent } from './component/pokedex/pokedex.component';
import { PokemonComponent } from './component/pokemon/pokemon.component';

import { PokeService } from './service/poke/poke.service';


@NgModule({
  declarations: [
    AppComponent,
    ErrorComponent,
    PokedexComponent,
    PokemonComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule
  ],
  providers: [
    PokeService,
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
