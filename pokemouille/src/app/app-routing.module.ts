import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { ErrorComponent } from './component/error/error.component';
import { PokedexComponent } from './component/pokedex/pokedex.component';
import { PokemonComponent } from './component/pokemon/pokemon.component';

const routes: Routes = [
  {path: '', component: PokedexComponent},
  {path: 'pokemon/:pkmnName', component: PokemonComponent},
  {path: '**', component: ErrorComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
